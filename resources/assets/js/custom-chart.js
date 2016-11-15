function initChart(status, customChart) {
    var graph = $('.chartdiv');
    AmCharts.translations.dataLoader.custom = {
        'Loading data...': paginatation.sProcessing
    }

    $.each(graph, function (key, element) {
        var id = $(element).attr('id');
        if (customChart) {
            var fromDate = $('#' + id).attr('data-fromDate');
            var toDate = $('#' + id).attr('data-toDate');
            var url = $('#' + id).data('href') + '/' + fromDate + '/' + toDate;
        } else {
            if (status == 'new') {
            var url = $('#' + id).data('href');
            } else {
                var url = $('#' + id).data('href') + "/" + $('#startDate').val() + "/" + $('#endDate').val();
            }
        }
        
        var valueField = $('#' + id).data('value');
        var titleField = $('#' + id).data('title');
        var sourceField = $('#' + id).data('source');
        var results_id = $('#' + id).data('results_id');
        $('#' + results_id).hide();

        var chart = AmCharts.makeChart(id, {
            "type": "pie",
            "language": "custom",
            "startDuration": 0,
            "theme": "light",
            "addClassNames": true,
            "legend": {
                "position": "left"
            },
            "innerRadius": "30%",
            "defs": {
                "filter": [{
                    "id": "shadow",
                    "width": "200%",
                    "height": "200%",
                    "feOffset": {
                        "result": "offOut",
                        "in": "SourceAlpha",
                        "dx": 0,
                        "dy": 0
                    },
                    "feGaussianBlur": {
                        "result": "blurOut",
                        "in": "offOut",
                        "stdDeviation": 5
                    },
                    "feBlend": {
                        "in": "SourceGraphic",
                        "in2": "blurOut",
                        "mode": "normal"
                    }
                }]
            },
            "dataLoader": {
                "url": url,
                "format": "json",
                postProcess: function(data, options) {
                    if (data == '') {
                        options.chart.addLabel("40%", "50%", paginatation.sZeroRecords, "left", 20);
                    }
                    return data;
                }
            },
            "valueField": valueField,
            "titleField": titleField,
            'sourceField': sourceField,
        });

        chart.addListener("init", handleInit);

        chart.addListener("rollOverSlice", function (e) {
            handleRollOver(e);
        });
        chart.addListener("clickSlice", function (e) {
            var dp = e.dataItem.dataContext;
            var contract_status = dp[chart.sourceField];
            var token = $('#' + id).data('token');
            var action = $('#' + id).data('action');
            
            if (customChart) {
                action = action.replace('4table', contract_status) + '/' + fromDate + '/' + toDate;
            } else {
                action = action + '/' + contract_status;
            } 

            $('#' + results_id).show();
            $('#' + results_id + ' table').dataTable({
                columnDefs: [{
                    targets: "datatable-nosort",
                    orderable: false,
                }],
                paging: false,
                searching: false,
                ordering: false,
                bFilter: false,
                destroy: true,
                "ajax": action,
                loadingMessage: paginatation.loading,
                "language": {
                    "search": paginatation.search,
                    "sProcessing": paginatation.loading,
                    "sLoadingRecords": paginatation.loading,
                    "sLengthMenu": paginatation.sLengthMenu,
                    "sZeroRecords": paginatation.sZeroRecords,
                    "sInfo": paginatation.info,
                    "sInfoEmpty": paginatation.sInfoEmpty,
                    "sInfoFiltered": paginatation.sInfoFiltered,
                    "sInfoPostFix": paginatation.sInfoPostFix,
                    "sSearch": paginatation.sSearch,
                    "sUrl": paginatation.sUrl,
                    "sPage": paginatation.sPage,
                    "oPaginate": {
                        "sFirst": paginatation.oPaginate.sFirst,
                        "sPrevious": paginatation.oPaginate.sPrevious,
                        "sNext": paginatation.oPaginate.sNext,
                        "sLast": paginatation.oPaginate.sLast,
                        "page": paginatation.oPaginate.page,
                        "pageOf": paginatation.oPaginate.pageOf
                    },
                    "oAria": {
                        "sSortAscending": paginatation.oAria.sSortAscending,
                        "sSortDescending": paginatation.oAria.sSortDescending
                    }
                },
            });
        });

        function handleInit() {
            chart.legend.addListener("rollOverItem", handleRollOver);
        }

        function handleRollOver(e) {
            var wedge = e.dataItem.wedge.node;
            wedge.parentNode.appendChild(wedge);
        }
    });
}
$(function () {
    if ($('#ishaarsLineChart').length > 0) {
        drawIshaarsLineChart();
    }
    
    if ($('.chartdiv').length > 0) {
        var customChart = $('.chartdiv').attr('data-custom_action');
        if (customChart != undefined) {
            initChart('old', 'custom');
        } else {
            initChart('new');
            $('#showAll').on('click', function (e) {
                $('#startDate').val('');
                $('#endDate').val('');
                initChart('new');
            });
        }
    }
    
    $('#changeDate').on('click', function (e) {
        if ($('#ishaarsLineChart').length > 0) {
            $('.chartdiv').attr('data-fromDate', $('#startDate').val());
            $('.chartdiv').attr('data-toDate', $('#endDate').val());
            eval('drawIshaarsLineChart("' + $('#startDate').val() + '","' + $('#endDate').val() + '");');
        }
        
        if ($('.chartdiv').length > 0) {
            if ($('#startDate').val() == '') {
                toastr.error('', $('#startDate').data('toastr'));
                return false;
            }
            if ($('#endDate').val() == '') {
                toastr.error('', $('#endDate').data('toastr'));
                return false;
            }

            var startDate = new Date($('#startDate').val());
            var endDate = new Date($('#endDate').val());
            if (endDate < startDate) {
                toastr.error('', $('#endDate').data('toastr-greater'));
                return false;
            }

            if (customChart != undefined) {
                $('.chartdiv').attr('data-fromDate', $('#startDate').val());
                $('.chartdiv').attr('data-toDate', $('#endDate').val());
                initChart('old', 'custom');
            } else {
                initChart('old');
            }
        }
    });
});

function drawIshaarsLineChart(from, to) {
    $('#ishaarsLineChart').html('');

    var chartData = '';
    var fromDate = from == undefined ? $('#ishaarsLineChart').attr('data-fromDate') : from;
    var toDate = to == undefined ? $('#ishaarsLineChart').attr('data-toDate') : to;

    $.get('/admin/reports/contractTypesIshaarsData/' + fromDate + '/' + toDate, function (data) {
        chartData = data;
    }).done(function (chartData) {
        new Morris.Line({
            // ID of the element in which to draw the chart.
            element: 'ishaarsLineChart',
            // Chart data records -- each entry in this array corresponds to a point on
            // the chart.
            data: chartData,
            // The name of the data record attribute that contains x-values.
            xkey: 'date',
            // A list of names of data record attributes that contain y-values.
            ykeys: ["taqawel", "temp_work", "hajj"],
            // Labels for the ykeys -- will be displayed when you hover over the
            // chart.
            labels: [$('#ishaarsLineChart').attr('data-label1'), $('#ishaarsLineChart').attr('data-label2'), $('#ishaarsLineChart').attr('data-label3')],

            // Lines Colrs
            lineColors: ['#a93535', '#98e454', '#2692a5']
        });
    });
}
