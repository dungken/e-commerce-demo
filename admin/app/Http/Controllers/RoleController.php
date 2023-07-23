<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use App\User;
// use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Access\Gate;

class RoleController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['mod_active' => 'role']);
            return $next($request);
        });
    }
    //
    public function permission()
    {
        $permissions = Permission::all()->groupBy(function ($permission) {
            return explode('.', $permission->slug)[0];
        });

        // dd($permissions);
        /*
        $data = [];

        $data_mod = array('Page', 'Post', 'Product', 'Order', 'User', 'Dashboard');

        foreach ($permissions as $permission) {

            $arr = explode('.', $permission->slug);
            $mod = ucfirst($arr[0]);

            if (in_array($mod, $data_mod)) {
                $data[$mod][] = array(
                    'name' => $permission->name,
                    'slug' => $permission->slug,
                    'description' => $permission->description
                );
            }
        }
        */
        return view('admin.role.permission', compact('permissions'));
    }

    public function permissionStore(Request $request)
    {
        $request->validate(
            [
                'name' => ['required'],
                'slug' => ['required'],
            ],
            [
                'required' => ':attribute không được để trống!'
            ],
            [
                'name' => 'Tên quyền',
                'slug' => 'Slug',
            ]
        );

        $data = [
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
            'description' => $request->input('description'),
        ];

        Permission::create($data);

        return redirect('role/permission')->with('status', 'Đã thêm quyền thành công!');
    }

    public function permissionEdit($id)
    {
        $permission = Permission::find($id);
        // return $permission;
        return view('admin.role.permissionEdit', compact('permission'));
    }
    public function permissionUpdate(Request $request, $id)
    {
        $request->validate(
            [
                'name' => ['required'],
                'slug' => ['required'],
            ],
            [
                'required' => ':attribute không được để trống!'
            ],
            [
                'name' => 'Tên quyền',
                'slug' => 'Slug',
            ]
        );

        $data = [
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
            'description' => $request->input('description'),
        ];

        Permission::where('id', $id)->update($data);

        return redirect('role/permission')->with('status', 'Đã cập nhật quyền thành công!');
    }


    public function permissionDelete($id)
    {
        Permission::where('id', $id)->delete();
        return redirect('role/permission')->with('status', 'Đã xóa quyền thành công!');
    }

    public function add()
    {
        $permissions = Permission::all()->groupBy(function ($permission) {
            return explode('.', $permission->slug)[0];
        });

        return view('admin.role.add', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'description' => 'required',
                'name' => 'required|unique:roles,name',
                'permission_id' => 'nullable|array',
                'permission_id.*' => 'exists:permissions,id'
            ],
            [
                'required' => ':attribute không được để trống!'
            ],
            [
                'name' => 'Tên vai trò',
                'description' => 'Mô tả',
            ]
        );

        $role = Role::create(
            [
                'name' => $request->input('name'),
                'description' => $request->input('description')
            ]
        );

        $role->permissions()->attach($request->input('permission_id'));

        return redirect('role/list')->with('status', 'Đã thêm vai trò mới thành công!');
    }


    public function list(Gate $gate)
    {
        // if ($gate->allows('role.view')) {
        //     dd('Duoc phep xem');
        // } else {
        //     dd('Khong duoc phep xem');
        // }

        if(!$gate->allows('role.view'))
            abort(403);
        

        // return Auth::user()->hasPermission('user.edit');

        $roles = Role::all();

        return view('admin.role.list', compact('roles'));
    }

    public function listDelete($id)
    {
        Role::where('id', $id)->delete();
        return redirect('role/list')->with('status', 'Đã xóa vai trò thành công!');
    }

    public function listEdit(Role $role)
    {
        // return $role;

        $permissions = Permission::all()->groupBy(function ($permission) {
            return explode('.', $permission->slug)[0];
        });

        return view('admin.role.listEdit', compact('role', 'permissions'));
    }

    public function listUpdate(Request $request, Role $role)
    {
        // return $role;
        $request->validate(
            [
                'name' => 'required|unique:roles,name,' . $role->id,
                'permission_id' => 'nullable|array',
                'permission_id.*' => 'exists:permissions,id'
            ],
            [
                'required' => ':attribute không được để trống!',
                'unique' => ':attribute đã tồn tại trên hệ thống'
            ],
            [
                'name' => 'Tên vai trò',
                'description' => 'Mô tả',
            ]
        );

        $role->update(
            [
                'name' => $request->input('name'),
                'description' => $request->input('description')
            ]
        );

        $role->permissions()->sync($request->input('permission_id', []));

        return redirect('role/list')->with('status', 'Đã cập nhật vai trò thành công!');
    }
}
