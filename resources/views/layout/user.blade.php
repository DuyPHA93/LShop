<?php
    use App\Services\ProductTypeService;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>

    <link rel='stylesheet' type='text/css' href="{{URL::asset('plugins/bootstrap/css/bootstrap.min.css')}}">
    <link rel='stylesheet' type='text/css' href="{{URL::asset('plugins/fontawesome/css/all.min.css')}}">
    <link rel='stylesheet' type='text/css' href="{{URL::asset('plugins/magnific-popup/dist/magnific-popup.css')}}">
    <link rel='stylesheet' type='text/css' href="{{URL::asset('css/main.css')}}">
    <link rel='stylesheet' type='text/css' href="{{URL::asset('css/category.css')}}">
    <link rel='stylesheet' type='text/css' href="{{URL::asset('css/header.css')}}">
    <link rel='stylesheet' type='text/css' href="{{URL::asset('css/footer.css')}}">

    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Noto+Sans&family=Roboto&display=swap"
        rel="stylesheet">

    @yield('styles')
</head>

<body>
    <div class='header'>
        <div class='wrapper'>
            <div class='top-head d-flex align-items-center'>
                <div class='for-mobile d-lg-none'>
                    <span id='nav-button'><i class='fa-solid fa-bars'></i></span>
                    <span id='search-button'><i class='fa-solid fa-magnifying-glass'></i></span>
                </div>
                <div id='logo'>
                    <a href="{{ url('') }}"><img alt='Logo' src="{{ URL::asset('logo.png') }}"></a>
                </div>
                <div class='d-flex w-100'>
                    <div class='flex-grow-1'>
                        <form action="{{ route('products') }}" method='GET'>
                            <div id='search-bar'>
                                <input type='text' name="search" placeholder='Gõ từ khóa tìm kiếm...'
                                    value="{{ request()->query('search') }}" />
                                <button>
                                    <i class='fa-solid fa-magnifying-glass'></i>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class='flex-grow-1 d-none d-lg-block'>
                        <div class='d-flex m-1'>
                            @guest
                            <div class='box-link'>
                                <a href='login'>Đăng nhập</a>
                            </div>
                            <div class='box-link'>
                                <a href='register'>Đăng ký</a>
                            </div>
                            @endguest
                            @auth
                            <div class="box-link">
                                <a href="{{ route('myOrderList') }}">Xin chào, {{ Auth::user()->fullName() }}</a>
                            </div>
                            <div class="box-link">
                                <a href="{{ route('logoutUser') }}">Đăng xuất</a>
                            </div>
                            @endauth

                            <div class='box-link'>
                                <a class='cart-link' href="{{ route('cart') }}">
                                    Giỏ hàng /
                                    @currency
                                    {{ (Session::get('cart') != null) ? Session::get('cart')['totalAmount'] : 0}}
                                    @endcurrency
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class='navigation-bar d-none d-lg-block'>
            <div class='wrapper d-flex align-items-center'>
                <div class="mobile-mfp-popup category-main-popup">
                    <div class='category'>
                        <div class='caption no-select'>
                            <span class='c-icon'><i class='fa-solid fa-bars'></i></span>
                            <span>Danh mục sản phẩm</span>
                        </div>
                        <ul class='menu' style="{{ (isset($isHome) && $isHome) ? '' : 'display: none;' }}">
                            @foreach(ProductTypeService::getCategoryMenu() as $item)
                            <li>
                                <a href="{{ route('products') }}?type={{ $item->id }}">
                                    <span class='menu-icon'>
                                        <img alt='' src="{{ url('') }}/{{ $item->imgSrc }}">
                                    </span>
                                    <span class='menu-text'>{{ $item->name }}</span>
                                    @if ($item->availableBrands()->count() > 0)
                                    <span class="menu-badge"><i class="fas fa-chevron-right icon"></i></span>
                                    @endif
                                </a>
                                @if($item->availableBrands()->count() > 0)
                                <ul class='sub-menu'>
                                    @foreach($item->availableBrands() as $subItem)
                                    <li><a
                                            href="{{ route('products') }}?brand={{ $subItem->id }}">{{ $subItem->name }}</a>
                                    </li>
                                    @endforeach
                                </ul>
                                @endif
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <ul class='navigation flex-grow-1'>
                    <li><a href='#'>Trang chủ</a></li>
                    <li><a href='#'>Giới thiệu</a></li>
                    <li><a href="{{ route('products') }}">Sản phẩm</a></li>
                    <li><a href='#'>Tin tức</a></li>
                    <li><a href='#'>Liên hệ</a></li>
                </ul>
            </div>
        </div>
        @if (isset($isHome) && $isHome)
        <div class='bottom-head'>
            <div class='wrapper'>
                <div id='banner'>
                    <img alt='Banner' src="{{ URL::asset('banner.jpg') }}">
                </div>
                <div class='left-ad'>

                </div>
            </div>
        </div>
        @endif
    </div>

    @yield('content')

    <div class='footer'>
        <div class='wrapper'>
            © All rights reserved. Design Website <a href='#'>duyphaFX6686</a>
        </div>
    </div>
</body>

<script type='text/javascript' src="{{URL::asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script type='text/javascript' src="{{URL::asset('plugins/jquery/jquery.min.js')}}"></script>
<script type='text/javascript' src="{{URL::asset('plugins/magnific-popup/dist/jquery.magnific-popup.js')}}"></script>
<script type='text/javascript' src="{{URL::asset('js/layout.js')}}"></script>
<script type='text/javascript' src="{{URL::asset('js/category.js')}}"></script>

@yield('script')

</html>