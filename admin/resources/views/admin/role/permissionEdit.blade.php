@extends('layouts.admin')

@section('title', 'Edit Permission')

@section('content')
    <div id="content" class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    @if (session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
                    @endif
                    <div class="card-header font-weight-bold">
                        Cập nhật quyền
                    </div>
                    <div class="card-body">
                        <form action="{{ route('role.permission.update', $permission->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Tên quyền</label>
                                <br>
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                <input class="form-control" type="text" name="name" id="name"
                                    value="{{ $permission->name }}">
                            </div>
                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <br>
                                @error('slug')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                <small class="form-text text-muted pb-2">Ví dụ: post.add</small>
                                <input class="form-control" type="text" name="slug" id="slug"
                                    value="{{ $permission->slug }}">
                            </div>
                            <div class="form-group">
                                <label for="description">Mô tả</label>
                                <textarea class="form-control" type="text" name="description" id="description">{{ $permission->description }}</textarea>
                            </div>
                            <button type="submit" name="btn_add_update" class="btn btn-primary">Cập nhật</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
