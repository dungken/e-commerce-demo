@extends('layouts.admin')

@section('title', 'List User')

@section('content')
    <div id="content" class="container-fluid">
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        @if (session('status_error'))
            <div class="alert alert-danger">{{ session('status_error') }}</div>
        @endif
        <div class="card">

            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Danh sách thành viên</h5>
                <div class="form-search form-inline">
                    <form action="{{ route('user.list') }}" method="GET" class="d-flex">
                        <input type="text" name="keyword" value="{{ $keyword }}" class="form-control form-search"
                            placeholder="Tìm kiếm">
                        <input type="submit" name="btn_search" value="Tìm kiếm" class="btn btn-primary">
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="analytic">
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'active']) }}" class="text-primary">Hoạt động<span
                            class="text-muted">({{ $count_user[0] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'disable']) }}" class="text-primary">Vô hiệu
                        hóa<span class="text-muted">({{ $count_user[1] }})</span></a>
                </div>
                <form action="{{ route('user.action', $status) }} " method="POST">
                    @csrf
                    <div class="form-action form-inline py-3">
                        <select class="form-control mr-1" id="" name="action">
                            <option value="">Chọn</option>
                            @foreach ($action as $k => $v)
                                <option value="{{ $k }}">{{ $v }}</option>
                            @endforeach
                        </select>
                        <input type="submit" name="btn_action" value="Áp dụng" class="btn btn-primary">
                    </div>
                    <table class="table table-striped table-checkall">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" name="checkall">
                                </th>
                                <th scope="col">Họ tên</th>
                                <th scope="col">Email</th>
                                <th scope="col">Vai trò</th>
                                <th scope="col">Ngày tạo</th>
                                @if ($status == 'active')
                                    <th scope="col">Tác vụ</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @if ($users)
                                @foreach ($users as $user)
                                    <tr>
                                        <td>
                                            <input type="checkbox" value="{{ $user->id }}" name="check_list[]">
                                        </td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @foreach ($user->roles as $role)
                                                <a href="{{route('role.list')}}" class="badge badge-success">{{$role->name}}</a>
                                            @endforeach
                                        </td>
                                        <td>{{ $user->created_at }}</td>
                                        @if ($status == 'active')
                                            <td>
                                                <a href="{{ route('user.edit', $user->id) }}"
                                                    class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                        class="fa fa-edit"></i></a>
                                                @if (Auth::id() != $user->id)
                                                    <a href="{{ route('user.delete', $user->id) }}"
                                                        class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                                        onclick="return confirm('Bạn có chắc chắn xóa bản ghi này không?')"
                                                        data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                            class="fa fa-trash"></i></a>
                                                @endif
                                            </td>
                                        @endif

                                    </tr>
                                @endforeach
                        </tbody>
                    </table>
                    {{ $users->links() }}
                @else
                    <tr>
                        <td colspan="7" class="text-danger"><strong>Không tồn tại bản ghi nào!</strong></td>
                    </tr>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection
