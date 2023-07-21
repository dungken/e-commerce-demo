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
        if ($request->keyword) {
            $keyword = $request->keyword;
        } else {
            $keyword = " ";
        }

        if ($request->status == 'disable') {
            $status = 'disable';
            $action = [
                'restore' => 'Khôi phục',
                'forceDelete' => 'Xóa vĩnh viễn'
            ];
            $pages = Page::where('name',  'LIKE', "%{$keyword}%")->onlyTrashed()->paginate(3);
        } else if ($request->status == 'waiting') {
            $status = 'waiting';
            $action = [
                1 => 'Công khai',
                'delete' => 'Xóa tạm thời'
            ];

            $pages = Page::where(
                [
                    ['status', '0'],
                    ['name', 'LIKE', "%{$keyword}%"]
                ]
            )->paginate(3);
        } else {
            $status = 'public';
            $action = [
                0 => 'Chờ duyệt',
                'delete' => 'Xóa tạm thời'
            ];
            $pages = Page::where(
                [
                    ['status', '1'],
                    ['name', 'LIKE', "%{$keyword}%"]
                ]
            )->paginate(3);
        }

        if ($pages->total() == 0) {
            $pages = [];
        }

        $cnt_page_public = Page::where('status', '1')->count();
        $cnt_page_waiting = Page::where('status', '0')->count();
        $cnt_page_delete = Page::onlyTrashed()->count();

        $cnt_page = [$cnt_page_public, $cnt_page_waiting, $cnt_page_delete];

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
        return view('admin.page.edit', compact('page'));
    }


    public function action(Request $request)
    {
        $action = $request->action;
        $status = $request->status;
        $check_list = $request->check_list;

        if ($status == 'public') {
            if ($action == null) {
                return redirect('page/list')->with('status_error', 'Bạn cần chọn thao tác để thực hiện!');
            } else if (empty($check_list)) {
                return redirect('page/list')->with('status_error', 'Bạn cần tick để thực hiện!');
            } else {
                if ($action == 'delete') {
                    Page::destroy($check_list);
                    return redirect('page/list')->with('status', 'Đã xóa tạm thời thành công!');
                } else {
                    foreach ($check_list as $id) {
                        Page::where('id', $id)
                            ->update(['status' => '0']);
                    }
                    return redirect('page/list')->with('status', 'Đã chuyển sang chờ duyệt thành công!');
                }
            }
        } else if ($status == 'waiting') {
            if ($action == null) {
                return redirect('page/list?status=waiting')->with('status_error', 'Bạn cần chọn thao tác để thực hiện!');
            } else if (empty($check_list)) {
                return redirect('page/list?status=waiting')->with('status_error', 'Bạn cần tick để thực hiện!');
            } else {
                if ($action == 'delete') {
                    Page::destroy($check_list);
                    return redirect('page/list?status=waiting')->with('status', 'Đã xóa tạm thời thành công!');
                } else {
                    foreach ($check_list as $id) {
                        Page::where('id', $id)
                            ->update(['status' => '1']);
                    }
                    return redirect('page/list?status=waiting')->with('status', 'Đã chuyển sang chờ duyệt thành công!');
                }
            }
        } else {
            if ($action == null) {
                return redirect('page/list?status=disable')->with('status_error', 'Bạn cần chọn thao tác để thực hiện!');
            } else if (empty($check_list)) {
                return redirect('page/list?status=disable')->with('status_error', 'Bạn cần tick để thực hiện!');
            } else {
                if ($action == 'forceDelete') {
                    Page::onlyTrashed()->forceDelete();
                    return redirect('page/list?status=disable')->with('status', 'Đã xóa vĩnh viễn thành công!');
                } else {
                    Page::onlyTrashed()->restore();
                    return redirect('page/list?status=disable')->with('status', 'Đã khôi phục thành công!');
                }
            }
        }
    }
}
