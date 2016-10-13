$(function () {
    App.setAssetsPath('/assets/');
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "positionClass": "toast-bottom-left",
        "onclick": null,
        "showDuration": "0",
        "hideDuration": "0",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "show",
        "hideMethod": "fadeOut"
    };

    $(".bs-select").selectpicker({
        noneSelectedText: noneSelectedTextValue,
        iconBase: 'fa',
        tickIcon: 'fa-check'
    });
    $(".make-switch").bootstrapSwitch();
    $(".date-picker").datepicker({
        dateFormat: 'yy-mm-dd',
        changeYear: true
    });
    $('.selectpicker').selectpicker({
        noneSelectedText: noneSelectedTextValue,
        style: 'btn-default',
        size: 4
    });

    if (App.isRTL()) {
        $(".date-picker").datepicker("option", "dayNames", ["الأحد", "الاثنين", "الثلاثاء", "الأربعاء", "الخميس", "الجمعة", "السبت", "الأحد"]);
        $(".date-picker").datepicker("option", "dayNamesMin", ["ح", "ن", "ث", "ع", "خ", "ج", "س", "ح"]);
        $(".date-picker").datepicker("option", "dayNamesShort", ["أحد", "اثنين", "ثلاثاء", "أربعاء", "خميس", "جمعة", "سبت", "أحد"]);
        $(".date-picker").datepicker("option", "monthNames", ["يناير", "فبراير", "مارس", "أبريل", "مايو", "يونيو", "يوليو", "أغسطس", "سبتمبر", "أكتوبر", "نوفمبر", "ديسمبر"]);
        $(".date-picker").datepicker("option", "isRTL", true);
        $(".date-picker").datepicker("option", "monthNamesShort", ["يناير", "فبراير", "مارس", "أبريل", "مايو", "يونيو", "يوليو", "أغسطس", "سبتمبر", "أكتوبر", "نوفمبر", "ديسمبر"]);
        $(".date-picker").datepicker("option", "currentText", 'الان');
        $(".date-picker").datepicker("option", "firstDay", 6);
    }
    $("#acceptform").on("submit", function (e) {
        var btn = $(this).find("[type='submit']").button('loading');
        var current = $(this);
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function (msg) {
                btn.button('reset');
                $('#stack1').modal('show');

            },
            error: function (msg) {
                btn.button('reset');
                if (msg.status == 401 || msg.status == 404) {
                    window.location = msg.getResponseHeader('Location')
                }
                if (msg.status == 500 || msg.status == 405) {
                    toastr.error("", bug_msg);
                }
                current.find(".alert-danger").fadeOut(500);
                var json = $.parseJSON(msg.responseText);
                var error = '<div class="alert alert-block alert-danger fade in"><button type="button" class="close" data-dismiss="alert"></button> <p>';
                $.each(json, function (k, v) {
                    error += v + "</p>";
                });
                current.find(".form-body").prepend(error + '</div>');
                toastr.error("", error_msg);
            }
        });
    });

    $("#acceptform").validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help help-block help-block-error', // default input error message class
        errorPlacement: function (error, element) {
            if (element.is(':checkbox')) {
                error.insertAfter(element.closest(".md-checkbox-list, .md-checkbox-inline, .checkbox-list, .checkbox-inline"));
            } else if (element.is(':radio')) {
                error.insertAfter(element.closest(".md-radio-list, .md-radio-inline, .radio-list,.radio-inline"));
            } else {
                error.insertAfter(element); // for other inputs, just perform default behavior
            }
        },
        highlight: function (element) { // hightlight error inputs
            $(element)
                .closest('.form-group').addClass('has-error'); // set error class to the control group
        },
        unhighlight: function (element) { // revert the change done by hightlight
            $(element)
                .closest('.form-group').removeClass('has-error'); // set error class to the control group
        },
        success: function (label) {
            label
                .closest('.form-group').removeClass('has-error'); // set success class to the control group
        }
    });
    $("#form,#another_form").on("submit", function (e) {
        var btn = $(this).find("[type='submit']").button('loading');
        var current = $(this);
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function (msg) {
                toastr.success('', msg);
                setTimeout(function () {
                    window.location = current.data('url');
                }, 2000);
            },
            error: function (msg) {
                btn.button('reset');
                if (msg.status == 401 || msg.status == 404) {
                    window.location = msg.getResponseHeader('Location')
                }
                if (msg.status == 500 || msg.status == 405) {
                    toastr.error("", bug_msg);
                }
                current.find(".alert-danger").fadeOut(500);
                var json = $.parseJSON(msg.responseText);
                var error = '<div class="alert alert-block alert-danger fade in"><button type="button" class="close" data-dismiss="alert"></button> <p>';
                $.each(json, function (k, v) {
                    error += v + "</p>";
                });
                current.find(".form-body").prepend(error + '</div>');
                toastr.error("", error_msg);
            }
        });
    });
    $("#calculateButton").on("click", function (e) {
        var btn = $("#calculateButton").button('loading');
        var current = $(this);
        e.preventDefault();
        var route = $(this).data('hreff');
        var token = $(this).data('token');
        var requestedIshaars = $("#requestedIshaars").val();
        $.ajax({
            type: "post",
            data: {_method: 'put', _token: token, requestedIshaars: requestedIshaars},
            url: route,
            dataType: 'JSON',
            success: function (msg) {
                $("#ishaarsNoRe").html(msg['max_of_num_ishaar']);
                $("#totalCount").html(msg['totalCount']);
                $("#resultDiv").show(1000);
                btn.button('reset');

            },
            error: function (msg) {
                btn.button('reset');
                if (msg.status == 401 || msg.status == 404) {
                    window.location = msg.getResponseHeader('Location')
                }
                if (msg.status == 500 || msg.status == 405) {
                    toastr.error("", bug_msg);
                }
                current.find(".alert-danger").fadeOut(500);
                var json = $.parseJSON(msg.responseText);
                var error = '<div class="alert alert-block alert-danger fade in"><button type="button" class="close" data-dismiss="alert"></button> <p>';
                $.each(json, function (k, v) {
                    toastr.error("", v);
                });
                current.find("#calculateError").prepend(error + '</div>');
            }
        });
    });
    $("#generateInvoiceForm").on("submit", function (e) {
        var btn = $(this).find("[type='submit']").button('loading');
        var current = $(this);
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function (msg) {
                btn.button('reset');
                $('#invoiceModal').modal('show');
            },
            error: function (msg) {
                btn.button('reset');
                if (msg.status == 401 || msg.status == 404) {
                    window.location = msg.getResponseHeader('Location')
                }
                if (msg.status == 500 || msg.status == 405) {
                    toastr.error("", bug_msg);
                }
                current.find(".alert-danger").fadeOut(500);
                var json = $.parseJSON(msg.responseText);
                var error = '<div class="alert alert-block alert-danger fade in"><button type="button" class="close" data-dismiss="alert"></button> <p>';
                $.each(json, function (k, v) {
                    error += v + "</p>";
                });
                current.find(".form-body").prepend(error + '</div>');
                toastr.error("", error_msg);
            }
        });
    });
    $('#invoiceModal').on('show.bs.modal', function (e) {
        $("#invoiceModal .modal-content").html('<div class="modal-dialog"><div class="modal-content"> <div class="modal-body"></div> </div> </div> </div>');

        var route = $("#invoiceModal").data('href');
        $.ajax({
            type: "get",
            data: {},
            url: route,
            success: function (data) {
                $("#invoiceModal .modal-content").html(data);
            }
            , error: function (data) {
                if (data.status == 401 || data.status == 404) {
                    window.location = data.getResponseHeader('Location')
                }
            }
        });
    });
    $("#activateTrail").on("click", function (e) {
        var btn = $("#activateTrail").button('loading');
        var current = $(this);
        e.preventDefault();
        var route = $(this).data('hreff');
        var token = $(this).data('token');
        var uri = $(this).data('uri');
        $.ajax({
            type: "post",
            data: {_method: 'put', _token: token},
            url: route,
            success: function (msg) {
                toastr.success('', msg);
                setTimeout(function () {
                    window.location = uri;
                }, 2000);
                btn.button('reset');

            },
            error: function (msg) {
                btn.button('reset');
                if (msg.status == 401 || msg.status == 404) {
                    window.location = msg.getResponseHeader('Location')
                }
                if (msg.status == 500 || msg.status == 405) {
                    toastr.error("", bug_msg);
                }
                current.find(".alert-danger").fadeOut(500);
                var json = $.parseJSON(msg.responseText);
                var error = '<div class="alert alert-block alert-danger fade in"><button type="button" class="close" data-dismiss="alert"></button> <p>';
                $.each(json, function (k, v) {
                    toastr.error("", v);
                });
                current.find("#calculateError").prepend(error + '</div>');
            }
        });
    });

    $("#register-form").on("submit", function (e) {
        var btn = $(this).find("[type='submit']").button('loading');
        var current = $(this);
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function (msg) {
                setTimeout(function () {
                    window.location = current.data('url');
                }, 2000);
            },
            error: function (msg) {
                btn.button('reset');
                if (msg.status == 401 || msg.status == 404) {
                    window.location = msg.getResponseHeader('Location')
                }
                if (msg.status == 500 || msg.status == 405) {
                    toastr.error("", bug_msg);
                }
                current.find(".alert-danger").fadeOut(500);
                var json = $.parseJSON(msg.responseText);
                var error = '<div class="alert alert-block alert-danger fade in"><button type="button" class="close" data-dismiss="alert"></button> <p>';
                $.each(json, function (k, v) {
                    error += v + "</p>";
                });
                current.find(".form-body").prepend(error + '</div>');
                toastr.error("", error_msg);
            }
        });
    });

    $(".cancel_reset").on("click", function (e) {
        var current = $(this);
        var btn = current.button('loading');
        e.preventDefault();
        var route = current.data('hreff');
        var token = current.data('token');
        $.ajax({
            type: "post",
            data: {_method: 'put', _token: token},
            url: route,
            success: function (msg) {
                current.hide();
                toastr.success('', msg);
            },
            error: function (msg) {
                btn.button('reset');
                if (msg.status == 401 || msg.status == 404) {
                    window.location = msg.getResponseHeader('Location')
                }
                else if (msg.status == 500 || msg.status == 405) {
                    toastr.error("", bug_msg);
                }
                else {
                    toastr.error("", msg);
                }
            }
        });
    });

    $("#form").validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help help-block help-block-error', // default input error message class
        errorPlacement: function (error, element) {
            if (element.is(':checkbox')) {
                error.insertAfter(element.closest(".md-checkbox-list, .md-checkbox-inline, .checkbox-list, .checkbox-inline"));
            } else if (element.is(':radio')) {
                error.insertAfter(element.closest(".md-radio-list, .md-radio-inline, .radio-list,.radio-inline"));
            } else {
                error.insertAfter(element); // for other inputs, just perform default behavior
            }
        },
        highlight: function (element) { // hightlight error inputs
            $(element)
                .closest('.form-group').addClass('has-error'); // set error class to the control group
        },
        unhighlight: function (element) { // revert the change done by hightlight
            $(element)
                .closest('.form-group').removeClass('has-error'); // set error class to the control group
        },
        success: function (label) {
            label
                .closest('.form-group').removeClass('has-error'); // set success class to the control group
        }
    });
    $("#another_form").validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help help-block help-block-error', // default input error message class
        errorPlacement: function (error, element) {
            if (element.is(':checkbox')) {
                error.insertAfter(element.closest(".md-checkbox-list, .md-checkbox-inline, .checkbox-list, .checkbox-inline"));
            } else if (element.is(':radio')) {
                error.insertAfter(element.closest(".md-radio-list, .md-radio-inline, .radio-list,.radio-inline"));
            } else {
                error.insertAfter(element); // for other inputs, just perform default behavior
            }
        },
        highlight: function (element) { // hightlight error inputs
            $(element)
                .closest('.form-group').addClass('has-error'); // set error class to the control group
        },
        unhighlight: function (element) { // revert the change done by hightlightc
            $(element)
                .closest('.form-group').removeClass('has-error'); // set error class to the control group
        },
        success: function (label) {
            label
                .closest('.form-group').removeClass('has-error'); // set success class to the control group
        }
    });

    jQuery.extend(jQuery.validator.messages, {});

    /** datetables **/
    function apply_to_vacancy() {
        $('.apply_vacancy').click(function (e) {
            var btn = $(this).button('loading');
            e.preventDefault();
            $.ajax({
                type: "GET",
                url: $(this).attr('href'),
                data: {'_token': $(this).data('token')},
                headers: {'XSRF-TOKEN': $(this).data('token')},
                processData: false,
                contentType: false,
                success: function (msg) {
                    toastr.success('', msg);
                },
                error: function (msg) {
                    if (msg.status == 401 || msg.status == 404) {
                        window.location = msg.getResponseHeader('Location')
                    }
                    if (msg.status == 500 || msg.status == 405) {
                        toastr.error("", bug_msg);
                    }
                    var json = $.parseJSON(msg.responseText);
                    var error = '<p>';
                    $.each(json, function (k, v) {
                        error += v + "</p>";
                    });
                    toastr.error("", error);
                },
                complete: function() {
                    btn.button('reset');
                }
            });
        })
    }

    function cancel_Ishaar() {
        $('.cancel_ishaar').click(function (e) {
            e.preventDefault();
            var txt;
            var r = confirm(confirm_delete);
            if (r == true) {
                var button = $(this);
                $.ajax({
                    type: "GET",
                    url: $(this).attr('href') + '/cancel_ishaar',
                    data: {},
                    headers: {'XSRF-TOKEN': $(this).data('token')},
                    processData: false,
                    contentType: false,
                    success: function (msg) {
                        $(button).closest('td').prev('td').text("provider_cancel");
                        $(button).css('display', 'none');
                        toastr.success('', msg);

                    },
                    error: function (msg) {
                        if (msg.status == 401 || msg.status == 404) {
                            window.location = msg.getResponseHeader('Location')
                        }
                        if (msg.status == 500 || msg.status == 405) {
                            toastr.error("", bug_msg);
                        }
                        var json = $.parseJSON(msg.responseText);
                        var error = '<p>';
                        $.each(json, function (k, v) {
                            error += v + "</p>";
                        });
                        toastr.error("", error);
                    }
                });

            } else {
                return false;
            }
        });
    }

    //delete Taqawel service
    function deleteTaqawelService() {
        $('.delete_taqawel_service').click(function (e) {
            e.preventDefault();
            var txt;
            var r = confirm(confirm_delete);
            if (r == true) {
                var button = $(this);
                $.ajax({
                    type: "GET",
                    url: $(this).attr('href'),
                    data: {},
                    headers: {'XSRF-TOKEN': $(this).data('token')},
                    processData: false,
                    contentType: false,
                    success: function (msg) {
                        $(button).closest('tr').remove();
                        toastr.success('', msg);
                    },
                    error: function (msg) {
                        if (msg.status == 401 || msg.status == 404) {
                            window.location = msg.getResponseHeader('Location')
                        }
                        if (msg.status == 500 || msg.status == 405) {
                            toastr.error("", bug_msg);
                        }
                        var json = $.parseJSON(msg.responseText);
                        var error = '<p>';
                        $.each(json, function (k, v) {
                            error += v + "</p>";
                        });
                        toastr.error("", error);
                    }
                });

            } else {
                return false;
            }
        });
    }

    function deletePublishService() {
        $('.delete-ajax').click(function () {
            $(this).confirmation('show');
        });
        $('body').on('confirmed.bs.confirmation', '.delete-ajax', function (e) {
            e.preventDefault();
            var route = $(this).data('hreff');
            var token = $(this).data('token');
            var target_id = $(this).data('id');
            var button = $(this);
            $.ajax({
                type: "POST",
                data: {_method: 'delete', _token: token, id: target_id},
                url: route,
                success: function (data) {
                    $(button).closest('tr').remove();
                    toastr.success('', data);
                },
                error: function (data) {
                    if (data.status == 401 || data.status == 404) {
                        window.location = data.getResponseHeader('Location')
                    }
                    else {
                        var json = $.parseJSON(data.responseText);
                        var error = '';
                        $.each(json, function (k, v) {
                            error += v;
                        });
                        toastr.error('', error);
                    }
                }
            });
        });
    }

    var TableDatatablesAjax = function () {

        var initPickers = function () {
            //init date pickers
            $('.date-picker').datepicker({
                rtl: App.isRTL(),
                autoclose: true
            });
        };

        var columns = [];
        $("#datatable_ajax th").each(function () {
            columns.push({"defaultContent": '', data: $(this).attr("id"), name: $(this).attr("id")});
        });

        var handleRecords = function () {

            var grid = new Datatable();

            grid.init({
                src: $("#datatable_ajax, .datatable_ajax"),
                onSuccess: function (grid, response) {
                    $.each(response.data, function (i, item) {
                        if (item.hasOwnProperty('status')) {
                            if (jQuery.inArray(item.status, ['cancelled', 'provider_cancel', 'benef_cancel']) !== -1) {
                                item.details = strReplace("cancel_ishaar", "hidden", item.details);
                                item.details = strReplace("askcancelishaar", "hidden", item.details);
                            }
                        }
                    })
                    // grid:        grid object
                    // response:    json object of server side ajax response
                    // execute some code after table records loaded
                },
                onError: function (grid) {
                    // execute some code on network or other general error
                },
                onDataLoad: function (grid) {
                    // execute some code on ajax data load
                    apply_to_vacancy();

                    //call cancel Ishaar Function
                    cancel_Ishaar();


                    //show & hide cancel Ishaar Button
                    deleteTaqawelService();

                    //delete publish service
                    deletePublishService();
                },
                loadingMessage: paginatation.loading,
                dataTable: {
                    "bStateSave": true,
                    "lengthMenu": [
                        [10, 20, 50, 100, 150],
                        [10, 20, 50, 100, 150]
                    ],
                    "pageLength": 10,
                    "ajax": {
                        "headers": {
                            "X-CSRF-TOKEN": $("#datatable_ajax").attr('data-token')  // incase you using post request
                        },
                        "url": $("#datatable_ajax").attr('data-url') ? $("#datatable_ajax").attr('data-url') : '',
                        "type": $("#datatable_ajax").attr('data-type') ? $("#datatable_ajax").attr('data-type') : "get",
                    },
                    "columnDefs": [{
                        "targets": 'no-sort',
                        "orderable": false
                    }],
                    "language": {
                        "search": paginatation.search,
                        "sProcessing": paginatation.loading,
                        "sLengthMenu": paginatation.sLengthMenu,
                        "sZeroRecords": paginatation.sZeroRecords,
                        "info": paginatation.info,
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
                    "bInfo": false,
                    "columns": columns,
                    "ordering": true,
                    "order": [
                        [0, "desc"]
                    ]
                }
            });

            // handle group actionsubmit button click
            grid.getTableWrapper().on('click', '.table-group-action-submit', function (e) {
                e.preventDefault();
                var action = $(".table-group-action-input", grid.getTableWrapper());
                if (action.val() != "" && grid.getSelectedRowsCount() > 0) {
                    grid.setAjaxParam("customActionType", "group_action");
                    grid.setAjaxParam("customActionName", action.val());
                    grid.setAjaxParam("id", grid.getSelectedRows());
                    grid.getDataTable().ajax.reload();
                    grid.clearAjaxParams();
                } else if (action.val() == "") {
                    App.alert({
                        type: 'danger',
                        icon: 'warning',
                        message: paginatation.sInfoEmpty,
                        container: grid.getTableWrapper(),
                        place: 'prepend'
                    });
                } else if (grid.getSelectedRowsCount() === 0) {
                    App.alert({
                        type: 'danger',
                        icon: 'warning',
                        message: paginatation.sInfoEmpty,
                        container: grid.getTableWrapper(),
                        place: 'prepend'
                    });
                }
            });

            grid.setAjaxParam("customActionType", "group_action");
            grid.getDataTable().ajax.reload();
            grid.clearAjaxParams();
        }
        return {
            init: function () {
                initPickers();
                handleRecords();

                $("[name='datatable_ajax_length']").selectpicker({
                    noneSelectedText: noneSelectedTextValue,
                    iconBase: 'fa',
                    tickIcon: 'fa-check'
                });

            }

        };

    }();

    jQuery(document).ready(function () {
        TableDatatablesAjax.init();
    });

    /**
     * Individuals registration toggles
     */
    $('input[type="checkbox"][name="saudi"]').on('click', function (e) {

        if ($(this).is(':checked')) {
            $('div#birth_date_group').show();
            $('#saudi-label').show();
            $('#non-saudi-label').hide();
        } else {
            $('div#birth_date_group').hide();
            $('#saudi-label').hide();
            $('#non-saudi-label').show();
        }

    });

    /**
     * Hijri calender handler
     */
    $('#birth_date').calendarsPicker({calendar: $.calendars.instance('islamic')});

    $('.selectpicker').selectpicker({
        noneSelectedText: noneSelectedTextValue,
        style: 'btn-default',
        size: 12
    });

// shwagher Modal
    $('#show_details').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var modal = $(this);
        var butt = button.data('details');
        var base = window.location.protocol + "//" + window.location.host + "/";
        modal.find('.modal-body form').attr('action', base + 'vacancies/update/' + butt.id);
        modal.find('.modal-body #job').val(butt.job_id);
        modal.find(".modal-body input[name=gender][value=" + butt.gender + "]").prop('checked', true);
        modal.find('.modal-body #nationality').val(butt.nationality_id);
        modal.find(".modal-body input[name=religion][value=" + butt.religion + "]").prop('checked', true);
        modal.find(".modal-body input[name=job_type][value=" + butt.job_type + "]").prop('checked', true);
        modal.find('.modal-body #region_id').val(butt.region_id);
        modal.find('.modal-body #salary').val(butt.salary);
        if (butt.hide_salary == 1) {
            modal.find('.modal-body #hide_salary').attr('checked', true);
        }
        modal.find('.modal-body #work_areas').text(button.data('locations'));
        modal.find('.modal-body #work_start_date').val(butt.work_start_date);
        modal.find('.modal-body #work_end_date').val(butt.work_end_date);
        modal.find('.modal-body #no_of_vacancies').val(butt.no_of_vacancies);
        modal.find('.modal-footer #update_and_publish').on('click', function () {
            $(".modal-body input[name='status']").val('1');
            var form = modal.find('.modal-body form').serializeArray();
            modal.find('.modal-body form').submit();
        })
        modal.find('.modal-footer #update_draft').on('click', function () {
            $(".modal-body input[name='status']").val('0');
            var form = modal.find('.modal-body form').serializeArray();
            modal.find('.modal-body form').submit();
        })

    });

//if Work type is temprory at hajj sprint

    $('#region_id').bind('change', function (e) {
        if ($('#region_id').val() == '1') {
            $('#tayeed_area').show();
            $("#tayeed_area").css({display: "inline-block"});
            $("#tayeed_area").css({width: "100%"});
            $('#vacancies_area').hide();
        }
        else if ($('#region_id').val() != '1') {
            $('#tayeed_area').hide();
            $('#vacancies_area').show();
        }
    }).trigger('change');

    //Ishaar selecet contract
    $("#contract_id").on('change', function () {
        var id = $(this).val();
        var base = window.location.protocol + "//" + window.location.host;
        var current = $("#current_route").text();
        $("#add_ishaar").attr("href", base + current + '/' + id);
    });

    //Taqawel Ishaar selecet contract
    $("#taqawel_contract_id").on('change', function () {
        var id = $(this).val();
        var base = window.location.protocol + "//" + window.location.host + "/";
        $("#add_notice").attr("href", base + 'taqawel/notices/' + id);
    });

    // add Ishaar Confirmation
    $(".cancel_ishaar").on('click', function () {
        var txt;
        var r = confirm("Please Confirm You want to Cancel This Ishaar ... ");
        if (r == true) {
            var base = window.location.protocol + "//" + window.location.host + "/";
            $(".cancel_ishaar").attr("href", base + 'ishaar/' + id + 'destroy');
        } else {
            txt = "You pressed Cancel!";
        }

    });


    //Function To Return Variables in Current Url Link
    $.urlParam = function (name) {
        var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
        if (results)
            return results[1] || 0;
    }

    //Print Show Ishaar Page If Get Print params on url
    if ($.urlParam('print')) {
        console.log($.urlParam('print'));
        window.print();
    }

    /**
     * Add laborers Handlers, check if laborer exists in mol
     */
    $('#laborer_id_number').on('keyup', function (e) {
        $('#status-label').addClass('hidden');
        var id = jQuery.trim($(this).val());
        var url = '/laborer';
        $.get(url + '/' + id, function (data) {
            if (data != 'false') {
                $('#status-label-exist').removeClass('hidden');
                $('#status-label-not-exist').addClass('hidden');
            } else {
                $('#status-label-exist').addClass('hidden');
                $('#status-label-not-exist').removeClass('hidden');
            }
        }).fail(function () {
            $('#status-label-exist').addClass('hidden');
            $('#status-label-not-exist').removeClass('hidden');
        });
    });
    
    /**
     * publish Laborer to labor market handlers
     */
    jQuery(document).ready(function () {
        $('#datatable_ajax').on('change', '.select-checkbox', function () {
            if ($(this).is(':checked')) {
                var tr = $(this).parents('tr');
                var clone = tr.clone();
                clone.find("td:last").remove();
                $('#in-modal-table').append(clone);
            } else {
                var modal_tr = $('#in-modal-table').find('.select-checkbox[value="' + $(this).val() + '"]').parents('tr');
                modal_tr.remove();
            }
        });
    });

    $("#addResp").click(function () {
        var myclone = $("#responsible_data_box .data_box:last-child").clone();
        myclone.find('.record_id').remove();
        var size = $('.data_box').size();
        myclone.find("input").each(function (k, v) {
            $(v).attr('id', $(v).data('seg1') + size + $(v).data('seg2'));
            $(v).attr('name', $(v).data('seg1') + size + $(v).data('seg2'));
            $(v).closest('.data-box').find('label').attr('for', $(v).data('seg1') + size + $(v).data('seg2'));
        });

        myclone.val("");
        $('.data_box:last-child').after(myclone);
        myclone.focus();
        return false;
    });

    jQuery(document).ready(function () {
        $('.view_resp').on('click', function () {
                $(this).attr('disabled', true);
                var token = $('#csrf_token').val();
                var that = $(this);
                $('#est_responsibles').html('');
                $.ajax({
                    'url': $(this).data('url'),
                    'type': 'POST',
                    'cache': false,
                    'data': {'estid': $(this).data('estid'), '_token': token},
                    'success': function (data) {
                        $('#est_responsibles').html('').fadeOut(100, function () {
                            $(this).html(data);
                        }).fadeIn(100);
                    },
                    'error': function () {
                        console.log("error");
                    },
                    'complete': function () {
                        that.removeAttr('disabled');
                    }
                });
            }
        );
    });

    jQuery(document).ready(function () {
        var total = 0;
        $('#datatable_ajax').on('change', '.select-checkbox', function () {
            if ($(this).is(':checked')) {
                var tr = $(this).parents('tr');
                var salary = tr.find('td').find('.salary-input').val();
                total = parseInt(total) + parseInt(salary);
                $("input[name=contract_amount]").val(!isNaN(parseInt(total)) ? parseInt(total) : 0);
            }
        });

        $('#service-provider-select').on('change', function () {
            var val = $(this).val();
            var route = $(this).data('route');
            window.location = route + '/' + val;
        });
    });


    // This function to make replace in string

    function strReplace(oldStr, newStr, str) {
        if (isArray(oldStr)) {
            for (var i in oldStr) {
                var rpl = oldStr[i];
                var patt = new RegExp(escapeRegExp(rpl), 'g');
                str = str.replace(patt, (isArray(newStr) ? newStr[i] : newStr));
            }
            return str;
        }
        else if (isString(str)) {
            var patt = new RegExp(oldStr, 'g');
            return str.replace(patt, newStr);
        }
        else
            return "";
    }

    function isArray(i) {
        if (i && i != "undefined" && i != undefined)
            if (i instanceof Array)
                return true;
    }

    function isString(i) {
        if (i && i != "undefined" && i != undefined)
            if (typeof i == "string" || typeof i == "STRING")
                return true;
    }


    $("select[name=reason_id]").on('change', function () {
        if ($(this).val() == "14") {
            $("#other").parent('div').show();
        } else {
            $("#other").parent('div').hide();
        }
    });


    $('#select_reason').on('change', function () {
        var selectedOptionValue = $('#select_reason option:selected').val();
        var lastOptionValue = $('#select_reason option:last-child').val();
        if (selectedOptionValue == lastOptionValue) {
            $('#other_reason').show();
        } else {
            $('#other').val('');
            $('#other_reason').hide();
        }
    });


    /** todo: should be removed **/
    // $('#select_reason').on('change', function () {
    //     if ($(this).val() == 'other') {
    //         $('#other_reason').show();
    //     } else {
    //         $('#other').val('');
    //         $('#other_reason').hide();
    //     }
    // });
});

//generate Invoice
$('#generate_invoice').click(function (e) {
    e.preventDefault();
    {
        var button = $(this);
        $.ajax({
            type: "GET",
            url: $("form").attr('action') + '/' + $("form #contract_id").val() + '/generate_invoice',
            data: {_token: $(this).data('token')},
            headers: {'XSRF-TOKEN': $(this).data('token')},
            processData: false,
            contentType: false,
            success: function (msg) {
                console.log(msg);
                $("#after_invoice").text(msg + after_generate_invoice);
                $(button).css('display', 'none');
                toastr.success('', msg);
            },
            error: function (msg) {
                if (msg.status == 401 || msg.status == 404) {
                    window.location = msg.getResponseHeader('Location')
                }
                if (msg.status == 500 || msg.status == 405) {
                    toastr.error("", bug_msg);
                }
                var json = $.parseJSON(msg.responseText);
                var error = '<p>';
                $.each(json, function (k, v) {
                    error += v + "</p>";
                });
                toastr.error("", error);
            }
        });

    }
});


window.onload = function () {
    $(document).on('click', '.generate_cert', function () {
        if ($('.contracts_cert_list tbody tr#cid_' + $(this).data('cid')).length > 0)
            return false;
        $('.table_container #certificate_generate_invoice').attr("href","certificate_generate_invoice");
        var record = $(this).closest('tr').clone();
        record.attr('id', 'cid_' + $(this).data('cid'));
        var remove_btn = $('<a />').addClass('btn btn-danger remove_record').text(remove);
        record.find('td:last-child a').remove();
        record.find('td:last-child').append(remove_btn);
        record.find('td').eq(-2).after($('<td />').text($(this).data('startdate')))
        record.find('td').eq(-2).after($('<td />').text($(this).data('enddate')))
        $('.contracts_cert_list tbody').append(record);
        if ($('.contracts_cert_list tbody tr').length) {
            $('.table_container').fadeIn();
        }
    });

    $(document).on('click', '.remove_record', function () {
        $(this).closest('tr').remove();
        if ($('.contracts_cert_list tbody tr').length == 0)
            $('.table_container').fadeOut();
    });
};
//ask-offer
$('document').ready(function () {
    var ids = [];
    $('#datatable_ajax').on('click', '.ask-offer-benf', function (e) {
        e.preventDefault();
        var id = $(this).closest('tr').find('td:first').text();
        if (!$(this).hasClass('active')) {
            $(this).closest('tr').addClass('active');
            ids.push(id);
        } else {
            $(this).closest('tr').removeClass('active');
            var index = ids.indexOf(id);
            if (index > -1) {
                ids.splice(index, 1);
            }
        }
        $('#ask-offer').attr('value', ids.join());
    });

    $('#main').on('show.bs.modal', function (e) {
        var route = $(e.relatedTarget).data('href');
        $.ajax({
            type: "get",
            data: {},
            url: route,
            success: function (data) {
                $("#main .modal-content").html(data);
                var error_out = $(".modal-body").data("no_data");
                var success_data = $(".modal-body").data("success_data");

                $("#formTest").validate({
                    errorElement: 'span', //default input error message container
                    errorClass: 'help help-block help-block-error', // default input error message class
                    errorPlacement: function (error, element) {
                        if (element.is(':checkbox')) {
                            error.insertAfter(element.closest(".md-checkbox-list, .md-checkbox-inline, .checkbox-list, .checkbox-inline"));
                        } else if (element.is(':radio')) {
                            error.insertAfter(element.closest(".md-radio-list, .md-radio-inline, .radio-list,.radio-inline"));
                        } else {
                            error.insertAfter(element); // for other inputs, just perform default behavior
                        }
                    },
                    highlight: function (element) { // hightlight error inputs
                        $(element)
                            .closest('.form-group').addClass('has-error'); // set error class to the control group
                    },
                    unhighlight: function (element) { // revert the change done by hightlight
                        $(element)
                            .closest('.form-group').removeClass('has-error'); // set error class to the control group
                    },
                    success: function (label) {
                        label
                            .closest('.form-group').removeClass('has-error'); // set success class to the control group
                    }
                });

                $("#formTest").on("submit", function (e) {
                    var btn = $("[type='submit']").button('loading');
                    e.preventDefault();
                    $.ajax({
                        type: "POST",
                        url: $(this).attr('action'),
                        data: new FormData(this),
                        processData: false,
                        contentType: false,
                        success: function (msg) {
                            toastr.success('', msg);
                            setTimeout(function () {
                                location.reload(1);
                            }, 2000);
                        },
                        error: function (msg) {
                            if (msg.status == 401 || msg.status == 404) {
                                window.location = msg.getResponseHeader('Location')
                            }
                            $(".form-body .alert-danger").fadeOut(500);
                            var json = $.parseJSON(msg.responseText);
                            var error = '<div class="alert alert-block alert-danger fade in"><button type="button" class="close" data-dismiss="alert"></button> <p>';
                            $.each(json, function (k, v) {
                                error += v + "</p>";
                            });
                            $(".form-body").prepend(error + '</div>');
                            btn.button('reset');
                        }
                    });
                });
                $("#taqawel_service_type").change(function () {
                    if ($(this).val() == 'other') {
                        $('#new_service').append('<input id="myInput" class="form-control" name="new_service" type="text" />');
                    } else {
                        $('#myInput').remove();
                    }
                });
            }
            , error: function (data) {
                if (data.status == 401 || data.status == 404) {
                    window.location = data.getResponseHeader('Location')
                }
            }
        });
    });
    $('#ask-offer').on('click', function () {
        $.ajax({
            type: "POST",
            url: $(this).attr('data-route'),
            data: {
                id: $(this).val(),
                _token: $(this).attr('data-token')
            },
            headers: {'XSRF-TOKEN': $(this).attr('data-token')},
            success: function (msg) {
                toastr.success('', msg);
                setTimeout(function () {
                    window.location = $('#ask-offer').data('url');
                }, 2000);
            },
            error: function (msg) {
                // if (msg.status == 500 || msg.status == 405) {
                toastr.error('', msg);
                // }
            }
        });
    });

    //Taqawel Service
    $("#taqawel_service_type").change(function () {
        if ($(this).val() == 'other') {
            $('#new_service').append('<input id="myInput" class="form-control" name="new_service" type="text" />');
        } else {
            $('#myInput').remove();
        }
    });

    $(".date-picker-event").datepicker({
        rtl: App.isRTL(),
        autoclose: true,
        dateFormat: 'yy-mm-dd',
        changeYear: true,
        onSelect: function (date) {
            var from, to;
            if ($(this).hasClass('from')) {
                $(".duration").prop('disabled', false);
                from = new Date(date);
                to = $('.to').val().length !== 0 ? new Date($('.to').val()) : from;
            } else if ($(this).hasClass('to')) {
                to = new Date(date);
                from = $('.from').val().length !== 0 ? new Date($('.from').val()) : to;
            }
            var timeDiff = Math.abs(to.getTime() - from.getTime());
            var duration = Math.ceil(timeDiff / (1000 * 3600 * 24))/30;
            if(duration >= 1){
                $('#not_allowed_period').text("");
                $('.duration').val(Math.round(duration));
            }
            else
            $('#not_allowed_period').text(minimum_contract_period);

        },
    });
    if (App.isRTL()) {
        $(".date-picker-event").datepicker("option", "dayNames", ["الأحد", "الاثنين", "الثلاثاء", "الأربعاء", "الخميس", "الجمعة", "السبت", "الأحد"]);
        $(".date-picker-event").datepicker("option", "dayNamesMin", ["ح", "ن", "ث", "ع", "خ", "ج", "س", "ح"]);
        $(".date-picker-event").datepicker("option", "dayNamesShort", ["أحد", "اثنين", "ثلاثاء", "أربعاء", "خميس", "جمعة", "سبت", "أحد"]);
        $(".date-picker-event").datepicker("option", "monthNames", ["يناير", "فبراير", "مارس", "أبريل", "مايو", "يونيو", "يوليو", "أغسطس", "سبتمبر", "أكتوبر", "نوفمبر", "ديسمبر"]);
        $(".date-picker-event").datepicker("option", "isRTL", true);
        $(".date-picker-event").datepicker("option", "monthNamesShort", ["يناير", "فبراير", "مارس", "أبريل", "مايو", "يونيو", "يوليو", "أغسطس", "سبتمبر", "أكتوبر", "نوفمبر", "ديسمبر"]);
        $(".date-picker-event").datepicker("option", "currentText", 'الان');
        $(".date-picker-event").datepicker("option", "firstDay", 6);
    }
    
    $(".duration").on('change', function (){
       var x = parseInt($(this).val());
       var from = $(".from").val();
       var CurrentDate = new Date(from);
      CurrentDate.setMonth(CurrentDate.getMonth() + x);
       $('.to').datepicker("setDate", CurrentDate);
    })
    
   
    $('input[name=contract_type]').on('change', function () {
        if ($(this).val() == 1) {
            $('select[name=contract_ref_no]').closest('div').slideDown();
        } else {
            $('select[name=contract_ref_no]').closest('div').slideUp();
        }
    });


    $('.add-new').on('click', function (e) {
        e.preventDefault();
        $('.container-inputs').append('<input class="bs-select form-control desc-location" name="desc_location[]" type="text" value="">');
    });
    
    $('.update_contract').click(function () {
        $(':input[type="text"]').filter(function (e) {
            if (this.value.length === 0) {
                return true;
            }
        }).remove();
        if (!$('.container-inputs').find('input').length) { 
            $('.container-inputs').append('<input class="bs-select form-control desc-location" name="desc_location[]" type="text" value="">');
        }
    });


    //Taqawel add employees to contract
    $('#datatable_ajax').on('click', '.add_contract_employee', function (e) {
        e.preventDefault();
        var addnew = $(this).closest('tr');
        var add = addnew.find('td:first-child').text();
        var num = 0;
        $('#selected_employees tbody').find("tr td:first-child").each(function () {
            if (add == $(this).text()) {
                num = num + 1;
                addnew.find('td:last-child').html("");
                addnew.find('td:nth-child(2)').find('span').addClass("hidden");
                toastr.error('', already_added);
            }
        });
        if (num == 0) {
            var emp = $(this).closest('tr').clone();
            emp.find('td:nth-child(2)').remove();
            var added = $("#selected_employees tbody").append(emp);
            added.find(".add_contract_employee").replaceWith("<a class='btn btn-default red delete_contract_employee' href=''>" + delete_employee + "</a>");
            if ($("form #oneormore").val() === '0') {
                $('#datatable_ajax tbody tr').each(function () {
                    $(this).find('td:last-child').html("");
                    $("#only_one_employee_msg").text(only_one_employee);
                });
            } else {
                $(this).closest('tr').find('td:nth-child(2)').find('span').addClass("hidden");
                $(this).remove();
            }
        }

    });

    //Taqawel remove choosen employees
    $('#selected_employees').on('click', '.delete_contract_employee', function (e) {
        e.preventDefault();
        var del = $(this).closest('tr').find('td:first-child').text();
        $(this).closest('tr').remove();
        if ($("form #oneormore").val() === '0') {
            $('#datatable_ajax tbody tr').each(function () {
                $(this).find('td:last-child').append("<a class='btn btn-default blue add_contract_employee' href=''>" + add_employee + "</a>");
            });
        } else {
            $('#datatable_ajax').find("tr td:first-child").each(function () {
                if ($(this).text() === del) {
                    $(this).closest('tr').find('td:nth-child(2)').find('span').removeClass("hidden");
                    $(this).closest('tr').find('td:last-child').append("<a class='btn btn-default blue add_contract_employee' href=''>" + add_employee + "</a>");
                }
            });
        }

    });

    //Taqawel add Multi Employee
    $("#add_employees").on('click', function (e) {
        e.preventDefault();
        $('#datatable_ajax').find('tr').find('td:nth-child(2)').find(".checked").each(function () {
            var addnew = $(this).closest('tr');
            var add = addnew.find('td:first-child').text();
            var num = 0;
            $('#selected_employees tbody').find("tr td:first-child").each(function () {
                if (add == $(this).text()) {
                    num = num + 1;
                    addnew.find('td:last-child').html("");
                    addnew.find('td:nth-child(2)').find('span').addClass("hidden");
                    toastr.error('', already_added);
                }
            });
            if (num == 0) {
                var emp = $(this).closest('tr').clone();
                emp.find('td:nth-child(2)').remove();
                var added = $("#selected_employees tbody").append(emp);
                added.find(".add_contract_employee").replaceWith("<a class='btn btn-default red delete_contract_employee' href=''>" + delete_employee + "</a>");
                if ($("form #oneormore").val() === '0') {
                    $('#datatable_ajax tbody tr').each(function () {
                        $(this).find('td:last-child').html("");
                        $("#only_one_employee_msg").text(only_one_employee);
                    });
                } else {
                    addnew.find('td:last-child').html("");
                    addnew.find('td:nth-child(2)').find('span').addClass("hidden");
                }
            }
        });

    });


    // submit add taqawel notice form

    $('body').find("#ensure_data").on('click', function () {
        var emp_ids = [];
        var rowsCount = $('#selected_employees tr').length;
        var areas = [];
        $('#work_areas :selected').each(function (i, selected) {
            if ($("#work_areas :selected").index() == 0) {

            } else {

                areas[i] = $(selected).text();
            }

        });
        if (rowsCount > 1) {
            $('#selected_employees tbody').find("tr td:first-child").each(function () {
                emp_ids.push($(this).text());
            });

            // submit form
            $.ajax({
                type: "POST",
                url: $("#taqawel_notices_form").attr('action'),
                data: {
                    ids: emp_ids,
                    contract_id: $("#contract_id").val(),
                    start_date: $("#start_date").val(),
                    end_date: $("#end_date").val(),
                    contract_start_date: $("#contract_start_date").val(),
                    contract_end_date: $("#contract_end_date").val(),
                    work_areas: areas,
                    _token: $(this).attr('data-token')
                },
                headers: {'XSRF-TOKEN': $(this).attr('data-token')},
                success: function (msg) {
                    toastr.success('', msg);
                    setTimeout(function () {
                        window.location = $('#taqawel_notices_form').data('url');
                    }, 2000);
                },
                error: function (msg) {
                    if (msg.status == 401 || msg.status == 404) {
                        window.location = msg.getResponseHeader('Location')
                    }
                    if (msg.status == 500 || msg.status == 405) {
                        toastr.error('', bug_msg);
                    }
                    var json = $.parseJSON(msg.responseText);
                    var error = '';
                    $.each(json, function (k, v) {
                        error += "<span>" + v + "</span><br/>";
                    });
                    toastr.error('', error);
                    $(".alert-danger").removeClass('hidden');
                    $(".alert-danger").append(error);
                }
            });

        } else {
            toastr.error('', must_have_employee);
        }


    });

    // detect provider or beneficial in taqawel notices
    $('#taqawel-type-select').on('change', function () {
        var val = $(this).val();
        var route = $(this).data('route');
        if (val)
            window.location = route + '/type/' + val;
        else
            window.location = route;

    });
    
    // detect job seeker or job owner in DirectHiring labor market
    $('#directHiring-type-select').on('change', function () {
        var val = $(this).val();
        if (val)
            window.location = val;
       

    });
});

$(document).on('click', '.service', function () {
    var that = $(this);
    $.ajax({
        type: "POST",
        url: $(this).attr('data-url'),
        data: {
            id: $(this).attr('data-id'),
            _token: $(this).attr('data-token')
        },
        headers: {'XSRF-TOKEN': $(this).attr('data-token')},
        success: function (msg) {
            toastr.success('', msg);
            setTimeout(function () {
                //window.location = that.data('url');
            }, 2000);
        },
        error: function (msg) {
            // if (msg.status == 500 || msg.status == 405) {
            toastr.error('', msg);
            // }
        }
    });
});

$(document).ready(function () {
    $('select#prvd_benf').on('change', function () {
        window.location = $(this).data('url' + $(this).val());
    });
});


function selectEmployee(selected_row, id) {
    if ($("#selected_row_" + id).length)
        return false;
    row = $(selected_row).closest('tr').html();
    $('#contract_requests').show();
    $('#selected_employees tbody').append('<tr id="selected_row_' + id + '">' + row + '</tr>');
    $('#selected_row_' + id).find("td:first").remove();
    $('#selected_row_' + id).find("td:last").remove();
    $('#selected_row_' + id).append('<td><div class="form-group">' +
        '<input class="form-control form-filter input-sm salary-input" name="salary[]" type="text">' +
        '</div></td>');
    $('#selected_row_' + id).append('<td><div class="form-group">' +
        '<div class="col-md-3">' +
        '<div class="fileinput fileinput-new" data-provides="fileinput">' +
        '<div class="input-group input-small">' +
        '<div class="form-control input-fixed input-small" data-trigger="fileinput">' +
        '<i class="fa fa-file fileinput-exists"></i>&nbsp;' +
        '<span class="fileinput-filename"> </span>' +
        '</div>' +
        '<span class="input-group-addon btn default btn-file">' +
        '<span class="fileinput-new"> ' + select_file + '</span>' +
        '<span class="fileinput-exists">' + change + '</span>' +
        '<input type="file" name="fileupload_' + id + '"> </span>' +
        '<a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput">' +
        remove + '</a>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div></td>');
    $('#selected_row_' + id).append('<td><a class="del_tr"></a><input type="hidden" name="ids[]" value="' + id + '" /></td>');

    return true;
}

function selectEmployeeFromMarket(selected_row, id) {
    if ($("#selected_row_" + id).length)
        return false;
    row = $(selected_row).closest('tr').html();
    $('#contract_requests').show();
    $('#selected_employees_benf tbody').append('<tr id="selected_row_' + id + '">' + row + '</tr>');
    $('#selected_row_' + id).find("td:first").remove();
    $('#selected_row_' + id).find("td:last").remove();
    $('#selected_row_' + id).append('<td><a class="del_tr" rel="' + id + '"></a><input type="hidden" name="ids[]" value="' + id + '" /></td>');

    ids_str = $('#ask-offer').val();
    if (ids_str)
        ids = ids_str.split(',');
    else
        ids = [];
    ids.push(id);
    $('#ask-offer').attr('value', ids.join());
    return true;
}

$('document').ready(function () {
    $('#labor_click').on('click', function () {
        var check_pass = '';
        $(".select-checkbox:checked").each(function () {
            check_pass = '1';
            $(this).attr('checked', false);
            $(this).parent().removeClass("checked");
            selectEmployee(this, $(this).val());
        });
        if (check_pass) {
            $("html, body").animate({
                scrollTop: $('#selected_employees').offset().top
            }, 500);
        }
        else {
            toastr.error('', select_at_least_one);
        }
    });
    $('#select_employees_benf').on('click', function () {
        var check_pass = '';
        $(".select-checkbox:checked").each(function () {
            check_pass = '1';
            $(this).attr('checked', false);
            $(this).parent().removeClass("checked");
            selectEmployeeFromMarket(this, $(this).val());
        });
        if (check_pass) {
            $("html, body").animate({
                scrollTop: $('#selected_employees').offset().top
            }, 500);
        }
        else {
            toastr.error('', select_at_least_one);
        }
    });
    $('.labor_employee_data').on('click', '.select_emp', function (e) {
        e.preventDefault();
        var href = $(this).attr('href');
        id = href.replace("#/", "");
        return selectEmployee(this, id);
    });
    $('#selected_employees').on('click', '.del_tr', function (e) {
        $(this).parent().parent().remove();
        if ($('#selected_employees tbody tr').length == 0)
            $('#contract_requests').hide();
    });

    $('.labor_employee_data_benf').on('click', '.select_emp', function (e) {
        e.preventDefault();
        var href = $(this).attr('href');
        id = href.replace("#/", "");
        return selectEmployeeFromMarket(this, id);
    });
    $('#selected_employees_benf').on('click', '.del_tr', function (e) {
        $(this).parent().parent().remove();
        if ($('#selected_employees_benf tbody tr').length == 0)
            $('#contract_requests').hide();

        id = $(this).attr('rel');
        ids_str = $('#ask-offer').val();
        ids = ids_str.split(',');
        var index = ids.indexOf(id);
        if (index > -1) {
            ids.splice(index, 1);
        }
        $('#ask-offer').attr('value', ids.join());
    });
    
    //append contract id to cancellation modal
    $('#taqawelModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var modal = $(this);
        var id = button.data('contract_id');
        modal.find(".modal-body input[name=id]").val(id);
       
});

//certificate generate Invoice
$('#certificate_generate_invoice').click(function (e) {
    e.preventDefault();
    {
        var button = $(this);
        var IDs = [];
        $('.contracts_cert_list > tbody  > tr').each(function(){
            IDs.push($(this).find('td:first-child').text()); 
        });
        console.log(IDs);
        $.ajax({
            type: "POST",
            url: $(this).attr('href'),
            data:{
                contract_ids :IDs,
                _token : button.data('token')
            },
            headers: {'XSRF-TOKEN': button.data('token')},
            success: function (msg) {
                console.log(msg);
                $("#after_invoice").text(msg + after_generate_invoice);
                $(button).css('display', 'none');
                toastr.success('', msg);
            },
            error: function (msg) {
                if (msg.status == 401 || msg.status == 404) {
                    window.location = msg.getResponseHeader('Location')
                }
                if (msg.status == 500 || msg.status == 405) {
                    toastr.error("", bug_msg);
                }
                var json = $.parseJSON(msg.responseText);
                var error = '<p>';
                $.each(json, function (k, v) {
                    error += v + "</p>";
                });
                toastr.error("", error);
            }
        });

    }
});

});
