@extends('layout/admin')

@section('title')
Quản lý sản phẩm nổi bật
@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="{{URL::asset('admin/css/panel-list.css')}}">

<style>
#table_wraper tbody img {
    width: 60px;
    max-width: 100%;
    vertical-align: middle;
}
</style>
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
                <li class="active">Sản phẩm nổi bật</li>
            </ul>
        </div>

        <div class="title-section">
            <h1>Sản phẩm nổi bật</h1>

            <div class="menu-link">
                <span class="item"> <a href="{{ route('featuredProductDetail') }}"><i class="fa-solid fa-plus icon"></i>Thêm sản phẩm nổi bật</a>
                </span>
            </div>
        </div>

        <div class="content-section">
            <div class="panel-body">
                <div>
                    <h2>Sản phẩm nổi bật</h2>
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
                                    </select> trong {{ $featuredProducts->total() }} kết quả
                                </div>
                            </div>
                            <div class="col-sm-6 text-end">
                                <div class="table-search">
                                    <select name="search" class="" id="select_filter">
                                        <option value="1" {{ (request()->query('search') == 1) ? 'selected' : ''}}>Đang hoạt động</option>
                                        <option value="2" {{ (request()->query('search') == 2) ? 'selected' : ''}}>Không hoạt động</option>
                                        <option value="3" {{ (request()->query('search') == 3) ? 'selected' : ''}}>Hết kỳ hạn</option>
                                        <option value="0" {{ (request()->query('search') == 0) ? 'selected' : ''}}>Hiển thị tất cả</option>
                                    </select>
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
                                        <th style="min-width:92px">Ảnh</th>
                                        <th>Tên sản phẩm</th>
                                        <th style="min-width:135px">Ngày bắt đầu</th>
                                        <th style="min-width:140px">Ngày kết thúc</th>
                                        <th class="text-center" style="min-width:120px">Trạng thái</th>
                                        <th class="action" style="min-width:120px"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($featuredProducts as $item)
                                    <tr>
                                        <td class="choosen"><input class="form-check-input choose" type="checkbox"
                                                value="">
                                        </td>
                                        <td>{{ str_pad($item->id,4,'0',STR_PAD_LEFT) }}</td>
                                        <td>
                                        <a href="{{ route('featuredProductDetail') }}/{{$item->id}}"><img alt="" src="{{ url('') }}/{{ $item->imgSrc }}"></a>
                                        </td>
                                        <td style="width: 40%">{{$item->product->name}}</td>
                                        <td>{{ date('d/m/Y', strtotime($item->start_date)) }}</td>
                                        <td>{{ date('d/m/Y', strtotime($item->end_date)) }}</td>
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
                                                <a class="btn btn-default btn-sm" href="{{ route('featuredProductDetail') }}/{{$item->id}}">Xem</a>
                                                <button class="btn btn-default btn-sm dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false"></button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item delete" href="{{ route('deleteFeaturedProduct') }}"
                                                            data-id="{{$item->id}}"><i class="fa-solid fa-xmark icon"></i>Xóa</a>
                                                    </li>
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
                                            <li><a class="dropdown-item delete" href="{{ route('deleteFeaturedProduct') }}"><i
                                                        class="fa-solid fa-xmark icon"></i>Xóa</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 text-end">
                                {{ $featuredProducts->links('vendor.pagination.custom') }}
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection