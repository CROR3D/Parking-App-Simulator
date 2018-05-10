$(document).ready(function () {
    $('.box').hide();
    $('#starting_time').show();
    $('#selectTime').change(function () {
        $('.box').hide();
        var option = $(this).val();
        $('#'+option).show();
    });
});
