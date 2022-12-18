@extends('layout/user')

@section('title')
Đăng nhập
@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="css/login.css">
@endsection

@section('script')

@endsection

@section('content')

<div class="wrapper pt-5 pb-5">
	<form action="login" method="POST" id="loginFrm">
		@csrf
		<h3>Đăng nhập</h3>
		@if($errors->any())
            <p class="error"> <strong>Lỗi: </strong>{{ $errors->all()[0] }}</p>
        @endif
		
		<div class="d-input">
			<label>Địa chỉ email * 
				<input type="text" name="email" placeholder="Địa chỉ email" value="">
			</label>
		</div>
		<div class="d-input">
			<label>Mật khẩu * 
				<input type="password" name="password" placeholder="Mật khẩu">
			</label>
		</div>
		<div>
			<button>Đăng nhập</button>
		</div>
		<div class="row">
			<div class="col-md-6">
				<label>
					<input type="checkbox" name="remember">
					Ghi nhớ tài khoản
				</label>
			</div>
			<div class="col-md-6 text-end">
				<a href="#">Quên mật khẩu ?</a>
			</div>
		</div>
	</form>
</div>

@endsection