<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::prefix('/admin')->namespace('App\Http\Controllers\Admin')->group(function () {
    Route::match(['get', 'post'], 'login', 'AdminController@login');
    Route::group(['middleware' => ['admin']], function () {
        // ? admin
        Route::get('dashboard', 'AdminController@dashboard');
        Route::get('logout', 'AdminController@logout');
        Route::match(['get', 'post'],'update-password', 'AdminController@updatePassword');
        Route::match(['get', 'post'],'update-details', 'AdminController@updateDetails');
        Route::post('check-current-password', 'AdminController@checkCurrentPassword');
        //? hiển thị CMS Pages (CRUD - READ)
        Route::get('cms-pages', 'CmsController@index');
        Route::post('update-cms-page-status', 'CmsController@update');
        Route::match(['get', 'post'],'add-edit-cms-page/{id?}', 'CmsController@edit');
        Route::get('delete-cms-page/{id?}', 'CmsController@destroy');
        // ? Sub admin
        Route::get('subadmins', 'AdminController@subadmins');
        Route::post('update-subadmin-status', 'AdminController@updateSubadminStatus');
        Route::get('delete-subadmin/{id?}', 'AdminController@deleteSubadminStatus');
        Route::match(['get', 'post'],'add-edit-subadmin/{id?}', 'AdminController@addEditSubadmin');
        Route::match(['get', 'post'],'update-role/{id}', 'AdminController@updateRole');
        // ? Categories
        Route::get('categories', 'CategoryController@categories');
        Route::post('update-category-status', 'CategoryController@updateCategoryStatus');
        Route::get('delete-category/{id?}', 'CategoryController@deleteCategory');
        Route::match(['get', 'post'],'add-edit-category/{id?}', 'CategoryController@addEditCategory');


        
    });
});