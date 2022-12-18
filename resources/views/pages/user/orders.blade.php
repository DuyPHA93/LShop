@extends('layout/user')

@section('title')
Đơn hàng của tôi
@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/my-order.css') }}">
@endsection

@section('script')

@endsection

@section('content')

<div class="wrapper pb-5">
	<div class="row mt-4 mb-4">
		<div class="col-md-12">
			<div class="page-title">
				<span><a href="{{ route('home') }}">Trang chủ</a></span> <span><a href="{{ route('myOrderList') }}">Đơn hàng của tôi</a></span>
			</div>
		</div>
	</div>

	<div class="row mt-4">
		<div class="col-md-3 d-none d-md-block">
			<div>
				<ul class="menu-side">
					<li><a href='#'> <span class="menu-icon"><i
								class="fa-solid fa-user"></i></span> <span class="menu-text">Tài
								khoản</span>
					</a></li>
					<li><a href="{{ route('myOrderList') }}"> <span class="menu-icon"><i
								class="fa-solid fa-boxes-packing"></i></span> <span class="menu-text">Đơn
								hàng của tôi</span>
					</a></li>
					<li><a href='#'> <span class="menu-icon"><i
								class="fa-solid fa-gear"></i></span> <span class="menu-text">Cài
								đặt</span>
					</a></li>
				</ul>
			</div>
		</div>
		<div class="col-md-9">
			<div class="account-content table-responsive" id="my_order_table">
				<div class="row mb-4 align-items-center">
					<div class="col-md-5"><h3>Đơn hàng của tôi</h3></div>
					<div class="col-md-7">
						<div class="sort-choosen">
							<span>Hiển thị một kết quả duy nhất</span>
							<select class="sort">
								<option value="">Tất cả đơn hàng</option>
								<option value="">5 đơn hàng gần đây</option>
								<option value="">15 ngày gần đây</option>
								<option value="">30 ngày gần đây</option>
								<option value="">6 tháng gần đây</option>
								<option value="">Đặt hàng đặt trong năm 2</option>
							</select>
						</div>
					</div>
				</div>
				<table class="table">
					<thead>
						<th>Sản phẩm</th>
						<th>Số lượng</th>
						<th>Tổng tiền</th>
						<th>Trạng thái</th>
						<th></th>
					</thead>
					<tbody>
						@foreach($orders as $order)
						<tr style="background-color: #f0f0f0">
							<td colspan="5" class="text-muted">
								<span class="order-date">{{ date('d-m-Y H:i:s', strtotime($order->order_date)) }}</span>
								<span class="order-no">Mã số đơn: {{ $order->order_no }}</span>
							</td>
						</tr>
						<tr>
							<td>
								<div>
									<a href="{{ route('myOrderDetail', isset($order) ? $order->id : null) }}"><img alt="" src="{{ url('') }}/{{ $order->imgSrc }}" style="width: 60px;"></a>
								</div>
							</td>
							<td>{{ $order->total_quantity }} sản phẩm</td>
							<td>
								@currency {{ $order->total_price }} @endcurrency
							</td>
							<td>
								@orderStatus {{ $order->status }} @endorderStatus
							</td>
							<td><a href="{{ route('myOrderDetail', isset($order) ? $order->id : null) }}">Xem chi tiết</a></td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

@endsection