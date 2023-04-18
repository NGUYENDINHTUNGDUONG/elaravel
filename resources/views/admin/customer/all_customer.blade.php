@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Danh sách người dùng
    </div>

    <div class="table-responsive">
      <?php

      use Illuminate\Support\Facades\Session;

      $message = Session::get('message');
      if ($message) {
        echo '<span class="text-alert">', $message, '</span>';
        Session::put('message');
      }
      ?>
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th style="width:20px;">
              <label class="i-checks m-b-none">
                <input type="checkbox"><i></i>
              </label>
            </th>
            <th>Tên người dùng</th>
            <th>Email người dùng</th>
            <th>Số điện thoại</th>
            <th>Tài khoản khách vip</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          @foreach($all_customer as $key => $cus)
          <tr>
            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
            <td>{{$cus->customer_name}}</td>
            <td>{{$cus->customer_email}}</td>
            <td>{{$cus->customer_phone}}</td>
            <td>{{$cus->customer_vip}}</td>
            <td>
              <span class="text-ellipsis">
                <?php
                if ($cus->customer_vip == null) {
                ?>
                  <a href="{{URL::to('/unactive-vip/'.$cus->customer_id)}}"><span class="fa-thumb-styling fa fa-thumbs-down"></a>
                <?php
                } else {
                ?>
                  <a href="{{URL::to('/active-vip/'.$cus->customer_id)}}"><span class="fa-thumb-styling fa fa-thumbs-up"></a>
                <?php
                };
                ?>
              </span>
            </td>
            <td>
              <a href="{{URL::to('/edit-customer/'.$cus->customer_id)}}" class="active styling-edit" ui-toggle-class="">
                <i class="fa fa-pencil-square-o text-success text-active"></i>
              </a>
              <a onclick="return confirm('bạn có chắc là muốn xoá loại này ?')" href="{{URL::to('/delete-customer/'.$cus->customer_id)}}" class="active styling-edit" ui-toggle-class="">
                <i class="fa fa-times text-danger text"></i>
              </a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <footer class="panel-footer">
      <div class="row">
        <div class="col-sm-7 text-right text-center-xs">
          <ul class="pagination pagination-sm m-t-none m-b-none">
            {!!$all_customer->links()!!}
          </ul>
        </div>
      </div>
    </footer>
  </div>
</div>
@endsection