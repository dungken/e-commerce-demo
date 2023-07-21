@extends('layouts.admin')
@section('title', 'Add Product')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Thêm sản phẩm
            </div>
            {{-- @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif --}}
            <div class="card-body">
                <form action="{{ route('product.addStore') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name">Tên sản phẩm</label>
                                <br>
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                <input class="form-control" type="text" name="name" id="name">
                            </div>
                            <div class="form-group">
                                <label for="price">Giá</label>
                                <br>
                                @error('price')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                <input class="form-control" type="text" name="price" id="price">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="desc">Mô tả sản phẩm</label>
                                <br>
                                @error('desc')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                <textarea name="desc" class="form-control" id="desc" cols="30" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="detail">Chi tiết sản phẩm</label>
                        <br>
                        @error('detail')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <textarea name="detail" class="form-control" id="detail" cols="30" rows="20"></textarea>
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
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">Trạng thái</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="inStock" value="inStock"
                                checked>
                            <label class="form-check-label" for="inStock">
                                Còn hàng
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="soldOut" value="soldOut">
                            <label class="form-check-label" for="soldOut">
                                Hết hàng
                            </label>
                        </div>
                    </div>

                    <button type="submit" name="btn_add_product" value="Thêm mới sản phẩm" class="btn btn-primary">Thêm
                        mới</button>
                </form>
            </div>
        </div>
    </div>
    {{-- <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Thêm sản phẩm
            </div>
            <div class="card-body">
                <form action="{{ route('product.addStore') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="">Tiêu đề</label>
                        <br>
                        @error('title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <input class="form-control" type="text" name="title" id="title">
                    </div>
                    <div class="form-group">
                        <label for="desc">Mô tả ngắn</label>
                        <input class="form-control" type="text" name="desc" id="desc">
                    </div>
                    <div class="form-group">
                        <label for="content">Nội dung</label>
                        <br>
                        @error('content')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <textarea name="content" class="form-control" id="content" cols="30" rows="20"></textarea>
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
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
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
                    <button type="submit" name="btn_add" value="Thêm bài viết" class="btn btn-primary">Thêm mới</button>
                </form>
            </div>
        </div>
    </div> --}}
@endsection
