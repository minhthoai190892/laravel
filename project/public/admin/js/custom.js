//TODO: Check admin password is correct or not
$(document).ready(function () {
    //TODO chọn mật khẩu hiện tại
    $("#current_pwd").keyup(function () {
        // lấy mật khẩu hiện tại
        var current_pwd = $("#current_pwd").val();
        // alert(current_pwd);
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            type: "POST",
            url: "/admin/check-current-password", //=> tạo tuyến đường trong web.php
            data: { current_pwd: current_pwd },
            success: function (resp) {
                if (resp == "false") {
                    // tạo thông báo vào thẻ span ở trang update_password
                    $("#verifyCurrentPwd").html(
                        "Current password is incorrect!"
                    );
                } else if (resp == "true") {
                    $("#verifyCurrentPwd").html("Current password is correct!");
                }
            },
            error: function () {
                alert("Error");
            },
        });
    });
});
//TODO: Update CMS Page Status
$(document).on('click','.updateCmsPageStatus',function () {
    // <a href="javascript:void(0)" class="updateCmsPageStatus">  <i
    // class="fas fa-toggle-on" status="Active"></i> </a>
    // parent:  $(this) -> <a>
    // children: <i>
    // attr: status="Active"
    var status = $(this).children('i').attr('status');
    var page_id = $(this).attr('page_id');
    // alert( page_id);
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        type: "POST",
        url:'/admin/update-cms-page-status',
        data:{status:status,page_id:page_id},
        success:function (resp) {
            // kiểm tra kết quả json trả về
            if (resp['status'] == 0) {
                $('#page-'+page_id).html('<i class="fas fa-toggle-off" style="color: grey" status="Inactive"></i>');
            } else  if (resp['status'] == 1) {
                $('#page-'+page_id).html('<i class="fas fa-toggle-on" style="color: #007bff" status="Active"></i>');
                
            }
        },
        error:function (){
            alert("Error");
        }
    });
})
