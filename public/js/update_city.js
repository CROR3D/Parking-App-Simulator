$(document).ready(function () {
    $('.checkbox-group[type="checkbox"]').on('change', function() {
        $('.checkbox-group[type="checkbox"]').not(this).prop('checked', false);
    });
});
