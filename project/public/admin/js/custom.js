$(document).ready(function () {
    //TODO: Check admin password is correct or not
    //TODO chọn mật khẩu hiện tại
    $("#current_pwd").keyup(function () {
        // lấy mật khẩu hiện tại
        var current_pwd = $("#current_pwd").val();
        // alert(current_pwd);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: "/admin/check-current-password", //=> tạo tuyến đường trong web.php
            data: { current_pwd: current_pwd },
            success: function (resp) {
                if (resp == "false") {
                    // tạo thông báo vào thẻ span ở trang update_password
                    $('#verifyCurrentPwd').html('Current password is incorrect!');
                } else if (resp=='true') {
                    $('#verifyCurrentPwd').html('Current password is correct!');

                } 
            },
            error: function () {
                alert("Error");
            },
        });
    });
});
