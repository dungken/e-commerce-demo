<?php

namespace App\Http\Controllers;

use App\Http\Middleware\RedirectIfAuthenticated;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['mod_active' => 'user']);
            return $next($request);
        });
    }
    public function list(Request $request)
    {
        $keyword = "";
        if ($request->keyword)
            $keyword = $request->keyword;

        $status = $request->status;

        $action = [
            'delete' => 'Xóa tạm thời'
        ];

        if ($status == 'trash') {

            $action = [
                'restore' => 'Khôi phục',
                'forceDelete' => 'Xóa vĩnh viễn'
            ];

            $users = User::onlyTrashed()->where('name', 'LIKE', "%{$keyword}%")->paginate(5);
        } else {
            $users = User::where('name', 'LIKE', "%{$keyword}%")->paginate(5);
        }

        $count_user_active = User::count();
        $count_user_trash = User::onlyTrashed()->count();

        $count = [$count_user_active, $count_user_trash];

        return view('admin.user.list', compact('users', 'count', 'action'));
    }

    public function add()
    {
        return view('admin.user.add');
    }

    public function store(Request $request)
    {
        // return $request;
        $request->validate(
            [
                'name' => 'required', 'string', 'max:255',
                'email' => 'required', 'string', 'email', 'max:255', 'unique:users',
                'password' => 'required', 'string', 'min:8', 'confirmed',
            ],
            [
                'required' => ':attribute không được để trống!',
                'min' => ':attribute có độ dài ít nhất :min kí tự!',
                'max' => ':attribute có độ dài tối đa :max kí tự!',
                'confirmed' => 'Xác nhận mật khẩu không thành công!',
            ],
            [
                'name' => 'Tên người dùng',
                'email' => 'Email',
                'password' => 'Mật khẩu'
            ]
        );

        // return $request->all();

        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        return redirect('user/list')->with('status', 'Thêm người dùng thành công!');
    }

    public function delete($id)
    {
        if (Auth::id() != $id) {
            $user = User::find($id);
            $user->delete();
            return redirect('user/list')->with('status', 'Xóa thành viên thành công!');
        } else {
            return redirect('user/list')->with('status', 'Bạn không thể tự xóa mình!');
        }
    }

    public function action(Request $request)
    {
        $action = $request->action;
        $check_list = $request->check_list;

        if ($check_list) {
            if ($action == 'delete') {
                foreach ($check_list as $k => $id) {
                    if (Auth::id() == $id) {
                        unset($check_list[$k]);
                    }
                }

                if (empty($check_list)) {
                    return redirect('user/list')->with('status_danger', 'Bạn không thể xóa chính mình ra khỏi hệ thống!!!');
                } else {
                    User::destroy($check_list);
                    return redirect('user/list')->with('status', 'Xóa tạm thời thành công!');
                }
            } else if ($action == 'restore') {
                User::onlyTrashed()
                    ->whereIn('id', $check_list)
                    ->restore();

                return redirect('user/list')->with('status', 'Khôi phục thành công!');
            } else if ($action == 'forceDelete') {
                User::onlyTrashed()
                    ->whereIn('id', $check_list)
                    ->forceDelete();
                return redirect('user/list')->with('status', 'Xóa vĩnh viễn thành công!');
            } else {
                return redirect('user/list')->with('status_danger', 'Vui lòng lựa chọn thao tác để áp dụng!!!');
            }
        } else {
            return redirect('user/list')->with('status_danger', 'Vui lòng tick vào ô để áp dụng!!!');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required', 'string', 'max:255',
                'password' => 'required', 'string', 'min:8', 'confirmed',
            ],
            [
                'required' => ':attribute không được để trống!',
                'min' => ':attribute có độ dài ít nhất :min kí tự!',
                'max' => ':attribute có độ dài tối đa :max kí tự!',
                'confirmed' => 'Xác nhận mật khẩu không thành công!',
            ],
            [
                'name' => 'Tên người dùng',
                'password' => 'Mật khẩu'
            ]
        );

        User::where('id', $id)->update([
            'name' => $request->input('name'),
            'password' => Hash::make($request->input('password')),
        ]);

        return redirect('user/list')->with('status', 'Đã lưu thay đổi!');
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('admin.user.edit', compact('user'));
    }
}
