<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Models\Coupon;
use Illuminate\Support\Carbon;



session_start();

class CouponController extends Controller
{
    public function add_coupon()
    {
        return view('admin.coupon.add_coupon');
    }
    public function list_coupon()
    {
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
        $coupon = Coupon::orderby('coupon_id', 'DESC')->paginate(3);
        return view('admin.coupon.list_coupon')->with(compact('coupon', 'today'));
    }
    public function add_coupon_code(Request $request)
    {
        $data = $request->all();
        $coupon = new Coupon;
        $coupon->coupon_name = $data['coupon_name'];
        $coupon->coupon_date_start = $data['coupon_date_start'];
        $coupon->coupon_date_end  = $data['coupon_date_end'];
        $coupon->coupon_code = $data['coupon_code'];
        $coupon->coupon_time = $data['coupon_time'];
        $coupon->coupon_number = $data['coupon_number'];
        $coupon->coupon_condition = $data['coupon_condition'];
        $coupon->save();
        Session::put('message', 'Thêm mã giảm giá thành công');
        return Redirect::to('add-coupon');
    }
    public function delete_coupon($coupon_id)
    {
        $coupon = Coupon::find($coupon_id);
        $coupon->delete();
        Session::put('message', 'Xóa mã giảm giá thành công');
        return Redirect::to('list-coupon');
    }
    public function unset_coupon()
    {
        $coupon = Session::get('coupon');
        if ($coupon == true) {
            Session::forget('coupon');
            return redirect()->back()->with('message', 'Xóa mã khuyến mãi thành công');
        }
    }
}
