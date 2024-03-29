<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminsRole;
use App\Models\CmsPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

use function Laravel\Prompts\alert;

class CmsController extends Controller
{
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CmsPage $cmsPage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id = null)
    {
        Session::put('page', 'cms-pages');

        //kiểm tra id có hay không
        if ($id == '') {
            # không có id 
            $title = 'Add CMS Page';
            $cmspage = new CmsPage;
            $message = 'CMS Page added successfully';
        } else {
            # có id 
            $title = 'Edit CMS Page';
            // tìm id 
            $cmspage = CmsPage::find($id);
            $message = 'CMS Page updated successfully';
        }
        // kiểm tra loại phương thức
        if ($request->isMethod('POST')) {
            # lấy hết tất cả yêu cầu của người dùng
            $data = $request->all();
            // echo '<pre>';print_r($data);die;
            // CMS page validation
            $rules = [
                'title' => 'required',
                'url' => 'required',
                'description' => 'required',
            ];
            $customMessage = [
                'title.required' => 'Page Title is required',
                'url.required' => 'Page URL is required',
                'description.required' => 'Page Description is required',
            ];
            $this->validate($request, $rules, $customMessage);
            $cmspage->title = $data['title'];
            $cmspage->url = $data['url'];
            $cmspage->description = $data['description'];
            $cmspage->meta_title = $data['meta_title'];
            $cmspage->meta_description = $data['meta_description'];
            $cmspage->meta_keywords = $data['meta_keywords'];
            $cmspage->status = 1;
            $cmspage->save();
            return redirect('admin/cms-pages')->with('success_message', $message);
        }
        // trả về đăng add hoặc edit 
        return view('admin.pages.add_edit_cmspage')->with(compact('title', 'cmspage'));
    }

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
            if ($data['status'] == "Active") {
                # code...
                $status = 0;
            } else {
                $status = 1;

            }
            // cập nhập dữ liệu trong csdl
            CmsPage::where('id', $data['page_id'])->update(['status' => $status]);
            // trả về phản hồi json status and page_id
            return response()->json(['status' => $status, 'page_id' => $data['page_id']]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //delete cms page
        CmsPage::where('id', $id)->delete();
        return redirect()->back()->with('success_message', 'Delete successfully');
    }
}
