@extends('layout/admin')

@section('title')
Quản lý người dùng
@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="{{URL::asset('admin/css/panel-list.css')}}">
<link rel="stylesheet" type="text/css" href="{{URL::asset('admin/css/users-list.css')}}">
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
                <li class="active">Người dùng</li>
            </ul>
        </div>

        <div class="title-section">
            <h1>Người dùng</h1>

            <div class="menu-link">
                <span class="item"> <a href="{{ route('userDetail') }}"><i class="fa-solid fa-plus icon"></i>Thêm người dùng</a>
                </span>
            </div>
        </div>

        <div class="content-section">
            <div class="panel-body">
                <div>
                    <h2>Người dùng</h2>
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
                                    </select> trong {{ $users->total() }} kết quả
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
                                        <th style="min-width:80px">Id</th>
                                        <th style="min-width:95px">Ảnh</th>
                                        <th>Tên</th>
                                        <th>Email</th>
                                        <th style="min-width:155px">Số điện thoại</th>
                                        <th style="min-width:120px">Vai trò</th>
                                        <th class="text-center" style="min-width:120px">Trạng thái</th>
                                        <th class="action" style="min-width:130px"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $item)
                                    <tr>
                                        <td class="choosen">
                                            <input class="form-check-input choose" type="checkbox" value="">
                                        </td>
                                        <td>{{ str_pad($item->id,4,'0',STR_PAD_LEFT) }}</td>
                                        <td>
                                            <a href="{{ route('userDetail') }}/{{$item->id}}">
                                                @if (isset($item->imgSrc))
                                                    <img alt="" src="{{ url('') }}/{{ $item->imgSrc }}">
                                                @else
                                                    <img alt="" src="{{ url('admin/images') }}/default-avatar.png">
                                                @endif
                                            </a>
                                        </td>
                                        <td style="width: 40%">{{$item->fullName()}}</td>
                                        <td>{{$item->email}}</td>
                                        <td>{{$item->phone}}</td>
                                        <td>{{$item->role_id}}</td>
                                        <td class="text-center">
                                            @if ($item->active)
                                            <i class="fa fa-check check-status"></i>
                                            @else
                                            <i class="fa fa-times disable-status"></i>
                                            @endif
                                        </td>
                                        </c:otherwise>
                                        </c:choose>

                                        </td>
                                        <td class="action">
                                            <div class="btn-group action-group">
                                                <a class="btn btn-default btn-sm" href="{{ route('userDetail') }}/{{$item->id}}">Xem</a>
                                                <button class="btn btn-default btn-sm dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false"></button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item delete" href="{{ route('deleteUser') }}"
                                                            data-id="{{$item->id}}"><i class="fa-solid fa-xmark icon"></i>Xóa</a>
                                                    </li>
                                                    <li><a class="dropdown-item disable" href="{{ route('disableUser') }}"
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
                                            <li><a class="dropdown-item delete" href="{{ route('deleteUser') }}"><i
                                                        class="fa-solid fa-xmark icon"></i>Xóa</a></li>
                                            <li><a class="dropdown-item disable" href="{{ route('disableUser') }}"><i
                                                        class="fa-solid fa-power-off icon"></i>Vô hiệu hóa</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 text-end">
                                {{ $users->links('vendor.pagination.custom') }}
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection