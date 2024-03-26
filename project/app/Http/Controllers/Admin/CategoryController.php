<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Session;

class CategoryController extends Controller
{
    /**
     * hiển thị danh sách categories
     * @return View page
     */
    public function categories()
    {
        Session::put('page', 'categories');
        $categories = Category::with('parentcategory')->get()->toArray();
        // dd($categories);
        //    return $categories;
        return view('admin.categories.categories')->with(compact('categories'));
    }
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
    /**
     * Remove the specified resource from storage.
     */
    public function deleteCategory($id)
    {
        //delete category
        Category::where('id', $id)->delete();
        return redirect()->back()->with('success_message', 'Delete successfully');
    }
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

}
