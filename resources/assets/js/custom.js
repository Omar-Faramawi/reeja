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

    /**
     * Get establishment data based on inputs
     * @constructor
     */
    function molConnect(error_out, success_out) {
        var labour_office_no = $("#labour_office_no").val();
        var sequence_no = $("#sequence_no").val();
        var id_number = $("#id_number").val();

        if (!id_number && (!sequence_no || !labour_office_no)) {
            toastr.error("", error_out);
            return;
        }
        var params = "?labour_office_no=" + labour_office_no + "&sequence_no=" + sequence_no + "&id_number=" + id_number;

        $.ajax({
            url: $(location).attr('href') + "/establishmentData" + params
            , success: function (data) {
                if (data.status == true) {
                    $("#labour_office_no").val(data.est.labor_office_id);
                    $("#sequence_no").val(data.est.sequence_number);
                    $("#id_number").val(data.est.FK_establishment_id);
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

    validate_form();

    $("#form, #another_form, #another_form1").on("submit", function (e) {
        var btn = $("[type='submit']").button('loading');
        var form = $(this);
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
                form.find(".form-body").prepend(error + '</div>');
                btn.button('reset');
            }
        });
    });

    $("#live_form").on("submit", function (e) {
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
                btn.button('reset');
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
                }
                else {
                    $('td#' + target_id).html("<span class='badge label-sm label-danger'>" + trans + "</span>");
                }
            }
        });
    });
    $('#main').on('show.bs.modal', function (e) {
        $("#main .modal-content").html('<div class="modal-dialog"><div class="modal-content"> <div class="modal-body">'+"<img class='loading' src='" + loading_img + "' />"+'</div> </div> </div> </div>');

        var route = $(e.relatedTarget).data('href');
        $.ajax({
            type: "get",
            data: {},
            url: route,
            success: function (data) {
                $("#main .modal-content").html(data);

                $('.bs-select').selectpicker({
                    iconBase: 'fa',
                    tickIcon: 'fa-check'
                });
                ComponentsSelect2.init();

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

                validate_form();

                $("#form").on("submit", function (e) {
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

                })
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


                $(document).on("click", "#btn-save", function (e) {
                    var btn = $("#btn-save").button("loading");
                    e.preventDefault();
                    var route = $(this).data('action');
                    var token = $(this).data('token');
                    var question = $("#question").val();
                    var answers = [];
                    $('input[id^="answer"]').each(function (input) {
                        answers.push($(this).val());
                        var value = $(this).val();
                        var id = $(this).attr('id');
                    });
                    console.log()
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
                            $(".form-body .alert-danger").fadeOut(500);
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
                                $(".form-body .alert-danger").fadeOut(500);
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

    jQuery.extend(jQuery.validator.messages, {});
});
