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

session_start();

class CheckoutController extends Controller
{
    public function confirm_order(Request $request)
    {
        echo "<script>console.log('aaa');</script>";
        $data = $request->all();
        $coupon = Coupon::where('coupon_code', $data['order_coupon'])->first();
        $coupon->coupon_used = $coupon->coupon_used . ', ' . Session::get('customer_id');
        $coupon->coupon_time = $coupon->coupon_time - 1;
        $coupon_mail = $coupon->coupon_code;
        $coupon->save();
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


        $order = new Order();
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
        // $now = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
        // $title_mail = "Đơn hàng xác nhận ngày" . ' ' . $now;
        // $customer = Customer::find(Session::get('customer_id'));
        // $data['email'][] =  $customer->customer_email;
        //lấy giỏ hàng
        // if (Session::get('cart') == true) {
        //     foreach (Session::get('cart') as $key => $cart_mail) {
        //         $cart_array[] = array(
        //             'product_name' => $cart_mail['product_name'],
        //             'product_price' => $cart_mail['product_price'],
        //             'product_qty' => $cart_mail['product_qty'],
        //         );
        //     };
        // }
        // //lấy shippng
        // $shipping_array = array(
        //     'customer_name' => $customer->customer_name,
        //     'shipping_name' => $data['shipping_name'],
        //     'shipping_email' => $data['shipping_email'],
        //     'shipping_phone' => $data['shipping_phone'],
        //     'shipping_address' => $data['shipping_address'],
        //     'shipping_notes' => $data['shipping_notes'],
        //     'shipping_method' => $data['shipping_method'],
        // );
        // //lấy mã giảm giá
        // $ordercode_mail = array(
        //     'coupon_code' => $coupon_mail,
        //     'order_code' => $checkout_code,
        // );
        // Mail::send('pages.send_mail.mail_order', ['cart_array'=>$cart_array,'shipping_array'=>$shipping_array,'code'=>$ordercode_mail], function ($message) use ($title_mail, $data) {
        //     $message->to($data['email'])->subject($title_mail);
        //     $message->from($data['email'], $title_mail);
        // });
        Session::forget('coupon');
        Session::forget('cart');

    }
    public function login_customer(Request $request)
    {
        $email = $request->email_account;
        $password = md5($request->password_account);
        $result = Customer::where('customer_email', $email)->where('customer_password', $password)->first();

        if ($result) {
            Session::put('customer_id', $result->customer_id);
            return Redirect::to('/show-checkout')->with('message', 'đăng nhập thành công');;
        } else {

            return Redirect::to('/login-checkout')->with('error', 'Sai tài khoản hoặc mật khẩu');
        }
    }
    public function login_checkout()
    {
        $cate_product = Category::where('category_status', '1')->orderBy('category_id', 'desc')->get();
        $brand_product = Brand::where('brand_status', '1')->orderBy('brand_id', 'desc')->get();
        return view('pages.checkout.login_checkout')->with('category', $cate_product)->with('brand', $brand_product);

    }
    public function add_customer(Request $request)
    {
        $data = array();
        $data['customer_name'] = $request->customer_name;
        $data['customer_phone'] = $request->customer_phone;
        $data['customer_email'] = $request->customer_email;
        $data['customer_password'] = md5($request->customer_password);

        $customer_id = Customer::insertGetId($data);

        Session::put('customer_id', $customer_id);
        Session::put('customer_name', $request->customer_name);
        return Redirect::to('/show-checkout');
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
    // public function select_delivery_home(Request $request)
    // {
    //     $data = $request->all();
    //     if ($data['action']) {
    //         $output = '';
    //         if ($data['action'] == "city") {
    //             $select_province = Province::where('matp', $data['ma_id'])->orderby('maqh', 'ASC')->get();
    //             $output .= '<option>---Chọn quận huyện---</option>';
    //             foreach ($select_province as $key => $province) {
    //                 $output .= '<option value="' . $province->maqh . '">' . $province->name_quanhuyen . '</option>';
    //             }
    //         } else {
    //             $select_wards = Wards::where('maqh', $data['ma_id'])->orderby('xaid', 'ASC')->get();
    //             $output .= '<option>---Chọn xã phường---</option>';
    //             foreach ($select_wards as $key => $ward) {
    //                 $output .= '<option value="' . $ward->xaid . '">' . $ward->name_xaphuong . '</option>';
    //             }
    //         }
    //         echo $output;
    //     }
    // }
    // public function calculate_fee(Request $request)
    // //tính phí vận chuyển
    // {
    //     $data = $request->all();
    //     if ($data['matp']) {
    //         $feeship = Feeship::where('fee_matp', $data['matp'])->where('fee_maqh', $data['maqh'])->where('fee_xaid', $data['xaid'])->get();
    //         if ($feeship) {
    //             $count_feeship = $feeship->count();
    //             if ($count_feeship > 0) {
    //                 foreach ($feeship as $key => $fee) {
    //                     Session::put('fee', $fee->fee_feeship);
    //                     Session::save();
    //                 }
    //             } else {
    //                 Session::put('fee', 25000);
    //                 Session::save();
    //             }
    //         }
    //     }
    // }
    // public function save_checkout_customer(Request $request)
    // {
    //     $data = array();
    //     $data['shipping_name'] = $request->shipping_name;
    //     $data['shipping_phone'] = $request->shipping_phone;
    //     $data['shipping_email'] = $request->shipping_email;
    //     $data['shipping_notes'] = $request->shipping_notes;
    //     $data['shipping_address'] = $request->shipping_address;

    //     $shipping_id = DB::table('tbl_shipping')->insertGetId($data);

    //     Session::put('shipping_id', $shipping_id);
    // }

    public function logout_checkout()
    {
        session::forget('customer_id');
        session::forget('coupon');
        session::forget('cart');
        return redirect::to('/login-checkout');
    }

}
