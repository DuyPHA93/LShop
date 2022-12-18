<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập hệ thống</title>

    <link rel="stylesheet" type="text/css" href="{{URL::asset('admin/plugins/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('admin/css/login.css')}}">
</head>

<body>
    <form action="#" method="POST" id="frm">
        @csrf
        <input type="hidden" name="action" value="login">
        <div class="login-box">
            @if($errors->any())
            <p id="error"> <strong>Lỗi: </strong>{{ $errors->all()[0] }}</p>
            @endif

            <div class="form-group">
                <label>Email</label>
                <div>

                    <input type="text" placeholder="Email" name="email" value="">
                </div>
            </div>
            <div class="form-group">
                <label>Mật khẩu</label>
                <div>
                    <input type="password" placeholder="Mật khẩu" name="password">
                </div>
            </div>
            <div class="form-group">
                <button class="btn btn-primary login-button">Đăng nhập</button>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <input type="checkbox" id="remmember" name="remember" />
                    <label for="remmember">Nhớ tài khoản</label>
                </div>
                <div class="col-lg-6 text-end">
                    <a href="#">Quên mật khẩu ?</a>
                </div>
            </div>
        </div>
    </form>
</body>

</html>