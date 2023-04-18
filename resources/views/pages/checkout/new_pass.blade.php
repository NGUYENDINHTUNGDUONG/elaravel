@extends('welcome')
<!-- extends:có nghĩa là mở rộng để lấy những thành phần thuộc welcome -->
@section('content')
<section id="form"><!--form-->
  <div class="container">
    <div class="row">
      <div class="col-sm-12 col-sm-offset-1">
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
        @php
        $token=$_GET['token'];
        $email=$_GET['email'];
        @endphp
          <h2>Điền mật khẩu mới</h2>
          <form action="{{URL('/reset-new-pass')}}" method="post">
            @csrf
            <input type="hidden" name="email" value="{{$email}}"/>
            <input type="hidden" name="token" value="{{$token}}"/>
            <input type="password" name="password_account" placeholder="mật khẩu mới" />
            <button type="submit" class="btn btn-default">Gửi</button>
          </form>
        </div><!--/login form-->
      </div>
    </div>
  </div>
</section><!--/form-->
@endsection