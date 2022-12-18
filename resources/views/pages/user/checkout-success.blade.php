@extends('layout/user')

@section('title')
Thanh toán
@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="css/order-success.css">
@endsection

@section('script')

@endsection

@section('content')

<div class="wrapper pt-5 pb-5">
    <div class="order-success-container">
        <div class="head-section mt-5">
            <img alt="" src="images/success.png">
            <h3>Đặt hàng thành công</h3>
            <div style="color: #666">
                Mã đơn hàng: <span>{{ $orderNo }}</span>
            </div>
        </div>
        <div class="mt-4">
            <table class="table" id="products-table">
                <thead>
                    <tr>
                        <th>Thời gian</th>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Tổng</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($cart))
                    @foreach($cart->items as $item)
                    <tr>
                        <td>
                            <strong>{{ $timeOrder }}</strong>
                            <div>{{ $dateOrder }}</div>
                        </td>
                        <td><a href="{{ route('detail', $item->id) }}">{{ $item->product->name }}</a></td>
                        <td>x{{ $item->quantity }}</td>
                        <td>@currency {{ $item->product->price * $item->quantity }} @endcurrency</td>
                    </tr>
                    @endforeach
                    @endif
                    <!-- <tr>
                        <td>
                            <strong>17:25:21</strong>
                            <div>1/1/2022</div>
                        </td>
                        <td><a href='#'>Product name</a></td>
                        <td>x1</td>
                        <td>2,000,000đ</td>
                    </tr>
                    <tr>
                        <td>
                            <strong>17:25:21</strong>
                            <div>1/1/2022</div>
                        </td>
                        <td><a href='#'>Product name</a></td>
                        <td>x1</td>
                        <td>2,000,000đ</td>
                    </tr>
                    <tr>
                        <td>
                            <strong>17:25:21</strong>
                            <div>1/1/2022</div>
                        </td>
                        <td><a href='#'>Product name</a></td>
                        <td>x1</td>
                        <td>2,000,000đ</td>
                    </tr> -->
                </tbody>
            </table>
        </div>

        <div class="mt-3 mb-5 text-center">
            <div style="font-size: 1.2em">Chúng tôi sẽ liên hệ với bạn sau
                khi nhận được đơn đặt hàng này</div>
            <div>Mọi thắc mắc xin vui lòng liên hệ hotline: 0917 616 633</div>
        </div>

        <div class="text-center">
            <a href="{{ route('home') }}" id="home-back-btn"> <span><i class="fa-solid fa-house"></i></span> Trở về trang chủ</a> 
            <a href="{{ route('products') }}" id="continue-buy-btn">Mua thêm sản phẩm</a>
        </div>
    </div>
</div>

@endsection