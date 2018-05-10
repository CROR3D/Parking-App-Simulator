$(document).ready(function() {
    $(window).on('load', function() {
        $("#select3").val('---');
    });

    $("#select3").change(function() {
        var slug_city = $('#select3').find(':selected').text();
        $('button[name=select_all]').val(slug_city);
    });
});
