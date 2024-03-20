<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminsRole;
use Illuminate\Http\Request;
use Auth;
use Validator;
use Hash;
use Intervention\Image\Facades\Image;
use Session;

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
        Session::put('page', 'dashboard');
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
                // *TODO remember admin email and password with cookie
                //   ? - kiểm tra có được thiết lập không và không được để trống
                if (isset ($data['remember']) && !empty ($data['remember'])) {
                    // * thiết lập lưu cookie và thiết lập thời gian hết hạn
                    setcookie('email', $data['email'], time() + 3600);
                    setcookie('password', $data['password'], time() + 3600);
                } else {
                    // * người dùng không chọn remember me

                    setcookie('email', '');
                    setcookie('password', '');
                }
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
        Session::put('page', 'update-password');

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

    /**
     * update Admin Details
     * @param Request $request nhận một yêu cầu từ người dùng
     */
    public function updateDetails(Request $request)
    {
        Session::put('page', 'update-details');

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
                // 'admin_name' => 'required|max:255',
                // regex: chỉ có alpha và white space
                'admin_name' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
                'admin_mobile' => 'required|numeric|digits:10',
                'admin_image' => 'image',
            ];
            $customMessages = [
                'admin_name.required' => 'Name is required',
                'admin_name.regex' => 'Valid name is required',
                'admin_name.max' => 'Valid name is required',
                'admin_mobile.required' => 'Mobile is required',
                'admin_mobile.numeric' => 'Valid Mobile is required',
                'admin_mobile.digits' => 'Valid Mobile is required',
                'admin_image.image' => 'Valid Image is required',
            ];
            $this->validate($request, $rules, $customMessages);

            // update admin image
            // kiểm tra file hình ảnh
            if ($request->hasFile('admin_image')) {
                $image_tmp = $request->file('admin_image');
                if ($image_tmp->isValid()) {
                    # Get image extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    // Generate new Image Name
                    $imageName = rand(111, 99999) . '.' . $extension;
                    // tạo đường dẫn luư hình ảnh
                    $image_path = 'admin/images/photos/' . $imageName;
                    // tải hình ảnh
                    Image::make($image_tmp)->save($image_path);
                }
            } else if (
                !empty ($data['current_image'])
            ) {
                # code...
                $imageName = $data['current_image'];
            } else {
                # code...
                $imageName = '';
            }

            Admin::where('email', Auth::guard('admin')->user()->email)->update(
                ['name' => $data['admin_name'], 'mobile' => $data['admin_mobile'], 'image' => $imageName]
            );
            return redirect()->back()->with('success_message', 'Admin Details has been updated successfully');
        }
        return view('admin.update_details');
    }
    /**
     * show sub admins 
     */
    public function subadmins()
    {
        Session::put('page', 'subadmins');

        // * lấy tất cả các sub admins với loại subadmin
        $subadmins = Admin::where('type', 'subadmin')->get();
        //  echo "<pre>";
        //     print_r($subadmins);
        //     die;
        return view('admin.subadmins.subadmins')->with(compact('subadmins'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function updateSubadminStatus(Request $request)
    {
        //kiểm tra yêu cầu từ ajax
        if ($request->ajax()) {
            # lấy tất cả yêu cầu của người dùng
            $data = $request->all();
            // echo "<pre>";print_r($data);die;
            // Kiểm tra và thay đổi trạng thái của status
            if ($data['status'] == "Active") {
                # code...
                $status = 0;
            } else {
                $status = 1;

            }
            // cập nhập dữ liệu trong csdl
            // ! $data['subadmin_id'] attribute của trang php
            Admin::where('id', $data['subadmin_id'])->update(['status' => $status]);
            // trả về phản hồi json status and subadmin_id
            return response()->json(['status' => $status, 'subadmin_id' => $data['subadmin_id']]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteSubadminStatus($id)
    {
        //delete cms page
        Admin::where('id', $id)->delete();
        return redirect()->back()->with('success_message', 'Delete successfully');
    }
    /**
     * Add / Edit Subadmin
     */
    public function addEditSubadmin(Request $request, $id = null)
    {
        // ? kiểm tra xem id là thêm hay là update
        // ! id =='' là thêm id !='' là update 
        if ($id == '') {
            // ! Add Subadmin
            $title = 'Add Subadmin';
            $subadmindata = new Admin;
            $subadmindata->status = 1;

            $message = 'Subadmin added successfully';
        } else {
            // ! Update Subadmin
            $title = 'Update Subadmin';
            $subadmindata = Admin::find($id);
            $message = 'Subadmin updated successfully';
        }
        // ! kiểm tra phương thức
        if ($request->isMethod('POST')) {
            // * lấy tất cả yêu cầu từ người dùng
            $data = $request->all();
            //   print_r($data);
            // die;
            // ! kiểm tra id có tồn tại không
            if ($id == '') {
                // ? id không có
                // * so sánh email với email người dùng nhập
                $subadminCount = Admin::where('email', $data['email'])->count();
                // ! kiểm ra $subadminCount có >0 
                if ($subadminCount > 0) {
                    // ? >0 email đã tồn tại
                    return redirect()->back()->with('error_message', 'Subadmin already exists');
                }
                // * so sánh name với name người dùng nhập

                $subadminNameCount = Admin::where('name', $data['name'])->count();
                // ! kiểm ra $subadminNameCount có >0 
                if ($subadminNameCount > 0) {
                    // ? >0 name đã tồn tại
                    return redirect()->back()->with('error_message', 'Subadmin name already exists');
                }
            }
            // !  Subadmin validation
            $rules = [
                // 'admin_name' => 'required|max:255',
                // regex: chỉ có alpha và white space
                'name' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
                'mobile' => 'required|numeric|digits:10',
                'image' => 'image',
                'password' => 'required',

            ];
            $customMessages = [
                'name.required' => 'Name is required',
                'name.regex' => 'Valid name is required',
                'name.max' => 'Valid name is required',
                'mobile.required' => 'Mobile is required',
                'mobile.numeric' => 'Valid Mobile is required',
                'mobile.digits' => 'Valid Mobile is required',
                'image.image' => 'Valid Image is required',
                'password.required' => 'password is required',

            ];
            $this->validate($request, $rules, $customMessages);
            //! update admin image
            //? kiểm tra file hình ảnh
            if ($request->hasFile('image')) {
                $image_tmp = $request->file('image');
                if ($image_tmp->isValid()) {
                    # Get image extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    // Generate new Image Name
                    $imageName = rand(111, 99999) . '.' . $extension;
                    // tạo đường dẫn luư hình ảnh
                    $image_path = 'admin/images/photos/' . $imageName;
                    // tải hình ảnh
                    Image::make($image_tmp)->save($image_path);
                }
            } else if (
                !empty ($data['current_image'])
            ) {
                # code...
                $imageName = $data['current_image'];
            } else {
                # code...
                $imageName = '';
            }
            // ? set file
            $subadmindata->image = $imageName;
            $subadmindata->name = $data['name'];
            $subadmindata->mobile = $data['mobile'];
            // ! kiểm tra người dùng có tồn tại không 
            if ($id == '') {
                // ? chưa tồn tại
                // * ta thêm dữ liệu vào
                $subadmindata->email = $data['email'];
                $subadmindata->type = 'subadmin';
            }
            // ! kiểm tra mật khẩu có được nhập không
            if ($data['password'] != '') {
                // ? mật khẩu được nhập
                // * ta thêm dữ liệu vào và mã hóa mật khẩu
                $subadmindata->password = bcrypt($data['password']);
            }
            $subadmindata->status = $data['status'];
            $subadmindata->save();
            return redirect('admin/subadmins')->with('success_message', $message);
        }
        return view('admin.subadmins.add_edit_subadmin')->with(compact('title', 'subadmindata'));
    }
    public function updateRole($id, Request $request)
    {
        $title = 'Update Subadmin Roles/Persmission';
        if ($request->isMethod('post')) {
            # code...
            $data = $request->all();
            //  echo "<pre>";
            // print_r($data);
            // die;
            // ! delete all earlier roles for Subadmin
            AdminsRole::where('subadmin_id', $id)->delete();
            // ! add new roles for Subadmin
            if (isset ($data['cms_page']['view'])) {
                $cms_pages_view = $data['cms_page']['view'];
            } else {
                $cms_pages_view = 0;
            }
            if (isset ($data['cms_page']['edit'])) {
                $cms_pages_edit = $data['cms_page']['edit'];
            } else {
                $cms_pages_edit = 0;
            }
            if (isset ($data['cms_page']['full'])) {
                $cms_pages_full = $data['cms_page']['full'];
            } else {
                $cms_pages_full = 0;
            }
            $roles = new AdminsRole;
            $roles->subadmin_id=$id;
            $roles->module='cms_pages';
            $roles->view_access= $cms_pages_view;
            $roles->edit_access=$cms_pages_edit;
            $roles->full_access=$cms_pages_full;
            $roles->save();
            $message = 'Subadmin Roles updated successfully';

            return redirect()->back()->with('success_message', $message);
            
        }
        // ! lấy dữ liệu với "subadmin_id"  sau đó chuyển sang mảng
        $subadminRoles = AdminsRole::where('subadmin_id',$id)->get()->toArray();
        // dd($subadminRoles);
        return view('admin.subadmins.update_roles')->with(compact('title', 'id','subadminRoles'));

    }
}
