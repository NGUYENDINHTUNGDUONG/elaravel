@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Liệt kê mã giảm giá
    </div>

    <div class="table-responsive">
      <?php

      use Illuminate\Support\Facades\Session;

      $message = Session::get('message');
      if ($message) {
        echo '<span class="text-alert">' . $message . '</span>';
        Session::put('message', null);
      }
      ?>
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th>Tên mã giảm giá</th>
            <th>Ngày bắt đầu</th>
            <th>Ngày kết thúc</th>
            <th>Mã giảm giá</th>
            <th>Số lượng giảm giá</th>
            <th>Điều kiện giảm giá</th>
            <th>Số giảm</th>
            <th>Tình trạng</th>
            <th>Hết hạn</th>
            <th>Quản lý</th>
            <th>Gửi mã</th>
          </tr>
        </thead>
        <tbody>
          @foreach($coupon as $key => $cou)
          <tr>
            <td>{{ $cou->coupon_name }}</td>
            <td>{{ $cou->coupon_date_start }}</td>
            <td>{{ $cou->coupon_date_end }}</td>
            <td>{{ $cou->coupon_code }}</td>
            <td>{{ $cou->coupon_time }}</td>
            <!-- <td>{{ $cou->coupon_status }}</td> -->
            <td><span class="text-ellipsis">
                <?php
                if ($cou->coupon_condition == 1) {
                ?>
                  Giảm theo %
                <?php
                } else {
                ?>
                  Giảm theo tiền
                <?php
                }
                ?>
              </span>
            <td><span class="text-ellipsis">
                <?php
                if ($cou->coupon_condition == 1) {
                ?>
                  Giảm {{ $cou->coupon_number }} %
                <?php
                } else {
                ?>
                  Giảm {{ $cou->coupon_number }} đ
                <?php
                }
                ?>
              </span>
            </td>
            <td><span class="text-ellipsis">
                <?php
                if ($cou->coupon_status == 1) {
                ?>
                  <span style="color:green">Đang khích hoạt</span>
                <?php
                } else {
                ?>
                  <span style="color:red">Đã khoá</span>
                <?php
                }
                ?>
              </span></td>
            <td>
              <?php
              if ($cou->coupon_date_end > $today) {
              ?>
                <span style="color:green">Còn hạn</span>
              <?php
              } else {
              ?>
                <span style="color:green">Hết hạn</span>
              <?php
              }
              ?>
            </td>
            <td>
              <a onclick="return confirm('Bạn có chắc là muốn xóa mã này ko?')" href="{{URL::to('/delete-coupon/'.$cou->coupon_id)}}" class="active styling-edit" ui-toggle-class="">
                <i class="fa fa-times text-danger text"></i>
              </a>
            </td>
            <td>
              <p><a href="{{url('/send-coupon',[
              'start_date'=>$cou->coupon_date_start,
              'end_date'=>$cou->coupon_date_end,
              'coupon_time'=>$cou->coupon_time,
              'coupon_condition'=>$cou->coupon_condition,
              'coupon_number'=>$cou->coupon_number,
              'coupon_code'=>$cou->coupon_code
              ])}}" class="btn btn-default">Gửi mã giảm giá đến khách Vip</a></p>
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
            {!!$coupon->links()!!}
          </ul>
        </div>
      </div>
    </footer>
  </div>
</div>
@endsection