@extends('layouts.admin')
@section('title', 'List Order')
@section('content')
    <div id="main-content-wp" class="list-product-page">
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        @php
            $payment_translate = ['home' => 'Thanh toán tại nhà', 'direct' => 'Thanh toán tại cửa hàng'];
            $status_translate = [
                'pending' => 'Chờ duyệt',
                'approved' => 'Đã duyệt',
                'delivering' => 'Đang vận chuyển',
                'received' => 'Đã giao',
                'paid' => 'Đã thanh toán',
            ];
        @endphp
        <div class="wrap clearfix">
            <div id="content" class="detail-exhibition fl-right">
                <div class="section" id="info">
                    <div class="section-head">
                        <h3 class="section-title">Thông tin đơn hàng</h3>
                    </div>
                    <ul class="list-item">
                        <li>
                            <h3 class="title">Mã đơn hàng</h3>
                            <span class="detail">{{ $client->code_order }}</span>
                        </li>
                        <li>
                            <h3 class="title">Địa chỉ nhận hàng</h3>
                            <span class="detail">{{ $client->address }} / {{ $client->phone }} / {{ $client->email }} /
                                {{ $client->note }}</span>
                        </li>
                        <li>
                            <h3 class="title">Thông tin vận chuyển</h3>
                            <span class="detail">{{ $payment_translate[$client->payment] }}</span>
                        </li>
                        <form method="POST" action="{{ route('order.update', $client->id) }}">
                            @csrf
                            <li>
                                <h3 class="title">Tình trạng đơn hàng</h3>
                                <select name="status">
                                    <option {{ $client->status == 'pending' ? 'selected' : '' }} value='pending'>Chờ duyệt
                                    </option>
                                    <option {{ $client->status == 'approved' ? 'selected' : '' }} value='approved'>Đã duyệt
                                    </option>
                                    <option {{ $client->status == 'delivering' ? 'selected' : '' }} value='delivering'>Vận
                                        chuyển</option>
                                    <option {{ $client->status == 'received' ? 'selected' : '' }} value='received'>Đã nhận
                                    </option>
                                    <option {{ $client->status == 'paid' ? 'selected' : '' }} value='paid'>Đã thanh toán
                                    </option>
                                </select>
                                <input type="submit" name="sm_status" value="Cập nhật đơn hàng">
                            </li>
                        </form>
                    </ul>
                </div>
                <div class="section">
                    <div class="section-head">
                        <h3 class="section-title">Sản phẩm đơn hàng</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table info-exhibition">
                            <thead>
                                <tr>
                                    <td class="thead-text">STT</td>
                                    <td class="thead-text">Mã sản phẩm</td>
                                    <td class="thead-text">Ảnh sản phẩm</td>
                                    <td class="thead-text">Tên sản phẩm</td>
                                    <td class="thead-text">Đơn giá</td>
                                    <td class="thead-text">Số lượng</td>
                                    <td class="thead-text">Thành tiền</td>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $cnt = 0;
                                @endphp
                                @foreach ($orders as $order)
                                    @php
                                        $cnt++;
                                        foreach ($products as $product) {
                                            if ($product->id == $order->product_id) {
                                                $product_info = $product;
                                            }
                                        }
                                    @endphp
                                    <tr>
                                        <td class="thead-text">{{ $cnt }}</td>
                                        <td class="thead-text">{{ $product_info->product_code }}</td>
                                        <td class="thead-text">
                                            <div class="thumb">
                                                <img src="{{ url($product_info->thumbnail) }}" alt="">
                                            </div>
                                        </td>
                                        <td class="thead-text">{{ $product_info->name }}</td>
                                        <td class="thead-text">{{ number_format($product->price, 0, ',', '.') }} đ</td>
                                        <td class="thead-text">{{ $order->qty }}</td>
                                        <td class="thead-text">{{ number_format($order->sub_total, 0, ',', '.') }} đ</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="section">
                    <h3 class="section-title">Giá trị đơn hàng</h3>
                    <div class="section-detail">
                        <ul class="list-item clearfix">
                            <li>
                                <span class="total-fee">Tổng số lượng</span>
                                <span class="total">Tổng đơn hàng</span>
                            </li>
                            <li>
                                <span class="total-fee">{{ $client->num_order }} sản phẩm</span>
                                <span class="total">{{ number_format($client->total, 0, ',', '.') }} đ</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
