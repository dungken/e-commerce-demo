@extends('layouts.admin')

@section('title', 'Permission')

@section('content')

    <div id="content" class="container-fluid">
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        <div class="row">
            <div class="col-4">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        Thêm quyền
                    </div>
                    <div class="card-body">
                        <form action="{{ route('role.permission.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Tên quyền</label>
                                <br>
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                <input class="form-control" type="text" name="name" id="name"
                                    value="{{ old('name') }}">
                            </div>
                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <br>
                                @error('slug')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                <small class="form-text text-muted pb-2">Ví dụ: post.add</small>
                                <input class="form-control" type="text" name="slug" id="slug"
                                    value="{{ old('slug') }}">
                            </div>
                            <div class="form-group">
                                <label for="description">Mô tả</label>
                                <textarea class="form-control" type="text" name="description" id="description">{{ old('description') }}</textarea>
                            </div>
                            <button type="submit" name="btn_add_permission" class="btn btn-primary">Thêm mới</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        Danh sách quyền
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tên quyền</th>
                                    <th scope="col">Slug</th>
                                    <th scope="col">Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($permissions))
                                    @foreach ($permissions as $mod => $arr_mod)
                                        <tr>
                                            <td scope="row"></td>
                                            <td><strong>Module {{ Str::ucfirst($mod) }}</strong></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        @php
                                            $cnt = 0;
                                        @endphp
                                        @foreach ($arr_mod as $item)
                                            @php
                                                $cnt++;
                                            @endphp
                                            <tr>
                                                <td scope="row">{{ $cnt }}</td>
                                                <td>|---{{ $item->name }}</td>
                                                <td>{{ $item->slug }}</td>
                                                <td>
                                                    <a href="{{ route('role.permission.edit', $item->id) }}"
                                                        class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                                        data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                            class="fa fa-edit"></i></a>
                                                    <a href="{{ route('role.permission.delete', $item->id) }}"
                                                        class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                                        data-toggle="tooltip" data-placement="top" title="Delete"
                                                        onclick="return confirm('Bạn có muốn xóa quyền này không?')"><i
                                                            class="fa fa-trash"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                @else
                                    <tr>
                                        <th colspan="4" class="text-danger text-center">Không có quyền nào trong hệ
                                            thống!</th>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
