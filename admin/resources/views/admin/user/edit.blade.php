@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
    <div id="content" class="container-fluid">
        <div class="card"> 
            <div class="card-header font-weight-bold">
                Cập nhật thông tin
            </div>
            <div class="card-body">

                <form action="{{ route('user.update', $user->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Tên người dùng</label>
                        <br>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <input class="form-control" type="text" name="name" id="name" value="{{$user->name}}">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <br>
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <input class="form-control" type="email" name="email" id="email" disabled value="{{$user->email}}">
                    </div>
                    <div class="form-group">
                        <label for="password">Mật khẩu</label>
                        <br>
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <input class="form-control" type="password" name="password" id="password">
                    </div>
                    <div class="form-group">
                        <label for="password-confimred">Xác nhận mật khẩu</label>
                        <input class="form-control" type="password" name="password_confirmation" id="password-confimred">
                    </div>

                    <div class="form-group">
                        <label for="">Nhóm quyền</label>
                        <select class="form-control" id="" name="role">
                            <option>Chọn quyền</option>
                            <option>Danh mục 1</option>
                            <option>Danh mục 2</option>
                            <option>Danh mục 3</option>
                            <option>Danh mục 4</option>
                        </select>
                    </div>
                    <button type="submit" value="Lưu thay đổi" name="btn_update" class="btn btn-primary">Lưu thay đổi</button>
                </form>
            </div>
        </div>
    </div>
@endsection
