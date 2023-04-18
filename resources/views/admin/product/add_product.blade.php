@extends('admin_layout')
@section('admin_content')
<div class="row">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        Thêm sản phẩm sản phẩm
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
          <form role="form" action="{{URL::to('/save-product')}}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}

            <div class="form-group">
              <label for="exampleInputEmail1">Tên sản phẩm</label>
              <input type="text" data-validation="length" data-validation-length="min3" data-validation-error-msg="làm ơn điền ít nhất 3 ký tự" name="product_name" class="form-control" id="exampleInputEmail1" placeholder="Tên sản phẩm">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Giá sản phẩm</label>
              <input type="text" name="product_price" class="form-control" id="exampleInputEmail1" placeholder="giá sản phẩm">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">hình ảnh sản phẩm</label>
              <input type="file" name="product_image" class="form-control" id="exampleInputEmail1" placeholder="hình ảnh sản phẩm">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Mô tả sản phẩm</label>
              <textarea style="resize: none" row="8" class="form-control" id="ckeditor1" name="product_desc" placeholder="Mô tả sản phẩm"></textarea>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Nội dung sản phẩm</label>
              <textarea style="resize: none" row="8" class="form-control" id="ckeditor2" name="product_content" placeholder="Nội dung sản phẩm"></textarea>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Danh mục sản phẩm</label>
              <select name="category_product" class="form-control input-sm m-bot15">
                @foreach($cate_product as $key=> $cate)
                <option value="{{$cate->category_id}}">{{$cate->category_name}}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Loại sản phẩm</label>
              <select name="brand_product" class="form-control input-sm m-bot15">
                @foreach($brand_product as $key=> $brand)
                <option value="{{$brand->brand_id}}">{{$brand->brand_name}}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Hiển thị</label>
              <select name="product_status" class="form-control input-sm m-bot15">
                <option value="0">Ẩn</option>
                <option value="1">Hiển thị</option>
              </select>
            </div>
            <button type="submit" name="add_product" class="btn btn-info">Thêm sản phẩm</button>
          </form>
        </div>

      </div>
    </section>

  </div>
</div>

@endsection