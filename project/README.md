<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

-   [Simple, fast routing engine](https://laravel.com/docs/routing).
-   [Powerful dependency injection container](https://laravel.com/docs/container).
-   Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
-   Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
-   Database agnostic [schema migrations](https://laravel.com/docs/migrations).
-   [Robust background job processing](https://laravel.com/docs/queues).
-   [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

<!-- database -->

http://localhost/phpmyadmin/

### Laravel 10 Tutorial #4

1. Update layout.blade.php file :-
   First of all, we will update layout.blade.php file to add Laravel asset and url to css/js/images and plugins paths.

1) thêm thư viện

```c
<link rel="stylesheet" href="{{ url('admin/plugins/fontawesome-free/css/all.min.css') }}">
...
```

2. thêm các trang khác vào

```c
@include('admin.layout.header')
@include('admin.layout.sidebar')
...
yield sử dụng khi nội dung thay đổi theo từng trang
gọi trang dashboard
   @yield('content')

@include('admin.layout.footer')
```

2. Update header.blade.php file :-
   Now we will update the header.blade.php file to add Laravel asset to images paths.

```c
<img src="{{ asset('admin/images/user1-128x128.jpg') }}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
...
```

3. Update sidebar.blade.php file :-
   Now we will update sidebar.blade.php file to add Laravel asset to images paths.

```c
<img src="{{ asset('admin/images/user1-128x128.jpg') }}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
...
```

4. Update dashboard.blade.php file :-
   Now we will update dashboard.blade.php file to add Laravel asset to images paths.
   _tạo phần nội dung_
   **extends: mở rộng tối layout**
    > @extends('admin.layout.layout')
    > @section('content')

```c
<img src="{{ asset('admin/images/user1-128x128.jpg') }}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
...
```

5. Create AdminController.php file :-
   Now create Admin folder under /app/Http/Controllers/ and then create **AdminController**.php file under Admin folder by running below artisan command :-
    > php artisan make:controller Admin/AdminController

```c
 //gọi đến trang để hiển thị
    public function dashboard(){
        //  admin_dashboard.blade.php
        return view('admin.dashboard');
    }
```

6. Create Route :-
   We will create a separate group in the **web.php** file for admin routes so that we can keep them separately with namespace Admin and prefix admin.

```c
// tạo nhóm tuyến đường
Route::prefix('/admin')->namespace('App\Http\Controllers\Admin')->group(function () {
    Route::get('/dashboard', 'AdminController@dashboard');
});
```

7. You can see the view of the dashboard page by opening below link :-
   http://127.0.0.1:8000/admin/dashboard

## Create Admin Panel Login Page

1. Create Route:-
   First of all, create a **GET/POST** route for admin login in the Admin route group like below:-

    > Route::match(['get','post'],'/login','AdminController@login');

2. Create Function:-
   Now create a login function in **AdminController** that will return to the **admin_login.blade.php** file that we will create in the next step.
3. Create **login.blade.php** file :-
   Now we will create a **login.blade.php** file in _/resources/views/admin/_ folder in which we will add content from the login.html page from _AdminLTE/pages/examples/_ folder.
4. We will also correct paths in the login.blade.php file.
   (http://127.0.0.1:8000/admin/login)

## Create Admin Middleware to Protect Admin Routes

1. Create admins table:-
   First of all, we will create an **admins table** with migration with the below columns:
   _id, name, type, mobile, email, password, image, status_
   So, we will run the below artisan command to create a migration file for admins:-
    > php artisan make:migration create_admins_table

```
/**
     * Run the migrations.
     * create admins table
     */
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->string('mobile');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('image');
            $table->tinyInteger('status');
            $table->timestamps();
        });
    }
```

Now we will run below artisan command to create an admins table with the required columns:-

> php artisan migrate 2) Create Admin model:-
> Now we will create an **Admin model** with the below artisan command:-
> php artisan make:model Admin

We will update the content of the Admin model file to set the protected guard variable for admin and set other variables as shown in the video.

We will also extend the Admin class to Authenticatable and add its namespace as well. 3) Update **auth.php** file :-
We will update **auth.php** file located at **config\auth.php** to set guards for admin to assign session in driver and admins in provider as shown in video.

We will also set providers for admins to assign eloquent in driver and Admin class in model.

```

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],
    ],


    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],
        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],]
```

4. Create **Admin Middleware** :-
   Now we will create **Admin Middleware** file by running below command :-
    > php artisan make:middleware Admin

```
<!-- library  -->
use Auth;

 /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('admin')->check()) {
            # code...
            return redirect('/admin/login');
        }
        return $next($request);
    }
```

5. Update _kernel.php_ file :-
   Now we will update _kernel.php_ file located at app\http\ folder to register Admin middleware as global as shown in video.

```
protected $middlewareAliases = [
    ...
    'admin' => \App\Http\Middleware\Admin::class,
]
```

6. Update **Admin Middleware**
   **Add Auth:guard** check in **Admin Middleware** to protect the admin routes. This check will be false for now as we have not registered the admin guard yet.

7. Update web.php file :-
   Add admin middleware group and move admin dashboard route under it to protect it from unauthorized access.

```
// tạo nhóm tuyến đường
Route::prefix('/admin')->namespace('App\Http\Controllers\Admin')->group(function () {
    Route::match(['get','post'],'login','AdminController@login');
    Route::group(['middleware'=>['admin']],function ()  {

    });
    Route::get('/dashboard', 'AdminController@dashboard');
});


```

# Insert Record into Admins Table with Seeder

1. Writing Seeder / Create AdminsTableSeeder file:-
   First of all, we will generate a seeder and create an **AdminsTableSeeder** file where we will add records for the admins table.
   Run below artisan command to generate Seeder and create AdminsTableSeeder file :-
    > php artisan make:seeder AdminsTableSeeder

```
<!-- sử dụng thư viện -->
use App\Models\Admin;
use Hash;

/**
     * Run the database seeds.
     */
    public function run(): void
    {
        //We will generate a hash password for the admin by using the Hash::make function
        $password = Hash::make('123456');
        $adminRecords = [['id' => 2, 'name' => 'Admin', 'type' => 'admin', 'mobile' => 156545654, 'email' => 'admin2@admin.com', 'password' => $password, 'image' => '', 'status' => 1],['id' => 3, 'name' => 'Admin', 'type' => 'admin', 'mobile' => 156545654, 'email' => 'admin3@admin.com', 'password' => $password, 'image' => '', 'status' => 1],];
    Admin::insert($adminRecords);
    }
```

2. Update DatabaseSeeder.php file:-
   Now update the **DatabaseSeeder.php** file located at _database/seeds/_ to add AdminsTableSeeder class

```
/**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // gọi đến seeder
        $this->call(AdminsTableSeeder::class);
    }
```

3. Running Seeders / Run below command:-
   Once you have written your seeder, you may need to regenerate Composer's autoloader using the dump-autoload command:
    > composer dump-autoload
4. Run below command :-
   Now run the last command that will finally insert the admin record into the admins table that we can use for admin login.
    > php artisan db:seed

# Admin Panel Login / Logout Functionality

1. Update **admin_login.blade.php** file :-
   First of all, we will update the **admin_login.blade.php** file to update the Login form. We will set its action, CSRF token, username (email), and password.

```
 <form action="{{ url('admin/login') }}" method="post">@csrf
                    <div class="input-group mb-3">
                        <input name='email' type="email" class="form-control" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input name="password" type="password" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
```

2. Update login function :-
   Now we will update the login function at AdminController. We will add the condition for posted data and use the guard for admin login

```
 /**
     * phương thức kiển tra đăng nhập
     * @param Request $request kiểm tra loại phương thức [POST,PUT,DELETE,PATCH]
     *  trả về một trang web
     */
    public function login(Request $request)
    {
        // kiểm tra loại phương thức
        if ($request->isMethod('POST')) {
            # lấy thông tin đăng nhập mà người dùng nhập vào
            $data = $request->all();
            // test hiển thị thông tin đăng nhập người dùng
            // echo "<pre>";
            // print_r($data);
            // die;
            // xác minh dữ liệu có đúng trong database không
            if (Auth::guard('admin')->attempt(['email'=>$data['email'],'password'=>$data['password']])) {
                # đi đến trang dashboard
                return redirect('admin/dashboard');
            }else{
                // thông báo lỗi nếu sai
                return redirect()->back()-with('error_message','Invalid email or password');
            }
        }
        return view('admin.login');
    }
```

## Error

> Illuminate\Auth\EloquentUserProvider::validateCredentials(): Argument #1 ($user) must be of type Illuminate\Contracts\Auth\Authenticatable, App\Models\Admin given, called in C:\xampp\htdocs\laravel\project\vendor\laravel\framework\src\Illuminate\Auth\SessionGuard.php on line 438

cần phải thiết lập lại **admin model**

> class Admin extends Model => class Admin extends Authenticatable

3. Update **admin_header.blade.php** file :-
   Remove all unwanted code and add "Logout" link for the user at top right side of the header

```
 <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ url('admin/logout') }}" class="nav-link">Logout</a>
      </li>
```

4.  Create Route :-
    Now we will create GET route for Admin Logout in **web.php** file like below :-
    > Route::get('logout', 'AdminController@logout');
5.  Create logout function :-
    Now we will create logout function in AdminController in which we will unset admin guard
    /\*\*
    _ Đăng xuất người dùng
    _/
    public function logout(){
    // đăng xuất người dùng
    Auth::guard('admin')->logout();
    // trả về trang login
    return redirect('admin/login');
    }
6.  Update login function :-
    Update login function located at AdminController and write the validator code for email and password

```
>use Validator;
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

```

7. Update **login.blade.php** file :-
   Now update the **login.blade.php** file to display the error if validation fails for email and password. You can check this at Laravel website under "Displaying The Validation Errors" section.

```
{{-- Show message --}}
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                @if (Session::has('error_message'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error:</strong> {{ Session::get('error_message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                @endif
                {{-- Show message --}}
```

# Update Admin Password (I) Integrate Update Password Page and Form

1.  Create Route :
    First of all, create GET/POST route for updating admin password in the **web.php** file like below:-

        > Route::match(['GET','POST'],'update-password', 'AdminController@updatePassword');

    ```
    Route::get('update-password', 'AdminController@updatePassword');

    ```

    We will also keep this route in the admin middleware Route::group to protect it from unauthorized access.

2) Create **updatePassword** function :-
   Now we will create an **updatePassword** function in <a href='./app/Http/Controllers/Admin/AdminController.php'>AdminController</a> that we will return to setting blade file.
    ```
    /**
     * Cập nhật password
     */
    public function updatePassword(){
        // trả về trang update password
        return view('admin.update_password');
    }
    ```
3) Create update_password.blade.php :-
   Now we will create a update_password.blade.php file similar to dashboard.blade.php file that we created earlier on.
   We will add email, current password, new password and confirm password fields.
   <a href='../project/resources/views/admin/update_password.blade.php'> update pasword page
4) Update <a href='../project/resources/views/admin/update_password.blade.php'> update pasword page</a> :-
   Now we will update update password page and will show email in update password form that we have got from updatePassword function at AdminController from admin guard.
    ```
    {{-- lấy user từ database --}}
    <input type="email" class="form-control" id="addmin_email"
        value="{{ Auth::guard('admin')->user()->email }}">
    ```
