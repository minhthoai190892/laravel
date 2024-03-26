<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
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
}
