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
                        <h5 class="card-title">{{ number_format($cnt[2], 0, ',', '.') }} đ</h5>
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
                <table class="table table-striped table-checkall">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Mã đơn hàng</th>
                            <th scope="col">Mã KH</th>
                            <th scope="col">Khách hàng</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Tổng giá</th>
                            <th scope="col">Chi tiết</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Thời gian</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if (!empty($clients))
                            @php
                                $cnt = 0;
                            @endphp
                            @foreach ($clients as $client)
                                @php
                                    $cnt++;
                                    $status_translate = [
                                        'pending' => 'Chờ duyệt',
                                        'approved' => 'Đã duyệt',
                                        'delivering' => 'Đang vận chuyển',
                                        'received' => 'Đã giao',
                                        'paid' => 'Đã thanh toán',
                                    ];
                                @endphp
                                <tr>
                                    <td>{{ $cnt }}</td>
                                    <td>{{ $client->code_order }}</td>
                                    <td>{{ $client->code_client }}</td>
                                    <td>
                                        {{ $client->name }} <br>
                                        {{ $client->phone }} <br>
                                        {{ $client->email }}
                                    </td>
                                    <td class="text-center">{{ $client->num_order }}</td>
                                    <td>{{ number_format($client->total, 0, ',', '.') }} đ</td>
                                    <td><a href="{{ route('order.detail', $client->id) }}">Xem chi tiết</a></td>
                                    @if ($client->status == 'pending')
                                        <td>
                                            <span
                                                class="badge badge-danger">{{ $status_translate[$client->status] }}</span>
                                        </td>
                                    @elseif ($client->status == 'approved')
                                        <td>
                                            <span class="badge badge-info">{{ $status_translate[$client->status] }}</span>
                                        </td>
                                    @elseif ($client->status == 'delivering')
                                        <td>
                                            <span
                                                class="badge badge-secondary">{{ $status_translate[$client->status] }}</span>
                                        </td>
                                    @elseif ($client->status == 'received')
                                        <td>
                                            <span
                                                class="badge badge-primary">{{ $status_translate[$client->status] }}</span>
                                        </td>
                                    @else
                                        <td>
                                            <span
                                                class="badge badge-success">{{ $status_translate[$client->status] }}</span>
                                        </td>
                                    @endif

                                    <td>{{ $client->created_at }}</td>
                                    <td>
                                        <a href="{{ route('order.delete', $client->id) }}"
                                            onclick="return confirm('Bạn có chắc chắn muốn xóa khách hàng này không?'); "
                                            class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                            data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                class="fa fa-trash"></i></a>
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
                @if (!empty($clients))
                    {{ $clients->links() }}
                @endif
            </div>
        </div>

    </div>
@endsection
