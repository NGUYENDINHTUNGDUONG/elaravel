@extends('welcome')
<!-- extends:có nghĩa là mở rộng để lấy những thành phần thuộc welcome -->
@section('content')
<section id="form"><!--form-->

  <div class="container">
    <div class="row">
      <div class="col-sm-4 col-sm-offset-1">
      <?php

use Illuminate\Support\Facades\Session;

$message = Session::get('message');

?>
@if(session()->has('message'))
<div class="alert alert-success">
  {!! session()->get('message') !!}
</div>
@elseif(session()->has('error'))
<div class="alert alert-danger">
  {!! session()->get('error') !!}
</div>
@endif
        <div class="login-form"><!--login form-->
          <h2>Đăng nhập</h2>
          <form action="{{URL::to('/login-customer')}}" method="POST">
            {{csrf_field()}}
            <input type="text" name="email_account" placeholder="Tài khoản" />
            <input type="password" name="password_account" placeholder="Password" />
            <span>
              <input type="checkbox" class="checkbox">
              Ghi nhớ đăng nhập
            </span>
            <span>
              <a href="{{url('/forget-password')}}">quên mật khẩu</a>
            </span>
            <button type="submit" class="btn btn-default">Đăng nhập</button>
          </form>
        </div><!--/login form-->
      </div>
      <div class="col-sm-1">
        <h2 class="or">Hoặc</h2>
      </div>
      <div class="col-sm-4">
        <div class="signup-form"><!--sign up form-->
          <h2>Đăng ký!</h2>

          <form action="{{URL::to('/add-customer')}}" method="post">
            {{csrf_field()}}
            <input type="text" name="customer_name" placeholder="Họ và tên" />
            <input type="email" name="customer_email" placeholder="Địa chỉ mail" />
            <input type="password" name="customer_password" placeholder="Mật khẩu" />
            <input type="text" name="customer_phone" placeholder="Điện thoại" />
            <button type="submit" class="btn btn-default">Signup</button>
          </form>
        </div><!--/sign up form-->
      </div>
    </div>
  </div>
</section><!--/form-->
@endsection