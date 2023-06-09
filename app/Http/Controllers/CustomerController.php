<?php

namespace App\Http\Controllers;

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

class CustomerController extends Controller
{
    public function AuthLogin()
    {
        $admin_id = Session::get('admin_id');
        if ($admin_id) {
            return Redirect::to('dashboard');
        } else {
            return Redirect::to('admin')->send();
        }
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

    public function logout_checkout()
    {
        session::forget('customer_id');
        session::forget('coupon');
        session::forget('cart');
        return redirect::to('/login-checkout');
    }
    public function all_customer()
    {
        $this->AuthLogin();
        $all_customer = Customer::orderby('customer_id', 'ASC')->paginate(10);
        $maneger_customer = view('admin.customer.all_customer')->with('all_customer', $all_customer);
        return view('admin_layout')->with('admin.customer.all_customer', $maneger_customer);
    }
    public function active_vip($customer_id)
    {
        $this->AuthLogin();
        Customer::where('customer_id', $customer_id)->update(['customer_vip' => null]);
        Session::put('message', 'Không kích hoạt VIP thành công');
        return Redirect::to('all-customer');
    }
    public function unactive_vip($customer_id)
    {
        $this->AuthLogin();
        Customer::where('customer_id', $customer_id)->update(['customer_vip' => 1]);
        Session::put('message', 'Kích hoạt VIP thành công');
        return Redirect::to('all-customer');
    }
}
