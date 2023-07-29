@extends('layouts.admin')
@section('title', 'List Order')
@section('content')

    <div id="content" class="container-fluid">
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        @if (session('status_error'))
            <div class="alert alert-danger">{{ session('status_error') }}</div>
        @endif  
        <div class="card">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Danh sách đơn hàng</h5>
                <div class="form-search form-inline">
                    <form action="{{route('order.list', $status)}}" class="d-flex">
                        <input type="text" name="keyword" class="form-control form-search" placeholder="Tìm kiếm"
                            value="{{ request()->keyword }}">
                        <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                    </form>
                </div>
            </div>
            <form action="{{ route('order.action', $status) }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="analytic">
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'pending']) }}" class="text-primary">Chờ
                            duyệt<span class="text-muted">({{ $cnt_client[0] }})</span></a>
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'approved']) }}" class="text-primary">Đã
                            duyệt<span class="text-muted">({{ $cnt_client[1] }})</span></a>
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'delivering']) }}" class="text-primary">Đang
                            giao hàng<span class="text-muted">({{ $cnt_client[2] }})</span></a>
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'received']) }}" class="text-primary">Đã giao
                            hàng<span class="text-muted">({{ $cnt_client[3] }})</span></a>
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'paid']) }}" class="text-primary">Đã thanh
                            toán<span class="text-muted">({{ $cnt_client[4] }})</span></a>
                    </div>

                    <div class="form-action form-inline py-3">
                        <select class="form-control mr-1" id="" name="action">
                            <option value="0">Chọn</option>
                            @foreach ($action as $k => $act)
                                <option value="{{ $k }}">{{ $act }}</option>
                            @endforeach
                        </select>
                        <input type="submit" name="btn-action" value="Áp dụng" class="btn btn-primary">
                    </div>

                    <table class="table table-striped table-checkall">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" name="checkall">
                                </th>
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
                                        <td>
                                            <input type="checkbox" name="check_list[]" value="{{$client->id}}">
                                        </td>
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
                                                <span
                                                    class="badge badge-info">{{ $status_translate[$client->status] }}</span>
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
            </form>
        </div>
    </div>
@endsection