5) Update <a href='../project/resources/views/admin/layout/sidebar.blade.php'> sidebar page</a> file :-
   Now we will also update admin sidebar to show settings link along with admin name and type who logged in.

# Update Admin Password (II) | Check Current Password via Ajax

1. Update <a href='../project/resources/views/admin/update_password.blade.php'> update pasword page</a> file :
   First of all, we will update "Update Password" form by adding action, name, id to form.
    ```
     <form method="POST" action="{{ url('admin/update-password') }}">
     @csrf
     ...
     </form>
    ```

2)  Create custom.js file :-
    First of all, we will create <a href='./public/admin/js/custom.js'>custom.js</a> file at /public/admin/js/ folder. Then we will add Jquery/Ajax in this file to check if current password entered by the admin is correct or not.

    Also search for keyword "add csrf token to laravel ajax" and open below link to update jquery code:

    https://stackoverflow.com/questions/3...

3)  Update layout.blade.php file :-
    Now we will include custom.js file in <a href='resources\views\admin\layout\layout.blade.php'>layout.blade.php</a> file located under admin\layout\ folder.

4)  Create Route :-
    Now we will create POST route in <a href='routes\web.php'>web.php</a> file for checking current password that we have passed via Ajax URL :-
    > Route::POST('check-current-password','AdminController@checkCurrentPassword');
5)  Create **checkCurrentPassword** function :-
    Now we will create **checkCurrentPassword** function at <a href='app\Http\Controllers\Admin\AdminController.php'>AdminController.php</a> in which we will check if current password entered by admin is correct or not. We will return true or false to Ajax to display the message at update password form.
    ```
     /**
     * kiểm tra mật khẩu hiện tại
     * @param Request $request nhận một yêu cầu từ người dùng
     */
    public function checkCurrentPassword(Request $request)
    {
        // lấy hết tất cả yêu cầu của người dùng
        $data = $request->all();
        // kiểm tra mật khẩu người dùng nhập vào có giống với mật khẩu trong database không
        if (Hash::check($data['current_pwd'],Auth::guard('admin')->user()->password)) {
            // password đúng
            return true;
        }else{
            // password sai
            return false;
        }
    }
    ```
6)  Update **update_password.blade.php** file :-
    Now in <a href='../project/resources/views/admin/update_password.blade.php'> update pasword page</a> file, in Password form, below Current password field, we will add one span tag with id to display message that we have returned from Ajax.

    ```
        <span id="verifyCurrentPwd"></span>
    ```

7)  Include Hash Class
    Include Hash Class at top of AdminController

# Update Admin Password (III) | Change Admin Password

1. Update <a href='resources\views\admin\layout\header.blade.php'>header.blade.php</a> file :-
   First of all, update admin header with Admin name who logged in and Settings page link.
    ```
     <li class="nav-item d-none d-sm-inline-block">
            <a href="index3.html" class="nav-link">Welcome <strong>{{ Auth::guard('admin')->user()->name }}
                    ({{ Auth::guard('admin')->user()->type }})</strong></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            {{-- lấy đường dẫn từ web.php --}}
            <a href="{{ url('admin/dashboard') }}" class="nav-link">Dashboard</a>
        </li>
    ```

2)  Update **updatePassword** function :-
    Now we will update **updatePassword** function to update the current password and set the new password entered by the user but first we will check if current password entered is correct or not.

    If not correct we will send back the admin to update password form with error message. And if correct then we will compare new password with confirm password, if correct then we will update new password and return success message otherwise will return error message.

    ```
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
    ```

3)  Update <a href='../project/resources/views/admin/update_password.blade.php'> update pasword page</a> file :-
    Update admin update password page with success and error message div's

    ````
    {{-- Show message --}}

                                  @if (Session::has('error_message'))
                                      <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                          <strong>Error:</strong> {{ Session::get('error_message') }}
                                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                          </button>
                                      </div>
                                  @endif
                                  @if (Session::has('success_message'))
                                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                                      <strong>Success:</strong> {{ Session::get('success_message') }}
                                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                      </button>
                                  </div>
                              @endif
                                  {{-- Show message --}}
        ```

    4 update <a href='routes\web.php'>web.php</a> file:

    > Route::match(['get', 'post'],'update-password', 'AdminController@updatePassword');
    ````

# Update Admin Details (I) | Create Admin Details Page

1. Create Route :-
   Create GET/POST route for updating admin details in <a href='routes\web.php'>web.php</a> file like below :-
    > Route::match(['get','post'],'update-details', 'AdminController@updateDetails');

2) Create **updateDetails** function :-
   Create **updateDetails** function in <a href='./app/Http/Controllers/Admin/AdminController.php'>AdminController</a> and return to <a href='resources\views\admin\update_details.blade.php'>update_details.blade.php</a> file.

3) Create update_details.blade.php file :-
   Now create update_details.blade.php file at resources/views/admin/ folder.
   We will create update admin details form with admin name, email, image and mobile with email as read only.
4) Update **updateDetails** function :-
   Now update **updateDetails** function to get admin name and mobile and update in admins table.
   We will also validate name and mobile and return to update admin details form in case name and mobile is not valid.

    ```

     /**
      * update Admin Details
      * @param Request $request nhận một yêu cầu từ người dùng
      */
     public function updateDetails(Request $request)
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
                 // 'admin_name' => 'required|max:255',
                 // regex: chỉ có alpha và white space
                 'admin_name' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
                 'admin_mobile' => 'required|numeric|digits:10',
             ];
             $customMessages = [
                 'admin_name.required' => 'Name is required',
                 'admin_mobile.required' => 'Mobile is required',
                 'admin_mobile.numeric' => 'Valid Mobile is required',
                 'admin_mobile.digits' => 'Valid Mobile is required',
             ];
             $this->validate($request, $rules, $customMessages);
             Admin::where('email', Auth::guard('admin')->user()->email)->update(
                 ['name' => $data['admin_name'], 'mobile' => $data['admin_mobile']]
             );
             return redirect()->back()->with('success_message', 'Admin Details has been updated successfully');
         }
         return view('admin.update_details');
     }
    ```

5) Update **update_details.blade.php** file :-
   We will add alert div at <a href='resources\views\admin\update_details.blade.php'>update_details.blade.php</a>file that we will display in case if name or mobile is not valid.

# Update Admin Details (II) | Upload Admin Image | Install Intervention

1. Install Intervention Package :-
   Simply run below composer command to install Intervention Package :-
    > composer require intervention/image:2.7.\*
    ## fix bug
    https://youtu.be/-E3amn3gGFo?t=490
    1. add Intervention\Image\ImageServiceProvider::class, in **providers** of **app.php**
    1. add 'Image' => Intervention\Image\Facades\Image::class in **aliases** of **app.php**

2) Update **update_admin_details.blade.php** file :-
   Add **enctype="multipart/form-data"** in update admin details form to accept files and we will also add condition to show admin image and add another hidden field for current admin image.

    ```
      <form method="POST" action="{{ url('admin/update-details') }}" enctype="multipart/form-data">
           <div class="form-group">
                  <label for="admin_image">Photo</label>
                  <input type="file" class="form-control" id="admin_image" name="admin_image">
                  @if (!empty(Auth::guard('admin')->user()->image))
                      <a href="{{ url('admin/images/photos/'.Auth::guard('admin')->user()->image) }}"
                          target="_blank" rel="noopener noreferrer">view</a>
                          <input type="hidden" name="current_image" value="{{ Auth::guard('admin')->user()->image }}">
                  @endif
              </div>
      </form>
    ```

3) Update **updateAdminDetails** function :-
   Now we will update **updateAdminDetails** function to add validation for image and will add upload image script and finally save the image name in admins table as well.

    We will create admin_photos folder under admin_images folder where we will store all admin images.

    ```
      if ($request->hasFile('admin_image')) {
                $image_tmp = $request->file('admin_image');
                if ($image_tmp->isValid()) {
                    # Get image extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    // Generate new Image Name
                    $imageName = rand(111, 99999) . '.' . $extension;
                    // tạo đường dẫn luư hình ảnh
                    $image_path = 'admin/images/photos/'.$imageName;
                    // tải hình ảnh
                    Image::make($image_tmp)->save($image_path);
                }
            } else if (
                !empty($data['current_image'])
            ) {
                # code...
                $imageName = $data['current_image'];
            } else {
                # code...
                $imageName='';
            }

               Admin::where('email', Auth::guard('admin')->user()->email)->update(
                ['name' => $data['admin_name'], 'mobile' => $data['admin_mobile'], 'image' => $imageName]
            );
    ```

# Update Admin Sidebar | Highlight Current Open Module

1. Update **sidebar.blade.php** file :-
   First of all, we will update admin sidebar to show admin photo and admin name.
    ```
      <div class="image">
               {{-- hình ảnh của admin --}}
                 @if (!empty(Auth::guard('admin')->user()->image))
                     <img src="{{ url('admin/images/photos/' . Auth::guard('admin')->user()->image) }}"
                         class="img-circle elevation-2" alt="User Image">
                 @else
                 {{-- hình ảnh mặc định --}}
                     <img src="{{ asset('admin/images/AdminLTELogo.png') }}" class="img-circle elevation-2"
                         alt="User Image">
                 @endif
             </div>
    ```

2) Update **dashboard** function :-
   Update **dashboard** function with page session having **dashboard** value.
    ```
     <!-- add library -->
     use Session;
         public function dashboard()
         {
             Session::put('page','dashboard');
             return view('admin.dashboard');
         }
    ```
3) Update **updatePassword** function :-
   Update **updatePassword** function with page session having update-password value.
    ```
        public function updatePassword(Request $request)
        {
         Session::put('page','update-password');
         ...
         }
    ```
4) Update **updateDetails** function :-
   Update **updateDetails** function with page session having update-password value.
    ```
        public function updateDetails(Request $request)
        {
         Session::put('page','update-details');
         ...
         }
    ```

# Laravel 10 CRUD Operations | Manage CMS / Dynamic Pages (I) | Create Table

1. Create **cms_pages table & model** :-
   First of all, we will create cms_pages table and model together with migration.

    Create migration file with name create_cms_pages_table for creating cms_pages table with below columns :-
    id, title, description, url, meta_title, meta_description, meta_keywords, status, created_at and updated_at

    So, we will run below artisan command to create migration file for cms_pages & model simultaneously :-

    > php artisan make:model CmsPage -m

    Open create_cms_pages_table migration file and add all required columns mentioned earlier.

    ```
     Schema::create('cms_pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('url');
            $table->string('meta_title');
            $table->string('meta_description');
            $table->string('meta_keywords');
            $table->tinyInteger('status');
            $table->timestamps();
        });
    ```

    Now, we will run below artisan command to create cms_pages table with required columns :-

    > php artisan migrate

    Now cms_pages table has been created with all the required columns.

    Now, We will create Seeding for **cms_pages** table to insert few cms pages from file.

2) Writing Seeder / **Create CmsPagesTableSeeder** file :-
   First of all, we will generate seeder and **create CmsPagesTableSeeder** file from where we will add one cms page for cms_pages table.

    Run below artisan command to generate Seeder and **create CmsPagesTableSeeder** file :-

    > php artisan make:seeder CmsPagesTableSeeder

    Above command will **create CmsPagesTableSeeder.php** file at \database\seeders\

    Now open CmsPagesTableSeeder file and add record for cms page.

    ```
     //
        $cmsPagesRecords=[
            ['id'=>1,'title'=>'Abount Us','description'=>'Content is coming soon','url'=>'abount-us','meta_title'=>'Abount Us','meta_description'=>'Abount Us Content','meta_keywords'=>'about us,abount','status'=>1],
            ['id'=>2,'title'=>'Terms & Conditions','description'=>'Content is coming soon','url'=>'terms-conditions','meta_title'=>'Terms & Conditions','meta_description'=>'Terms & Conditions Content','meta_keywords'=>'terms,terms conditions','status'=>1],
            ['id'=>3,'title'=>'Privacy Policy','description'=>'Content is coming soon','url'=>'privacy-policy','meta_title'=>'Privacy Policy','meta_description'=>'Privacy Policy Content','meta_keywords'=>'privacy policy','status'=>1],
        ];
        // thêm dữ liệu vào bảng
        CmsPage::insert($cmsPagesRecords);
    ```

3) Run below command :-
   Now run below commands that will finally insert cms pages into cms_pages table.
   composer dump-autoload (if required)
    > php artisan db:seed

# Laravel CRUD | Manage CMS Dynamic Pages (II) | Create Resource Controller

1. Create Resource **CmsController** :-
   First of all, we will create Resource **CmsController** under app/Http/Controllers/Admin folder that will automatically create default methods for CRUD operations.

    Create **CmsController** by running below artisan command :-

    > php artisan make:controller Admin/CmsController --resource --model=CmsPage

2) Create Route :-
   Create GET route in **web.php** file in admin middleware group prefixed with admin and having namespace Admin for displaying cms pages in admin panel :-
   // CMS Pages
    > Route::get('cms-pages','CmsController@index');
3) Update _index_ function :-
   Now update _index_ function in **CmsController** to write query to display all the cms pages in admin panel and return to cms_pages.blade.php file that we will create under /resources/views/admin/pages/ folder.

    ```
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //lấy tất cả các trang và chuyển đổi sang mảng
        $CmsPages = CmsPage::get()->toArray();
        // xem mảng danh sách
        // dd($CmsPages);
        // hiển thị trang web
        return view('admin.pages.cms_pages')->with(compact('CmsPages'));
    }
    ```

4) Create **cms_pages.blade.php** file :-
   Now create **cms_pages.blade.php** file under /resources/views/admin/pages/ folder in which we will add content from LTE admin template data.html file located at folder /pages/tables/data.html and will display cms pages within foreach loop.

```
 <div class="card-body">
                   <table id="cmspages" class="table table-bordered table-striped">
                     <thead>
                     <tr>
                       <th>ID</th>
                       <th>Title</th>
                       <th>URL</th>
                       <th>Create on</th>
                       <th>Actions</th>
                     </tr>
                     </thead>
                     <tbody>
                         @foreach ($CmsPages as $page )
                         <tr>
                             <td>{{ $page['id'] }}</td>
                             <td>{{ $page['title'] }}</td>
                             <td>{{ $page['url'] }}</td>
                             <td>{{ $page['created_at'] }}</td>

                           </tr>
                         @endforeach

                     </tbody>

                   </table>
             </div>
```

5. Update **layout.blade.php** file :-
   Now update **layout.blade.php** file to add DataTable jQuery script for cms pages to display the cms pages in datatable.
    ```
     <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
     <script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
     <script>
         $(function() {
             $("#cmspages").DataTable();
         });
     </script>
    ```

6) Update **sidebar.blade.php** file :-
   Update Admin sidebar to add CMS Pages tab in which we will display "View CMS Pages" link and will highlight it when CMS Pages module selected.

# Laravel CRUD | Manage CMS Pages (III) | Active/Inactive Status for Pages

1. Update **cms_pages.blade.php** file :-
   Add id, class and page_id attributes for Active and Inactive status for cms_pages at **cms_pages.blade.php** file that are required to update the status with jquery and ajax.
    ```
     {{-- kiểm tra trạng thái --}}
        @if ($page['status'] == 1)
            <td><a href="javascript:void(0)" class="updateCmsPageStatus"
                    id="page-{{ $page['id'] }}" page_id={{ $page['id'] }}><i
                        class="fas fa-toggle-on" status="Active"></i></a></td>
        @else
            <td><a href="javascript:void(0)" class="updateCmsPageStatus"
                    id="page-{{ $page['id'] }}" page_id={{ $page['id'] }}
                    style="color: grey"><i
                        class="fas fa-toggle-off" status="Inactive"></i></a></td>
        @endif
    ```

2)  Update **custom.js** file :-
    **Add updateCmsPageStatus** jquery function in **custom.js** file in which we will pass status and page_id that we will return to ajax via admin/update-cms-page-status route.
    ```
    $(document).on('click','.updateCmsPageStatus',function () {
    // <a href="javascript:void(0)" class="updateCmsPageStatus"> <i
    // class="fas fa-toggle-on" status="Active"></i> </a>
    // parent: $(this) -> <a>
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
    } else if (resp['status'] == 1) {
    $('#page-'+page_id).html('<i class="fas fa-toggle-on" style="color: #007bff" status="Active"></i>');
                }
            },
            error:function (){
                alert("Error");
            }
        });
    })
    ```
3)  Create Route :-
    Now we will create below Post route in admin middleware group in **web.php** file for updating status that we pass via ajax in last step.
    > Route::post('update-cms-page-status','CmsController@update');
4)  Update "**update**" function :-
    Now we will update "update" function in **CmsController** to update the status of cms page in cms_pages table and return back the updated status to ajax via json.

    ```
     /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CmsPage $cmsPage)
    {
        //kiểm tra yêu cầu từ ajax
        if ($request->ajax()) {
            # lấy tất cả yêu cầu của người dùng
            $data = $request->all();
            // echo "<pre>";print_r($data);die;
            // Kiểm tra và thay đổi trạng thái của status
            if ($data['status'] =="Active") {
                # code...
                $status =0;
            }else{
                $status =1;

            }
            // cập nhập dữ liệu trong csdl
            CmsPage::where('id',$data['page_id'])->update(['status'=>$status]);
            // trả về phản hồi json status and page_id
            return response()->json(['status'=>$status,'page_id'=>$data['page_id']]);
        }
    }

    ```

5)  Update **custom.js** file :-
    Update **custom.js** file again to get the status and page id in ajax response and update status in cms_pages.blade.php file.

6)  Update sidebar.blade.php file :-
    Update Admin sidebar to add CMS Pages tab in which we will display "View CMS Pages" link and will highlight it when CMS Pages module selected.

# CMS / Dynamic Pages (IV) | Add/Edit CMS Pages

1. Update **cms_pages.blade.php** file :-
   First of all, we will show "Add CMS Page" link at top right side of the cms pages in admin panel.
    > <a style="max-width: 150px;float: right;display: inline-block;" class="btn btn-block btn-primary" href="{{ url('admin/add-edit-cms-page') }}"target="\_blank" rel="noopener noreferrer">Add CMS Page</a>

2) Create Route :-
   Create GET/POST route for Add/Edit CMS Page in web.php file under admin group with id parameter as optional (that is required in case of edit cms page) like below :-
    > Route::match(['get','post'],'add-edit-cms-page','CmsController@edit');
3) Update edit function :-
   Now we will update "**edit**" function in **CmsController** with parameter $id as optional. We will add condition to execute "Add CMS Page" functionality in case $id is empty otherwise "Edit CMS Page" functionality if $id is coming.

    ```
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request,$id=null)
    {
        //kiểm tra id có hay không
        if ($id=='') {
            # không có id
            $title= 'Add CMS Page';
        } else {
            # có id
            $title= 'Edit CMS Page';

        }
        // trả về đăng add hoặc edit
        return view('admin.pages.add_edit_cmspage')->with(compact('title'));

    }

    ``

    ```

4) Create <a href='resources/views/admin/pages/add_edit_cmspage.blade.php'>add_edit_cmspage.blade.php</a> file :-
   Now we will create **add_edit_cmspage.blade.php** file at path /resources/views/admin/pages/ and will add admin design to it.
5) Update <a href='resources\views\admin\layout\layout.blade.php'>layout.blade.php</a> file :-
   Add select2 CSS/JS files for advance html form that is having better select box script .

# CMS / Dynamic Pages (V) | Add CMS Page Functionality

1. Update **edit** function :-
   Now we will update "**edit**" function at CmsController to add Laravel validations to make sure correct cms page details added.
    ```
      // kiểm tra loại phương thức
         if ($request->isMethod('POST')) {
             # lấy hết tất cả yêu cầu của người dùng
             $data = $request->all();
             // echo '<pre>';print_r($data);die;
             // CMS page validation
             $rules=[
                 'title' => 'required',
                 'url' => 'required',
                 'description' => 'required',
             ];
             $customMessage=[
                 'title.required' => 'Page Title is required',
                 'url.required' => 'Page URL is required',
                 'description.required' => 'Page Description is required',
             ];
             $this->validate($request,$rules,$customMessage);
             $cmspage->title = $data['title'];
             $cmspage->url = $data['url'];
             $cmspage->description = $data['description'];
             $cmspage->meta_title = $data['meta_title'];
             $cmspage->meta_description = $data['meta_description'];
             $cmspage->meta_keywords = $data['meta_keywords'];
             $cmspage->status =1;
             $cmspage->save();
             return redirect('admin/cms-pages')->with('success_message', $message );
         }
    ```

2) Include Header Statements :-
   Make sure to include Session and CmsPage model at top of CmsController :-
   use App\Models\CmsPage;
   use Session;
3) Update **add_edit_cmspage.blade.php** file :-
   Now show error message above form at **add_edit_cmspage.blade.php** file.
    ```
     {{-- Show message --}}
          @if ($errors->any())
              <div class="alert alert-danger">
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
          @endif
        {{-- Show message --}}
    ```
4) Update edit function :-
   Now we will update "edit" function at CmsController to add query for adding cms page details in cms_pages table and return the user to cms pages with success message.
5) Update **cms_pages.blade.php** file :-
   We will show success message in categories page if category successfully added.
    ```
         {{-- Show message --}}
          @if (Session::has('success_message'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <strong>Success:</strong> {{ Session::get('success_message') }}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
          @endif
          {{-- Show message --}}
    ```
6) Update database.php file :-
   If Undefined array key error comes for any of the fields that you left empty like meta_title, meta_decription or meta_keywords then update **strict to false** in database.php file

# CMS / Dynamic Pages (VI) | Edit CMS Page Functionality

1. Update edit function:-
   Now we will update the "**edit**" function at CmsController to add a query for editing cms page details in the cms_pages table and return the user to cms pages with a success message.
    ```
     //kiểm tra id có hay không
        if ($id == '') {
            # không có id
            $title = 'Add CMS Page';
            $cmspage= new CmsPage;
            $message = 'CMS Page added successfully';
        } else {
            # có id
            $title = 'Edit CMS Page';
            // tìm id
            $cmspage=  CmsPage::find($id);
            $message = 'CMS Page updated successfully';
        }
    ```

2) Update <a href='resources\views\admin\pages\cms_pages.blade.php'>cms_pages.blade.php</a> file :-
   Now we will update the cms pages file to update form action and show data in fields in case the cms page already has data.
    ```
    <a href="{{ url('admin/add-edit-cms-page/' . $page['id']) }}"> <i class="fas fa-edit"></i></a>
    ```
3) update <a href='resources\views\admin\pages\add_edit_cmspage.blade.php'>add_edit_cmspage.blade.php</a>

    ```
      <form name="cmsForm" id="cmsForm"
              @if (empty($cmspage['id'])) action="{{ url('admin/add-edit-cms-page') }}"
          @else
          action="{{ url('admin/add-edit-cms-page/' . $cmspage['id']) }}" @endif
              method="POST">
              @csrf
              <!-- sử dụng if để kiểm tra xem là tạo mới hay cập nhật -->
               <div class="form-group">
                      <label for="title">Title*</label>
                      <input type="text" class="form-control" id="title" name="title"
                          placeholder="Enter Title"
                          @if (!empty($cmspage['title'])) value="{{ $cmspage['title'] }}" @endif>
                  </div>
                  ....
      </form>

    ```

# CMS / Dynamic Pages (VII) | Delete CMS Page Functionality

1. Update **cms_pages.blade.php** file :-
   First of all, we will update the <a href='resources\views\admin\pages\cms_pages.blade.php'>cms_pages.blade.php</a> file to **add delete** CMS Page link with every CMS Page listing.
    ```
     <a href="{{ url('admin/add-delete-cms-page/' . $page['id']) }}"><i class="fas fa-trash"></i></a>
    ```

2) Create Route :-
   Now we will create GET route with parameter page id to delete cms page in web.php file like below :-

    > Route::get('delete-cms-page/{id}','CmsController@destroy');

3) Update destroy function :-
   Now we will update **destroy** function in **CmsController** that automatically gets created earlier as the part of the CRUD operations by generating Resource Controller. Now we will write the query to delete the cms page with page id that we will get as parameter. After deleting the cms page, we will return to cms pages with success message.
    ```
        /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //delete cms page
        CmsPage::where('id', $id)->delete();
        return redirect()->back()->with('success_message', 'Delete successfully' );
    }
    ```

# 23 Make Admin Panel in Laravel 10 | Integrate SweetAlert2 jQuery Alert

1. Simple JavaScript Alert

    1. Update <a href='resources\views\admin\pages\cms_pages.blade.php'>cms_pages.blade.php</a>
        ```
        {{-- simple aler --}}
            <a  href="{{ url('admin/delete-cms-page/' . $page['id']) }}" class="confirmDelete" name='CMS Page' title="Delete CMS Page" record='cms-page' recordid={{ $page['id'] }}>
                <i class="fas fa-trash"></i></a>
        ```
    2. Update <a href='public\admin\js\custom.js'>custom.js</a>

        ```
        $(document).on("click", ".confirmDelete", function (e) {
         var name = $(this).attr("name");

            if (confirm("Are you sure you want to delete this " + name + "?")) {
         return true;
             }
            return false;
        });

        ```

2. SweetAlert 2 Javascript Library
   <a href='https://sweetalert2.github.io/'>SweetAlert 2 Javascript Library</a>

    1. install sweetalert2
        > npm install sweetalert2
    2. update <a href='resources\views\admin\layout\layout.blade.php'>SweetAlert 2 Javascript Library</a>
        > <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    3. Update <a href='resources\views\admin\pages\cms_pages.blade.php'>cms_pages.blade.php</a>

        ```
        {{-- simple aler --}}
           <a  href="javascript:void(0)"  <?php /*href="{{ url('admin/delete-cms-page/' . $page['id']) }}"*/?> class="confirmDelete" name='CMS Page' title="Delete CMS Page" record='cms-page' recordid={{ $page['id'] }}>
                <i class="fas fa-trash"></i></a>
        ```

    4. Update <a href='public\admin\js\custom.js'>custom.js</a>

        ```
        $(document).on("click", ".confirmDelete", function (e) {
            var record = $(this).attr("record");
            var recordid = $(this).attr("recordid");
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Deleted!",
                        text: "Your file has been deleted.",
                        icon: "success",
                    });
                    window.location.href='/admin/delete-'+record+'/'+recordid;
                }
            });
        });


        ```

# 24 Remember me Laravel functionality| Remember me functionality in Login Page

1. Update <a href='resources\views\admin\login.blade.php'>login.blade.php</a> file :-
   First of all, we will add a "**Remember Me**" checkbox at the admin login form with the **name "remember"**.

2)  Update <a href='app\Http\Controllers\Admin\AdminController.php'>AdminController.php</a>login function:-
    Now we will update the login function at AdminController and will set cookies both for email and password when the remember post data is not empty means when the user checks at Remember Me checkbox at the admin login form.

    ```
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
    ```

3)  Update <a href='resources\views\admin\login.blade.php'>login.blade.php</a> file :-
    Now we will update the **login.blade.php** file once again to show the username and password that we have stored in cookies when the user checks the "Remember Me" checkbox.

        ```
           {{-- ! hiển thị dữ liệu từ cookie  --}}
             @if (isset($_COOKIE['email'])) value="{{ $_COOKIE['email'] }}" @endif

            {{-- ! hiển thị dữ liệu từ cookie  --}}
            @if (isset($_COOKIE['password'])) value="{{ $_COOKIE['password'] }}" @endif

        {{-- ! hiển thị dữ liệu từ cookie remember me --}}
            @if (isset($\_COOKIE['email'])) checked @endif

    ```

    ```

