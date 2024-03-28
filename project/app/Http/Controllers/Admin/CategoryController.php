<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminsRole;
use App\Models\Category;
use Illuminate\Http\Request;
use Session;
use Image;
use Auth;

class CategoryController extends Controller
{
    /**
     * hiển thị danh sách categories
     * @return View page
     */
    public function categories()
    {
        Session::put('page', 'categories');
        $categories = Category::with('parentcategory')->get();
        // dd($categories);
        //    return $categories;
          // ! set Admin/Subadmin Permissions for Categories
        // ? so sánh id trong bảng AdminsRole có giống với id đăng đăng nhập và so sánh module có phải categories
        $categoriesModuleCount = AdminsRole::where([
            'subadmin_id' => Auth::guard('admin')->user()->id,
            'module' => 'categories'
        ])->count();
        $categoriesModule = array();
        // ? kiểm tra admin đang đăng nhập
        if (Auth::guard('admin')->user()->type == 'admin') {
            // * đây là admin 
            $categoriesModule['view_access'] = 1;
            $categoriesModule['edit_access'] = 1;
            $categoriesModule['full_access'] = 1;

        } else if ($categoriesModuleCount == 0) {
            // * chưa có quyền truy cập
            $message = 'This feature is restricted for you';
            return redirect('/admin/dashboard')->with('error_message', $message);
        } else {
            // * có một số quyền truy cập
            $categoriesModule = AdminsRole::where([
                'subadmin_id' => Auth::guard('admin')->user()->id,
                'module' => 'categories'
            ])->first()->toArray();
           
        }
        return view('admin.categories.categories')->with(compact('categories','categoriesModule'));
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
        $this->deleteCategoryImage($id);
        //delete category
        Category::where('id', $id)->delete();
        return redirect()->back()->with('success_message', 'Delete successfully');
    }
    /**
     * add/edit category
     * @param Request $request yêu cầu của người dùng
     * @param mixed $id id category
     */
    public function addEditCategory(Request $request, $id = null)
    {
        // lấy danh sách category
        $getCategories = Category::getCategories();
        //    return $getCategories;
        // dd($getCategories);
        // ! kiểm tra id có tồn tại không
        if ($id == "") {
            // ? id chưa tồn tại
            $title = 'Add Category';
            $category = new Category;
            $message = "Category added successfully";
        } else {
            // ? id đã tồn tại
            $title = 'Edit Category';
            $category = Category::find($id);
            $message = "Category edited successfully";
        }
        if ($request->isMethod('POST')) {
            $data = $request->all();
            // echo"<pre>";
            // print_r($data);die;
            // !validation
            if ($id=='') {
                $rules = [
                    // ! bắt buộc nhập tên category
                    'category_name' => 'required',
                    // ! bắt buộc nhập url | và không trùng với url cũ
                    'url' => 'required|unique:categories',
                ];
            } else {
                $rules = [
                    // ! bắt buộc nhập tên category
                    'category_name' => 'required',
                    // ! bắt buộc nhập url | và không trùng với url cũ
                    'url' => 'required',
                ];
            }
            
          
            $customMessage = [
                'category_name.required' => 'Category Name is required',
                'url.required' => 'Category Url is required',
                'url.unique' => 'Unique Category Url is required',
            ];
            $this->validate($request, $rules, $customMessage);
            // ? update category image
            // kiểm tra file hình ảnh
            if ($request->hasFile('category_image')) {
                $image_tmp = $request->file('category_image');
                if ($image_tmp->isValid()) {
                    # Get image extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    // Generate new Image Name
                    $imageName = rand(111, 99999) . '.' . $extension;
                    // tạo đường dẫn luư hình ảnh
                    $image_path = 'admin/images/categories/' . $imageName;

                    // tải hình ảnh
                    Image::make($image_tmp)->save($image_path);
                    // $category->category_image = $imageName;
                }
            }
            //  else {
            //     # code...
            //     $category->category_image = '';
            // }
            else if (
                !empty ($data['current_image'])
            ) {
                # code...
                $imageName = $data['current_image'];
            } else {
                # code...
                $imageName = '';
            }

            if (empty($data['category_discount'])) {
                # code...
                $data['category_discount']=0;
            }
            $category->category_name = $data['category_name'];
            $category->category_image =   $imageName;
            $category->category_discount = $data['category_discount'];
            $category->description = $data['description'];
            $category->url = $data['url'];
            $category->meta_title = $data['meta_title'];
            $category->meta_description = $data['meta_description'];
            $category->meta_keywords = $data['meta_keywords'];
            $category->parent_id =  $data['parent_id'];

            $category->status = 1;

            $category->save();
            return redirect('admin/categories')->with('success_message', $message);

        }
        // ! hiển thị trang web add/edit category
        return view('admin.categories.add_edit_category')->with(compact('title', 'getCategories','category'));

    }
    
    public function deleteCategoryImage($id){
        // ? lấy hình ảnh của category
        $categoryImage = Category::select('category_image')->where('id',$id)->first();
        // ? lấy đường dẫn hình ảnh
        $category_image_path = 'admin/images/categories/';
        // ? xóa hình ảnh category từ thư mục categories
        if (file_exists($category_image_path.$categoryImage->category_image)) {
           unlink($category_image_path.$categoryImage->category_image);
        }
        // ? xóa hình ảnh category từ bảng categories
        Category::where('id',$id)->update(['category_image'=>'']);
        
        return redirect()->back()->with('success_message', 'Category imge deleted successfully');
    }
    
}
