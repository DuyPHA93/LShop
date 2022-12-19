<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title')</title>

    <link rel="stylesheet" type="text/css" href="{{URL::asset('admin/plugins/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('admin/plugins/fontawesome/css/all.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('admin/plugins/sweetalert2/dist/sweetalert2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('admin/css/main.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('admin/css/header.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('admin/css/footer.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('admin/css/side-menu.css')}}">

    @yield('styles')
</head>

<body>
    <div class="header">
        <div class="container-left head-part-1">
            <div class="logo">
                <span class="mb-menu-btn"><i class="fa-solid fa-ellipsis-vertical"></i></span>
                <div>
                    <a href="#">Admin System</a>
                </div>
            </div>
        </div>
        <div class="container-right head-part-2">
            <div class="row">
                <div class="col-4">
                    <div id="search-bar">
                        <input type="text" name="headSearch" placeholder="Tìm kiếm...">
                        <button>
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </div>
                <div class="col-8">
                    <div class="head-menu text-end">
                        @auth
                        <div class="account-info noselect">
                            <div class="avatar">
                                <img alt="" src="{{URL::asset('admin/images/avatars/avatar.jpg')}}">
                            </div>
                            <div class="menu">
                                <div>
                                    <span>{{ Auth::user()->fullName() }}</span> <i
                                        class="icon fa-solid fa-caret-down"></i>
                                </div>
                                <ul class="hide">
                                    <li><a href="#"> <span class="menu-icon"><i class="fa-solid fa-gears"></i></span>
                                            <span class="menu-text">Cài đặt</span>
                                        </a></li>
                                    <li><a href="{{ route('logoutAdmin') }}">
                                            <span class="menu-icon"><i
                                                    class="fa-solid fa-right-from-bracket"></i></span> <span
                                                class="menu-text">Đăng xuất</span>
                                        </a></li>
                                </ul>
                            </div>
                        </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="side-menu">
            <div class="container-left">
                <ul class="menu">
                    <li class="menu-item">
                        <a href="{{ route('dashboard') }}">
                            <span class="menu-icon"><i class="fa-solid fa-gauge"></i></span>
                            <span class="menu-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('productTypeMasterList') }}">
                            <span class="menu-icon"><i class="fa-solid fa-laptop"></i></span>
                            <span class="menu-text">Loại sản phẩm</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('brandMasterList') }}">
                            <span class="menu-icon"><i class="fa-solid fa-bandage"></i></span>
                            <span class="menu-text">Nhãn hiệu</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('productMasterList') }}">
                            <span class="menu-icon"><i class="fa-solid fa-boxes-stacked"></i></span>
                            <span class="menu-text">Sản phẩm</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('featuredProductMasterList') }}">
                            <span class="menu-icon"><i class="fa-brands fa-product-hunt"></i></span>
                            <span class="menu-text">Sản phẩm nổi bật</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('userMasterList') }}">
                            <span class="menu-icon"><i class="fa-solid fa-users"></i></span>
                            <span class="menu-text">Người dùng</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('orderMasterList') }}">
                            <span class="menu-icon"><i class="fa-solid fa-boxes-packing"></i></span>
                            <span class="menu-text">Đơn hàng</span>
                        </a>
                    </li>
                </ul>
            </div>

        </div>

        @yield('content')
    </div>

    <div class="footer">
        All Rights Reserved. Design Webside <a href="#">duyphaFX16686</a>
    </div>
</body>

<script type="text/javascript" src="{{URL::asset('admin/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('admin/plugins/fontawesome/js/all.min.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('admin/plugins/jquery/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('admin/plugins/sweetalert2/dist/sweetalert2.all.min.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('admin/js/header.js')}}"></script>

@yield('script')

</html>