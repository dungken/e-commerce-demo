@extends('layouts.admin')

@section('title', 'Add Page')

@section('content')
    <div id="content" class="container-fluid">
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        <div class="card">
            <div class="card-header font-weight-bold">
                Thêm trang mới
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('page.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="name">Tên trang</label>
                        <br>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <input class="form-control" type="text" name="name" id="name">
                    </div>
                    <div class="form-group">
                        <label for="content">Nội dung trang</label>
                        <br>
                        @error('content')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <textarea name="content" class="form-control" id="content" cols="30" rows="10"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="status">Trạng thái</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="waiting" value="0"
                                checked>
                            <label class="form-check-label" for="waiting">
                                Chờ duyệt
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="public" value="1">
                            <label class="form-check-label" for="public">
                                Công khai
                            </label>
                        </div>
                    </div>
                    <button type="submit" name="btn_add" value="'Thêm trang" class="btn btn-primary">Thêm mới</button>
                </form>
            </div>
        </div>
    </div>
@endsection
