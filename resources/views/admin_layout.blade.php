<!--A Design by W3layouts
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>

<head>
	<title>Dashboard</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="Visitors Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template,
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
	<script type="application/x-javascript">
		addEventListener("load", function() {
			setTimeout(hideURLbar, 0);
		}, false);

		function hideURLbar() {
			window.scrollTo(0, 1);
		}
	</script>
	<!-- bootstrap-css -->
	<link rel="stylesheet" href="{{asset('backend/css/bootstrap.min.css')}}">
	<!-- //bootstrap-css -->
	<!-- Custom CSS -->
	<link href="{{asset('backend/css/style.css')}}" rel='stylesheet' type='text/css' />
	<link href="{{asset('backend/css/style-responsive.css')}}" rel="stylesheet" />
	<!-- font CSS -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
	<!-- font-awesome icons -->
	<link rel="stylesheet" href="{{asset('backend/css/font.css')}}" type="text/css" />
	<link href="{{asset('backend/css/font-awesome.css')}}" rel="stylesheet">
	<link rel="stylesheet" href="{{asset('backend/css/morris.css')}}" type="text/css" />
	<!-- calendar -->
	<link rel="stylesheet" href="{{asset('backend/css/monthly.css')}}">
	<!-- //calendar -->
	<!-- //font-awesome icons -->
	<script src="{{asset('backend/js/jquery2.0.3.min.js')}}"></script>
	<script src="{{asset('backend/js/raphael-min.js')}}"></script>
	<script src="{{asset('backend/js/morris.js')}}"></script>
</head>