# 25 Roles and Permissions in Laravel 10 (I) | Display Subadmins in Admin Panel

1. Update <a href='resources\views\admin\layout\sidebar.blade.php'>sidebar.blade.php</a> file :-
   Now, update **sidebar.blade.php** file to show Add/View Sub-Admins links at admin sidebar.

    ```
         {{-- ! Sub Admins --}}

                @if (Session::get('page') == 'subadmins')
                    @php
                        $active = 'active';
                    @endphp
                @else
                    @php
                        $active = '';
                    @endphp
                @endif
                <li class="nav-item">
                    <a href="{{ url('admin/subadmins') }}" class="nav-link {{ $active }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Subadmins
                        </p>
                    </a>
                </li>
                {{-- ! Sub Admins --}}
    ```

2) Create Route <a href='routes\web.php'>web.php</a>
   Now create GET Route for displaying subadmins in admin panel.
    > Route::get('subadmins', 'AdminController@subadmins');
3) Create subadmins function :-
   Now we will create subadmins function in <a href='app\Http\Controllers\Admin\AdminController.php'>AdminController</a> where we will add query to select all subadmins from admins table to show in **subadmins.blade.php** file that we will create in our next step.

    ```
      /**
     * show sub admins
     */
    public function subadmins(){
        Session::put('page', 'subadmins');

        // * lấy tất cả các sub admins với loại subadmin
        $subadmins = Admin::where('type','subadmin')->get();
        //  echo "<pre>";
        //     print_r($subadmins);
        //     die;
        return view('admin.subadmins.subadmins')->with(compact('subadmins'));
    }
    ```

4) Create <a href='resources\views\admin\subadmins\subadmins.blade.php'>subadmins.blade.php</a> file :-
   Now create subadmins folder under \resources\views\admin\ and then create **subadmins.blade.php** file under that subadmins folder.

# 26 Roles and Permissions in Laravel (II) | Active/Inactive/Delete Sub admins

1. Update <a href='public\admin\js\custom.js'>custom.js</a> file :-
   Add jQuery script for active/inactive status for sub admins in custom.js file.

    ```
     $(document).on("click", ".updateSubadminStatus", function () {
     // <a href="javascript:void(0)" class="updateSubadminStatus">  <i
     // class="fas fa-toggle-on" status="Active"></i> </a>
     // parent:  $(this) -> <a>
     // children: <i>
     // attr: status="Active"
     var status = $(this).children("i").attr("status");
     var subadmin_id = $(this).attr("subadmin_id");
     // alert( subadmin);
     $.ajax({
         headers: {
             "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
         },
         type: "POST",
         url: "/admin/update-subadmin-status",
         data: { status: status, subadmin_id: subadmin_id },
         success: function (resp) {
             // kiểm tra kết quả json trả về
             if (resp["status"] == 0) {
                 $("#subadmin-" + subadmin_id).html(
                     '<i class="fas fa-toggle-off" style="color: grey" status="Inactive"></i>'
                 );
             } else if (resp["status"] == 1) {
                 $("#subadmin-" + subadmin_id).html(
                     '<i class="fas fa-toggle-on" style="color: #007bff" status="Active"></i>'
                 );
             }
         },
         error: function () {
             alert("Error");
         },
     });
    });

    ```

