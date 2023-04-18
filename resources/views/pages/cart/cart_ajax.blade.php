@extends('welcome')
<!-- extends:có nghĩa là mở rộng để lấy những thành phần thuộc welcome -->
@section('content')

<section id="cart_items">
	<div class="container">
		<div class="breadcrumbs">
			<ol class="breadcrumb">
				<li><a href="{{URL::to('/')}}">Trang chủ</a></li>
				<li class="active">Giỏ hàng của bạn</li>
			</ol>
		</div>
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
		<div class="table-responsive cart_info">

			<form action="{{url('/update-cart')}}" method="POST">
				@csrf
				<table class="table table-condensed">
					<thead>
						<tr class="cart_menu">
							<td class="image">Hình ảnh</td>
							<td class="description">Tên sản phẩm</td>
							<td class="price">Giá sản phẩm</td>
							<td class="quantity">Số lượng</td>
							<td class="total">Thành tiền</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
						@if(Session::get('cart')==true)
						@php
						$total = 0;
						@endphp
						@foreach(Session::get('cart') as $key => $cart)
						@php
						$subtotal = $cart['product_price']*$cart['product_qty'];
						$total+=$subtotal;
						@endphp
						<tr>
							<td class="cart_product">
								<img src="{{URL::to('/public/upload/product/'.$cart['product_image'])}}" width="90" alt="{{$cart['product_name']}}" />
							</td>
							<td class="cart_description">
								<h4><a href=""></a></h4>
								<p>{{$cart['product_name']}}</p>
							</td>
							<td class="cart_price">
								<p>{{number_format($cart['product_price'],0,',','.')}}đ</p>
							</td>
							<td class="cart_quantity">
								<div class="cart_quantity_button">
									<input class="cart_quantity" type="number" min="1" name="cart_qty[{{$cart['session_id']}}]" value="{{$cart['product_qty']}}" disabled>
								</div>
							</td>
							<td class="cart_total">
								<p class="cart_total_price">
									{{number_format($subtotal,0,',','.')}}đ
								</p>
							</td>
							<td class="cart_delete">
								<a class="cart_quantity_delete" href="{{url('/delete-cart-product/'.$cart['session_id'])}}"><i class="fa fa-times"></i></a>
							</td>
						</tr>

						@endforeach
						<tr>
							<td><input type="submit" value="Cập nhật giỏ hàng" name="update_qty" class="check_out btn btn-default btn-sm"></td>
							<td><a class="btn btn-default check_out" href="{{url('/delete-all-product')}}">Xóa tất cả</a></td>
							<td>
								@if(Session::get('customer_id'))
								<a class="btn btn-default check_out" href="{{url('/show-checkout')}}">Đặt hàng</a>
								@else
								<a class="btn btn-default check_out" href="{{url('/login-checkout')}}">Đặt hàng</a>
								@endif
							</td>
							<td colspan="2">
								<li>Tổng tiền :<span>{{number_format($total,0,',','.')}}đ</span></li>
							</td>
						</tr>
						@else
						<tr>
							<td colspan="5">
								<center>
									@php
									echo 'Làm ơn thêm sản phẩm vào giỏ hàng';
									@endphp
								</center>
							</td>
						</tr>
						@endif
					</tbody>
				</table>
			</form>
		</div>
	</div>
</section>
@endsection