<body>
	<section id="container">
		<!--header start-->
		<header class="header fixed-top clearfix">
			<!--logo start-->
			<div class="brand">
				<a href="index.html" class="logo">
					Admin
				</a>
				<div class="sidebar-toggle-box">
					<div class="fa fa-bars"></div>
				</div>
			</div>
			<!--logo end-->
			<div class="nav notify-row" id="top_menu">
			</div>
			<div class="top-nav clearfix">
				<!--search & user info start-->
				<ul class="nav pull-right top-menu">
					<li>
						<input type="text" class="form-control search" placeholder=" Search">
					</li>
					<!-- user login dropdown start-->
					<li class="dropdown">
						<a data-toggle="dropdown" class="dropdown-toggle" href="#">
							<img alt="" src="{{asset('backend/images/logo.webp')}}">
							<span class="username">
								<?php

								use Illuminate\Support\Facades\Session;

								$name = Session::get('admin_name');
								if ($name) {
									echo $name;
								}
								?>
							</span>
							<b class="caret"></b>
						</a>
						<ul class="dropdown-menu extended logout">
							<li><a href="#"><i class=" fa fa-suitcase"></i>Profile</a></li>
							<li><a href="#"><i class="fa fa-cog"></i> Cài đặt</a></li>
							<li><a href="{{URL::to('/logout')}}"><i class="fa fa-key"></i> Đăng xuất</a></li>
						</ul>
					</li>
					<!-- user login dropdown end -->

				</ul>
				<!--search & user info end-->
			</div>
		</header>
		<!--header end-->
		<!--sidebar start-->
		<aside>
			<div id="sidebar" class="nav-collapse">
				<!-- sidebar menu start-->
				<div class="leftside-navigation">
					<ul class="sidebar-menu" id="nav-accordion">
						<li>
							<a class="active" href="{{URL::to('/dashboard')}}">
								<i class="fa fa-dashboard"></i>
								<span>Tổng quan</span>
							</a>
						</li>
						<!-- <li class="sub-menu">
							<a href="javascript:;">
								<i class="fa fa-book"></i>
								<span>Slider</span>
							</a>
							<ul class="sub">
								<li><a href="{{URL::to('/manage-slider')}}">Liệt kê slider</a></li>
								<li><a href="{{URL::to('/add-slider')}}">Thêm slider</a></li>
							</ul>
						</li> -->
						<li class="sub-menu">
							<a href="javascript:;">
								<i class="fa fa-book"></i>
								<span>Đơn hàng</span>
							</a>
							<ul class="sub">
								<li><a href="{{URL::to('/manage-order/')}}">Quản lý đơn hàng</a></li>
							</ul>
						</li>
						<li class="sub-menu">
							<a href="javascript:;">
								<i class="fa fa-book"></i>
								<span>Mã giảm giá</span>
							</a>
							<ul class="sub">
								<li><a href="{{URL::to('/add-coupon')}}">Thêm mã giảm giá</a></li>
								<li><a href="{{URL::to('/list-coupon')}}">Liệt kê mã giảm giá</a></li>
							</ul>
						</li>
						<!-- <li class="sub-menu">
							<a href="javascript:;">
								<i class="fa fa-book"></i>
								<span>Vận chuyển</span>
							</a>
							<ul class="sub">
								<li><a href="{{URL::to('/delivery')}}">Quản lý vận chuyển</a></li>
							</ul>
						</li> -->
						<li class="sub-menu">
							<a href="javascript:;">
								<i class="fa fa-book"></i>
								<span>Sản phẩm</span>
							</a>
							<ul class="sub">
								<li><a href="{{URL::to('/add-product')}}">Thêm sản phẩm</a></li>
								<li><a href="{{URL::to('/all-product')}}">Liệt kê sản phẩm</a></li>
							</ul>
						</li>
						<li class="sub-menu">
							<a href="javascript:;">
								<i class="fa fa-book"></i>
								<span>Danh mục sản phẩm</span>
							</a>
							<ul class="sub">
								<li><a href="{{URL::to('/add-category-product')}}">Thêm danh mục sản phẩm</a></li>
								<li><a href="{{URL::to('/all-category-product')}}">Liệt kê danh mục sản phẩm</a></li>
							</ul>
						</li>
						<li class="sub-menu">
							<a href="javascript:;">
								<i class="fa fa-book"></i>
								<span>Loại sản phẩm</span>
							</a>
							<ul class="sub">
								<li><a href="{{URL::to('/add-brand-product')}}">Thêm loại sản phẩm</a></li>
								<li><a href="{{URL::to('/all-brand-product')}}">Liệt kê loại sản phẩm</a></li>
							</ul>
						</li>
						<li class="sub-menu">
							<a href="javascript:;">
								<i class="fa fa-book"></i>
								<span>Người đùng</span>
							</a>
							<ul class="sub">
								<li><a href="{{URL::to('/all-customer')}}">Danh sách người dùng</a></li>
							</ul>
						</li>
					</ul>
				</div>
				<!-- sidebar menu end-->
			</div>
		</aside>
		<!--sidebar end-->
		<!--main content start-->
		<section id="main-content">
			<section class="wrapper">
				@yield('admin_content')
			</section>
			<!-- footer -->
			<div class="footer">
				<div class="wthree-copyright">
					<p>© 2017 Visitors. All rights reserved | Design by <a href="http://w3layouts.com">Nhóm 12</a></p>
				</div>
			</div>
			<!-- / footer -->
		</section>
		<!--main content end-->
	</section>
	<script src="{{asset('backend/js/bootstrap.js')}}"></script>
	<script src="{{asset('backend/js/jquery.dcjqaccordion.2.7.js')}}"></script>
	<script src="{{asset('backend/js/scripts.js')}}"></script>
	<script src="{{asset('backend/js/jquery.slimscroll.js')}}"></script>
	<script src="{{asset('backend/js/jquery.nicescroll.js')}}"></script>
	<script src="{{asset('backend/ckeditor5-build-classic/ckeditor.js')}}"></script>

	<script src="https://cdn.ckeditor.com/ckeditor5/34.0.0/classic/ckeditor.js"></script>
	<script>
		ClassicEditor
			.create(document.querySelector('#editor1'))
	</script>
		<script>
		ClassicEditor
			.create(document.querySelector('#editor2'))
	</script>

	<script type="text/javascript" src="{{asset('backend/js/monthly.js')}}"></script>
	<script type="text/javascript">
		$('.order_details').change(function() {
			var order_status = $(this).val();
			var order_id = $(this).children(":selected").attr("id");
			var _token = $('input[name="_token"]').val();
			//lay ra so luong
			quantity = [];
			$("input[name='product_sales_quantity']").each(function() {
				quantity.push($(this).val());
			});
			//lay ra product id
			order_product_id = [];
			$("input[name='order_product_id']").each(function() {
				order_product_id.push($(this).val());
			});
			$.ajax({
				url: "{{url('/update-order-qty')}}",
				method: 'POST',
				data: {
					_token: _token,
					order_status: order_status,
					order_id: order_id,
					quantity: quantity,
					order_product_id: order_product_id
				},
				success: function(data) {
					alert('Thay đổi tình trạng đơn hàng thành công');
					location.reload();
				}
			});



		});
	</script>
	<script type="text/javascript">
		$(document).ready(function() {
			fetch_delivery();

			function fetch_delivery() {
				var _token = $('input[name="_token"]').val();
				$.ajax({
					url: '{{url("/select-feeship")}}',
					method: 'POST',
					data: {
						_token: _token
					},
					success: function(data) {
						$('#load_delivery').html(data);
					}
				});
			}
			$(document).on('blur', '.fee_feeship_edit', function() {

				var feeship_id = $(this).data('feeship_id');
				var fee_value = $(this).text();
				var _token = $('input[name="_token"]').val();
				// alert(feeship_id);
				// alert(fee_value);
				$.ajax({
					url: '{{url("/update-delivery")}}',
					method: 'POST',
					data: {
						feeship_id: feeship_id,
						fee_value: fee_value,
						_token: _token
					},
					success: function(data) {
						fetch_delivery();
					}
				});

			});
			$('.add_delivery').click(function() {
				var city = $('.city').val();
				var province = $('.province').val();
				var wards = $('.wards').val();
				var fee_ship = $('.fee_ship').val();
				var _token = $('input[name="_token"]').val();
				// alert(city);
				// alert(province);
				// alert(wards);
				// alert(fee_ship);
				$.ajax({
					url: '{{url("/insert-delivery")}}',
					method: 'POST',
					data: {
						city: city,
						province: province,
						_token: _token,
						wards: wards,
						fee_ship: fee_ship
					},
					success: function(data) {
						fetch_delivery();
					}
				});
			});
			$('.choose').on('change', function() {
				var action = $(this).attr('id');
				var ma_id = $(this).val();
				var _token = $('input[name="_token"]').val();
				var result = '';
				// alert(action);
				//  alert(matp);
				//   alert(_token);

				if (action == 'city') {
					result = 'province';
				} else {
					result = 'wards';
				}
				$.ajax({
					url: '{{url("/select-delivery")}}',
					method: 'POST',
					data: {
						action: action,
						ma_id: ma_id,
						_token: _token
					},
					success: function(data) {
						$('#' + result).html(data);
					}
				});
			});
		})
	</script>
</body>

</html>