2) Create Route :-
   Now create post route for active/inactive status for sub-admins in web.php file :-
    > Route::post('update-subadmin-status','AdminController@updateSubadminStatus');
3) Create **updateSubadminStatus** function :-
   Now create **updateSubadminStatus** function at <a href='app\Http\Controllers\Admin\AdminController.php'>AdminController</a> to update active/inactive status for sub admins.
   Now we will work on delete functionality for subadmins.

    ```

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

    ```

4) Create Route :-
   Create Get route for deleting subadmin in web.php file like below :-

    > Route::get('delete-subadmin/{id}','AdminController@deleteSubadmin');

5) Create **deleteSubadmin** function :-
   Create **deleteSubadmin** function at <a href='app\Http\Controllers\Admin\AdminController.php'>AdminController</a> to delete sub-admin.

    ```
      /**
     * Remove the specified resource from storage.
     */
    public function deleteSubadminStatus($id)
    {
        //delete cms page
        Admin::where('id', $id)->delete();
        return redirect()->back()->with('success_message', 'Delete successfully' );
    }

    ```

# 27 Roles and Permissions in Laravel (III) | Add/Edit Sub Admin in Admin Panel

1. Create Route :-
   First of all, create GET/POST route for adding/editing admin/subadmin in web.php file :-
    > Route::match(['get','post'],'add-edit-subadmin/{id?}','AdminController@addEditSubadmin');

2) Create **addEditSubadmin** function :-
   Now create **addEditSubadmin** function at <a href='app\Http\Controllers\Admin\AdminController.php'>AdminController</a> which will work for both add and edit. When subadmin id return then it will work for edit otherwise add subadmin.

    ```
      /**
     * Add / Edit Subadmin
     */
    public function addEditSubadmin(Request $request, $id = null)
    {
        // ? kiểm tra xem id là thêm hay là update
        // ! id =='' là thêm id !='' là update
        if ($id == '') {
            # code...
            $title = 'Add Subadmin';
            $subadmindata = new Admin;
            $message = 'Subadmin added successfully';
        } else {
            $title = 'Update Subadmin';
            $subadmindata = Admin::find($id);

            $message = 'Subadmin updated successfully';
        }
        if ($request->isMethod('POST')) {
            # code...
            $data = $request->all();
              print_r($data);
            die;

        }
        return view('admin.subadmins.add_edit_subadmin')->with(compact('title', 'subadmindata'));
    }
    ```

3) Create <a href='resources\views\admin\subadmins\add_edit_subadmin.blade.php'>add_edit_subadmin.blade.php</a> file :-
   Now create **add_edit_subadmin.blade.php** file under \resources\views\admin\subadmins\ folder in which we will display add/edit subadmin form with subadmin name, email, password, mobile and image.

# 28 Roles and Permissions in Laravel (IV) | Add/Edit Sub Admin in Admin Panel

1. Update **addEditSubadmin** function in <a href='app\Http\Controllers\Admin\AdminController.php'>AdminController.php</a> :-
   First of all, we will update **addEditSubadmin** function to add/edit subadmin details in admins table and return back to subadmins page. In case subadmin already exists in case of add then we will return with error message.

    ```
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
            ];
            $customMessages = [
                'name.required' => 'Name is required',
                'name.regex' => 'Valid name is required',
                'name.max' => 'Valid name is required',
                'mobile.required' => 'Mobile is required',
                'mobile.numeric' => 'Valid Mobile is required',
                'mobile.digits' => 'Valid Mobile is required',
                'image.image' => 'Valid Image is required',
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
    ```

2) Update <a href='resources\views\admin\subadmins\subadmins.blade.php'>subadmins.blade.php</a> file :-
   We will add "Edit subadmin" link with subadmin id at subadmins page in the admin panel.
    ```
     <a href="{{ url('admin/add-edit-subadmin/' . $subadmin['id']) }}"> <i class="fas fa-edit"></i></a>
    ```

# 29 Roles and Permissions in Laravel (V) | Set Permissions for Sub Admins

1.  Create admins_roles table :-
    1.1 Run below command to make migration file :-

            > php artisan make:migration create_admins_roles_table

            1.2 Update migration file to add columns in <a href='database\migrations\2024_03_20_130431_create_admins_roles_table.php'>admins_roles</a> table

            ```
                Schema::create('admins_roles', function (Blueprint $table) {
                    $table->id();
                    $table->integer('admin_id');
                    $table->string('module');
                    $table->string('view_access');
                    $table->string('edit_access');
                    $table->string('full_access');
                    $table->timestamps();
                });
            ```

        1.3 Run below command

        > php artisan migrate

        Now, admins_roles table has been created.

2) Create **AdminRole** Model :-

    Create **AdminRole** Model with below artisan command :-

    > php artisan make:model AdminRole

3) Update <a href='resources\views\admin\subadmins\subadmins.blade.php'>subadmins.blade.php</a> file :-
   Add update-role link at subadmins page for setting the permission for subadmin.
    ```
      <a href="{{ url('admin/update-role/' . $subadmin['id']) }}"> <i  class="fas fa-unlock"></i></a>
    ```
4) Create Route :-
   Now create GET/POST route for update roles/permissions for sub admins in web.php file :-
    > Route::match(['get','post'],'/update-role/{id}','AdminController@updateRole');
5) Create **updateRole** function :-
   Now create **updateRole** function at <a href='./app/Http/Controllers/Admin/AdminController.php'>AdminController</a> return to **update_roles.blade.php** file that we will create in next step.

    ```
      public function updateRole($id,Request $request){
        $title= 'Update Subadmin Roles/Persmission';
        if ($request->isMethod('post')) {
            # code...
            $data = $request->all();
             echo "<pre>";
            print_r($data);
            die;
        }
        return view('admin.subadmins.update_roles')->with(compact('title','id'));

    }
    ```

6) Create **update_roles.blade.php** file :-
   Now create **update_roles.blade.php** file under \resources\views\admin\subadmins\ folder in which we will add cms pages add/edit/full access as this is the only module we have created so far.
7) Update updateRole function :-
   Now we will update updateRole function to get the posted data and update view/edit/full access for categories, products, coupons and other modules for admins and subadmins.

# 30 Roles and Permissions in Laravel (VI) | Update Permissions for Subadmins

1. update updateRole method in <a href='./app/Http/Controllers/Admin/AdminController.php'>AdminController</a>

    ```
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
    ```

