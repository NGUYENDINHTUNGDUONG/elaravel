@extends('admin_layout')
@section('admin_content')
<div class="row">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        Cập sản phẩm sản phẩm
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
          @foreach($edit_product as $key => $edit_product)
          <form role="form" action="{{URL::to('/update-product/'.$edit_product->product_id )}}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="form-group">
              <label for="exampleInputEmail1">Tên sản phẩm</label>
              <input type="text" name="product_name" class="form-control" id="exampleInputEmail1" value="{{$edit_product->product_name}}">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Giá sản phẩm</label>
              <input type="text" name="product_price" class="form-control" id="exampleInputEmail1" value="{{$edit_product->product_price}}">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">hình ảnh sản phẩm</label>
              <input type="file" name="product_image" class="form-control" id="exampleInputEmail1" placeholder="hình ảnh sản phẩm">
              <img src="{{URL::to('public/upload/product/'.$edit_product->product_image)}}" alt="" height="100px" width="150px">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Mô tả sản phẩm</label>
              <textarea style="resize: none" row="8" class="form-control" id="editor1" name="product_desc" placeholder="Mô tả sản phẩm"></textarea>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Nội dung sản phẩm</label>
              <textarea style="resize: none" row="8" class="form-control" id="editor2" name="product_content" placeholder="Nội dung sản phẩm"></textarea>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Danh mục sản phẩm</label>
              <select name="category_product" class="form-control input-sm m-bot15">
                @foreach($cate_product as $key=> $cate)
                @if($cate->category_id == $edit_product->category_id)
                <option selected value="{{$cate->category_id}}">{{$cate->category_name}}</option>
                @else
                <option value="{{$cate->category_id}}">{{$cate->category_name}}</option>
                @endif
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Thương hiệu</label>
              <select name="brand_product" class="form-control input-sm m-bot15">
                @foreach($brand_product as $key=> $brand)
                @if($brand->brand_id == $edit_product->brand_id)
                <option selected value="{{$brand->brand_id}}">{{$brand->brand_name}}</option>
                @else
                <option value="{{$brand->brand_id}}">{{$brand->brand_name}}</option>
                @endif
                @endforeach
              </select>
            </div>

            <button type="submit" name="update_product" class="btn btn-info">cập nhập sản phẩm</button>
          </form>
          @endforeach
        </div>
      </div>
    </section>
  </div>
</div>
@endsection