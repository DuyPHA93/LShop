@extends('layout/user')

@section('title')
Chi tiết {{ $product->name }}
@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="{{URL::asset('css/detail.css')}}">
@endsection

@section('script')

@endsection

@section('content')

<div class="wrapper pb-5">
    <div class="row mt-4 mb-4">
        <div class="col-md-12">
            <div class="page-title">
                <span><a href="{{ url('') }}">Trang chủ</a></span>
                <span><a href="{{ route('products') }}?type={{ $product->productType->id }}">{{ $product->productType->name }}</a></span>
                @if (isset($product->brand))
                <span><a href="{{ route('products') }}?brand={{ $product->brand->id }}">{{ $product->brand->name }}</a></span>
                @endif
            </div>
        </div>
    </div>

    @if (Session::get('cart-msg') != null)
    <div id="success-msg">
        <span><i class="fa-solid fa-check"></i></span> {{Session::get('cart-msg')}}
    </div>
    @endif


    <div class="row mt-4">
        <div class="col-md-3 d-none d-md-block">
            <div class="products-side">
                <h3>Sản Phẩm</h3>
                <div class="divider"></div>
                <div class="products">
                    @foreach($randomProducts as $item)
                    <div class="item">
                        <a href="{{ route('detail', $item->id) }}"> <img alt="{{ $item->name }}" src="{{ url('') }}/{{ $item->imgSrc }}">
                            <p class="name">{{ $item->name }}</p>
                        </a> <span class="price">
                            @currency {{ $item->price }} @endcurrency
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <form action="{{ route('addToCart') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="photo-detail">
                            <img alt="{{ $product->name }}" src="{{ url('') }}/{{ $product->imgSrc }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info">
                            <h1>{{ $product->name }}</h1>
                            <div class="divider"></div>
                            <div class="price">
                                @currency {{ $product->price }} @endcurrency
                            </div>
                            <div class="description">
                                {!! $product->description !!}
                            </div>

                            <div>
                                <input type="hidden" name="id" value="{{ $product->id }}">
                                <input type="number" class="quantity" name="quantity" value="1">
                                <button class="add-to-cart-btn">THÊM VÀO GIỎ</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection