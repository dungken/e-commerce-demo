@extends('layouts.admin')
@section('title', 'List Product')
@section('content')
    <div id="content" class="container-fluid">
        @php
            // dd($cats);
        @endphp
        <div class="card">
            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif
            @if (session('status_error'))
                <div class="alert alert-danger">{{ session('status_error') }}</div>
            @endif
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Danh sách sản phẩm</h5>
                <div class="form-search form-inline">
                    <form action="#" class=" d-flex">
                        <input type="text" name="keyword" value="{{ request()->keyword }}"
                            class="form-control form-search" placeholder="Tìm kiếm bài viết">
                        <input type="submit" name="btn_search" value="Tìm kiếm" class="btn btn-primary">
                    </form>
                </div>
            </div>
            <form action="{{ route('product.action', $status) }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="analytic">
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'inStock']) }}" class="text-primary">Còn
                            hàng<span class="text-muted">({{ $cnt_product[1] }})</span></a>
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'soldOut']) }}" class="text-primary">Hết
                            hàng<span class="text-muted">({{ $cnt_product[0] }})</span></a>
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'disable']) }}" class="text-primary">Vô hiệu
                            hóa<span class="text-muted">({{ $cnt_product[2] }})</span></a>
                    </div>
                    <div class="form-action form-inline py-3">
                        <select class="form-control mr-1" id="" name="action">
                            <option value="">Chọn</option>
                            @foreach ($action as $k => $v)
                                <option value="{{ $k }}">{{ $v }}</option>
                            @endforeach
                        </select>
                        <input type="submit" name="btn_action" value="Áp dụng" class="btn btn-primary">
                    </div>
                    <table class="table table-striped table-checkall">
                        <thead>
                            <tr>
                                <th scope="col">
                                    <input name="checkall" type="checkbox">
                                </th>
                                <th scope="col">#</th>
                                <th scope="col">Ảnh</th>
                                <th scope="col">Tên sản phẩm</th>
                                <th scope="col">Giá</th>
                                <th scope="col">Danh mục</th>
                                <th scope="col">Tình trạng</th>
                                <th scope="col">Ngày tạo</th>
                                @if ($status == 'inStock' || $status == 'soldOut')
                                    <th scope="col">Tác vụ</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($products))
                                @php
                                    $cnt = 0;
                                @endphp
                                @foreach ($products as $product)
                                    @php
                                        $cnt++;
                                        // dd($product);
                                    @endphp
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="check_list[]" value="{{ $product->id }}">
                                        </td>
                                        <td scope="row">{{ $cnt }}</td>
                                        <td><img style="width: 150px; height: 150px;"
                                                src="{{ url($product->thumbnail) }}" alt=""></td>
                                        <td>{{ Str::limit($product->name, 50, '...') }}</td>
                                        <td>{{ number_format($product->price, 0, ',', '.') }}đ</td>
                                        @foreach ($cats as $cat)
                                            @if ($cat->id == $product->cat_id)
                                                <td>{{ $cat->name }}</td>
                                            @endif
                                        @endforeach

                                        @if ($product->status == 'soldOut')
                                            <td><span class="badge badge-dark">Hết hàng</span></td>
                                        @else
                                            <td><span class="badge badge-success">Còn hàng</span></td>
                                        @endif
                                        <td>{{ $product->created_at }}</td>
                                        <td>
                                            @if ($status == $product->status)
                                                <a href="{{ route('product.edit', $product->id) }}"
                                                    class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                        class="fa fa-edit"></i></a>
                                                <a href="{{ route('product.delete', $product->id) }}"
                                                    class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Delete"
                                                    onclick="return confirm('Bạn có muốn xóa tạm thời sản phẩm này không?')"><i
                                                        class="fa fa-trash"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="text-danger" colspan="9">
                                        <strong>Không có bản ghi nào!</strong>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    @if (!empty($products))
                        {{ $products->links() }}
                    @endif
                </div>
            </form>
        </div>
    </div>
@endsection
