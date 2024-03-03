<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel
<!-- database -->
http://localhost/phpmyadmin/
### Laravel 10 Tutorial #4
1) Update layout.blade.php file :-
First of all, we will update layout.blade.php file to add Laravel asset and url to css/js/images and plugins paths.
1. thêm thư viện

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

2) Update header.blade.php file :-
Now we will update the header.blade.php file to add Laravel asset to images paths.
```c 
<img src="{{ asset('admin/images/user1-128x128.jpg') }}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
...
```

3) Update sidebar.blade.php file :-
Now we will update sidebar.blade.php file to add Laravel asset to images paths.
```c 
<img src="{{ asset('admin/images/user1-128x128.jpg') }}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
...
```
4) Update dashboard.blade.php file :-
Now we will update dashboard.blade.php file to add Laravel asset to images paths.
_tạo phần nội dung_
**extends: mở rộng tối layout**
>   @extends('admin.layout.layout')
  @section('content')
```c 
<img src="{{ asset('admin/images/user1-128x128.jpg') }}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
...
```
5) Create AdminController.php file :-
Now create Admin folder under /app/Http/Controllers/ and then create **AdminController**.php file under Admin folder by running below artisan command :-
>php artisan make:controller Admin/AdminController
```c 
 //gọi đến trang để hiển thị
    public function dashboard(){
        //  admin_dashboard.blade.php
        return view('admin.dashboard');
    }
```

6) Create Route :-
We will create a separate group in the **web.php** file for admin routes so that we can keep them separately with namespace Admin and prefix admin.
```c 
// tạo nhóm tuyến đường
Route::prefix('/admin')->namespace('App\Http\Controllers\Admin')->group(function () {
    Route::get('/dashboard', 'AdminController@dashboard');
});
```
7) You can see the view of the dashboard page by opening below link :-
http://127.0.0.1:8000/admin/dashboard
## Create Admin Panel Login Page
1) Create Route:- 
First of all, create a **GET/POST** route for admin login in the Admin route group like below:-
>Route::match(['get','post'],'/login','AdminController@login');

2) Create Function:-
Now create a login function in **AdminController** that will return to the **admin_login.blade.php** file that we will create in the next step.
3) Create **login.blade.php** file :-
Now we will create a **login.blade.php** file in _/resources/views/admin/_ folder in which we will add content from the login.html page from _AdminLTE/pages/examples/_ folder. 
4) We will also correct paths in the login.blade.php file. 
(http://127.0.0.1:8000/admin/login)

## Create Admin Middleware to Protect Admin Routes
1) Create admins table:-
First of all, we will create an **admins table** with migration with the below columns:
_id, name, type, mobile, email, password, image, status_
So, we will run the below artisan command to create a migration file for admins:-
>php artisan make:migration create_admins_table

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
            $table->string('password');
            $table->string('image');
            $table->tinyInteger('status');

            $table->string('phone')->unique();
            $table->string('email')->unique();
            $table->timestamps();
        });
    }
```

Now we will run below artisan command to create an admins table with the required columns:- 
>php artisan migrate
2) Create Admin model:-
Now we will create an **Admin model** with the below artisan command:-
>php artisan make:model Admin

We will update the content of the Admin model file to set the protected guard variable for admin and set other variables as shown in the video.

We will also extend the Admin class to Authenticatable and add its namespace as well.
3) Update **auth.php** file :-
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

4) Create **Admin Middleware** :-
Now we will create **Admin Middleware** file by running below command :-
>php artisan make:middleware Admin
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

5) Update *kernel.php* file :-
Now we will update *kernel.php* file located at app\http\ folder to register Admin middleware as global as shown in video.
```
protected $middlewareAliases = [ 
    ...
    'admin' => \App\Http\Middleware\Admin::class,
]
```

6) Update **Admin Middleware**
**Add Auth:guard** check in **Admin Middleware** to protect the admin routes. This check will be false for now as we have not registered the admin guard yet. 

7) Update web.php file :-
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