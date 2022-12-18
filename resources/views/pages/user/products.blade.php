<?php
    use App\Services\ProductTypeService;
?>

@section('title')
Cửa hàng sản phẩm
@endsection

@extends('layout/user')

@section('styles')
<link rel="stylesheet" type="text/css" href="css/products.css">
@endsection

@section('script')
<script src="js/products.js"></script>
@endsection

@section('content')

<div class="wrapper pb-5">
    <div class="row mt-4">
        <div class="col-md-12 col-lg-6">
            <div class="page-title">
                <span><a href="{{ url('') }}">Trang chủ</a></span>
                <!-- <span class="active">Sản phẩm</span> -->
                @if (request()->query('search'))
                    <span><a href="{{ route('products') }}">Sản phẩm</a></span> 
					<span class="active">Kết quả tìm kiếm cho "{{ request()->query('search') }}"</span>
                @elseif (request()->query('type'))
                    <span class="active">{{ $products->productTypeName }}</span>
                @elseif (request()->query('brand'))
                    <span><a href="{{ route('products') }}?type={{ $products->productTypeId }}">{{ $products->productTypeName }}</a></span> 
					<span class="active">{{ $products->brandName }}</span>
                @else
                    <span class="active">Sản phẩm</span> 
                @endif
            </div>
        </div>
        <div class="col-md-12 col-lg-6 text-end">
            @if ($products->total() > 0)
            <div class="sort-choosen">
                @if ($products->currentPage() == $products->lastPage())
                <span>Hiển thị một kết quả duy nhất</span> 
                @else
                <span>Hiển thị {{ $products->from }}–{{ $products->to }} trong {{ $products->total() }} kết quả</span>
                @endif

                <select name="sort">
                    <option value="">Thứ tự mặc định</option>
                    <option value="1">Thứ tự theo mức độ phổ biến</option>
                    <option value="2">Mới nhất</option>
                    <option value="3">Thứ tự theo giá: thấp đến cao</option>
                    <option value="4">Thứ tự theo giá: cao xuống thấp</option>
                </select>
            </div>
            @endif
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-3 d-none d-lg-block">
            <div class="product-category-side">
                <h3>Danh mục sản phẩm</h3>
                <div class="divider"></div>
                <ul class="menu">
                    @foreach(ProductTypeService::getCategoryMenu() as $item)
                    <li>
                        <a href="{{ route('products') }}?type={{ $item->id }}">
                            <span class="menu-icon"><img alt="" src="{{ url('') }}/{{ $item->imgSrc }}"></span>
                            <span class="menu-text">{{ $item->name }}</span>
                        </a>
                        @if($item->availableBrands()->count() > 0)
                        <span class="menu-badge no-select"><i class="fa-solid fa-angle-down"></i></span>
                        <ul class="submenu">
                            @foreach($item->availableBrands() as $subItem)
                            <li><a href="{{ route('products') }}?brand={{ $subItem->id }}">{{ $subItem->name }}</a></li>
                            @endforeach
                        </ul>
                        @endif
                    </li>
                    @endforeach
                </ul>
            </div>

            <div class="products-side">
                <h3>Sản Phẩm</h3>
                <div class="divider"></div>
                <div class="products">
                    @foreach($randomProducts as $item)
                    <div class="item">
                        <a href="{{ route('detail', $item->id) }}"> <img alt="{{ $item->name }}"
                                src="{{ url('') }}/{{ $item->imgSrc }}">
                            <p class="name">{{ $item->name }}</p>
                        </a> <span class="price">
                            @currency {{ $item->price }} @endcurrency
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-9">
            @if (empty($products) || $products->count() == 0)
            <p>Không tìm thấy sản phẩm nào khớp với lựa chọn của bạn.</p>
            @else
            <div class="products-list blur-hover mb-5 large-columns-4 meidum-columns-3 small-columns-2">
                @foreach($products as $item)
                <div class="col">
                    <div class="product-box">
                        <div class="photo">
                            <a href="{{ route('detail', $item->id) }}"> <img alt=""
                                    src="{{ url('') }}/{{ $item->imgSrc }}">
                            </a>
                        </div>
                        <div class="box-text text-center">
                            <p class="name">
                                <a href="{{ route('detail', $item->id) }}">{{ $item->name }}</a>
                            </p>
                            <p class="price">
                                @currency {{ $item->price }} @endcurrency
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{ $products->links('vendor.pagination.products') }}
            @endif
        </div>
    </div>
</div>

@endsection