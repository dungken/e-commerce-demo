@extends('layouts.admin')
@section('title', 'Edit Slide')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Cập nhật slide
            </div>
            <div class="card-body">
                <form action="{{ route('slide.update', $slide->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="desc">Mô tả ngắn</label>
                        <br>
                        @error('desc')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <input class="form-control" type="text" name="desc" id="desc"
                            value="{{ $slide->desc }}">
                    </div>

                    <div class="form-group">
                        <label for="link">Đường dẫn liên kết</label>
                        <br>
                        @error('link')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <input class="form-control" type="text" name="link" id="link"
                            value="{{ $slide->link }}">
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
                                {{ $slide->status == 'waiting' ? 'checked' : '' }}>
                            <label class="form-check-label" for="waiting">
                                Chờ duyệt
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="public" value="public"
                                {{ $slide->status == 'public' ? 'checked' : '' }}>
                            <label class="form-check-label" for="public">
                                Công khai
                            </label>
                        </div>
                    </div>
                    <button type="submit" name="btn_edit" value="Cập nhật slide" class="btn btn-primary">Cập
                        nhật</button>
                </form>
            </div>
        </div>
    </div>
@endsection
