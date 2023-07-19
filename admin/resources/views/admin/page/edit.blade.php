@extends('layouts.admin')

@section('title', 'Edit Page')

@section('content')
    <div id="content" class="container-fluid">
      
        <div class="card">
            <div class="card-header font-weight-bold">
                Chỉnh sửa trang
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('page.update', $page->id) }}">
                    @csrf
                    <div class="form-group">
                        <label for="name">Tên trang</label>
                        <br>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <input class="form-control" type="text" name="name" id="name"
                            value="{{ $page->name }}">
                    </div>
                    <div class="form-group">
                        <label for="content">Nội dung trang</label>
                        <br>
                        @error('content')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <textarea name="content" class="form-control" id="content" cols="30" rows="10">{{ $page->content }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="status">Trạng thái</label>
                        @php
                            $status = ['Chờ duyệt', 'Công khai'];
                        @endphp
                        @foreach ($status as $k => $v)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="{{ $k }}"
                                    value="{{ $k }}" {{ $page->status == $k ? 'checked' : '' }}>
                                <label class="form-check-label" for="{{ $k }}">
                                    {{ $v }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <button type="submit" name="btn_edit" value="Lưu thay đổi" class="btn btn-primary">Lưu thay
                        đổi</button>
                </form>
            </div>
        </div>
    </div>
@endsection
