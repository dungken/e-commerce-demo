<?php

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Stringable;

class PageController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['mod_active' => 'page']);
            return $next($request);
        });
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'content' => ['required', 'string']
            ],
            [
                'required' => ':attribute không được để trống!',
                'max' => ':attribute có tối đa :max kí tự!',
                'string' => ':attribute phải là chuỗi!'
            ],
            [
                'name' => 'Tên trang',
                'content' => 'Nội dung trang'
            ]
        );

        // return $request;

        Page::create(
            [
                'name' => $request->input('name'),
                'content' => $request->input('content'),
                'status' => $request->input('status'),
            ]
        );

        return redirect('page/list')->with('status', 'Đã thêm trang mới thành công!');
    }

    public function add()
    {
        return view('admin.page.add');
    }
    public function list(Request $request)
    {
        $status = $request->status;

        if ($request->status == 'public') {
            $action = [
                0 => 'Chờ duyệt',
                'delete' => 'Xóa tạm thời'
            ];
            $pages = Page::where('status', '1')->paginate(3);
        } else if ($request->status == 'waiting') {
            $action = [
                1 => 'Công khai',
                'delete' => 'Xóa tạm thời'
            ];
            $pages = Page::where('status', '0')->paginate(3);
        } else {
            $action = [
                0 => 'Chờ duyệt',
                1 => 'Công khai',
                'forceDelete' => 'Xóa vĩnh viễn'
            ];
            $pages = Page::onlyTrashed()->paginate(3);
        }

        if ($pages->total() == 0) {
            $pages = [];
        }


        $cnt_page_public = Page::where('status', '1')->count();
        $cnt_page_waiting = Page::where('status', '0')->count();
        $cnt_page_delete = Page::onlyTrashed()->count();

        $cnt_page = [$cnt_page_public, $cnt_page_waiting, $cnt_page_delete];


        // return $pages;
        return view('admin.page.list', compact('pages', 'action', 'status', 'cnt_page'));
    }
    public function delete($id)
    {
        Page::where('id', $id)->delete();
        return redirect('page/list')->with('status', 'Đã xóa tạm thời thành công!');
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'content' => ['required', 'string']
            ],
            [
                'required' => ':attribute không được để trống!',
                'max' => ':attribute có tối đa :max kí tự!',
                'string' => ':attribute phải là chuỗi!'
            ],
            [
                'name' => 'Tên trang',
                'content' => 'Nội dung trang'
            ]
        );

        // return $request;

        Page::where('id', $id)->update(
            [
                'name' => $request->input('name'),
                'content' => $request->input('content'),
                'status' => $request->input('status'),
            ]
        );

        return redirect('page/list')->with('status', 'Cập nhật thành công!');
    }

    public function edit($id)
    {
        $page = Page::find($id);
        // return $page;
        return view('admin.page.edit', compact('page'));
    }
}
