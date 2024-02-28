<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Admincontroller extends Controller
{
    //gọi đến trang để hiển thị
    public function dashboard(){
        return view('admin.dashboard');
    }
}
