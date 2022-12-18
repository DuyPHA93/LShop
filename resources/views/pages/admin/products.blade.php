@extends('layout/admin')

@section('title')
Quản lý sản phẩm
@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="{{URL::asset('admin/css/panel-list.css')}}">
<link rel="stylesheet" type="text/css" href="{{URL::asset('admin/css/products-list.css')}}">
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
                <li class="active">Sản phẩm</li>
            </ul>
        </div>

        <div class="title-section">
            <h1>Sản phẩm</h1>

            <div class="menu-link">
                <span class="item"> <a href="{{ route('productDetail') }}"><i class="fa-solid fa-plus icon"></i>Thêm sản phẩm</a>
                </span>
            </div>
        </div>

        <div class="content-section">
            <div class="panel-body">
                <div>
                    <h2>Sản phẩm</h2>
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
                                    </select> trong {{ $products->total() }} kết quả
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
                                        <th>Id</th>
                                        <th>Ảnh</th>
                                        <th class="name">Tên</th>
                                        <th style="min-width:110px">Danh mục</th>
                                        <th>Giá</th>
                                        <th style="min-width:70px">SL</th>
                                        <th style="min-width:120px">Trạng thái</th>
                                        <th class="action"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $item)
                                    <tr>
                                        <td class="choosen"><input class="form-check-input choose" type="checkbox"
                                                value="">
                                        </td>
                                        <td>{{ str_pad($item->id,4,'0',STR_PAD_LEFT) }}</td>
                                        <td>
                                            <a href="{{ route('productDetail') }}/{{$item->id}}"><img alt="" src="{{ url('') }}/{{ $item->imgSrc }}"></a>
                                        </td>
                                        <td class="name">{{$item->name}}</td>
                                        <td>{{$item->productType->name}}</td>
                                        <td>
                                            @currency {{ $item->price }} @endcurrency
                                        </td>
                                        <td>{{$item->quantity}}</td>
                                        <td class="text-center">
                                            @if ($item->active)
                                            <i class="fa fa-check check-status"></i>
                                            @else
                                            <i class="fa fa-times disable-status"></i>
                                            @endif
                                        </td>
                                        </td>
                                        <td class="action">
                                            <div class="btn-group action-group">
                                                <a class="btn btn-default btn-sm" href="{{ route('productDetail') }}/{{$item->id}}">Xem</a>
                                                <button class="btn btn-default btn-sm dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false"></button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item delete" href="{{ route('deleteProduct') }}"
                                                            data-id="{{$item->id}}"><i class="fa-solid fa-xmark icon"></i>Xóa</a>
                                                    </li>
                                                    <li><a class="dropdown-item disable" href="{{ route('disableProduct') }}"
                                                            data-id="{{$item->id}}"><i class="fa-solid fa-power-off icon"></i>Vô
                                                            hiệu
                                                            hóa</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="table-bulk-action">
                                    <div class="dropdown">
                                        <button class="btn btn-orange btn-md dropdown-toggle" type="button"
                                            id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                            Hành động hàng loạt</button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <li><a class="dropdown-item delete" href="{{ route('deleteProduct') }}"><i
                                                        class="fa-solid fa-xmark icon"></i>Xóa</a></li>
                                            <li><a class="dropdown-item disable" href="{{ route('disableProduct') }}"><i
                                                        class="fa-solid fa-power-off icon"></i>Vô hiệu hóa</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 text-end">
                                {{ $products->links('vendor.pagination.custom') }}
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection