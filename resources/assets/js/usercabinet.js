$(document).ready(function () {
    $("#avatar_anchor").click(function () {
        $("#usercabinet_avatar").click();
    });

    $("#usercabinet_avatar").change(function() {
        //var f = $("#user_avatar_upload_form");
        /*
         $.ajax({
         url: "/user/saveAvatar",
         type: "POST",
         dataType: "json"
         }, function(data) {
         var ok = data.success == "1";
         if (ok) {
         f.find("img").attr("src", data.url);
         } else {
         if (data.error) {
         alert(data.error);
         }
         }
         })
         */
        $("#avatar_form").submit(function(event) {
            console.log(event);
        });
    });

    $("#mailings_submit").click(function(event) {
        event.preventDefault();
        $('#mailings_submit').addClass('disabled');
        $("#mailings_form").submit(function(event) {
            console.log(event);
        });
    });
    $("#mailings_form").bind('ajax:complete', function() {
        $('#mailings_submit').removeClass('disabled');
    });
});