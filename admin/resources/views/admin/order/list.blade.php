@extends('layouts.admin')
@section('title', 'List Order')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif
            @if (session('status_error'))
                <div class="alert alert-danger">{{ session('status_error') }}</div>
            @endif
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Danh sách đơn hàng</h5>
                <div class="form-search form-inline">
                    <form action="#" class=" d-flex">
                        <input type="text" name="keyword" value="{{ request()->keyword }}"
                            class="form-control form-search" placeholder="Tìm kiếm khách hàng">
                        <input type="submit" name="btn_search" value="Tìm kiếm" class="btn btn-primary">
                    </form>
                </div>
            </div>
            <form action="{{ route('order.action', $status) }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="analytic">
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'completed']) }}" class="text-primary">Hoàn
                            thành<span class="text-muted">({{ $cnt_order[0] }})</span></a>
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'processing']) }}" class="text-primary">Đang xử
                            lí<span class="text-muted">({{ $cnt_order[1] }})</span></a>
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'disable']) }}" class="text-primary">Vô hiệu
                            hóa<span class="text-muted">({{ $cnt_order[2] }})</span></a>
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
                                <th scope="col">Mã KH </th>
                                <th scope="col">Tên KH</th>
                                <th scope="col">Tên SP</th>
                                <th scope="col">Số lượng</th>
                                <th scope="col">Giá</th>
                                <th scope="col">Tổng tiền</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Thời gian</th>
                                @if ($status == 'completed' || $status == 'processing')
                                    <th scope="col">Tác vụ</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($orders))
                                @php
                                    $cnt = 0;
                                @endphp
                                @foreach ($orders as $order)
                                    @php
                                        $cnt++;
                                    @endphp
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="check_list[]" value="{{ $order->id }}">
                                        </td>
                                        <td scope="row">{{ $cnt }}</td>
                                        <td scope="row">{{ $order->code_user }}</td>
                                        <td scope="row">{{ $order->name }}
                                            <br>
                                            {{ $order->phone_number }}
                                        </td>
                                        <td>{{ Str::limit($order->product_name, 50, '...') }}</td>
                                        <td scope="row">{{ $order->qty }}</td>
                                        <td>{{ number_format($order->price, 0, ',', '.') }}đ</td>
                                        <td>{{ number_format($order->price * $order->qty, 0, ',', '.') }}đ</td>
                                        @if ($order->status == 'processing')
                                            <td><span class="badge badge-dark">Đang xử lí</span></td>
                                        @else
                                            <td><span class="badge badge-success">Hoàn thành</span></td>
                                        @endif
                                        <td>{{ $order->created_at }}</td>
                                        <td>
                                            @if ($status == $order->status)
                                                <a href="{{ route('order.delete', $order->id) }}"
                                                    class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Delete"
                                                    onclick="return confirm('Bạn có muốn xóa tạm thời đơn hàng này không?')"><i
                                                        class="fa fa-trash"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="text-danger" colspan="11">
                                        <strong>Không có bản ghi nào!</strong>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    @if (!empty($orders))
                        {{ $orders->links() }}
                    @endif
                </div>
            </form>
        </div>
    </div>
@endsection
