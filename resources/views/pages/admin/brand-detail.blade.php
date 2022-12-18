@extends('layout/admin')

@section('title')
Chi tiết nhãn hiệu
@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="{{URL::asset('admin/css/panel-detail.css')}}">
@endsection

@section('script')
<script type="text/javascript" src="{{URL::asset('admin/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('admin/js/panel-detail.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('admin/js/brand-detail.js')}}"></script>
@endsection

@section('content')

<div class="container-right">
    <div class="">
        <div class="head-section">
            <ul>
                <li><a href="{{ route('dashboard') }}">Trang chủ</a></li>
                <li><a href="{{ route('brandMasterList') }}">Nhãn hiệu</a></li>
                <li class="active">Chi tiết</li>
            </ul>
        </div>

        <div class="title-section">
            <h1>Chi tiết nhãn hiệu</h1>
        </div>

        <div class="content-section">
            <form action="{{ route('saveBrand', isset($brand) ? $brand->id : null) }}" method="POST"
                enctype="multipart/form-data" id="frm" data-list-url="{{ route('brandMasterList') }}">
                @csrf

                <div class="panel-body">
                    @if (isset($brand))
                    <h2>
                        Chi tiết: <strong>{{ $brand->name }}</strong>
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
                                                @if (isset($brand) && $brand->active)
                                                <span class="status-icon active">Đang hoạt động</span>
                                                @elseif (isset($brand) && !$brand->active)
                                                <span class="status-icon disabled">Không hoạt động</span>
                                                @else
                                                <span class="status-icon active">Mới</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Được tạo ra vào</td>
                                            <td>{{ date_format(isset($brand) ? $brand->created_at : now(),'H:i d/m/Y') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Đã cập nhật vào</td>
                                            <td>{{ isset($brand) && !empty($brand->updated_at) ? date_format($brand->updated_at,'H:i d/m/Y') : null }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <!-- <div class="error-alert"><i class="fa-solid fa-triangle-exclamation"></i> Message</div> -->

                            <h3>Thông tin nhãn hiệu</h3>
                            <div class="row mb-3">
                                <label class="col-md-3 d-form-label">Mã</label>
                                <div class="col-md-9">
                                    <input type="text" name="code" class="d-form-control dw-75"
                                        value="{{ isset($brand) ? $brand->code : old('code') }}"
                                        {{ isset($brand) ? 'readonly' : null }} required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-md-3 d-form-label">Tên</label>
                                <div class="col-md-9">
                                    <input type="text" name="name" class="d-form-control dw-75"
                                        value="{{ isset($brand) ? $brand->name : old('name') }}" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-md-3 d-form-label">Loại sản phẩm</label>
                                <div class="col-md-9">
                                    <select name="productType" class="d-form-control dw-75" required>
                                        <option value=""></option>
                                        @foreach($productTypes as $productType)
                                        <option value="{{ $productType->id }}" {{ ( isset($brand) && $brand->product_type_id == $productType->id) ? 'selected' : '' }} >{{ $productType->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-md-3 d-form-label">Hoạt động</label>
                                <div class="col-md-9">
                                    <label class="check-switch" for="_active">
                                        <input type="checkbox" name="active" id="_active"
                                            {{ (isset($brand) && $brand->active) || old('active') ? 'checked' : null }}>
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