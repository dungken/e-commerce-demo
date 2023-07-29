@extends('layouts.admin')
@section('title', 'Add Product')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Thêm sản phẩm
            </div>
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
                            <div class="form-group">
                                <label for="qty_on_hand">Số lượng có trong kho</label>
                                <br>
                                @error('qty_on_hand')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                <input class="form-control" type="text" name="qty_on_hand" id="qty_on_hand">
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

                    {{-- <form enctype="multipart/form-data">
                        <input type="file" id="file-input" name="file">
                    </form> --}}

                    <!-- Hiển thị ảnh -->
                    {{-- <div id="image-preview"></div> --}}


                    <div class="form-group">
                        <label for="thumbnail">Hình ảnh đại diện</label>
                        <br>
                        @error('thumbnail')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <input type="file" id="file-input" name="thumbnail" class="form-control-file mb-2" id="thumbnail">
                        <div id="image-preview-thumbnail">
                            <img class="mt-2 mb-3" src="{{ url('public/images/300-300.png') }}" alt="">
                        </div>
                    </div>
                    <script>
                        document.getElementById("file-input").addEventListener("change", function(event) {
                            var file = event.target.files[0];
                            var reader = new FileReader();
                            reader.onload = function(e) {
                                var imgElement = document.createElement("img");
                                imgElement.src = e.target.result;
                                imgElement.style.maxWidth = "100%";
                                var previewContainer = document.getElementById("image-preview-thumbnail");
                                previewContainer.innerHTML = "";
                                previewContainer.appendChild(imgElement);
                            };
                            reader.readAsDataURL(file);
                        });
                    </script>

                    <div class="form-group">
                        <label for="imgs_relate">Hình ảnh liên quan</label>
                        <br>
                        @error('imgs_relate')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <input type="file" multiple name="imgs_relate[]" class="form-control-file" id="imgs_relate">
                        <br>
                        @error('imgs_relate')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <div id="image-preview-imgs-relate">
                            <img class="mt-2 mr-3 border" src="{{ url('public/images/300-300.png') }}" alt="">
                            <img class="mt-2 mr-3" src="{{ url('public/images/300-300.png') }}" alt="">
                            <img class="mt-2 mr-3" src="{{ url('public/images/300-300.png') }}" alt="">
                            <img class="mt-2 mr-3" src="{{ url('public/images/300-300.png') }}" alt="">
                        </div>
                    </div>

                    <script>
                        document.getElementById("imgs_relate").addEventListener("change", function(event) {
                            var files = event.target.files;

                            var previewContainer = document.getElementById("image-preview-imgs-relate");
                            previewContainer.innerHTML = "";

                            for (var i = 0; i < files.length; i++) {
                                var file = files[i];

                                var reader = new FileReader();
                                reader.onload = function(e) {
                                    var imgElement = document.createElement("img");
                                    imgElement.src = e.target.result;
                                    imgElement.style.maxWidth = "100%";
                                    previewContainer.appendChild(imgElement);
                                };
                                reader.readAsDataURL(file);
                            }
                        });
                    </script>

                    <div class="form-group mt-3">
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
                            <input class="form-check-input" type="radio" name="status" id="soldOut"
                                value="soldOut">
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
@endsection
