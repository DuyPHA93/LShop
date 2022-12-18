@extends('layout/user')

@section('title')
Đăng ký tài khoản
@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="css/register.css">
@endsection

@section('script')

@endsection

@section('content')

<div class="wrapper pt-5 pb-5">
	<form action="performRegister" method="POST" id="registerFrm">
		@csrf
		<input type="hidden" name="action" value="register">
		
		<h3>Đăng ký</h3>
		@if($errors->any())
            <p class="error"> <strong>Lỗi: </strong>{{ $errors->all()[0] }}</p>
        @endif
		
		<div class="row">
			<div class="col-md-12">
				<div class="d-input">
					<label>Email: <input type="text" name="email" placeholder="Email" value="">
					</label>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="d-input">
					<label>Mật khẩu: <input type="password" name="password" placeholder="Mật khẩu">
					</label>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="d-input">
					<label>Nhập lại mật khẩu: <input type="password" name="password_confirmation" placeholder="Nhập lại mật khẩu">
					</label>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="d-input">
					<label>Họ: <input type="text" name="firstName" placeholder="Họ" value="">
					</label>
				</div>
			</div>
			<div class="col-md-6">
				<div class="d-input">
					<label>Tên: <input type="text" name="lastName" placeholder="Tên" value="">
					</label>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="d-input">
					<label>Số điện thoại: <input type="text" name="phone" placeholder="Số điện thoại" value="">
					</label>
				</div>
			</div>
		</div>
		<div>
			<button>Đăng ký</button>
		</div>
		<div class="row">
			<div class="col-md-6">
				<a href='#'>Đăng nhập</a>
			</div>
			<div class="col-md-6 text-end">
				<a href='#'>Quên mật khẩu ?</a>
			</div>
		</div>
	</form>
</div>

@endsection