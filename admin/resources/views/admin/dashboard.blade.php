@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid py-5">
        <div class="row">
            <div class="col">
                <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                    <div class="card-header">ĐƠN HÀNG THÀNH CÔNG</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $cnt[0] }}</h5>
                        <p class="card-text">Đơn hàng giao dịch thành công</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-danger mb-3" style="max-width: 18rem;">
                    <div class="card-header">ĐANG XỬ LÝ</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $cnt[1] }}</h5>
                        <p class="card-text">Số lượng đơn hàng đang xử lý</p>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
                    <div class="card-header">DOANH SỐ</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ number_format($cnt[2], 0, ',', '.') }} vnđ</h5>
                        <p class="card-text">Doanh số hệ thống</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
                    <div class="card-header">ĐƠN HÀNG HỦY</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $cnt[3] }}</h5>
                        <p class="card-text">Số đơn bị hủy trong hệ thống</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- end analytic  -->

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <div class="card">
            <div class="card-header font-weight-bold">
                ĐƠN HÀNG MỚI
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Mã</th>
                            <th scope="col">Khách hàng</th>
                            <th scope="col">Sản phẩm</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Giá trị</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Thời gian</th>
                            <th scope="col">Tác vụ</th>
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
                                    <th scope="row">{{ $cnt }}</th>
                                    <td>{{ $order->code_user }}</td>
                                    <td>
                                        {{ $order->name }} <br>
                                        {{ $order->phone_number }}
                                    </td>
                                    <td><a href="#">{{ $order->product_name }}</a></td>
                                    <td>{{ $order->qty }}</td>
                                    <td>{{ number_format($order->qty * $order->price, 0, ',', '.') }}₫</td>
                                    @if ($order->status == 'completed')
                                        <td><span class="badge badge-success">Đã hoàn thành</span></td>
                                    @else
                                        <td><span class="badge badge-warning">Đang chờ xử lý</span></td>
                                    @endif
                                    <td>{{ $order->created_at }}</td>
                                    <td>
                                        <a href="{{ route('dashboard.delete', $order->id) }}"
                                            onclick="return confirm('Bạn có chắc chắn xóa khách hàng này!');"
                                            class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                            data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td class="text-danger" colspan="9">
                                    <strong>Không có đơn hàng nào!</strong>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                @if (!empty($orders))
                    {{ $orders->links() }}
                @endif
            </div>
        </div>

    </div>
@endsection
