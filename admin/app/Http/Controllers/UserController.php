<?php

namespace App\Http\Controllers;

use App\Role;
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
        if ($request->status) {
            $status = $request->status;
            if ($status == 'active') {
                $action = [
                    'delete' => 'Xóa tạm thời'
                ];
            } else {
                $action = [
                    'restore' => 'Khôi phục',
                    'forceDelete' => 'Xóa vĩnh viễn'
                ];
            }
        } else {
            $status = 'active';
            $action = [
                'delete' => 'Xóa tạm thời'
            ];
        }

        $count_user_active = User::all()->count();
        $count_user_disable = User::onlyTrashed()->count();
        $count_user = [$count_user_active, $count_user_disable];

        if ($request->keyword) {
            $keyword = $request->keyword;
        } else {
            $keyword = '';
        }

        if ($request->status == 'disable') {
            $users = User::onlyTrashed()->where('name', 'LIKE', "%{$keyword}%")->paginate(6);
        } else {
            $users = User::where('name', 'LIKE', "%{$keyword}%")->paginate(6);
        }

        if ($users->total()) {
            $users = $users;
        } else {
            $users = [];
        }


        return view('admin.user.list', compact('users', 'keyword', 'count_user', 'action', 'status'));
    }


    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ],
            [
                'required' => ':attribute không được để trống!',
                'max' => ':attribute có tối đa :max kí tự!',
                'min' => ':attribute có tối thiểu :min kí tự!',
                'confirmed' => 'Xác nhận mật khẩu không thành công',
                'unique' => ':attribute đã tồn tại trong hệ thống'
            ],
            [
                'name' => 'Tên người dùng',
                'email' => 'Email',
                'password' => 'Mật khẩu'
            ]
        );

        $user = User::create(
            [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]
        );

        return redirect('user/list')->with('status', 'Đã thêm thành viên mới thành công!');
    }


    public function add()
    {
        $roles = Role::all();
        // return $roles;

        return view('admin.user.add', compact('roles'));
    }


    public function delete($id)
    {
        User::where('id', $id)->delete();
        return redirect('user/list')->with('status', 'Đã xóa tạm thời thành công!');
    }


    public function edit(User $user)
    {
        $roles = Role::all();

        return view('admin.user.edit', compact('user', 'roles'));
    }


    public function update(Request $request, User $user)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
            ],
            [
                'required' => ':attribute không được để trống!',
                'max' => ':attribute có tối đa :max kí tự!',
            ],
            [
                'name' => 'Tên người dùng',
            ]
        );


        $user->update(
            [
                'name' => $request->input('name'),
            ]
        );

        $user->roles()->sync($request->input('role_id', []));

        return redirect('user/list')->with('status', 'Đã cập nhật thành công');
    }


    public function action(Request $request, $status)
    {
        $action = $request->action;
        $check_list = $request->check_list;

        if ($status == 'active') {
            if ($action == null) {
                return redirect('user/list?status=active')->with('status_error', 'Chọn thao tác để áp dụng!!!');
            } else if (empty($check_list)) {
                return redirect('user/list?status=active')->with('status_error', 'Vui lòng tick lựa chọn!!!');
            } else {
                foreach ($check_list as $k => $v) {
                    if (Auth::id() == $v) {
                        unset($check_list[$k]);
                    }
                }
                if (count($check_list)) {
                    User::destroy($check_list);
                    return redirect('user/list?status=active')->with('status', 'Xóa tạm thời thành công');
                } else {
                    return redirect('user/list?status=active')->with('status_error', 'Bạn không thể xóa chính mình ra khỏi hệ thống!');
                }
            }
        } else {
            if ($action == null) {
                return redirect('user/list?status=disable')->with('status_error', 'Chọn thao tác để áp dụng!!!');
            } else if (empty($check_list)) {
                return redirect('user/list?status=disable')->with('status_error', 'Vui lòng tick lựa chọn!!!');
            } else {
                if ($action == 'restore') {
                    User::onlyTrashed()
                        ->whereIn('id', $check_list)
                        ->restore();
                    return redirect('user/list?status=disable')->with('status', 'Khôi phục thành công');
                } else {
                    User::onlyTrashed()
                        ->whereIn('id', $check_list)
                        ->forceDelete();
                    return redirect('user/list?status=disable')->with('status', 'Xóa vĩnh viễn thành công');
                }
            }
        }
    }
}
