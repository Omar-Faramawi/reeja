$(".e1").select2();
$(function () {
    $('#datetimepicker1, .datetimepicker1').datetimepicker({
        'format': 'YYYY-MM-DD'
    });

    $(".work_start_date").on("dp.change", function (e) {
        $('.work_end_date').data("DateTimePicker").minDate(e.date);
    });
    $(".work_end_date").on("dp.change", function (e) {
        $('.work_start_date').data("DateTimePicker").maxDate(e.date);
    });
});
