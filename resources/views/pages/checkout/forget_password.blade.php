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
          <h2>Điền email để lấy lại mật khẩu</h2>
          <form action="{{URL('/recover-pass')}}" method="post">
            @csrf
            <input type="text" name="email_account" placeholder="Tài khoản" />
            <button type="submit" class="btn btn-default">Gửi mail</button>
          </form>
        </div><!--/login form-->
      </div>
    </div>
  </div>
</section><!--/form-->
@endsection