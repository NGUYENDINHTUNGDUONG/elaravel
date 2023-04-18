@extends('admin_layout')
@section('admin_content')
<div class="row">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        Cập danh mục sản phẩm
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
          <form role="form" action="{{URL::to('/update-category-product/'.$edit_category_product->category_id )}}" method="post">
            {{csrf_field()}}
            <div class="form-group">
              <label for="exampleInputEmail1">Tên danh mục</label>
              <input type="text" value="{{$edit_category_product->category_name}}" name="category_product_name" class="form-control" id="exampleInputEmail1" placeholder="Tên danh mục">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Mô tả danh mục</label>
              <textarea style="resize: none" row="8" class="form-control" id="exampleInputPassword1" name="category_product_desc" >{{$edit_category_product->category_desc}}</textarea>
            </div>
            <button type="submit" name="update_category_product" class="btn btn-info">Cập nhật danh mục</button>
          </form>
        </div>

      </div>
    </section>

  </div>
</div>
@endsection