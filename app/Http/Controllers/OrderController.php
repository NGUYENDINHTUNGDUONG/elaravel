<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Shipping;
use App\Models\Customer;
use App\Models\Coupon;
use App\Models\Product;


use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\PDF;

class OrderController extends Controller
{
    public function print_order($checkout_code)
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->print_order_convert($checkout_code));

        return $pdf->stream();
    }
    public function print_order_convert($checkout_code)
    {
        $order_details = OrderDetails::where('order_code', $checkout_code)->get();
        $order = Order::where('order_code', $checkout_code)->get();
        foreach ($order as $key => $ord) {
            $customer_id = $ord->customer_id;
            $shipping_id = $ord->shipping_id;
        }
        $customer = Customer::where('customer_id', $customer_id)->first();
        $shipping = Shipping::where('shipping_id', $shipping_id)->first();

        $order_details_product = OrderDetails::with('product')->where('order_code', $checkout_code)->get();

        foreach ($order_details_product as $key => $order_d) {

            $product_coupon = $order_d->product_coupon;
        }
        if ($product_coupon != 'no') {
            $coupon = Coupon::where('coupon_code', $product_coupon)->first();

            $coupon_condition = $coupon->coupon_condition;
            $coupon_number = $coupon->coupon_number;

            if ($coupon_condition == 1) {
                $coupon_echo = $coupon_number . '%';
            } elseif ($coupon_condition == 2) {
                $coupon_echo = number_format($coupon_number, 0, ',', '.') . 'đ';
            }
        } else {
            $coupon_condition = 2;
            $coupon_number = 0;

            $coupon_echo = '0';
        }

        $output = '';

        $output .= '<style>body{
			font-family: DejaVu Sans;
		}
		.table-styling{
			border:1px solid #000;
		}
		.table-styling tbody tr td{
			border:1px solid #000;
		}
		</style>
		<h3><center>CỘNG HOÀ XÃ HỘI CHỦ NGHĨA VIỆT NAM</center></h3>
		<h4><center>Độc lập - Tự do - Hạnh phúc</center></h4>
		<p>Người đặt hàng</p>
		<table class="table-styling">
				<thead>
					<tr>
						<th>Tên khách đặt</th>
						<th>Số điện thoại</th>
						<th>Email</th>
					</tr>
				</thead>
				<tbody>';

        $output .= '
					<tr>
						<td>' . $customer->customer_name . '</td>
						<td>' . $customer->customer_phone . '</td>
						<td>' . $customer->customer_email . '</td>

					</tr>';


        $output .= '
				</tbody>

		</table>

		<p>Ship hàng tới</p>
			<table class="table-styling">
				<thead>
					<tr>
						<th>Tên người nhận</th>
						<th>Địa chỉ</th>
						<th>Sdt</th>
						<th>Email</th>
						<th>Ghi chú</th>
					</tr>
				</thead>
				<tbody>';

        $output .= '
					<tr>
						<td>' . $shipping->shipping_name . '</td>
						<td>' . $shipping->shipping_address . '</td>
						<td>' . $shipping->shipping_phone . '</td>
						<td>' . $shipping->shipping_email . '</td>
						<td>' . $shipping->shipping_notes . '</td>

					</tr>';

        $output .= '
				</tbody>

		</table>

		<p>Đơn hàng đặt</p>
			<table class="table-styling">
				<thead>
					<tr>
						<th>Tên sản phẩm</th>
						<th>Mã giảm giá</th>
						<th>Số lượng</th>
						<th>Giá sản phẩm</th>
						<th>Thành tiền</th>
					</tr>
				</thead>
				<tbody>';

        $total = 0;

        foreach ($order_details_product as $key => $product) {

            $subtotal = $product->product_price * $product->product_sales_quantity;
            $total += $subtotal;

            if ($product->product_coupon != 'no') {
                $product_coupon = $product->product_coupon;
            } else {
                $product_coupon = 'không mã';
            }

            $output .= '
					<tr>
						<td>' . $product->product_name . '</td>
						<td>' . $product_coupon . '</td>
						<td>' . $product->product_sales_quantity . '</td>
						<td>' . number_format($product->product_price, 0, ',', '.') . 'đ' . '</td>
						<td>' . number_format($subtotal, 0, ',', '.') . 'đ' . '</td>

					</tr>';
        }

        if ($coupon_condition == 1) {
            $total_after_coupon = ($total * $coupon_number) / 100;
            $total_coupon = $total - $total_after_coupon;
        } else {
            $total_coupon = $total - $coupon_number;
        }

        $output .= '<tr>
				<td colspan="2">
					<p>Tổng giảm: ' . $coupon_echo . '</p>
					<p>Thanh toán : ' . number_format($total_coupon, 0, ',', '.') . 'đ' . '</p>
				</td>
		</tr>';
        $output .= '
				</tbody>

		</table>
		<p>Ký tên</p>
			<table>
				<thead>
					<tr>
						<th width="200px">Người lập phiếu</th>
						<th width="800px">Người nhận</th>

					</tr>
				</thead>
				<tbody>';
        $output .= '
				</tbody>

		</table>

		';

        return $output;
    }
    public function view_order($order_code)
    {
        $order_details = OrderDetails::with('product')->where('order_code', $order_code)->get();
        $order = Order::where('order_code', $order_code)->get();
        foreach ($order as $key => $ord) {
            $customer_id = $ord->customer_id;
            $shipping_id = $ord->shipping_id;
            $order_status = $ord->order_status;
        }
        $customer = Customer::where('customer_id', $customer_id)->first();
        $shipping = Shipping::where('shipping_id', $shipping_id)->first();

        $order_details_product = OrderDetails::with('product')->where('order_code', $order_code)->get();

        foreach ($order_details_product as $key => $order_d) {

            $product_coupon = $order_d->product_coupon;
        }
        if ($product_coupon != 'no') {
            $coupon = Coupon::where('coupon_code', $product_coupon)->first();
            $coupon_condition = $coupon->coupon_condition;
            $coupon_number = $coupon->coupon_number;
        } else {
            $coupon_condition = 2;
            $coupon_number = 0;
        }

        return view('admin.order.view_order')->with(compact('order_details', 'customer', 'shipping', 'order_details', 'coupon_condition', 'coupon_number', 'order', 'order_status'));
    }
    public function manage_order()
    {
        $order = Order::orderby('order_id', 'DESC')->paginate(5);
        return view('admin.order.manage_order')->with(compact('order'));
    }
    public function history(Request $request)
    {
        if (!Session::get('customer_id')) {
            return redirect('login-checkout')->with('error', 'vui lòng đăng nhập để xem đơn hàng');
        } else {
            $order = Order::where('customer_id', Session::get('customer_id'))->orderby('created_at', 'DESC')->get();
            $cate_product = Category::where('category_status', '1')->orderBy('category_id', 'desc')->get();
            $brand_product = Brand::where('brand_status', '1')->orderBy('brand_id', 'desc')->get();
            return view('pages.history.history')->with('category', $cate_product)->with('brand', $brand_product)->with('order', $order);
        }
    }
    public function view_history_order(Request $request, $order_code)
    {
        if (!Session::get('customer_id')) {
            return redirect('login-checkout')->with('error', 'vui lòng đăng nhập để xem đơn hàng');
        } else {
            //xem lịch sử đơn hàng
            $order_details = OrderDetails::with('product')->where('order_code', $order_code)->get();
            $order = Order::where('order_code', $order_code)->first();
            $customer_id = $order->customer_id;
            $shipping_id = $order->shipping_id;
            $order_status = $order->order_status;
            $customer = Customer::where('customer_id', $customer_id)->first();
            $shipping = Shipping::where('shipping_id', $shipping_id)->first();

            $order_details_product = OrderDetails::with('product')->where('order_code', $order_code)->get();

            foreach ($order_details_product as $key => $order_d) {

                $product_coupon = $order_d->product_coupon;
            }
            if ($product_coupon != 'no') {
                $coupon = Coupon::where('coupon_code', $product_coupon)->first();
                $coupon_condition = $coupon->coupon_condition;
                $coupon_number = $coupon->coupon_number;
            } else {
                $coupon_condition = 2;
                $coupon_number = 0;
            }
            $cate_product = Category::where('category_status', '1')->orderBy('category_id', 'desc')->get();
            $brand_product = Brand::where('brand_status', '1')->orderBy('brand_id', 'desc')->get();
            return view('pages.history.view_history_order')->with('category', $cate_product)->with('brand', $brand_product)->with(compact('order_details', 'customer', 'shipping', 'order_details', 'coupon_condition', 'coupon_number', 'order', 'order_status'));
        }
    }
}
