@extends('layout/admin')

@section('title')
Chi tiết người dùng
@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="{{URL::asset('admin/css/panel-detail.css')}}">
@endsection

@section('script')
<script type="text/javascript" src="{{URL::asset('admin/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('admin/js/panel-detail.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('admin/js/user-detail.js')}}"></script>
@endsection

@section('content')

<div class="container-right">
    <div class="">
        <div class="head-section">
            <ul>
                <li><a href="{{ route('dashboard') }}">Trang chủ</a></li>
                <li><a href="{{ route('userMasterList') }}">Người dùng</a></li>
                <li class="active">Chi tiết</li>
            </ul>
        </div>

        <div class="title-section">
            <h1>Chi tiết người dùng</h1>
        </div>

        <div class="content-section">
            <form action="{{ route('saveUser', isset($user) ? $user->id : null) }}" method="POST"
                enctype="multipart/form-data" id="frm" data-list-url="{{ route('userMasterList') }}">
                @csrf

                <div class="panel-body">
                    @if (isset($user))
                    <h2>
                        Chi tiết: <strong>{{ $user->fullName() }}</strong>
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
                                                @if (isset($user) && $user->active)
                                                <span class="status-icon active">Đang hoạt động</span>
                                                @elseif (isset($user) && !$user->active)
                                                <span class="status-icon disabled">Không hoạt động</span>
                                                @else
                                                <span class="status-icon active">Mới</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Được tạo ra vào</td>
                                            <td>{{ date_format(isset($user) ? $user->created_at : now(),'H:i d/m/Y') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Đã cập nhật vào</td>
                                            <td>{{ isset($user) && !empty($user->updated_at) ? date_format($user->updated_at,'H:i d/m/Y') : null }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <!-- <div class="error-alert"><i class="fa-solid fa-triangle-exclamation"></i> Message</div> -->

                            <h3>Tài khoản người dùng</h3>
                            <div class="row mb-3">
                                <label class="col-md-3 d-form-label">Email</label>
                                <div class="col-md-9">
                                    <input type="text" name="email" class="d-form-control dw-75"
                                        value="{{ isset($user) ? $user->email : old('email') }}"
                                        {{ isset($user) ? 'readonly' : null }} required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-md-3 d-form-label">Mật khẩu</label>
                                <div class="col-md-9">
                                    <input type="password" name="password" class="d-form-control dw-75" {{ isset($user) ? '' : 'required' }}>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-md-3 d-form-label">Xác nhận mật khẩu</label>
                                <div class="col-md-9">
                                    <input type="password" name="confirmPassword" class="d-form-control dw-75" {{ isset($user) ? '' : 'required' }}>
                                </div>
                            </div>
                            <h3>Thông tin người dùng</h3>
                            <div class="row mb-3">
                                <label class="col-md-3 d-form-label">Họ</label>
                                <div class="col-md-9">
                                    <input type="text" name="firstName" class="d-form-control dw-75"
                                        value="{{ isset($user) ? $user->first_name : old('firstName') }}" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-md-3 d-form-label">Tên</label>
                                <div class="col-md-9">
                                    <input type="text" name="lastName" class="d-form-control dw-75"
                                        value="{{ isset($user) ? $user->last_name : old('lastName') }}" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-md-3 d-form-label">Số điện thoại</label>
                                <div class="col-md-9">
                                    <input type="text" name="phone" class="d-form-control dw-75"
                                        value="{{ isset($user) ? $user->phone : old('phone') }}" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-md-3 d-form-label">Vai trò</label>
                                <div class="col-md-9">
                                    <select class="d-form-control dw-75" name="role" required>
                                        <option value=""></option>
                                        <option value="1" {{ ( isset($user) && $user->role_id == 1) ? 'selected' : '' }}>Quản trị viên</option>
                                        <option value="2" {{ ( isset($user) && $user->role_id == 2) ? 'selected' : '' }}>Người mua</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-md-3 d-form-label">Hoạt động</label>
                                <div class="col-md-9">
                                    <label class="check-switch" for="_active">
                                        <input type="checkbox" name="active" id="_active"
                                            {{ (isset($user) && $user->active) || old('active') ? 'checked' : null }}>
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