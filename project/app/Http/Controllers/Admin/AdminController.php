<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
use Auth;
use Validator;

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
            $rules=[
                'email'=>'required|email|max:255',
                'password'=>'required|max:30',
            ];
            $customMessages=[
                'email.required'=>'Email is required',
                'email.email'=>'Valid Email is required',
                'password.required'=>'Password is required',
            ];
            $this->validate($request,$rules,$customMessages);

            // xác minh dữ liệu có đúng trong database không
            if (Auth::guard('admin')->attempt(['email'=>$data['email'],'password'=>$data['password']])) {
                # đi đến trang dashboard
                return redirect('admin/dashboard');
            }else{
                // thông báo lỗi nếu sai
                return redirect()->back()->with('error_message','Invalid email or password');
            }
        }
        return view('admin.login');
    }
    /**
     * Đăng xuất người dùng
     */
    public function logout(){
        // đăng xuất người dùng
        Auth::guard('admin')->logout();
        // trả về trang login
        return redirect('admin/login');
        
    }
}
