@extends('layout/admin')

@section('title')
Chi tiết đơn hàng
@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="{{URL::asset('admin/css/panel-detail.css')}}">
<link rel="stylesheet" type="text/css" href="{{URL::asset('admin/css/order-detail.css')}}">
@endsection

@section('script')
<script type="text/javascript" src="{{URL::asset('admin/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('admin/js/panel-detail.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('admin/js/order-detail.js')}}"></script>
@endsection

@section('content')

<div class="container-right">
    <div class="">
        <div class="head-section">
            <ul>
                <li><a href="{{ route('dashboard') }}">Trang chủ</a></li>
                <li><a href="{{ route('orderMasterList') }}">Đơn hàng</a></li>
                <li class="active">Chi tiết</li>
            </ul>
        </div>

        <div class="title-section">
            <h1>Chi tiết đơn hàng</h1>
        </div>

        <div class="content-section" id="order-detail">
            <form action="{{ route('saveOrder', isset($order) ? $order->id : null) }}" method="POST" id="frm" data-list-url="{{ route('orderMasterList') }}">
                @csrf
                <!-- <input type="hidden" name="id" value="{{ $order->id }}"> -->
                <input type="hidden" name="orderNo" value="{{ $order->order_no }}">

                <div class="row">
                    <div class="col-lg-9">
                        <div class="panel-body">
                            <h2>Đơn hàng #{{ $order->order_no }}</h2>
                            <span style="font-size: 1.15rem">
                                @aOrderStatus {{ $order->status }} @endaOrderStatus
                            </span>
                            <div class="row info mt-4">
                                <div class="col-md-7 mb-3">
                                    <p>{{ $order->contact_address }}</p>
                                    <p>P: {{ $order->contact_phone }}</p>
                                    <p>{{ $order->contact_email }}</p>
                                </div>
                                <div class="col-md-5">
                                    <div class="text-end">
                                        <table class="table table-bordered">
                                            <thead>
                                                <th>Số đơn hàng</th>
                                                <th>Ngày đặt hàng</th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>{{ $order->order_no }}</td>
                                                    <td>{{ date('d/m/Y', strtotime($order->order_date)) }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="error-alert"><i class="fa-solid fa-triangle-exclamation"></i>Message</div> -->

                            <div class="row mt-5">
                                <div class="col-12">
                                    <div class="products-table">
                                        <h4>Sản phẩm</h4>
                                        <table class="table mt-3" id="products-table">
                                            <thead>
                                                <th style="width: 90px">Ảnh</th>
                                                <th style="width: 60%">Tên</th>
                                                <th class="quantity">SL</th>
                                                <th class="price">Giá</th>
                                                <th class="total">Tổng</th>
                                            </thead>
                                            <tbody>
                                                @foreach($orderLines as $item)
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('productDetail') }}/{{$item->product->id}}"><img alt="" src="{{ url('') }}/{{ $item->imgSrc }}"></a>
                                                    </td>
                                                    <td>{{ $item->product->name }}
                                                        <div class="code">{{ $item->product->code }}</div>
                                                        <div class="for-mobile">
                                                            <span>{{ $item->product_quantity }} x </span>
                                                            @currency {{ $item->product->price }} @endcurrency
                                                        </div>
                                                    </td>
                                                    <td class="quantity">{{ $item->product_quantity }}</td>
                                                    <td class="price">
                                                        @currency {{ $item->product->price }} @endcurrency
                                                    </td>
                                                    <td class="total">
                                                        @currency {{ $item->product_total_price }} @endcurrency
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="3"><strong>Ghi chú:</strong>
                                                        <p>{{ $order->note }}</p>
                                                    </td>
                                                    <th>Tổng</th>
                                                    <td class="total-amount">
                                                        @currency {{ $order->total_price }} @endcurrency
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-5">
                                <div class="col-12">

                                    @if ($order->status == 'da_nhan_hang')
                                    <h4>Vận chuyển</h4>

                                    <div class="mt-3" id="input-delivery">
                                        <div class="row mb-3">
                                            <label class="col-md-3 d-form-label">Kho lấy hàng</label>
                                            <div class="col-md-9">
                                                <select class="d-form-control dw-25" name="warehousePickup" required>
                                                    <option value="Kho chính">Kho chính</option>
                                                    <option value="Kho 1">Kho 1</option>
                                                    <option value="Kho 2">Kho 2</option>
                                                    <option value="Kho 3">Kho 3</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-md-3 d-form-label">Mã vận chuyển</label>
                                            <div class="col-md-9">
                                                <input type="text" name="shippingCode" class="d-form-control dw-25" required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-md-3 d-form-label">Nhà vận chuyển</label>
                                            <div class="col-md-9">
                                                <select class="d-form-control dw-25" name="transporter" required>
                                                    <option value="Nhà vận chuyển 1">Nhà vân chuyển
                                                        1</option>
                                                    <option value="Nhà vận chuyển 2">Nhà vân chuyển
                                                        2</option>
                                                    <option value="Nhà vận chuyển 3">Nhà vân chuyển
                                                        3</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-md-3 d-form-label">Tổng khối
                                                lượng</label>
                                            <div class="col-md-9">
                                                <div class="d-input-group dw-25">
                                                    <input type="number" step=".01" class="d-form-control"
                                                        name="totalWeight" aria-describedby="basic-addon2" required> <span
                                                        class="d-input-group-text" id="basic-addon2">kg</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    @if ($order->status != 'dang_cho_nhan_hang' && $order->status != 'da_nhan_hang' &&
                                    $order->status != 'da_huy')
                                    <h4>Vận chuyển</h4>

                                    <div class="mt-4" id="output-delivery">
                                        <div class="row">
                                            <div class="col-md-6 col-left">
                                                <div class="row">
                                                    <div class="col-6">Kho lấy hàng</div>
                                                    <div class="col-6 text-end">{{ $order->warehouse_pickup }}</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">Mã vận chuyển</div>
                                                    <div class="col-6 text-end">{{ $order->shipping_code }}</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">Nhà vận chuyển</div>
                                                    <div class="col-6 text-end">{{ $order->transporter }}</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-right">
                                                <div class="row">
                                                    <div class="col-6">Trạng thái vận chuyển</div>
                                                    <div class="col-6 text-end">
                                                        @aOrderStatus {{ $order->shipping_status }} @endaOrderStatus
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">Tổng khối lượng</div>
                                                    <div class="col-6 text-end">{{ $order->total_weight }} kg</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                </div>
                            </div>

                            @if ($order->status == 'dang_cho_nhan_hang' || $order->status == 'da_huy')
                            <div class="row mt-4">
                                <div class="col-12">
                                    <h4>Hủy đơn hàng</h4>

                                    <div class="mt-4">
                                        @if ($order->status == 'da_huy')
                                        <div style="color: #f85d2c">
                                            <strong>Lý do hủy: </strong>
                                            {{ $order->reason_for_cancel_order }}
                                        </div>
                                        @else
                                        <div>Xin vui lòng nhập lý do trả về (tối đa 1000 kí tự).</div>
                                        <textarea rows="5" cols="" class="d-form-control dw-100"
                                            name="reasonCancelOrder"></textarea>
                                        <button type="button" class="d-btn d-default-btn mt-3" id="cancel_order_btn">
                                            <i class="fa-solid fa-arrow-right-arrow-left icon"></i> Hủy
                                        </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endif

                            <div class="row mt-5">
                                <div class="col-12">
                                    <div class="text-center">
                                        @if ($order->status != 'hoan_thanh' && $order->status != 'da_huy')
                                        <button type="button" class="d-btn d-blue-btn" id="apply_btn">
                                            @if ($order->status == 'dang_cho_nhan_hang')
                                            <i class="fa-solid fa-check icon"></i> Nhận đơn hàng
                                            @elseif ($order->status == 'da_nhan_hang')
                                            <i class="fa-solid fa-truck icon"></i> Giao
                                            @elseif ($order->status == 'dang_giao_hang')
                                            <i class="fa-solid fa-check icon"></i> Xác nhận đã giao hàng
                                            @elseif ($order->status == 'da_giao_hang')
                                            <i class="fa-solid fa-check icon"></i> Xác nhận đơn hàng
                                            @endif
                                        </button>
                                        @endif

                                        <a href="{{ route('orderMasterList') }}" class="d-btn d-default-btn"
                                            id="back_button"> <i class="fa-solid fa-arrow-left-long icon"></i> Trở lại
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="panel-body panel-right">
                            <div class="caption">Khách hàng</div>

                            <a href="{{ route('userDetail') }}/{{$personOrder->id}}" class="customer-name">{{ $personOrder->fullName() }}</a>
                            <div class="text-muted">Lần đầu đặt hàng</div>
                        </div>
                        <div class="panel-body panel-right">
                            <div class="caption">Người liên hệ</div>

                            <div>{{ $order->contact_first_name }} {{ $order->contact_last_name }}</div>
                            <div>
                                <a href="#">{{ $order->contact_email }}</a>
                            </div>
                            <div class="text-muted">{{ $order->contact_phone }}</div>
                        </div>
                        <div class="panel-body panel-right">
                            <div class="caption">Địa chỉ giao hàng</div>
                            <div>{{ $order->contact_first_name }} {{ $order->contact_last_name }}</div>
                            <div>{{ $order->contact_address }}</div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection