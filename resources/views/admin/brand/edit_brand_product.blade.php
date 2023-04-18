@extends('admin_layout')
@section('admin_content')
<div class="row">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        Cập loại sản phẩm
      </header>
      <?php

      use Illuminate\Support\Facades\Session;

      $message = Session::get('message');
      if ($message) {
        echo '<span class="text-alert">', $message, '</span>';
        Session::put('message');
      }
      ?>
      <div class="panel-body">
        <div class="position-center">
          <form role="form" action="{{URL::to('/update-brand-product/'.$edit_brand_product->brand_id )}}" method="post">
            {{csrf_field()}}
            <div class="form-group">
              <label for="exampleInputEmail1">Tên loại</label>
              <input type="text" value="{{$edit_brand_product->brand_name}}" name="brand_product_name" class="form-control" id="exampleInputEmail1" placeholder="Tên loại">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Mô tả loại</label>
              <textarea style="resize: none" row="8" class="form-control" id="exampleInputPassword1" name="brand_product_desc" >{{$edit_brand_product->brand_desc}}</textarea>
            </div>
            <button type="submit" name="update_brand_product" class="btn btn-info">Cập nhật loại</button>
          </form>
        </div>
      </div>
    </section>

  </div>
</div>
@endsection