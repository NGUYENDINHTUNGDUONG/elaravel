<?php

namespace App\Http\Controllers;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Models\Shipping;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Customer;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

use function Psy\debug;

session_start();

class CheckoutController extends Controller
{
    public function confirm_order(Request $request)
    {
        $data = $request->all();
        $shipping = new Shipping();
        $shipping->shipping_name = $data['shipping_name'];
        $shipping->shipping_email = $data['shipping_email'];
        $shipping->shipping_phone = $data['shipping_phone'];
        $shipping->shipping_address = $data['shipping_address'];
        $shipping->shipping_notes = $data['shipping_notes'];
        $shipping->shipping_method = $data['shipping_method'];
        $shipping->save();
        $shipping_id = $shipping->shipping_id;

        $checkout_code = substr(md5(microtime()), rand(0, 26), 5);


        $order = new Order;
        $order->customer_id = Session::get('customer_id');
        $order->shipping_id = $shipping_id;
        $order->order_status = 1;
        $order->order_code = $checkout_code;

        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $order->created_at = now();
        $order->save();

        if (Session::get('cart') == true) {
            foreach (Session::get('cart') as $key => $cart) {
                $order_details = new OrderDetails;
                $order_details->order_code = $checkout_code;
                $order_details->product_id = $cart['product_id'];
                $order_details->product_name = $cart['product_name'];
                $order_details->product_price = $cart['product_price'];
                $order_details->product_sales_quantity = $cart['product_qty'];
                $order_details->product_coupon =  $data['order_coupon'];
                $order_details->product_feeship = $data['order_fee'];
                $order_details->save();
            }
        }
        Session::forget('coupon');

        Session::forget('cart');
    }

    public function show_checkout()
    {
        $customer_id = Session::get('customer_id');
        if ($customer_id) {
            $customer = Customer::where('customer_id', $customer_id)->first();
            if ($customer) {
                $data['customer_name'] = $customer->customer_name;
                $data['customer_phone'] = $customer->customer_phone;
                $data['customer_email'] = $customer->customer_email;
                $data['customer_password'] = md5($customer->customer_password);
            }
        }

        $cate_product = Category::where('category_status', '1')->orderBy('category_id', 'desc')->get();
        $brand_product = Brand::where('brand_status', '1')->orderBy('brand_id', 'desc')->get();

        return view('pages.checkout.show_checkout')->with('category', $cate_product)->with('brand', $brand_product)->with('data', $data);
    }
}
