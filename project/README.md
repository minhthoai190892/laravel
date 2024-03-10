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

2) Update **updatePassword** function :-
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

3) Update <a href='../project/resources/views/admin/update_password.blade.php'> update pasword page</a> file :-
   Update admin update password page with success and error message div's
    ```
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
>Route::match(['get', 'post'],'update-password', 'AdminController@updatePassword');