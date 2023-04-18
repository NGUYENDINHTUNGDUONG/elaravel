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

    public function index(Request $request)
    {
        //Seo

        //--Seo
        $cate_product = Category::where('category_status', '1')->orderBy('category_id', 'desc')->get();
        $brand_product = Brand::where('brand_status', '1')->orderBy('brand_id', 'desc')->get();
        $all_product = Product::where('product_status', '1')->orderBy('product_id', 'asc')->limit(9)->get();
        $maneger_product = view('admin.product.all_product')->with('all_product', $all_product);
        return view('pages.home')->with('category', $cate_product)->with('brand', $brand_product)->with('all_product', $all_product);
    }
    public function search(Request $request){
        $keywords = $request ->keywords_submit;
        $cate_product = Category::where('category_status', '1')->orderBy('category_id', 'desc')->get();
        $brand_product = Brand::where('brand_status', '1')->orderBy('brand_id', 'desc')->get();
        $search_product = Product::where('product_name', 'like','%'.$keywords.'%')->orderBy('product_id', 'desc')->get();

        return view('pages.product.search')->with('category', $cate_product)->with('brand', $brand_product)->with('search_product', $search_product);
    }
}
