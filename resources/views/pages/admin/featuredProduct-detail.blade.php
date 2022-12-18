@extends('layout/admin')

@section('title')
Chi tiết sản phẩm nổi bật
@endsection

@section('styles')
<link rel="stylesheet" type="text/css"
    href="{{URL::asset('admin/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.standalone.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{URL::asset('admin/css/panel-detail.css')}}">
@endsection

@section('script')
<script type="text/javascript" src="{{URL::asset('admin/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
<script type="text/javascript"
    src="{{URL::asset('admin/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('admin/js/panel-detail.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('admin/js/featured-product-detail.js')}}"></script>
@endsection

@section('content')

<div class="container-right">
    <div class="">
        <div class="head-section">
            <ul>
                <li><a href="{{ route('dashboard') }}">Trang chủ</a></li>
                <li><a href="{{ route('featuredProductMasterList') }}">Sản phẩm nổi bật</a></li>
                <li class="active">Chi tiết</li>
            </ul>
        </div>

        <div class="title-section">
            <h1>Chi tiết sản phẩm nổi bật</h1>
        </div>

        <div class="content-section">
            <form action="{{ route('saveFeaturedProduct', isset($featuredProduct) ? $featuredProduct->id : null) }}"
                method="POST" enctype="multipart/form-data" id="frm"
                data-list-url="{{ route('featuredProductMasterList') }}">
                @csrf

                <div class="panel-body">
                    @if (isset($featuredProduct))
                    <h2>
                        Chi tiết: <strong>{{ $featuredProduct->product->name }}</strong>
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
                                                @if (isset($featuredProduct) && $featuredProduct->active)
                                                <span class="status-icon active">Đang hoạt động</span>
                                                @elseif (isset($featuredProduct) && !$featuredProduct->active)
                                                <span class="status-icon disabled">Không hoạt động</span>
                                                @else
                                                <span class="status-icon active">Mới</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Được tạo ra vào</td>
                                            <td>{{ date_format(isset($featuredProduct) ? $featuredProduct->created_at : now(),'H:i d/m/Y') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Đã cập nhật vào</td>
                                            <td>{{ isset($featuredProduct) && !empty($featuredProduct->updated_at) ? date_format($featuredProduct->updated_at,'H:i d/m/Y') : null }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <!-- <div class="error-alert"><i class="fa-solid fa-triangle-exclamation"></i> Message</div> -->

                            <h3>Thông tin sản phẩm nổi bật</h3>
                            <div class="row mb-3">
                                <label class="col-md-3 d-form-label">Sản phẩm</label>
                                <div class="col-md-9">
                                    @if (isset($featuredProduct))
                                        <input type="text" class="d-form-control dw-75" value="[{{ $featuredProduct->product->code }}] {{ $featuredProduct->product->name }}" readonly>
                                        <input type="hidden" name="product" value="{{ $featuredProduct->product_id }}">
                                    @else
                                    <select name="product" class="d-form-control dw-75" required>
                                        <option value=""></option>
                                        @foreach($products as $product)
                                        <option value="{{ $product->id }}"
                                            {{ isset($featuredProduct) && $featuredProduct->product_id === $product->id ? 'selected' : null }}>
                                            [{{ $product->code }}] {{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                    @endif
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-md-3 d-form-label">Ngày bắt đầu</label>
                                <div class="col-md-9">
                                    <input type="text" name="startDate" class="d-form-control dw-75 {{ isset($featuredProduct) ? '' : 'datepicker'  }}" id="startDate"
                                        value="{{ isset($featuredProduct) ? date('d/m/Y', strtotime($featuredProduct->start_date)) : old('startDate') }}" {{ isset($featuredProduct) ? 'readonly' : '' }}
                                        required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-md-3 d-form-label">Ngày kết thúc</label>
                                <div class="col-md-9">
                                    <input type="text" name="endDate" class="d-form-control dw-75 datepicker"
                                        value="{{ isset($featuredProduct) ? date('d/m/Y', strtotime($featuredProduct->end_date)) : old('endDate') }}"
                                        required>
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