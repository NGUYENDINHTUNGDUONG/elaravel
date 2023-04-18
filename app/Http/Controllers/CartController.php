<?php

namespace App\Http\Controllers;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Coupon;
use Illuminate\Support\Carbon;

session_start();

class CartController extends Controller
{
    public function check_coupon(Request $request)
    {
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
        $data = $request->all();
        if (Session::get('customer_id')) {
            $coupon = Coupon::where('coupon_code', $data['coupon'])->where('coupon_status', 1)->where('coupon_date_end', '>=', $today)->where('coupon_used', 'LIKE', '%' . Session::get('customer_id') . '%')->first();
            if ($coupon) {
                return redirect()->back()->with('error', 'Mã giảm giá đã được nhập vui lòng nhập mã khác');
            } else {
                $coupon_login = Coupon::where('coupon_code', $data['coupon'])->where('coupon_status', 1)->where('coupon_date_end', '>=', $today)->first();
                if ($coupon_login) {
                    $count_coupon = $coupon_login->count();
                    if ($count_coupon > 0) {
                        $coupon_session = Session::get('coupon');
                        if ($coupon_session == true) {
                            $is_avaiable = 0;
                            if ($is_avaiable == 0) {
                                $cou[] = array(
                                    'coupon_code' => $coupon_login->coupon_code,
                                    'coupon_condition' => $coupon_login->coupon_condition,
                                    'coupon_number' => $coupon_login->coupon_number,
                                );
                                Session::put('coupon', $cou);
                            }
                        } else {
                            $cou[] = array(
                                'coupon_code' => $coupon_login->coupon_code,
                                'coupon_condition' => $coupon_login->coupon_condition,
                                'coupon_number' => $coupon_login->coupon_number,
                            );
                            Session::put('coupon', $cou);
                        }
                        Session::save();
                        return redirect()->back()->with('message', 'Thêm mã giảm giá thành công');
                    }
                } else {
                    return redirect()->back()->with('error', 'Mã giảm giá không đúng hoặc đã hết hạn');
                }
            }
        } else {
            $coupon = Coupon::where('coupon_code', $data['coupon'])->where('coupon_status', 1)->where('coupon_date_end', '>=', $today)->first();
            if ($coupon) {
                $count_coupon = $coupon->count();
                if ($count_coupon > 0) {
                    $coupon_session = Session::get('coupon');
                    if ($coupon_session == true) {
                        $is_avaiable = 0;
                        if ($is_avaiable == 0) {
                            $cou[] = array(
                                'coupon_code' => $coupon->coupon_code,
                                'coupon_condition' => $coupon->coupon_condition,
                                'coupon_number' => $coupon->coupon_number,
                            );
                            Session::put('coupon', $cou);
                        }
                    } else {
                        $cou[] = array(
                            'coupon_code' => $coupon->coupon_code,
                            'coupon_condition' => $coupon->coupon_condition,
                            'coupon_number' => $coupon->coupon_number,
                        );
                        Session::put('coupon', $cou);
                    }
                    Session::save();
                    return redirect()->back()->with('message', 'Thêm mã giảm giá thành công');
                }
            } else {
                return redirect()->back()->with('error', 'Mã giảm giá không đúng hoặc đã hết hạn');
            }
        }
    }
    public function cart(Request $request)
    {
        $cate_product = Category::where('category_status', '1')->orderBy('category_id', 'desc')->get();
        $brand_product = Brand::where('brand_status', '1')->orderBy('brand_id', 'desc')->get();

        return view('pages.cart.cart_ajax')->with('category', $cate_product)->with('brand', $brand_product);
    }
    public function add_cart_ajax(Request $request)
    {
        // Session::forget('cart');
        $data = $request->all();
        $session_id = substr(md5(microtime()), rand(0, 26), 5);
        $cart = Session::get('cart');
        if ($cart == true) {
            $is_avaiable = 0;
            foreach ($cart as $key => $val) {
                if ($val['product_id'] == $data['cart_product_id']) {
                    $is_avaiable++;
                }
            }
            if ($is_avaiable == 0) {
                $cart[] = array(
                    'session_id' => $session_id,
                    'product_name' => $data['cart_product_name'],
                    'product_id' => $data['cart_product_id'],
                    'product_image' => $data['cart_product_image'],
                    'product_qty' => $data['cart_product_qty'],
                    'product_price' => $data['cart_product_price'],
                );
                Session::put('cart', $cart);
            }
        } else {
            $cart[] = array(
                'session_id' => $session_id,
                'product_name' => $data['cart_product_name'],
                'product_id' => $data['cart_product_id'],
                'product_image' => $data['cart_product_image'],
                'product_qty' => $data['cart_product_qty'],
                'product_price' => $data['cart_product_price'],

            );
            Session::put('cart', $cart);
        }

        Session::save();
    }



    public function show_cart()
    {
        $cate_product = Category::where('category_status', '1')->orderBy('category_id', 'desc')->get();
        $brand_product = Brand::where('brand_status', '1')->orderBy('brand_id', 'desc')->get();

        return view('pages.cart.show_cart')->with('category', $cate_product)->with('brand', $brand_product);
    }
    public function delete_cart_product($session_id)
    {
        $cart = Session::get('cart');
        if ($cart == true) {
            foreach ($cart as $key => $val) {
                if ($val['session_id'] == $session_id) {
                    unset($cart[$key]);
                }
            }
            Session::put('cart', $cart);
            return redirect()->back()->with('message', 'Xóa sản phẩm thành công');
        } else {
            return redirect()->back()->with('message', 'Xóa sản phẩm thất bại');
        }
    }
    public function delete_all_product()
    {
        $cart = Session::get('cart');
        if ($cart == true) {
            Session::forget('cart');
            return Redirect::back()->with('message', 'Xoá hết giỏ hàng thành công');
        }
    }
    public function update_cart(Request $request)
    {
        $data = $request->all();
        $cart = Session::get('cart');
        if ($cart == true) {
            $message = '';
            foreach ($data['cart_qty'] as $key => $qty) {
                foreach ($cart as $session => $val) {
                    if ($val['session_id'] == $key) {
                        $cart[$session]['product_qty'] = $qty;
                    }
                }
            }

            Session::put('cart', $cart);
            return redirect()->back()->with('message', $message);
        } else {
            return redirect()->back()->with('message', 'Cập nhật số lượng thất bại');
        }
    }
}
