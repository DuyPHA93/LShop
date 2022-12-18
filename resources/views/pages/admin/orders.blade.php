@extends('layout/admin')

@section('title')
Quản lý đơn hàng
@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="{{URL::asset('admin/css/panel-list.css')}}">
<link rel="stylesheet" type="text/css" href="{{URL::asset('admin/css/orders-list.css')}}">
@endsection

@section('script')
<script type="text/javascript" src="{{URL::asset('admin/js/panel-list.js')}}"></script>
@endsection

@section('content')

<div class="container-right">
    <div class="">
        <div class="head-section">
            <ul>
                <li><a href="{{ route('dashboard') }}">Trang chủ</a></li>
                <li class="active">Đơn hàng</li>
            </ul>
        </div>

        <div class="title-section">
            <h1>Đơn hàng</h1>
        </div>

        <div class="content-section">
            <div class="panel-body">
                <div>
                    <h2>Đơn hàng</h2>
                </div>
                <form action="" method="GET" id="frm">
                    <div id="table_wraper">
                        <div class="row align-items-center">
                            <div class="col-sm-6">
                                <div class="table-length">
                                    Hiển thị <select name="perPage" id="select_perPage">
                                        <option value="10" {{ (request()->query('perPage') == 10) ? 'selected' : ''}}>10</option>
                                        <option value="25" {{ (request()->query('perPage') == 25) ? 'selected' : ''}}>25</option>
                                        <option value="50" {{ (request()->query('perPage') == 50) ? 'selected' : ''}}>50</option>
                                        <option value="100" {{ (request()->query('perPage') == 100) ? 'selected' : ''}}>100</option>
                                    </select> trong {{ $orders->total() }} kết quả
                                </div>
                            </div>
                            <div class="col-sm-6 text-end">
                                <div class="table-search">
                                    <div>
                                        <input type="text" name="search" placeholder="Gõ từ khóa tìm kiếm..." value="{{ request()->query('search') }}">
                                        <button>
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive mt-3">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="choosen"><input class="form-check-input" type="checkbox" value=""
                                                id="choose_all"></th>
                                        <th>Số</th>
                                        <th>Địa chỉ giao hàng</th>
                                        <th>Ngày</th>
                                        <th style="min-width:105px">Số lượng</th>
                                        <th>Tổng</th>
                                        <th style="min-width:120px">Trạng thái</th>
                                        <th class="action"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $item)
                                    <tr>
                                        <td class="choosen"><input class="form-check-input choose" type="checkbox"
                                                value="">
                                        </td>
                                        <td>{{ $item->order_no }}</td>
                                        <td>{{ $item->contact_address}}</td>
                                        <td>{{ date('d/m/Y', strtotime($item->order_date)) }}</td>
                                        <td>{{ $item->total_quantity }} sản phẩm</td>
                                        <td>
                                            @currency {{ $item->total_price }} @endcurrency
                                        </td>
                                        <td>
                                            @aOrderStatus {{ $item->status }} @endaOrderStatus
                                        </td>
                                        <td class="action">
                                            <div class="btn-group action-group">
                                                <a class="btn btn-default btn-sm" href="{{ route('orderDetail') }}/{{$item->id}}">Xem</a>
                                                <button class="btn btn-default btn-sm dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false"></button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                            </div>
                            <div class="col-sm-6 text-end">
                                {{ $orders->links('vendor.pagination.custom') }}
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection