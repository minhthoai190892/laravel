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
