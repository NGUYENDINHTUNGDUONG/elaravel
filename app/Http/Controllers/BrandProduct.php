<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

session_start();

class BrandProduct extends Controller
{
    //Function Admin page
    public function AuthLogin()
    {
        $admin_id = Session::get('admin_id');
        if ($admin_id) {
            return Redirect::to('dashboard');
        } else {
            return Redirect::to('admin')->send();
        }
    }
    public function add_brand_product()
    {
        $this->AuthLogin();
        return view('admin.brand.add_brand_product');
    }
    public function all_brand_product()
    {
        $this->AuthLogin();
        $all_brand_product = Brand::orderBy('brand_id','DESC')->paginate(2);
        // dd($all_brand_product);
        $maneger_brand_product = view('admin.brand.all_brand_product')->with('all_brand_product', $all_brand_product);
        return view('admin_layout')->with('admin.brand.all_brand_product', $maneger_brand_product);
    }
    public function save_brand_product(Request $request)
    {
        $this->AuthLogin();
        $data = $request->all();
        $brand = new Brand();
        $brand -> brand_name = $data['brand_product_name'];
        $brand -> brand_desc = $data['brand_product_desc'];
        $brand -> brand_status = $data['brand_product_status'];
        $brand -> save();

        Session::put('message', 'Thêm danh mục sản phẩm thành công');
        return Redirect::to('add-brand-product');
    }
    public function active_brand_product($brand_product_id)
    {
        $this->AuthLogin();
        Brand::where('brand_id', $brand_product_id)->update(['brand_status' => 0]);
        Session::put('message', 'Không kích hoạt danh mục thành công');
        return Redirect::to('all-brand-product');
    }
    public function unactive_brand_product($brand_product_id)
    {
        $this->AuthLogin();
        Brand::where('brand_id', $brand_product_id)->update(['brand_status' => 1]);
        Session::put('message', 'Kích hoạt danh mục thành công');
        return Redirect::to('all-brand-product');
    }
    public function edit_brand_product($brand_product_id)
    {
        $this->AuthLogin();
        $edit_brand_product = Brand::find($brand_product_id);
        $maneger_brand_product = view('admin.brand.edit_brand_product')->with('edit_brand_product', $edit_brand_product);
        return view('admin_layout')->with('admin.brand.edit_brand_product', $maneger_brand_product);
    }
    public function update_brand_product(Request $request, $brand_product_id)
    {
        $this->AuthLogin();
        $data = $request->all();
        $brand =  Brand::find($brand_product_id);
        $brand -> brand_name = $data['brand_product_name'];
        $brand -> brand_desc = $data['brand_product_desc'];
        $brand -> save();
        Session::put('message', 'Cập nhật danh mục sản phẩm thành công');
        return Redirect::to('all-brand-product');
    }
    public function delete_brand_product($brand_product_id)
    {
        $this->AuthLogin();
        Brand::where('brand_id', $brand_product_id)->delete();
        Session::put('message', 'xoá danh mục sản phẩm thành công');
        return Redirect::to('all-brand-product');
    }
    //End functions Admin pages
    //Function Admin home page
    public function show_brand_home($brand_id)
    {
        $cate_product = Category::where('category_status', '1')->orderBy('category_id', 'desc')->get();
        $brand_product = Brand::where('brand_status', '1')->orderBy('brand_id', 'desc')->get();
        $brand_by_id = Product::join('tbl_brand_product', 'tbl_product.brand_id', '=', 'tbl_brand_product.brand_id')->where('tbl_product.brand_id', $brand_id,)->get();
        $brand_name = Brand::where('tbl_brand_product.brand_id',$brand_id)->limit(1)->get();

        return view('pages.brand.show_brand')->with('category', $cate_product)->with('brand', $brand_product)->with('brand_by_id', $brand_by_id)->with('brand_name',$brand_name);
    }
}
