@extends('admin_layout')
@section('admin_content')
<div class="row">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        Thêm loại sản phẩm
      </header>
      <div class="panel-body">
        <?php

        use Illuminate\Support\Facades\Session;

        $message = Session::get('message');
        if ($message) {
          echo '<span class="text-alert">', $message, '</span>';
          Session::put('message');
        }
        ?>
        <div class="position-center">
          <form role="form" action="{{URL::to('/save-brand-product')}}" method="post">
            {{csrf_field()}}
            <div class="form-group">
              <label for="exampleInputEmail1">Tên loại</label>
              <input type="text" name="brand_product_name" class="form-control" id="exampleInputEmail1" placeholder="Tên loại">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Mô tả loại</label>
              <textarea style="resize: none" row="8" class="form-control" id="exampleInputPassword1" name="brand_product_desc" placeholder="Mô tả loại"></textarea>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Hiển thị</label>
              <select name="brand_product_status" class="form-control input-sm m-bot15">
                <option value="0">Ẩn</option>
                <option value="1">Hiển thị</option>
              </select>
            </div>
            <button type="submit" name="add_brand_product" class="btn btn-info">Thêm loại</button>
          </form>
        </div>

      </div>
    </section>

  </div>
</div>
@endsection