2. update <a href='resources\views\admin\subadmins\update_roles.blade.php'>update_roles.blade.php</a>

    ```
        {{-- Show message --}}

                                  @if (Session::has('success_message'))
                                      <div class="alert alert-success alert-dismissible fade show" role="alert">
                                          <strong>Success:</strong> {{ Session::get('success_message') }}
                                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                          </button>
                                      </div>
                                  @endif
                                  {{-- Show message --}}

                                  <form name="subadminForm" id="subadminForm" action="{{ url('admin/update-role/' . $id) }}"
                                      method="POST">
                                      @csrf
                                      <input type="hidden" name="subadmin_id" value="{{ $id }}">
                                      <div class="card-body">
                                          {{-- <div class="form-group col-md-6">
                                              <label for="email">Email</label>
                                              <input type="email" class="form-control"
                                                  @if ($subadmindata['email'] != '') disabled=''
                                            @else
                                                required='' @endif
                                                  id="email"name="email" placeholder="Enter Email"
                                                  @if (!empty($subadmindata['email'])) value="{{ $subadmindata['email'] }}"
                                                  @else
                                                      value="{{ old('name') }}" @endif>
                                          </div> --}}
                                          {{-- ! kiểm tra roles có rỗng không --}}
                                          @if (!empty($subadminRoles))
                                          {{-- ! duyệt mảng để lấy các roles đã được thiết lập --}}
                                              @foreach ($subadminRoles as $role)
                                              {{-- ! kiểm tra loại module --}}
                                                  @if ($role['module'] == 'cms_pages')
                                                  {{-- ! kiểm tra có chọn role view hay không --}}
                                                      @if ($role['view_access'] == 1)

                                                      {{-- ! có thì thêm attribute 'checked' --}}
                                                          @php
                                                              $viewCMSPages = 'checked';
                                                          @endphp
                                                      @else
                                                      {{-- ! không có để '' --}}
                                                          @php
                                                              $viewCMSPages = '';
                                                          @endphp
                                                      @endif
                                                      @if ($role['edit_access'] == 1)
                                                          @php
                                                              $editCMSPages = 'checked';
                                                          @endphp
                                                      @else
                                                          @php
                                                              $editCMSPages = '';
                                                          @endphp
                                                      @endif
                                                      @if ($role['full_access'] == 1)
                                                          @php
                                                              $fullCMSPages = 'checked';
                                                          @endphp
                                                      @else
                                                          @php
                                                              $fullCMSPages = '';
                                                          @endphp
                                                      @endif
                                                  @endif
                                              @endforeach
                                          @endif
                                          <div class="form-group col-md-6">
                                              <label for="cms_page">CMS Pages:&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                              <input type="checkbox" id="cms_page" value="1"
                                              {{-- ! kiểm tra view có được thiết lập không --}}
                                               @if (isset( $viewCMSPages))
                                              {{$viewCMSPages}}
                                              @endif
                                                  name="cms_page[view]">View Access
                                              &nbsp;&nbsp;&nbsp;&nbsp;
                                              <input type="checkbox" id="cms_page" value="1"
                                                  name="cms_page[edit]" @if (isset( $editCMSPages))
                                                  {{$editCMSPages}}
                                                  @endif>View/Edit Access
                                              &nbsp;&nbsp;&nbsp;&nbsp;
                                              <input type="checkbox" id="cms_page" value="1"
                                                  name="cms_page[full]"  @if (isset( $fullCMSPages))
                                                  {{$fullCMSPages}}
                                                  @endif>Full Access
                                              &nbsp;&nbsp;&nbsp;&nbsp;

                                          </div>
                                      </div>
                                      <!-- /.card-body -->
                                      {{-- <input type="hidden" name="status" value="{{ $subadmindata['status'] }}"> --}}
                                      <div>
                                          <button type="submit" class="btn btn-primary">Submit</button>
                                      </div>
                                  </form>

    ```

# 31 Roles and Permissions in Laravel 10 (VII) | Update Permissions for Subadmins

## cập nhật lại updateRole method

sử dụng vòng lập foreach để duyệt qua tất cả dữ liệu trong mảng

    ```
        foreach ($data as $key => $value) {
                if (isset($value['view'])) {
                    $view = $value['view'];
                }else {
                    $view =0;
                }
                if (isset($value['edit'])) {
                    $edit = $value['edit'];
                }else {
                    $edit =0;
                }
                if (isset($value['full'])) {
                    $full = $value['full'];
                }else {
                    $full =0;
                }
            }
    ```

# 32 Roles and Permissions (VIII) | Set Permissions to access CMS Pages Module

1. Update **index**function:-
   First of all, update the index function at <a href='app\Http\Controllers\Admin\CmsController.php'>CmsController</a>. If the logged-in user is admin or superadmin then we will give all the access and if subadmin then we will check which access is given to him.

    ```
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Session::put('page', 'cms-pages');
        //lấy tất cả các trang và chuyển đổi sang mảng
        $CmsPages = CmsPage::get()->toArray();
        // xem mảng danh sách
        // dd($CmsPages);
        // ! set Admin/Subadmin Permissions for CMS Pages
        // ? so sánh id trong bảng AdminsRole có giống với id đăng đăng nhập và so sánh module có phải cms-pages
        $cmspagesModuleCount = AdminsRole::where([
            'subadmin_id' => Auth::guard('admin')->user()->id,
            'module' => 'cms_pages'
        ])->count();
        $pagesModule = array();
        // ? kiểm tra admin đang đăng nhập
        if (Auth::guard('admin')->user()->type == 'admin') {
            // * đây là admin
            $pagesModule['view_access'] = 1;
            $pagesModule['edit_access'] = 1;
            $pagesModule['full_access'] = 1;

        } else if ($cmspagesModuleCount == 0) {
            // * chưa có quyền truy cập
            $message = 'This feature is restricted for you';
            return redirect('/admin/dashboard')->with('error_message', $message);
        } else {
            // * có một số quyền truy cập
            $pagesModule = AdminsRole::where([
                'subadmin_id' => Auth::guard('admin')->user()->id,
                'module' => 'cms_pages'
            ])->first()->toArray();

        }
        // hiển thị trang web
        return view('admin.pages.cms_pages')->with(compact('CmsPages', 'pagesModule'));
    }

    ```

2) Update <a href='resources\views\admin\pages\cms_pages.blade.php'>cms_pages.blade.php</a> file :-
   Update the cms_pages.blade.php file to check which access sub admin is having and show the feature according to it.
    ```
      @if ($pagesModule['edit_access'] == 1 || $pagesModule['full_access'] == 1)
          <a href="{{ url('admin/add-edit-cms-page/' . $page['id']) }}"> <i
                  class="fas fa-edit"></i></a>
                  ...
    ```
3) Update <a href='resources\views\admin\dashboard.blade.php'>dashboard.blade.php</a> file :-
   Now we will update the dashboard file to show the error message in case the module is restricted for the sub admin

# Basic Admin Panel for All Laravel Websites

# 34 Categories Module (I) | Create Table | Insert Categories with Seeder

1. Create categories table :-
   First of all, we will create categories table with migration. Create migration file with name create_categories_table for creating categories table with below columns:-
   id, parent_id, category_name, category_image, category_discount, description, url, meta_title, meta_description, meta_keywords and status

    So, we will run below artisan command to create a migration file for categories:-

    > php artisan make:migration create_categories_table

    Open the create_categories_table migration file and add all required columns mentioned earlier.

    ```
         /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id');
            $table->string('category_name');
            $table->string('category_image');
            $table->float('category_discount');
            $table->text('description');
            $table->string('url');
            $table->string('meta_title');
            $table->string('meta_description');
            $table->string('meta_keywords');
            $table->tinyInteger('status');
            $table->timestamps();
        });
    }
    ```

    Now, we will run below artisan command to create a categories table with required columns:-

    > php artisan migrate

    Now categories table has been created with all the required columns.

2) Create Category model :-
   Create Category model by running below command :-
    > php artisan make:model Category
3) Create CategoryController :-
   Create CategoryController in Admin folder at /app/Http/Controllers/Admin/ by running below command :-

    > php artisan make:controller Admin/CategoryController

    Now, We will create a Seeding for categories table to insert a few categories like Clothing, Electronics and Appliances and we will also create few sub categories under Clothing category like Men, Women and Kids.

4) Writing Seeder / Create CategoryTableSeeder file :-
   First of all, we will generate a seeder and create a CategoryTableSeeder file from which we will add few categories and sub-categories for the categories table.

    Run below artisan command to generate Seeder and create CategoryTableSeeder file:-
    php artisan make:seeder CategoryTableSeeder

    Above command will create the CategoryTableSeeder.php file at \database\seeds\

    Now open the CategoryTableSeeder file and add records for the categories.

5. Update DatabaseSeeder.php file:-
   Now update DatabaseSeeder.php file located at database/seeds/ to add CategoryTableSeeder class as shown in video.

6. Run below command :-
   Now run below command that will finally insert category into categories table.
    > php artisan db:seed

# 35 Categories Module (II) | Display Categories in Admin Panel

1. Create Route:-
   Create GET route in web.php file in admin middleware group prefixed with admin and having namespace Admin for displaying categories in admin panel:-
    > Route::get('categories','CategoryController@categories');

2) Create categories function:-
   Now create categories function in **CategoryController** to write query to display all the categories in admin panel and return to categories blade file that we will create under /resources/views/admin/categories/ folder.
3) Include Category model:-
   Include the Category model at top of CategoryController.
    > use App\Models\Category;
4) Create parentcategory Relation <a href='app\Models\Category.php'>Category.php</a>:-
   We will create parentcategory hasOne Relation to find the parent category of every category if there is any to display along with the category name in the categories module in admin panel.
5) Update categories function:-
   Now we will update categories function to attach parentcategory Relation to show the parent category of every category if there is any to display along with the category name in the categories module in admin panel.

    ```
     /**
      * hiển thị danh sách categories
      * @return View page
      */
    public function categories(){
         $categories = Category::with('parentcategory')->get()->toArray();
         // dd($categories);
     //    return $categories;
     return view('admin.categories.categories')->with(compact('categories'));
     }
    ```

6) Create <a href='resources\views\admin\categories\categories.blade.php'>categories.blade.php</a> file:-
   Now create the categories.blade.php file under /resources/views/admin/categories/ folder in which we will add content from the Skydash admin template and will display categories within foreach loop.

7) Update <a href='resources\views\admin\layout\layout.blade.php'>layout.blade.php</a> file :-
   We will update layout.blade.php file to call datatable for categories

    > $("#categories").DataTable();

# 36 Categories Module (III) | Active/Inactive/Delete Categories in Admin Panel

1. Update <a href='resources\views\admin\categories\categories.blade.php'>categories.blade.php</a> file:-
   Add updateCategoryStatus class with id and category_id for active/inactive status at categories.blade.php file

2) Create Route:-
   Create Post route to update status of category in web.php file :-

    > Route::post('update-category-status','CategoryController@updateCatgoryStatus');

3) Create updateCategoryStatus function :-
   Create updateCategoryStatus function in CategoryController to update the category status to active or inactive.

    ```
      /**
     * Update the specified resource in storage.
     * @param Request $request yêu cầu cập nhật status
     * trả về phản hồi json
     */
    public function updateCategoryStatus(Request $request)
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
            //! cập nhập dữ liệu trong csdl
            // ? so sánh id trong csdl với id trong categories.blade.php có giống nhau không -> update status
            Category::where('id', $data['category_id'])->update(['status' => $status]);
            // trả về phản hồi json status and category_id
            return response()->json(['status' => $status, 'category_id' => $data['category_id']]);
        }
    }
    ```

4) Update **custom.js** file :-
   Add jquery function to update active/inactive status for categories in custom.js file.
    ```
            //TODO: Update Category Status
        $(document).on("click", ".updateCategoryStatus", function () {
        // <a href="javascript:void(0)" class="updateCategoryStatus">  <i
        // class="fas fa-toggle-on" status="Active"></i> </a>
        // parent:  $(this) -> <a>
        // children: <i>
        // attr: status="Active"
        var status = $(this).children("i").attr("status");
        var category_id = $(this).attr("category_id");
        // alert( category);
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            type: "POST",
            url: "/admin/update-category-status",
            data: { status: status, category_id: category_id },
            success: function (resp) {
                // kiểm tra kết quả json trả về
                if (resp["status"] == 0) {
                    $("#category-" + category_id).html(
                        '<i class="fas fa-toggle-off" style="color: grey" status="Inactive"></i>'
                    );
                } else if (resp["status"] == 1) {
                    $("#category-" + category_id).html(
                        '<i class="fas fa-toggle-on" style="color: #007bff" status="Active"></i>'
                    );
                }
            },
            error: function () {
                alert("Error");
            },
        });
        });
    ```

Delete

    ```

        //! confirm delete with sweetalert subadmin
        $(document).on("click", ".confirmDelete", function (e) {
        var record = $(this).attr("record");
        var recordid = $(this).attr("recordid");
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "Deleted!",
                    text: "Your file has been deleted.",
                    icon: "success",
                });
                window.location.href='/admin/delete-'+record+'/'+recordid;
            }
        });
        });
    ```

# 37 Categories Module (IV) | Add/Edit Category Functionality | Category Form

1. Update <a href='resources\views\admin\categories\categories.blade.php'>categories.blade.php</a> file :-
   First of all, we will show "**Add Category**" link at top right side of the categories page in admin panel.
    ```
     <a style="max-width: 150px;float: right;display: inline-block;"
          class="btn btn-block btn-primary" href="{{ url('admin/add-edit-category') }}"
          rel="noopener noreferrer">Add Category</a>
    ```

2) Create Route :-
   Create GET/POST route for Add/Edit Category in web.php file under admin group with id parameter as optional (that is required in case of edit category) like below :-

    > Route::match(['get','post'],'add-edit-category/{id?}','CategoryController@addEditCategory');

3) Create **addEditCategory** function :-
   Create **addEditCategory** function in <a href='app\Http\Controllers\Admin\CategoryController.php'>CategoryController</a> with parameter $id as optional. We will add condition to execute "Add Category" functionality in case $id is empty otherwise "Edit Category" functionality if $id is coming.

    ```
         /**
     * add/edit category
     * @param Request $request yêu cầu của người dùng
     * @param mixed $id id category
      */
    public function addEditCategory(Request $request,$id = null)
    {
        // ! kiểm tra id có tồn tại không
        if ($id == "") {
            // ? id chưa tồn tại
            $title = 'Add Category';
        } else {
            // ? id đã tồn tại
            $title = 'Edit Category';


        }
        // ! hiển thị trang web add/edit category
        return view('admin.categories.add_edit_category')->with(compact('title'));

    }
    ```

4) Create <a href='resources\views\admin\categories\add_edit_category.blade.php'>add_edit_category.blade.php</a> file :-
   Now we will create add_edit_category.blade.php file at path /resources/views/admin/categories/ and will add admin design to it and will create add/edit category form.

# 38 Categories Module (V) | Add/Edit Category | Add Category Details

1. Update <a href='resources\views\admin\categories\add_edit_category.blade.php'>add_edit_category.blade.php</a> file :-
   First of all, we will update add_edit_category.blade.php file to make sure to add form action, name and id's for form and for all fields.

2) Update addEditCategory function :-
   Now we will update addEditCategory function at <a href='app\Http\Controllers\Admin\CategoryController.php'>CategoryController</a> to add query for adding category details in categories table and return the user to categories page with success message.

    We will only add main category for now that does not have any parent category so we will add parent_id as 0 for now.

    ```
         /**
     * add/edit category
     * @param Request $request yêu cầu của người dùng
     * @param mixed $id id category
      */
    public function addEditCategory(Request $request,$id = null)
    {
        // ! kiểm tra id có tồn tại không
        if ($id == "") {
            // ? id chưa tồn tại
            $title = 'Add Category';
            $category = new Category;
            $message = "Category added successfully";
        } else {
            // ? id đã tồn tại
            $title = 'Edit Category';
            $category =  Category::find($id);
            $message = "Category edited successfully";
        }
        if ($request->isMethod('POST')) {
            $data = $request->all();
            // echo"<pre>";
            // print_r($data);die;
            // ? update category image
              // update admin image
            // kiểm tra file hình ảnh
            if ($request->hasFile('category_image')) {
                $image_tmp = $request->file('category_image');
                if ($image_tmp->isValid()) {
                    # Get image extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    // Generate new Image Name
                    $imageName = rand(111, 99999) . '.' . $extension;
                    // tạo đường dẫn luư hình ảnh
                    $image_path = 'admin/front/images/categories/' . $imageName;

                    // tải hình ảnh
                    Image::make($image_tmp)->save($image_path);
                    $category->category_image=$imageName;
                }
            } else  {
                # code...
                $category->category_image= '';
            }
            $category->category_name = $data['category_name'];
            $category->category_discount = $data['category_discount'];
            $category->description = $data['description'];
            $category->url = $data['url'];
            $category->meta_title = $data['meta_title'];
            $category->meta_description = $data['meta_description'];
            $category->meta_keywords = $data['meta_keywords'];
            $category->parent_id =0;

            $category->status =1;

            $category->save();
            return redirect('admin/categories')->with('success_message',$message);

        }
        // ! hiển thị trang web add/edit category
        return view('admin.categories.add_edit_category')->with(compact('title'));

    }
    ```

3) Include Header Statements :-
   Include Session and Image class at top of CategoryController :-
    > use Session;
    > use Image;
4) Update <a href='resources\views\admin\categories\add_edit_category.blade.php'>add_edit_category.blade.php</a> file :-
   We will show success message in categories page if category successfully added.

# 39 Categories Module (VI) | Add/Edit Category | Validate Add Category Form

1. Update **addEditCategory** function:-
   We will update the **addEditCategory** function at <a href='app\Http\Controllers\Admin\CategoryController.php'>CategoryController</a> to add Laravel validations to make sure the correct category data is added.
    ```
    // !validation
            $rules=[
                // ! bắt buộc nhập tên category
                'category_name'=>'required',
                // ! bắt buộc nhập url | và không trùng với url cũ
                'url'=>'required|unique:categories',
            ];
            $customMessage=[
                'category_name.required'=>'Category Name is required',
                'url.required'=>'Category Url is required',
                'url.unique'=>'Unique Category Url is required',
            ];
            $this->validate($request,$rules,$customMessage);
    ```

2) Update <a href='resources\views\admin\categories\add_edit_category.blade.php'>add_edit_category.blade.php</a> file :-
Now show the error message above form at add_edit_category.blade.php file.
