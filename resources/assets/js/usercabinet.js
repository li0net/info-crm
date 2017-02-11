$(document).ready(function () {
    $("#mailings_form_success_alert").hide();
    $("#mailings_form_error_alert").hide();
    $("#main_info_form_success_alert").hide();
    $("#main_info_form_error_alert").hide();
    $("#password_form_success_alert").hide();
    $("#password_form_error_alert").hide();
    $("#phone_form_success_alert").hide();
    $("#phone_form_error_alert").hide();

    $("#avatar_anchor").click(function () {
        $("#usercabinet_avatar").click();
    });

    $("#usercabinet_avatar").change(function() {
        //TODO: не работает, сделать ajax аплоад аватара
        //var f = $("#user_avatar_upload_form");
        $.ajax({
            url: '/user/saveAvatar',
            type: 'post',
            dataType: 'json',
            data: $('form#avatar_form').serialize(),
            success: function(data) {
                //$('#mailings_submit').removeClass('disabled');
                console.log(data);
            }
        });
    });

    $("#mailings_submit").click(function(event) {
        event.preventDefault();
        $('#mailings_submit').addClass('disabled');
        $.ajax({
            url: '/user/saveMailingSettings',
            type: 'post',
            dataType: 'json',
            data: $('form#mailings_form').serialize(),
            success: function(data) {
                $('#mailings_submit').removeClass('disabled');
                if (data.success) {
                    $("#mailings_form_success_alert").alert();
                    $("#mailings_form_success_alert").fadeTo(2000, 500).slideUp(500, function() {
                        $("#mailings_form_success_alert").slideUp(500);
                    });
                } else {
                    $("#mailings_form_error_alert").alert();
                    $("#mailings_form_error_alert").fadeTo(3000, 500).slideUp(500, function() {
                        $("#mailings_form_error_alert").slideUp(500);
                    });
                }
            },
            error: function(jqXHR, errStr) {
                $('#mailings_submit').removeClass('disabled');
                console.log(errStr);
            }
        });
    });

    $("#main_info_submit").click(function(event) {
        event.preventDefault();
        $('#main_info_submit').addClass('disabled');
        $('#main_info_error_container').html('');
        $.ajax({
            url: '/user/saveMainInfo',
            type: 'post',
            dataType: 'json',
            data: $('form#usercabinet_main_info_form').serialize(),
            success: function(data) {
                $('#main_info_submit').removeClass('disabled');
                //console.log(data);

                if (data.success) {
                    $("#main_info_form_success_alert").alert();
                    $("#main_info_form_success_alert").fadeTo(2000, 500).slideUp(500, function() {
                        $("#mailings_form_success_alert").slideUp(500);
                    });
                } else {
                    $('#main_info_error_container').html(data.error);
                    $("#main_info_form_error_alert").alert();
                    $("#main_info_form_error_alert").fadeTo(3000, 500).slideUp(500, function() {
                        $("#main_info_form_error_alert").slideUp(500);
                    });
                }
            },
            error: function(jqXHR, errStr) {
                $('#main_info_submit').removeClass('disabled');
                console.log(errStr);
            }
        });
    });

    // форма изменения пароля
    $("#password_submit").click(function(event) {
        event.preventDefault();
        $('#password_submit').addClass('disabled');
        $('#password_error_container').html('');
        $.ajax({
            url: '/user/updatePassword',
            type: 'post',
            dataType: 'json',
            data: $('form#usercabinet_password_form').serialize(),
            success: function(data) {
                $('#password_submit').removeClass('disabled');
                //console.log(data);

                if (data.success) {
                    $("#password_form_success_alert").alert();
                    $("#password_form_success_alert").fadeTo(2000, 500).slideUp(500, function() {
                        $("#password_form_success_alert").slideUp(500);
                    });
                } else {
                    $('#password_error_container').html(data.error);
                    $("#password_form_error_alert").alert();
                    $("#password_form_error_alert").fadeTo(3000, 500).slideUp(500, function() {
                        $("#password_info_form_error_alert").slideUp(500);
                    });
                }
            },
            error: function(jqXHR, errStr) {
                $('#password_submit').removeClass('disabled');
                console.log(errStr);
            }
        });
    });

    // форма изменения телефона
    $("#phone_submit").click(function(event) {
        event.preventDefault();
        $('#phone_submit').addClass('disabled');
        $('#phone_error_container').html('');
        $.ajax({
            url: '/user/updatePhone',
            type: 'post',
            dataType: 'json',
            data: $('form#usercabinet_phone_form').serialize(),
            success: function(data) {
                $('#phone_submit').removeClass('disabled');
                //console.log(data);

                if (data.success) {
                    $("#phone_form_success_alert").alert();
                    $("#phone_form_success_alert").fadeTo(2000, 500).slideUp(500, function() {
                        $("#phone_form_success_alert").slideUp(500);
                    });
                } else {
                    $('#phone_form_error_alert').html(data.error);
                    $("#phone_form_error_alert").alert();
                    $("#phone_form_error_alert").fadeTo(3000, 500).slideUp(500, function() {
                        $("#phone_form_error_alert").slideUp(500);
                    });
                }
            },
            error: function(jqXHR, errStr) {
                $('#phone_submit').removeClass('disabled');
                console.log(errStr);
            }
        });
    });
});