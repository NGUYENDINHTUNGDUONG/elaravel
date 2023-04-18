<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Social;
use App\Models\Admin;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    public function login_facebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function callback_facebook()
    {
        $provider = Socialite::driver('facebook')->stateless()->user();
        $account = Social::where('provider', 'facebook')->where('provider_user_id', $provider->getId())->first();
        if ($account) {
            //login in vao trang quan tri
            $account_name = Admin::where('admin_id', $account->user)->first();
            Session::put('admin_login', $account_name->admin_name);
            Session::put('admin_id', $account_name->admin_id);
            return redirect('/dashboard')->with('message', 'Đăng nhập Admin thành công');
        } else {

            $nhom12 = new Social([
                'provider_user_id' => $provider->getId(),
                'provider' => 'facebook'
            ]);

            $orang = Admin::where('admin_email', $provider->getEmail())->first();

            if (!$orang) {
                $orang = Admin::create([
                    'admin_name' => $provider->getName(),
                    'admin_email' => $provider->getEmail(),
                    'admin_password' => '',
                    'admin_status' => 1

                ]);
            }
            $nhom12->login()->associate($orang);
            $nhom12->save();

            $account_name = Admin::where('admin_id', $account->user)->first();

            Session::put('admin_login', $account_name->admin_name);
            Session::put('admin_id', $account_name->admin_id);
            return redirect('/dashboard')->with('message', 'Đăng nhập Admin thành công');
        }
    }
}
