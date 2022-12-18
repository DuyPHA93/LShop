@extends('layout/user')

@section('title')
Thanh toán
@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="css/checkout.css">
@endsection

@section('script')

@endsection

@section('content')

<div class="wrapper mt-4 pb-5" id="checkout-form">
    <form action="{{ route('performCheckout') }}" method="POST">
        @if ($errors->any())
        <p class="error">{{ $errors->all()[0] }}</p>
        @endif

        @csrf

        <div class="row">
            <div class="col-md-7 pb-5">
                <h3>Thông tin thanh toán</h3>
                <div class="row">
                    <div class="col-lg-6">
                        <label>Họ * <input type="text" name="firstName" value="">
                        </label>
                    </div>
                    <div class="col-lg-6">
                        <label>Tên * <input type="text" name="lastName" value="">
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <label>Địa chỉ * <input type="text" name="address" value="">
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <label>Điện thoại * <input type="text" name="phone" value="">
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <label>Email * <input type="text" name="email" value="">
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <label>Ghi chú đơn hàng <textarea rows="4" cols="" name="note">Note abc</textarea>
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div id="order-report">
                    <h3>Đơn hàng của bạn</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Tổng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($cart))
                            @foreach($cart->items as $item)
                            <tr>
                                <td>{{ $item->product->name }} <strong>× {{ $item->quantity }}</strong></td>
                                <td>@currency {{ $item->product->price * $item->quantity }} @endcurrency</td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Tổng phụ</th>
                                <td>
                                    @currency {{ $cart->totalAmount }} @endcurrency
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding:0">
                                    <table>
                                        <tbody>
                                            <tr>
                                                <th>Giao hàng</th>
                                                <td style="color: #666; font-size: .9em; text-align: right;">Giao hàng
                                                    miễn phí</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <th>Tổng</th>
                                <td>
                                    @currency {{ $cart->totalAmount }} @endcurrency
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    <div>
                        <button id="order-btn">Đặt hàng</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection