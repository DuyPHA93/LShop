@extends('layout/admin')

@section('title')
Chi tiết sản phẩm
@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="{{URL::asset('admin/css/panel-detail.css')}}">
@endsection

@section('script')
<script type="text/javascript" src="{{URL::asset('admin/plugins/ckeditor/ckeditor.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('admin/plugins/ckfinder/ckfinder.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('admin/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('admin/js/panel-detail.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('admin/js/product-detail.js')}}"></script>
@endsection

@section('content')

<div class="container-right">
    <div class="">
        <div class="head-section">
            <ul>
                <li><a href="{{ route('dashboard') }}">Trang chủ</a></li>
                <li><a href="{{ route('productMasterList') }}">Sản phẩm</a></li>
                <li class="active">Chi tiết</li>
            </ul>
        </div>

        <div class="title-section">
            <h1>Chi tiết sản phẩm</h1>
        </div>

        <div class="content-section">
            <form action="{{ route('saveProduct', isset($product) ? $product->id : null) }}" method="POST" enctype="multipart/form-data" id="frm" data-list-url="{{ route('productMasterList') }}">
                @csrf

                <input type="hidden" id="product_id" value="{{ isset($product) ? $product->id : '' }}" >

                <div class="panel-body">
                    @if (isset($product))
                    <h2>
                        Chi tiết: <strong>{{ $product->name }}</strong>
                    </h2>
                    @else
                    <h2>
                        <strong>Tạo mới</strong>
                    </h2>
                    @endif

                    <div class="row mt-5">
                        <div class="col-md-3">
                            <div class="panel-upload mb-5">
                                <div class="photo">
                                    @if (isset($imgSrc))
                                        <img alt="" src="{{ asset('') }}{{ $imgSrc }}" id="result_photo">
                                    @else
                                        <img alt="" src="{{URL::asset('admin/images/add-image.png')}}" id="result_photo">
                                    @endif
                                </div>
                                <div class="text-center" id="file_errorMsg"></div>
                                <div class="upload">
                                    <input type="file" name="file" id="file_upload">
                                    <label for="file_upload" id="upload_btn"><i
                                            class="fa-solid fa-cloud-arrow-up icon"></i> Tải lên</label>
                                </div>
                            </div>
                            <div class="history-table mb-4">
                                <table class="table table-striped table-hover">
                                    <tbody>
                                        <tr>
                                            <td>Trạng thái</td>
                                            <td>
                                                @if (isset($product) && $product->active)
                                                <span class="status-icon active">Đang hoạt động</span>
                                                @elseif (isset($product) && !$product->active)
                                                <span class="status-icon disabled">Không hoạt động</span>
                                                @else
                                                <span class="status-icon active">Mới</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Được tạo ra vào</td>
                                            <td>{{ date_format(isset($product) ? $product->created_at : now(),'H:i d/m/Y') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Đã cập nhật vào</td>
                                            <td>{{ isset($product) && !empty($product->updated_at) ? date_format($product->updated_at,'H:i d/m/Y') : null }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <!-- <div class="error-alert"><i class="fa-solid fa-triangle-exclamation"></i> Message</div> -->

                            <h3>Thông tin sản phẩm</h3>
                            <div class="row mb-3">
                                <label class="col-md-3 d-form-label">Mã</label>
                                <div class="col-md-9">
                                    <input type="text" name="code" class="d-form-control dw-25" value="{{ isset($product) ? $product->code : old('code') }}" {{ isset($product) ? 'readonly' : null }} required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-md-3 d-form-label">Tên</label>
                                <div class="col-md-9">
                                    <input type="text" name="name" class="d-form-control dw-75" value="{{ isset($product) ? $product->name : old('name') }}" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-md-3 d-form-label">Mô tả</label>
                                <div class="col-md-9">
                                    <textarea rows="5" cols="" class="d-form-control dw-75" id="editor1" name="description" required>{{ isset($product) ? $product->description : old('description') }}</textarea>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-md-3 d-form-label">Hoạt động</label>
                                <div class="col-md-9">
                                    <label class="check-switch" for="_active">
                                        <input type="checkbox" name="active" id="_active" {{ (isset($product) && $product->active) || old('active') ? 'checked' : null }}>
                                        <span class="checkmark">
                                            <span class="pivot">
                                                <span class="checked"><i class="fas fa-check"></i></span>
                                                <span class="uncheck"><i class="fas fa-times"></i></span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-md-3 d-form-label">Giá</label>
                                <div class="col-md-9">
                                    <div class="d-input-group dw-25">
                                        <span class="d-input-group-text" id="basic-addon2">đ</span>
                                        <input type="text" class="d-form-control" name="price"
                                            value="{{ isset($product) ? $product->price : old('price') }}" aria-describedby="basic-addon2" required>
                                    </div>
                                </div>
                            </div>
                            <h3>Danh mục</h3>
                            <div class="row mb-3">
                                <label class="col-md-3 d-form-label">Loại</label>
                                <div class="col-md-9">
                                    <select class="d-form-control dw-25" name="productType" id="product_type_select" data-ajax-url="{{ route('getBrandHtml') }}" required>
                                        <option value=""></option>
                                        @foreach($productTypes as $productType)
                                        <option value="{{ $productType->id }}" {{ ( isset($product) && $product->product_type_id == $productType->id) ? 'selected' : '' }} >{{ $productType->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-md-3 d-form-label">Nhãn hiệu</label>
                                <div class="col-md-9">
                                    <select class="d-form-control dw-25" name="brand" id="brand_select">
                                        <option value=""></option>
                                        @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ ( isset($product) && $product->brand_id == $brand->id) ? 'selected' : '' }} >{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <h3>Số lượng trong kho</h3>
                            <div class="row mb-3">
                                <label class="col-md-3 d-form-label">Số lượng</label>
                                <div class="col-md-9">
                                    <input type="number" name="quantity" class="d-form-control dw-25" value="{{ isset($product) ? $product->quantity : old('quantity') }}" required>
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