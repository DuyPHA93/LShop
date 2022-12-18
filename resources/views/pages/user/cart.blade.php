@extends('layout/user')

@section('title')
Giỏ hàng
@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="css/cart.css">
@endsection

@section('script')
<script src="js/cart.js"></script>
@endsection

@section('content')

<div class="wrapper mt-4 pb-5 cart-container">
    @if (!isset($cart) || count($cart->items) == 0)
    <div class="row mt-5">
        <div class="col-12 text-center">
            <p class="mb-4">Chưa có sản phẩm nào trong giỏ hàng.</p>
            <a href="{{ route('products') }}" class="btn-red">Quay trở lại cửa hàng</a>
        </div>
    </div>
    @else
    <div class="row">
        <div class="col-lg-7 mb-4">
            <form action="{{ route('updateCart') }}" method="POST" id="frmCart">
                @csrf

                <div>
                    <table class="table" id="cart-table">
                        <thead>
                            <tr>
                                <th colspan="3">Sản phẩm</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Tổng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cart->items as $item)
                            <tr>
                                <td><span class="remove-btn" onclick="deleteItem(this)"><i
                                            class="fa-solid fa-xmark"></i></span></td>
                                <td class="thumbnail">
                                    <a href="{{ route('detail', $item->id) }}"> <img alt=""
                                            src="{{ url('') }}/{{ $item->product->imgSrc }}">
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('detail', $item->id) }}">{{ $item->product->name }}</a>
                                    <div class="for-mobile">
                                        <span class="m-quantity">{{ $item->quantity }} x </span> <span class="m-amount">
                                            @currency {{ $item->product->price }} @endcurrency
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    @currency {{ $item->product->price }} @endcurrency
                                </td>
                                <td>
                                    <input type="hidden" name="productId_{{ $item->id }}" id="1"
                                        value="{{ $item->quantity }}">
                                    <input type="number" class="quantity" name="quantity" value="{{ $item->quantity }}"
                                        oninput="onInputQty(this,productId_{{ $item->id }})">
                                </td>
                                <td class="text-end">
                                    @currency {{ $item->product->price * $item->quantity }} @endcurrency
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div>
                    <a href="{{ route('products') }}" class="btn-red-border">
                        <span><i class="fa-solid fa-arrow-left-long"></i></span> Tiếp tục xem sản phẩm
                    </a>
                    <button class="btn-red disabled" id="update-cart-btn">Cập nhật giỏ hàng</button>
                </div>
            </form>
        </div>
        <div class="col-lg-5">
            <div class="report-side">
                <table class="table" id="report-table">
                    <thead>
                        <tr>
                            <th>Tổng số lượng</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>Tổng phụ</th>
                                        <td class="text-end">
                                            @currency {{ $cart->totalAmount }} @endcurrency
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Giao hàng</th>
                                        <td class="text-end">
                                            <p style="color: #666">Giao hàng miễn phí</p>
                                            <p style="color: #666">Đây chỉ là ước tính. Giá sẽ cập
                                                nhật trong quá trình thanh toán.</p>
                                            <p>Tính phí giao hàng</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Tổng</th>
                                        <td class="text-end">
                                            @currency {{ $cart->totalAmount }} @endcurrency
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </tr>
                    </tbody>
                </table>

                <div>
                    <button id="checkout-btn" data-url-check="{{ route('checkAuth') }}"
                        data-url-login="{{ route('showUserLoginForm') }}"
                        data-url-checkout="{{ route('checkoutForm') }}">Tiến hành thanh toán</button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

@endsection