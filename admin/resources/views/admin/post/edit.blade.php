@extends('layouts.admin')
@section('title', 'Edit Post')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Chỉnh sửa bài viết
            </div>
            <div class="card-body">
                <form action="{{ route('post.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="title">Tiêu đề</label>
                        <br>
                        @error('title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <input class="form-control" type="text" name="title" id="title"
                            value="{{ $post->title }}">
                    </div>
                    <div class="form-group">
                        <label for="desc">Mô tả ngắn</label>
                        <input class="form-control" type="text" name="desc" id="desc"
                            value="{{ $post->desc }}">
                    </div>
                    <div class="form-group">
                        <label for="content">Nội dung</label>
                        <br>
                        @error('content')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <textarea name="content" class="form-control" id="content" cols="30" rows="20">{{ $post->content }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="thumbnail">Ảnh đại diện</label>
                        <br>
                        @error('thumbnail')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <input type="file" name="thumbnail" class="form-control-file" value="{{ $post->thumbnail }}"
                            id="thumbnail">
                    </div>
                    <div class="form-group">
                        <label for="type">Thuộc danh mục</label>
                        <br>
                        @error('catId')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <select class="form-control" id="type" name="catId">
                            <option value="">Chọn danh mục</option>
                            @foreach ($list_cat as $cat)
                                <option {{ $cat->id == $post->cat_id ? 'selected' : '' }} value="{{ $cat->id }}">
                                    {{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">Trạng thái</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="waiting" value="waiting"
                                {{ $post->status == 'waiting' ? 'checked' : '' }}>
                            <label class="form-check-label" for="waiting">
                                Chờ duyệt
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="public" value="public"
                                {{ $post->status == 'public' ? 'checked' : '' }}>
                            <label class="form-check-label" for="public">
                                Công khai
                            </label>
                        </div>
                    </div>
                    <button type="submit" name="btn_update" value="Thêm bài viết" class="btn btn-primary">Lưu thay đổi</button>
                </form>
            </div>
        </div>
    </div>
@endsection
