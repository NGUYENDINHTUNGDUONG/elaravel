<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function send_mail(){
        $to_name="TungDuong";
        $to_email="ndtd13102001@gmail.com";

        $data =array("name"=>"Mail từ tài khoản khách hàng", "body"=>'mail gửi về vấn đề');
        Mail::send('pages.send_mail',$data,function($message)use($to_name,$to_email){
            $message -> to($to_email)->subject('Test thử gửi mail');
            $message -> from($to_email,$to_name);

        });
        return redirect('/')->with('message'.'');
    }
    public function index(Request $request)
    {
        //Seo
        $meta_desc = "chuyên cafe rang xay";
        $meta_keywords = "cafe";
        $meta_title = 'cafe nguyên chất';
        $url_canonical = $request->url();
        //--Seo
        $cate_product = Category::where('category_status', '1')->orderBy('category_id', 'desc')->get();
        $brand_product = Brand::where('brand_status', '1')->orderBy('brand_id', 'desc')->get();
        // $all_product = DB::table('tbl_product')
        //     ->join('tbl_category_product', 'tbl_category_product.category_id', '=', 'tbl_product.category_id')
        //     ->join('tbl_brand_product', 'tbl_brand_product.brand_id', '=', 'tbl_product.brand_id')
        //     ->orderBy('tbl_product.product_id')->get();
        $all_product = Product::where('product_status', '1')->orderBy('product_id', 'asc')->limit(9)->get();

        return view('pages.home')->with('category', $cate_product)->with('brand', $brand_product)->with('all_product', $all_product)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical);
    }
    public function search(Request $request){
        $keywords = $request ->keywords_submit;
        $cate_product = Category::where('category_status', '1')->orderBy('category_id', 'desc')->get();
        $brand_product = Brand::where('brand_status', '1')->orderBy('brand_id', 'desc')->get();
        // $all_product = DB::table('tbl_product')
        //     ->join('tbl_category_product', 'tbl_category_product.category_id', '=', 'tbl_product.category_id')
        //     ->join('tbl_brand_product', 'tbl_brand_product.brand_id', '=', 'tbl_product.brand_id')
        //     ->orderBy('tbl_product.product_id')->get();
        $search_product = Product::where('product_name', 'like','%'.$keywords.'%')->orderBy('product_id', 'desc')->get();

        return view('pages.product.search')->with('category', $cate_product)->with('brand', $brand_product)->with('search_product', $search_product);
    }
}
