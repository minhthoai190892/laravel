<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
use Auth;
// use Illuminate\Support\Facades\Hash;
use Validator;
use Hash;

/**
 *  AdminController dùng để quản lý đăng nhập của Admin
 * @method function dashboard()
 * @method function login()
 * @method function logout()
 */
class AdminController extends Controller
{
    /**
     * hiển thị trang dashboard
     */
    public function dashboard()
    {
        return view('admin.dashboard');
    }
    /**
     * phương thức kiển tra đăng nhập
     * @param Request $request kiểm tra loại phương thức [POST,PUT,DELETE,PATCH]
     *  trả về một trang web
     */
    public function login(Request $request)
    {
        // kiểm tra loại phương thức
        if ($request->isMethod('post')) {
            # lấy thông tin đăng nhập mà người dùng nhập vào
            $data = $request->all();
            // test hiển thị thông tin đăng nhập người dùng
            // echo "<pre>";
            // print_r($data);
            // die;


            // tạo quy tắc
            $rules = [
                'email' => 'required|email|max:255',
                'password' => 'required|max:30',
            ];
            $customMessages = [
                'email.required' => 'Email is required',
                'email.email' => 'Valid Email is required',
                'password.required' => 'Password is required',
            ];
            $this->validate($request, $rules, $customMessages);

            // xác minh dữ liệu có đúng trong database không
            if (Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password']])) {
                # đi đến trang dashboard
                return redirect('admin/dashboard');
            } else {
                // thông báo lỗi nếu sai
                return redirect()->back()->with('error_message', 'Invalid email or password');
            }
        }
        return view('admin.login');
    }
    /**
     * Đăng xuất người dùng
     */
    public function logout()
    {
        // đăng xuất người dùng
        Auth::guard('admin')->logout();
        // trả về trang login
        return redirect('admin/login');

    }
    
    /**
     * Cập nhật password
     * @param Request $request nhận một yêu cầu từ người dùng
     */
    public function updatePassword(Request $request)
    {
        if ($request->isMethod('post')) {
            // lấy hết tất cả yêu cầu của người dùng
            $data = $request->all();
            // Check if current password is correct
            if (Hash::check($data['current_pwd'], Auth::guard('admin')->user()->password)) {
                // check if new password and confirm password are matching
                if ($data['new_pwd'] == $data['confirm_pwd']) {
                    # code...
                    // TODO Update new password
                    // - so sánh id
                    Admin::where('id', Auth::guard('admin')->user()->id)->update(['password' => bcrypt($data['new_pwd'])]);
                    return redirect()->back()->with('success_message', 'Password has been updated successfully');
                } else {
                    # code...
                    // trả về thông báo lỗi khi mật khẩu hiện tại sai
                    return redirect()->back()->with('error_message', 'New password and Retype password not match');
                }
            } else {
                // trả về thông báo lỗi khi mật khẩu hiện tại sai
                return redirect()->back()->with('error_message', 'Your current password is incorrect');
            }
        }
        // trả về trang update password
        return view('admin.update_password');
    }
    /**
     * kiểm tra mật khẩu hiện tại
     * @param Request $request nhận một yêu cầu từ người dùng
     */
    public function checkCurrentPassword(Request $request)
    {
        // lấy hết tất cả yêu cầu của người dùng
        $data = $request->all();
        // kiểm tra mật khẩu người dùng nhập vào có giống với mật khẩu trong database không
        if (Hash::check($data['current_pwd'], Auth::guard('admin')->user()->password)) {
            // password đúng
            return 'true';
        } else {
            // password sai
            return 'false';
        }
    }
}
