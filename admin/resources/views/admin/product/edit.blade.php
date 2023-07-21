@extends('layouts.admin')
@section('title', 'Edit Post')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Cập nhật sản phẩm
            </div>
            <div class="card-body">
                <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name">Tên sản phẩm</label>
                                <br>
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                <input class="form-control" type="text" name="name" id="name"
                                    value="{{ $product->name }}">
                            </div>
                            <div class="form-group">
                                <label for="price">Giá</label>
                                <br>
                                @error('price')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                <input class="form-control" type="text" name="price" id="price"
                                    value="{{ $product->price }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="desc">Mô tả sản phẩm</label>
                                <br>
                                @error('desc')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                <textarea name="desc" class="form-control" id="desc" cols="30" rows="5">{{ $product->desc }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="detail">Chi tiết sản phẩm</label>
                        <br>
                        @error('detail')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <textarea name="detail" class="form-control" id="detail" cols="30" rows="20">{{ $product->detail }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="thumbnail">Ảnh đại diện</label>
                        <br>
                        @error('thumbnail')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <input type="file" name="thumbnail" class="form-control-file" id="thumbnail">
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
                                <option {{ $product->cat_id == $cat->id ? 'selected' : '' }} value="{{ $cat->id }}">
                                    {{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">Trạng thái</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="inStock" value="inStock"
                                {{ $product->status == 'inStock' ? 'checked' : '' }}>
                            <label class="form-check-label" for="inStock">
                                Còn hàng
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="soldOut" value="soldOut"
                                {{ $product->status == 'soldOut' ? 'checked' : '' }}>
                            <label class="form-check-label" for="soldOut">
                                Hết hàng
                            </label>
                        </div>
                    </div>
                    <button type="submit" name="btn_add_update" value="Thêm mới sản phẩm" class="btn btn-primary">Lưu thay
                        đổi</button>
                </form>
            </div>
        </div>
    </div>
@endsection
