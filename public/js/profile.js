$(document).ready(function () {
    $('#change_username').click(function(){
        $('#change_username').hide();
        $('#username_input').attr('readonly', false);
        $('#save_username').show();
    });

    $('#save_username').click(function(){
        $('#save_username').hide();
        $('#username_input').attr('readonly', true);
        $('#change_username').show();
    });

    $('#change_email').click(function(){
        $('#change_email').hide();
        $('#email_input').attr('readonly', false);
        $('#save_email').show();
    });

    $('#save_email').click(function(){
        $('#save_email').hide();
        $('#email_input').attr('readonly', true);
        $('#change_email').show();
    });

    $('#change_card').click(function(){
        $('#change_card').hide();
        $('#card_input').attr('readonly', false);
        $('#save_card').show();
    });

    $('#save_card').click(function(){
        $('#save_card').hide();
        $('#card_input').attr('readonly', true);
        $('#change_card').show();
    });
});
