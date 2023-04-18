<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function send_coupon($start_date, $end_date, $coupon_time, $coupon_condition, $coupon_number, $coupon_code)
    {
        $customer_vip = Customer::where('customer_vip', 1)->get();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
        $title_mail = "Mã khuyến mãi ngày" . ' ' . $now;
        $data = [];
        foreach ($customer_vip as $vip) {
            $data['email'][] = $vip->customer_email;
        }
        $coupon = array(
            'start_date' => $start_date,
            'end_date' => $end_date,
            'coupon_time' => $coupon_time,
            'coupon_condition' => $coupon_condition,
            'coupon_number' => $coupon_number,
            'coupon_code' => $coupon_code
        );
        Mail::send('pages.send_mail.send_coupon', ['coupon'=>$coupon], function ($message) use ($title_mail, $data) {
            $message->to($data['email'])->subject($title_mail);
            $message->from($data['email'], $title_mail);
        });
        return redirect()->back()->with('message', 'Gửi mã khuyến mãi tới khách vip thành công');
        //--send mail
    }
    public function forget_password(Request $request)
    {
        $cate_product = Category::where('category_status', '1')->orderBy('category_id', 'desc')->get();
        $brand_product = Brand::where('brand_status', '1')->orderBy('brand_id', 'desc')->get();
        return view('pages.checkout.forget_password')->with('category', $cate_product)->with('brand', $brand_product);
    }
    public function recover_pass(Request $request)
    {
        $data = $request->all();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
        $title_mail = "lấy lại mật khẩu" . ' ' . $now;
        $customer = Customer::where('customer_email', '=', $data['email_account'])->get();
        foreach ($customer as $key => $value) {
            $customer_id = $value->customer_id;
        }
        if ($customer) {
            $count_customer = $customer->count();
            if ($count_customer == 0) {
                return redirect()->back()->with('error', 'email chưa được đăng ký để phục hồi mật khẩu');
            } else {
                $token_random = Str::random();
                $customer = Customer::find($customer_id);
                $customer->customer_token = $token_random;
                $customer->save();

                $to_email = $data['email_account'];
                $link_resset_pass = url('/update-new-pass?email=' . $to_email . '&token=' . $token_random);
                $data = array("name" => $title_mail, "body" => $link_resset_pass, "email" => $data['email_account']);
                Mail::send('pages.checkout.forget_pass_notify', ['data' => $data], function ($message) use ($title_mail, $data) {
                    $message->to($data['email'])->subject($title_mail);
                    $message->from($data['email'], $title_mail);
                });
                return redirect()->back()->with('message', 'Gửi mail thành công vui lòng vào mail để resset password');
            }
        }
    }
    public function update_new_pass(Request $request)
    {
        $cate_product = Category::where('category_status', '1')->orderBy('category_id', 'desc')->get();
        $brand_product = Brand::where('brand_status', '1')->orderBy('brand_id', 'desc')->get();
        return view('pages.checkout.new_pass')->with('category', $cate_product)->with('brand', $brand_product);
    }
    public function reset_new_pass(Request $request)
    {
        $data = $request->all();
        $token_random = Str::random();
        $customer = Customer::where('customer_email', '=', $data['email'])->where('customer_token', '=', $data['token'])->get();
        $count = $customer->count();
        if ($count > 0) {
            foreach ($customer as $key => $cus) {
                $customer_id = $cus->customer_id;
            }
            $resset = Customer::find($customer_id);
            $resset->customer_password = md5($data['password_account']);
            $resset->customer_token =  $token_random;
            $resset->save();
            return redirect('/login-checkout')->with('message', 'đổi mật khẩu mới thành công, vui lòng đăng nhập');
        } else {
            return redirect('/forget-password')->with('error', 'vui lòng nhập lại mail vì link đã quá hạn');
        }
    }
}
