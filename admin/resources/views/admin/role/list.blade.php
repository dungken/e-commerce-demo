@extends('layouts.admin')

@section('title', 'List Role')

@section('content')
    <div id="content" class="container-fluid">
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        <div class="card">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Danh sách vai trò</h5>
                <div class="form-search form-inline">
                    <form action="#" class="d-flex">
                        <input type="text" name="keyword" class="form-control form-search" placeholder="Tìm kiếm vai trò">
                        <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="form-action form-inline py-3">
                    <select class="form-control mr-1" id="" name="action">
                        <option value="">Chọn</option>
                        <option value="delete">Xóa</option>
                    </select>
                    <input type="submit" name="btn-action" value="Áp dụng" class="btn btn-primary">
                </div>
                <table class="table table-striped table-checkall">
                    <thead>
                        <tr>
                            <th scope="col">
                                <input name="checkall" type="checkbox">
                            </th>
                            <th scope="col">#</th>
                            <th scope="col">Vai trò</th>
                            <th scope="col">Mô tả</th>
                            <th scope="col">Ngày tạo</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $cnt = 1;
                        @endphp
                        @forelse ($roles as $role)
                            <tr>
                                <td>
                                    <input type="checkbox" name="check_list[]" value="{{ $role->id }}">
                                </td>
                                <td scope="row">{{ $cnt++ }}</td>
                                <td><a href="{{ route('role.list.edit', $role->id) }}">{{ $role->name }}</a></td>
                                <td>{!! $role->description !!}</td>
                                <td>{{ $role->created_at }}</td>
                                <td>
                                    <a href="{{ route('role.list.edit', $role->id) }}"
                                        class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                        data-toggle="tooltip" data-placement="top" title="Edit"><i
                                            class="fa fa-edit"></i></a>
                                    <a href="{{ route('role.list.delete', $role->id) }}"
                                        class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                        data-toggle="tooltip" data-placement="top" title="Delete"
                                        onclick="return confirm('Bạn có muốn xóa vai trò này không?')"><i
                                            class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-danger">
                                    <strong>Không có vai trò nào trong hệ thống!</strong>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>

@endsection
