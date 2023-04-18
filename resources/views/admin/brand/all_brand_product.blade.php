@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Liệt kê loại sản phẩm
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
            <th>Tên loại</th>
            <th>Hiển thị</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          @foreach($all_brand_product as $key => $brand_pro)
          <tr>
            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
            <td>{{$brand_pro->brand_name}}</td>
            <td>
              <span class="text-ellipsis">
                <?php
                if ($brand_pro->brand_status == 0) {
                ?>
                  <a href="{{URL::to('/unactive-brand-product/'.$brand_pro->brand_id)}}"><span class="fa-thumb-styling fa fa-thumbs-down"></a>
                <?php
                } else {
                ?>
                  <a href="{{URL::to('/active-brand-product/'.$brand_pro->brand_id)}}"><span class="fa-thumb-styling fa fa-thumbs-up"></a>
                <?php
                };
                ?>


              </span>
            </td>
            <td>
              <a href="{{URL::to('/edit-brand-product/'.$brand_pro->brand_id)}}" class="active styling-edit" ui-toggle-class="">
                <i class="fa fa-pencil-square-o text-success text-active"></i>
              </a>
              <a onclick="return confirm('bạn có chắc là muốn xoá loại này ?')" href="{{URL::to('/delete-brand-product/'.$brand_pro->brand_id)}}" class="active styling-edit" ui-toggle-class="">
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
            {!!$all_brand_product->links()!!}
          </ul>
        </div>
      </div>
    </footer>
  </div>
</div>
@endsection