@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Liệt kê danh mục sản phẩm
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
            <th>Tên danh mục</th>
            <th>Hiển thị</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          @foreach($all_category_product as $key => $cate_pro)
          <tr>
            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
            <td>{{$cate_pro->category_name}}</td>
            <td>
              <span class="text-ellipsis">
                <?php
                if ($cate_pro->category_status == 0) {
                ?>
                  <a href="{{URL::to('/unactive-category-product/'.$cate_pro->category_id)}}"><span class="fa-thumb-styling fa fa-thumbs-down"></a>
                <?php
                } else {
                ?>
                  <a href="{{URL::to('/active-category-product/'.$cate_pro->category_id)}}"><span class="fa-thumb-styling fa fa-thumbs-up"></a>
                <?php
                };
                ?>


              </span>
            </td>
            <td>
              <a href="{{URL::to('/edit-category-product/'.$cate_pro->category_id)}}" class="active styling-edit" ui-toggle-class="">
                <i class="fa fa-pencil-square-o text-success text-active"></i>
              </a>
              <a onclick="return confirm('bạn có chắc là muốn xoá danh mục này ?')" href="{{URL::to('/delete-category-product/'.$cate_pro->category_id)}}" class="active styling-edit" ui-toggle-class="">
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
            {!!$all_category_product->links()!!}
          </ul>
        </div>
      </div>
    </footer>
  </div>
</div>
@endsection