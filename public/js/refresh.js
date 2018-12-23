$(document).ready(function() {

    if($('#ticket-screen').val() || $('#insert_ticket').val() || $('#insert_coins').val() || $('#exit_insert_ticket').val()) {
        $.ajax({ url: window.location.href,
            context: document.body,
            success: function() {
                $(window).scrollTop($(document).height());
            }
        });
    }

    $('#ticket_info').click(function () {
        $('#info').slideToggle(500);
    });

});
