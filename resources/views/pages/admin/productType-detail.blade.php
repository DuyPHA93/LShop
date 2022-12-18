@extends('layout/admin')

@section('title')
Chi tiết loại sản phẩm
@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="{{URL::asset('admin/css/panel-detail.css')}}">
<link rel="stylesheet" type="text/css" href="{{URL::asset('admin/css/product-type-detail.css')}}">
@endsection

@section('script')
<script type="text/javascript" src="{{URL::asset('admin/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('admin/js/panel-detail.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('admin/js/product-type-detail.js')}}"></script>
@endsection

@section('content')

<div class="container-right">
    <div class="">
        <div class="head-section">
            <ul>
                <li><a href="{{ route('dashboard') }}">Trang chủ</a></li>
                <li><a href="{{ route('productTypeMasterList') }}">Loại sản phẩm</a></li>
                <li class="active">Chi tiết</li>
            </ul>
        </div>

        <div class="title-section">
            <h1>Chi tiết loại sản phẩm</h1>
        </div>

        <div class="content-section">
            <form action="{{ route('saveProductType', isset($productType) ? $productType->id : null) }}" method="POST"
                enctype="multipart/form-data" id="frm" data-list-url="{{ route('productTypeMasterList') }}">
                @csrf

                <div class="panel-body">
                    @if (isset($productType))
                    <h2>
                        Chi tiết: <strong>{{ $productType->name }}</strong>
                    </h2>
                    @else
                    <h2>
                        <strong>Tạo mới</strong>
                    </h2>
                    @endif

                    <div class="row mt-5">
                        <div class="col-md-3">
                            <div class="history-table mb-4">
                                <table class="table table-striped table-hover">
                                    <tbody>
                                        <tr>
                                            <td>Trạng thái</td>
                                            <td>
                                                @if (isset($productType) && $productType->active)
                                                <span class="status-icon active">Đang hoạt động</span>
                                                @elseif (isset($productType) && !$productType->active)
                                                <span class="status-icon disabled">Không hoạt động</span>
                                                @else
                                                <span class="status-icon active">Mới</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Được tạo ra vào</td>
                                            <td>{{ date_format(isset($productType) ? $productType->created_at : now(),'H:i d/m/Y') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Đã cập nhật vào</td>
                                            <td>{{ isset($productType) && !empty($productType->updated_at) ? date_format($productType->updated_at,'H:i d/m/Y') : null }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-9">
                            @if($errors->any())
                            <div class="error-alert"><i class="fa-solid fa-triangle-exclamation"></i>
                                {{ $errors->all()[0] }}</div>
                            @endif

                            <h3>Thông tin loại sản phẩm</h3>
                            <div class="row mb-3">
                                <label class="col-md-3 d-form-label">Mã</label>
                                <div class="col-md-9">
                                    <input type="text" name="code" class="d-form-control dw-75"
                                        value="{{ isset($productType) ? $productType->code : old('code') }}"
                                        {{ isset($productType) ? 'readonly' : null }} required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-md-3 d-form-label">Tên</label>
                                <div class="col-md-9">
                                    <input type="text" name="name" class="d-form-control dw-75"
                                        value="{{ isset($productType) ? $productType->name : old('name') }}" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-md-3 d-form-label">Ảnh đại diện</label>
                                <div class="col-md-9">
                                    <div class="file-upload">
                                        <input type="file" name="file" id="_file">
                                        <label for="_file">
                                            <img id="result_photo" alt=""
                                                src="{{ asset('') }}{{ isset($productType) ? $imgSrc : '' }}"
                                                onerror="this.style.display='none'">
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-md-3 d-form-label">Hoạt động</label>
                                <div class="col-md-9">
                                    <label class="check-switch" for="_active">
                                        <input type="checkbox" name="active" id="_active"
                                            {{ (isset($productType) && $productType->active) || old('active') ? 'checked' : null }}>
                                        <span class="checkmark">
                                            <span class="pivot">
                                                <span class="checked"><i class="fas fa-check"></i></span>
                                                <span class="uncheck"><i class="fas fa-times"></i></span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                            </div>


                            <div class="row mt-5">
                                <div class="col-md-3 finish-row">
                                    <button class="btn btn-finish" id="save_btn">
                                        <i class="fa-solid fa-circle-check icon"></i>Lưu lại
                                    </button>
                                </div>
                                <div class="col-md-9">
                                    <button class="btn btn-cancel" id="cancel_btn">
                                        <i class="fa-solid fa-circle-xmark icon"></i>Hủy
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection