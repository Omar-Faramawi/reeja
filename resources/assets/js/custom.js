$(function () {
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "positionClass": "toast-top-right",
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

    $("input[name=ishaar_cancel_paid], input[name=ishaar_cancel_free]").on('change', function() {
        if(!$("input[name=ishaar_cancel_paid]").is(":checked") && !$("input[name=ishaar_cancel_free]").is(":checked")) {
            $("input[name=ishaar_cancel_provider]").val('');
            $("input[name=ishaar_cancel_benf]").val('');
            $('.ishaar-cancel-container').hide();
        } else {
            $('.ishaar-cancel-container').show();
        }
    });


    /**
     * Get establishment data based on inputs
     * @constructor
     */
    function molConnect(error_out, success_out) {
        $(".form-body .alert-danger").remove();

        var labour_office_no = $("#labour_office_no").val();
        var sequence_no = $("#sequence_no").val();
        var id_number = $("#id_number").val();

        if (!id_number || !sequence_no || !labour_office_no) {
            toastr.error("", missing_required_fields);
            return;
        }

        var params = "?labour_office_no=" + labour_office_no + "&sequence_no=" + sequence_no + "&id_number=" + id_number;

        $.ajax({
            url: $(location).attr('href') + "/establishmentData" + params
            , success: function (data) {
                if (data.status == true) {
                    //$("#labour_office_no").val(data.est.labor_office_id);
                    //$("#sequence_no").val(data.est.sequence_number);
                    //$("#id_number").val(data.est.FK_establishment_id);
                    $("#name").val(data.est.name);
                    $("#est_activity").val(data.est.economic_activity);
                    $("#est_size").val(data.est.size_id);
                    $("#est_nitaq").val(data.est.nitaqat_color);
                    $("#district").val(data.est.district);
                    $("#city").val(data.est.city);
                    $("#region").val(data.est.region);
                    var address = data.est.street + "-" + data.est.region + "-" + data.est.city;
                    $("#wasel_address").val(address);
                    $("#local_liecense_no").val(data.est.cr_number);
                    $("#phone").val(data.est.phone);
                    toastr.success('', success_out);
                } else {
                    toastr.error('', error_out);
                }
            }
            , error: function (data) {
                toastr.error('', error_out);
            }
        });
    }

    function validate_form() {
        $("#form, #another_form, #another_form1, #live_form, #form_nationalities, #form_qualification, #form_experience, #form_banks, #form_reasons, #form_attachments, #form_est_sizes, #form_bundle").validate({
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
    }

    function prepare_inputs() {
        $('.bs-select').selectpicker({
            noneSelectedText: noneSelectedTextValue,
            noneResultsText: noSearchResult + " {0}",
            countSelectedText: function (a, b) {
                return 1 == a ? "{0} " + itemSelected : "{0} " + itemsSelected
            },
            selectAllText: selectAll,
            deselectAllText: deselectAll,
            iconBase: 'fa',
            tickIcon: 'fa-check',
            container: 'body'
        });
        //ComponentsSelect2.init();

        var error_out = $(".modal-body").data("no_data");
        var success_data = $(".modal-body").data("success_data");
        $("#mol_search_co").click(function () {
            molConnect(error_out, success_data);
        });
        $("#labour_office_no,#sequence_no,#id_number").keypress(function (e) {
            if (e.which == 13) {
                e.preventDefault();
                molConnect(error_out, success_data);
            }
        });

        $(".make-switch").bootstrapSwitch();

        $(".date-picker").datepicker({
            dateFormat: 'yy-mm-dd',
            changeYear: true
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

        $('#main').on('click', '#taqawel_services', function () {
            $("#taqawel_services_div").toggle(this.checked);
        });
        $('#main').on('click', '#hire_labore', function () {
            $("#hire_labore_div").toggle(this.checked);
        });
        $('#main').on('click', '#direct_emp', function () {
            $("#direct_emp_div").toggle(this.checked);
        });

    }

    validate_form();
    prepare_inputs();

    $("#form").on("submit", function (e) {
        var btn = $("[type='submit']").button('loading');
        var form = $(this);
        $(".form-body .alert-danger").remove();
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
                var json = $.parseJSON(msg.responseText);
                var error = '<div class="alert alert-block alert-danger fade in"><button type="button" class="close" data-dismiss="alert"></button> <p>';
                $.each(json, function (k, v) {
                    error += v + "</p>";
                });
                form.find(".form-body").prepend(error + '</div>');
                btn.button('reset');
                $('html,body').animate({
                    scrollTop: ($(".form-body").offset().top - 200)
                }, 1000);
            }
        });
    });

    $("#live_form, #another_form, #another_form1").on("submit", function (e) {
        var btn = $("[type='submit']").button('loading');
        $(".form-body .alert-danger").remove();
        e.preventDefault();
        var current = $(this);
        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function (msg) {
                toastr.success('', msg);
                if (current.data('back-url')) {
                    setTimeout(function () {
                        window.location = current.data('back-url');
                    }, 2000);
                }
                btn.button('reset');
            },
            error: function (msg) {
                if (msg.status == 401 || msg.status == 404) {
                    window.location = msg.getResponseHeader('Location')
                }
                var json = $.parseJSON(msg.responseText);
                var error = '<div class="alert alert-block alert-danger fade in"><button type="button" class="close" data-dismiss="alert"></button> <p>';
                $.each(json, function (k, v) {
                    error += v + "</p>";
                });
                $(".form-body").prepend(error + '</div>');
                btn.button('reset');
                $('html,body').animate({
                    scrollTop: ($(".form-body").offset().top - 200)
                }, 1000);
            }
        });
    });

    $('body').on('confirmed.bs.confirmation', '.delete-ajax', function () {
        var route = $(this).data('hreff');
        var token = $(this).data('token');
        var target_id = $(this).data('id');
        $.ajax({
            type: "post",
            data: {_method: 'delete', _token: token, id: target_id},
            url: route,
            success: function (data) {
                $("tr." + target_id).toggle(500);
                toastr.error('', data);
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
    $('body').on('confirmed.bs.confirmation', '.action-ajax', function () {
        var route = $(this).data('hreff');
        var token = $(this).data('token');
        var target_id = $(this).data('id');
        var trans = $(this).data('trans');
        var type = $(this).data('type');
        $.ajax({
            type: "post",
            data: {_method: 'patch', _token: token, id: target_id, type: type},
            url: route,
            success: function (data) {
                toastr.info('', data);
                if (type == 'approve') {
                    $('td#' + target_id).html("<span class='badge bg-green-seagreen bg-font-green-seagreen'>" + trans + "</span>");
                    $('#taqyeem_enable_btn').hide();
                    $('#taqyeem_disable_btn').show();
                }
                else {
                    $('td#' + target_id).html("<span class='badge label-sm label-danger'>" + trans + "</span>");
                    $('#taqyeem_enable_btn').show();
                    $('#taqyeem_disable_btn').hide();
                }
            }
        });
    });
    $('#main').on('show.bs.modal', function (e) {
        $("#main .modal-content").html('<div class="modal-dialog"><div class="modal-content"> <div class="modal-body">' + "<img class='loading' src='" + loading_img + "' />" + '</div> </div> </div> </div>');

        var route = $(e.relatedTarget).data('href');
        $.ajax({
            type: "get",
            data: {},
            url: route,
            success: function (data) {
                $("#main .modal-content").html(data);
                prepare_inputs();

                var error_out = $(".modal-body").data("no_data");
                var success_data = $(".modal-body").data("success_data");

                validate_form();

                $("#form").on("submit", function (e) {
                    var btn = $("[type='submit']").button('loading');
                    $(".form-body .alert-danger").remove();
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

                $(document).on('click', '.sessionClose', function (e) {
                    e.preventDefault();
                    $(this).closest('.submitform').fadeOut(300, function () {
                        $(this).remove();
                    });
                    var route = $(this).data('action');
                    var token = $(this).data('token');
                    var addOrEdit = $(this).data('status');
                    $.ajax({
                        type: "post",
                        data: {_method: 'patch', _token: token, addOrEdit: addOrEdit},
                        url: route,
                        success: function (data) {
                            $(".resultdiv").html(data);


                        }
                    });

                });
                $(document).on('click', '.btn-add', function (e) {
                    e.preventDefault();
                    $elementsGroup = $(this).closest('.divAdd').clone();
                    $elementsGroup.find("#answer").val("");
                    $(this).after("<button class='remove'><i class='fa fa-close'></i></button>");
                    $elementsGroup.insertAfter($(this).closest('.divAdd'));
                    $(this).remove();
                });


                $(document).on('click', '.remove', function () {
                    $(this).closest('.divAdd').remove();
                });

                /* Banks Checkbox toggles*/
                $('input[name="type"]').on('change', function (e) {
                    var checked = $(this).attr('id');
                    if (checked == 'children') {
                        $('select[name="parent_bank_id"]').show();
                    } else {
                        $('select[name="parent_bank_id"]').hide();
                        $('select[name="parent_bank_id"]').val('');
                    }
                });

                /* Settigns Submission */
                $('#form_nationalities, #form_qualification, #form_experience, #form_banks, #form_reasons, #form_attachments, #form_est_sizes, #form_bundle').click(function (event) {
                    $(this).data('clicked', $(event.target));
                });

                $('#form_nationalities, #form_qualification, #form_experience, #form_banks, #form_reasons, #form_attachments, #form_est_sizes, #form_bundle').on("submit", function (e) {
                    var btn = null;
                    if ($(this).data('clicked').is('[name="saveandadd"]')) {
                        btn = $("[type='submit'][name='saveandadd']").button('loading');
                        console.log('Save and Add');
                    } else {
                        btn = $("[type='submit'][name='save']").button('loading');
                        console.log("Save");
                    }
                    var that = $(this);
                    $(".form-body .alert-danger").remove();
                    e.preventDefault();
                    $.ajax({
                        type: "POST",
                        url: $(this).attr('action'),
                        data: new FormData(this),
                        processData: false,
                        contentType: false,
                        success: function (msg) {
                            if (that.data('clicked').is('[name="saveandadd"]')) {
                                toastr.success('', msg);
                                $('input[name="name"').val('');
                                btn.button('reset');
                            } else {
                                toastr.success('', msg);
                                setTimeout(function () {
                                    location.reload(1);
                                }, 2000);
                            }
                        },
                        error: function (msg) {
                            if (msg.status == 401 || msg.status == 404) {
                                window.location = msg.getResponseHeader('Location')
                            }
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
            }
            , error: function (data) {
                if (data.status == 401 || data.status == 404) {
                    window.location = data.getResponseHeader('Location')
                }
            }
        });

    });


    //Remove unchecked checkboxes before form submission
    $('form.removeCheckboxes button[type=submit]').on('click', function () {
        $('.gov_activity input:checkbox:not(:checked)').each(function (k, v) {
            $(v).closest('tr.gov_activity').find('.act_checked').attr('value', 0);
        });
    });

    // Show/hide boxes on checkbox check/uncheck
    function valueChanged(selector, checked) {
        if (checked)
            $(selector).show();
        else
            $(selector).hide();
    }

    $('.toggling_checkbox').on('change', function (e) {
        valueChanged($(this).data('boxclass'), this.checked);
    });


    // Bind the selected value with the targeted input to show or hide
    // add data-value with the same value of the selected
    $('#main').on('change', '.auto-hide', function (e) {
        var that = $(this);
        var selectedValue = that.find(':selected').val();
        var id = that.attr("id");
        var inputs = $('#main').find('input');
        that.closest('.extra').hide();
        inputs.each(function (index, element) {
            var dataValue = $(element).attr('data-value');
            var idValue = $(element).attr('data-id');
            if (idValue === id) {
                $(element).closest('.extra').hide();
            }
        });

        inputs.each(function (index, element) {
            var dataValue = $(element).attr('data-value');
            var idValue = $(element).attr('data-id');
            if ((dataValue === selectedValue) && (idValue === id)) {
                $(element).closest('.extra').show();
            }
        });
    });

    $('#tab3').on('change', '.auto-hide1', function (e) {
        $(".extra").hide();
        if ($(this).val() == 1) {
            $(".extra").show();
        }
    });

    $('#main').on('click', '.add-regions', function () {
        $.ajax({
            url: $(this).attr('data-route'),
            type: 'POST',
            data: {
                _token: $('input[name=_token]').val(),
                name: $(this).prev().val()
            },
            success: function (msg) {
                toastr.success('', msg);
                setTimeout(function () {
                    location.reload(1);
                }, 2000);
            },
            error: function (msg) {
                var json = $.parseJSON(msg.responseText);
                var error = '';
                $.each(json, function (k, v) {
                    error += v;
                });
                toastr.error('', error);
            }
        });
    });

    $('#main').on('change', 'input[name=taqyeem_type]', function () {
        $(".form-body .alert-danger").remove();
        $('.partial-resident-div').empty();
        $('.partial-page-content').empty();
        var that = $(this);

        $.ajax({
            url: $(this).data('url'),
            beforeSend: function (xhr) {
                $('.partial-div .page-loader').first().fadeIn();
            },
            success: function (response) {
                $('.partial-div .page-loader').first().fadeOut();

                if (that.val() == "2") {
                    $('.partial-resident-div').append(response);
                    that.closest('.row').nextAll('.details').show();
                } else {
                    $('.partial-page-content').append(response);
                    that.closest('.row').nextAll('.details').hide();
                }
                prepare_inputs();
            }
        });
    });

    $('#main').on('change', 'input[name=residents]', function () {
        var that = $(this);
        if (that.val() == 2) {
            $('.residents_search').remove();
            $('#userTypeResidents').hide();
            $.ajax({
                url: $(this).data('url'),
                beforeSend: function (xhr) {
                    $('.resident-div .page-loader').first().fadeIn();
                },
                success: function (response) {
                    $('.resident-div .page-loader').first().fadeOut();
                    $(response).insertAfter('.residents_type');
                }
            });
        } else {
            $('#userTypeResidents').show();
            $('.residents_search').remove();
        }
    });

    $('#main').on('change', 'input[name=periodic_or_date]', function () {
        if ($(this).val() == 1) {
            $('#taqyeem_date_div').hide();
            $('#taqyeem_period').show();
        } else {
            $('#taqyeem_period').hide();
            $('#taqyeem_date_div').show();
        }
    });

    $('#main').on('click', '#search-users', function () {
        $('.search-results').empty();
        var that = $(this);
        var inputValue = that.closest('.row').find('input').val();
        var selectorValue = that.closest('.row').find('select').val();
        $.ajax({
            url: that.data('url'),
            data: {
                name: inputValue,
                type: selectorValue
            },
            beforeSend: function (xhr) {
                $('.resident-div .page-loader').first().fadeIn();
            },
            success: function (response) {
                $('.resident-div .page-loader').first().fadeOut();
                $('.search-results').append(response);
            }
        });
    });


    $('#main').on('click', 'a[rel]', function (e) {

        e.preventDefault();
        $('.search-results').empty();
        var that = $(this);
        var searchUsers = $('#search-users');
        $.ajax({
            url: that.attr('href'),
            data: {
                name: searchUsers.closest('.row').find('input').val(),
                type: searchUsers.closest('.row').find('select').val()
            },
            beforeSend: function (xhr) {
                $('.resident-div .page-loader').first().fadeIn();
            },
            success: function (response) {
                $('.resident-div .page-loader').first().fadeOut();
                $('.search-results').append(response);
            }
        });
    });

    var inputValue = new Array();

    $('#main').on('change', '.input-id', function (e) {
        e.preventDefault();
        var that = $(this);
        if (that.is(':checked')) {
            if (!$("#taqyeem_row_" + that.attr('data-userType') + '_' + that.val()).length) {
                var tr = that.closest('tr');
                var tableDiv = $('.table-div');
                var clonedTr = tr.clone();
                tableDiv.show();
                clonedTr.attr('id', "#taqyeem_row_" + that.attr('data-userType') + '_' + that.val());
                clonedTr.find("td:first").remove();
                clonedTr = clonedTr.append('<td><input type="hidden" name="ids[]" value="' + that.val() + '"><input type="hidden" name="userType[]" value="' + that.attr('data-userType') + '"><button class="remove-row btn btn-danger error">&times;</button></td>');

                tableDiv.find('tbody').append(clonedTr);
                tableDiv.show();
            }
        }
    });

    $('#main').on('click', '.remove-row', function (e) {
        e.preventDefault();
        $(this).closest('tr').remove();
        if ($('.table-div tbody tr').length) {
            $('.table-div').show();
        } else {
            $('.table-div').hide();
        }
    });

    $(document).on("click", "#btn-save", function (e) {
        var btn = $("#btn-save").button("loading");
        $(".form-body .alert-danger").remove();
        e.preventDefault();
        var route = $(this).data('action');
        var token = $(this).data('token');
        var question = $("#question").val();
        var answers = [];
        $('input[id^="answer"]').each(function (input) {
            if ($(this).val() != '')
                answers.push($(this).val());
            //var value = $(this).val();
        });
        if (!answers[0])
            answers.push('');
        $.ajax({
            type: "post",
            data: {_method: 'patch', _token: token, question: question, answers: answers},
            url: route,
            success: function (data) {
                $(".QAalert").remove();
                $(".resultdiv").html(data);
                $("#question").val("");
                $(".answerClass").val("");
                btn.button('reset');

            },
            error: function (msg) {
                if (msg.status == 401 || msg.status == 404) {
                    window.location = msg.getResponseHeader('Location')
                }
                var json = $.parseJSON(msg.responseText);
                var error = '<div class="alert alert-block alert-danger fade in QAalert"><button type="button" class="close" data-dismiss="alert"></button> <p>';
                $.each(json, function (k, v) {
                    error += v + "</p>";
                });
                $(".form-body").prepend(error + '</div>');
                btn.button('reset');
            }

        });
    });
    $('body').on('click', '.send_template', function (e) {
        if ($(this).attr('id') == 'nextButton') {
            $('#go_next').val('1');
        } else {
            $('#go_next').val('0');
        }
    });
    $('body').on('submit', '#taqeemform', function (e) {
        var btn = $("[type='submit']").button('loading');
        $(".form-body .alert-danger").remove();
        e.preventDefault();
        var route = $('#nextButton').data('href');
        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            data: new FormData(this),
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (msg) {
                toastr.success('', msg['msg']);
                if (msg['refresh'] == true) {
                    setTimeout(function () {
                        location.reload(1);
                    }, 1000);
                } else {
                    $("#main .modal-content").html('<div class="modal-dialog"><div class="modal-content"> <div class="modal-body">' + "<img class='loading' src='" + loading_img + "' />" + '</div> </div> </div> </div>');
                    $.ajax({
                        type: "get",
                        data: {},
                        url: route + '/' + msg['taqeemID'],
                        success: function (data) {
                            $("#main .modal-content").html(data);
                        }
                        , error: function (data) {
                            if (data.status == 401 || data.status == 404) {
                                window.location = data.getResponseHeader('Location')
                            }
                        }
                    });
                }
            },
            error: function (msg) {
                if (msg.status == 401 || msg.status == 404) {
                    window.location = msg.getResponseHeader('Location')
                }
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

    $('body').on('submit', '#taqyeem_permissions_form', function (e) {
        var btn = $("[type='submit']").button('loading');
        $(".form-body .alert-danger").remove();
        e.preventDefault();
        var current = $(this);
        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function (msg) {
                toastr.success('', msg);
                if (current.data('back-url')) {
                    setTimeout(function () {
                        window.location = current.data('back-url');
                    }, 2000);
                }
            },
            error: function (msg) {
                if (msg.status == 401 || msg.status == 404) {
                    window.location = msg.getResponseHeader('Location')
                }
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

    $('body').on('click', 'button[value=cancel]', function (e) {
        e.preventDefault();
        location.reload();
    });

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        $(".form-body .alert-danger").remove();
    });

    $('#filter').change(function () {
        var search_text = $(this).val();
        if (search_text == '') {
            $("#table tr").show();
            $("#table2 tr").show();
        } else {
            $("#table tr").hide();
            $("#table2 tr").hide();
            $("#table td:first-child").filter(function () {
                return $(this).text().trim() === search_text.trim();
            }).parent().show();
            $("#table2 td:last-child").filter(function () {
                return $(this).text().trim() === search_text.trim();
            }).parent().show();
        }
    });

    jQuery.extend(jQuery.validator.messages, {});

    /**
     * Hijri calender handler
     */
    var islamicCalendarLang = '';
    if (App.isRTL()) {
        islamicCalendarLang = 'ar';
    }
    $('#period_start_date, #period_end_date').calendarsPicker({
        calendar: $.calendars.instance('islamic', islamicCalendarLang),
        
        onSelect: function() {
            // floating label adjustment
            if ($(this).val().length > 0) {
                $(this).addClass('edited');
            } else {
                $(this).removeClass('edited');
            }
        },
        onClose: function() {
            // floating label adjustment
            if ($(this).val().length > 0) {
                $(this).addClass('edited');
            } else {
                $(this).removeClass('edited');
            }
        }
    });
	
    
    // add job nationalities
     $('body').on('click', 'button[id=add_job_nationalities]', function (e) {
        var job_name = $('#jobs option:selected').text();
        var job_id = $('#jobs').val();
        var edit_nationalities = []; 
        $('#nationalities option:selected').each(function(i, selected){ 
            if ($(selected).val() > 0) {
                edit_nationalities[i] = $(selected).text(); 
            }
        });
        if (!job_name || edit_nationalities.length == 0) {
            toastr.error("", $(this).data('error'));
        } else { 
            var delete_button = '<button type="button" class="btn sbold red" id="delete_job_nationalities"><i class="fa fa-check"></i> '+ display_delete_button +'</button>';
            $("#job_nationalities_table tbody #second_row_in_selected").show();       
            $("#job_nationalities_table tbody").append('<tr><td><input type="hidden" name="job[]" value="'+ job_id +'">'+ job_name +'</td><td><input type="hidden" name="nationalities['+job_id+']" value="'+ $('#nationalities').val()+'">'+ edit_nationalities +'</td><td>'+ delete_button +'</td></tr>');
            $('#job_nationalities_table .bs-select').selectpicker('deselectAll');
        }
    });
	
    //delete already added job nationality
    $('body').on('click', 'button[id=delete_job_nationalities]', function (e) {
        $(this).closest('tr').remove();
    });	
});
