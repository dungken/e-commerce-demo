@extends('layouts.admin')
@section('title', 'Add Slide')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Thêm slide
            </div>
            <div class="card-body">
                <form action="{{ route('slide.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="desc">Mô tả ngắn</label>
                        <br>
                        @error('desc')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <input class="form-control" type="text" name="desc" id="desc">
                    </div>

                    <div class="form-group">
                        <label for="link">Đường dẫn liên kết</label>
                        <br>
                        @error('link')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <input class="form-control" type="text" name="link" id="link">
                    </div>
                    <div class="form-group">
                        <label for="slide">Slide</label>
                        <br>
                        @error('slide')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <input class="form-control" type="file" name="slide" id="slide">
                    </div>
                    <div class="form-group">
                        <label for="status">Trạng thái</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="waiting" value="waiting"
                                checked>
                            <label class="form-check-label" for="waiting">
                                Chờ duyệt
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="public" value="public">
                            <label class="form-check-label" for="public">
                                Công khai
                            </label>
                        </div>
                    </div>
                    <button type="submit" name="btn_add" value="Thêm slide" class="btn btn-primary">Thêm mới</button>
                </form>
            </div>
        </div>
    </div>
@endsection
