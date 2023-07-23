@extends('layouts.admin')

@section('title', 'Add User')

@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Thêm người dùng
            </div>
            <div class="card-body">
                <form action="{{ route('user.store') }}" method="POST">
                    @csrf
                    <div class="form-group">

                        <label for="name">Tên người dùng</label>
                        <br>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <input class="form-control" type="text" name="name" id="name">

                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <br>
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <input class="form-control" type="email" name="email" id="email">
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
                        @error('password_confirmed')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <input class="form-control" type="password" name="password_confirmation" id="password-confimred">
                    </div>

                    <button type="submit" value="Thêm thành viên" name="btn_add" class="btn btn-primary">Thêm mới</button>
                </form>
            </div>
        </div>
    </div>
@endsection
