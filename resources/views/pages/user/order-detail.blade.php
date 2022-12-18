@extends('layout/user')

@section('title')
Chi tiết đơn hàng {{ $order->order_no }}
@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/order-detail.css') }}">
@endsection

@section('script')

@endsection

@section('content')

<div class="wrapper pb-5">
	<div class="row mt-4 mb-4">
		<div class="col-md-12">
			<div class="page-title">
				<span><a href="{{ route('home') }}">Trang chủ</a></span> <span><a href="{{ route('myOrderList') }}">Đơn
						hàng của tôi</a></span>
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
			<div class="account-content" id="order_detail_table">
				<div class="row">
					<div class="col-12">
						<h3>Chi tiết đơn hàng #{{ $order->order_no }}</h3>
						@orderStatus {{ $order->status }} @endorderStatus
					</div>
				</div>
				
				@if ($order->status == "da_huy")
				<div style="color:#f85d2c"><strong>Lý do hủy: </strong>{{ $order->reason_for_cancel_order }}</div>
				@endif
				
				<div class="row mt-3">
					<div class="col-md-6 mb-3">
						<div>{{ $order->contact_address }}</div>
						<div>P: {{ $order->contact_phone }}</div>
					</div>
					<div class="col-md-6">
						<div id="right-table">
							<table class="table table-bordered">
								<thead>
									<th>Mã đơn hàng</th>
									<th>Ngày đặt hàng</th>
								</thead>
								<tbody>
									<tr>
										<td>{{ $order->order_no }}</td>
										<td>{{ date('H:i d/m/Y', strtotime($order->order_date)) }}</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="row mt-4">
					<div class="col-md-4">
						<div>
							<div><strong>Địa chỉ người nhận</strong></div>
							<div>{{ $order->contact_first_name }} {{ $order->contact_last_name }}</div>
							<div>{{ $order->contact_address }}</div>
							<div>{{ $order->contact_phone }}</div>
						</div>
					</div>
					<div class="col-md-4">
						<div>
							<div><strong>Hình thức giao hàng</strong></div>
							<div>Vận chuyển tiết kiệm (dự kiến giao hàng vào Thứ bảy, 1/1/2022)</div>
							<div>Phí vận chuyển: 0d</div>
						</div>
					</div>
					<div class="col-md-4">
						<div>
							<div><strong>Hình thức thanh toán</strong></div>
							<div>Thanh toán tiền mặt khi nhận hàng</div>
						</div>
					</div>
				</div>
				<div class="row mt-5">
					<div class="col-12">
						<div>
							<table class="table" id="product_table">
								<thead>
									<th colspan="2">Sản phẩm</th>
									<th class="text-end">Giá</th>
									<th class="text-center" style="min-width:55px">SL</th>
									<th class="text-end" style="min-width:120px">Giảm giá</th>
									<th class="text-end">Tổng</th>
								</thead>
								<tbody>
									@foreach($orderLines as $item)
									<tr>
										<td class="thumbnail">
											<a href="{{ route('detail', $item->product_id) }}"><img alt="" src="{{ url('') }}/{{ $item->imgSrc }}"></a>
										</td>
										<td><a href="{{ route('detail', $item->product_id) }}">{{ $item->product->name }}</a></td>
										<td class="text-end">@currency {{ $item->product->price }} @endcurrency</td>
										<td class="text-center">{{ $item->product_quantity }}</td>
										<td class="text-end">0 ₫</td>
										<td class="text-end">@currency {{ $item->product_total_price }} @endcurrency</td>
									</tr>
									@endforeach
									<!-- <tr>
										<td class="thumbnail">
											<a href="#"><img alt="" src="images/products/product-02.jpg"></a>
										</td>
										<td><a href="#">Mouse Razer Mamba WirelessK</a></td>
										<td class="text-end">1,110,000 ₫</td>
										<td class="text-center">1</td>
										<td class="text-end">0 ₫</td>
										<td class="text-end">1,110,000 ₫</td>
									</tr>
									<tr>
										<td class="thumbnail">
											<a href="#"><img alt="" src="images/products/product-06.jpg"></a>
										</td>
										<td><a href="#">Camera Xiaomi Yi - Cloud Dome 1080P</a></td>
										<td class="text-end">1,110,000 ₫</td>
										<td class="text-center">1</td>
										<td class="text-end">0 ₫</td>
										<td class="text-end">1,110,000 ₫</td>
									</tr> -->
								</tbody>
								<tfoot>
									<tr>
										<th colspan="4" rowspan="3">
											Ghi chú: <br>
											<p class="fw-normal">{{ $order->note }}</p>
										</th>
										<th class="no-bd text-end">Tổng phụ</th>
										<th class="no-bd text-end">@currency {{ $order->total_price }} @endcurrency</th>
									</tr>
									<tr>
										<th class="no-bd text-end">Giảm giá</th>
										<th class="no-bd text-end">0 ₫</th>
									</tr>
									<tr>
										<th class="no-bd text-end">Phí vận chuyển</th>
										<th class="no-bd text-end">0 ₫</th>
									</tr>
									<tr>
										<th colspan="4"></th>
										<th class="text-end">Tổng cộng</th>
										<th class="text-end">@currency {{ $order->total_price }} @endcurrency</th>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection