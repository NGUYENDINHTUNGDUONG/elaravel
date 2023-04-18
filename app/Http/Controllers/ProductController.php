<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

session_start();

class ProductController extends Controller
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
    public function add_product()
    {
        $this->AuthLogin();
        $cate_product = Category::orderBy('category_id', 'desc')->get();
        $brand_product = Brand::orderBy('brand_id', 'desc')->get();

        return view('admin.product.add_product')->with('cate_product', $cate_product)->with('brand_product', $brand_product);
    }
    public function all_product()
    {
        $this->AuthLogin();
        $all_product = Product::
            join('tbl_category_product', 'tbl_category_product.category_id', '=', 'tbl_product.category_id')
            ->join('tbl_brand_product', 'tbl_brand_product.brand_id', '=', 'tbl_product.brand_id')
            ->orderby('tbl_product.product_id','desc')->paginate(5);
        // dd($all_product);
        $maneger_product = view('admin.product.all_product')->with('all_product', $all_product);
        return view('admin_layout')->with('admin.product.all_product', $maneger_product);
        //return view('admin.all_product')->with('all_product', $all_product);
    }
    public function save_product(Request $request)
    {
        $this->AuthLogin();
        $data = $request->all();
        $product = new Product();
        $product->product_name = $data['product_name'];
        $product->product_price = $data['product_price'];
        $product->product_desc = $data['product_desc'];
        $product->product_content = $data['product_content'];
        $product->category_id = $data['category_product'];
        $product->brand_id = $data['brand_product'];
        $product->product_status = $data['product_status'];
        $product->product_image = $data['product_image'];
        $get_image = $request->file('product_image');
        dd($request->file('product_image'));

        if ($get_image) {
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));//ghép lại thành tên trước dấu chấm
            $new_image = $get_name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move('public/upload/product', $new_image);
            $product->product_image = $new_image;
            $product -> save();

            Session::put('message', 'Thêm sản phẩm thành công');
            return Redirect::to('add-product');
        }
        $product->product_image = '';
        $product -> save();

        Session::put('message', 'Thêm sản phẩm thành công');
        return Redirect::to('add-product');
    }
    public function active_product($product_id)
    {
        $this->AuthLogin();
        Product::where('product_id', $product_id)->update(['product_status' => 0]);
        Session::put('message', 'Không kích hoạt danh mục thành công');
        return Redirect::to('all-product');
    }
    public function unactive_product($product_id)
    {
        $this->AuthLogin();
        Product::where('product_id', $product_id)->update(['product_status' => 1]);
        Session::put('message', 'Kích hoạt danh mục thành công');
        return Redirect::to('all-product');
    }
    public function edit_product($product_id)
    {
        $this->AuthLogin();
        $cate_product = Category::orderBy('category_id', 'desc')->get();
        $brand_product = Brand::orderBy('brand_id', 'desc')->get();
        $edit_product = Product::where('product_id', $product_id)->get();
        $maneger_product = view('admin.product.edit_product')->with('edit_product', $edit_product)->with('cate_product', $cate_product)->with('brand_product', $brand_product);
        return view('admin_layout')->with('admin.edit_product', $maneger_product);
    }
    public function update_product(Request $request, $product_id)
    {
        $this->AuthLogin();
        $data = $request->all();
        $product = Product::find($product_id);
        $product->product_name = $data['product_name'];
        $product->product_price = $data['product_price'];
        $product->product_desc = $data['product_desc'];
        $product->product_content = $data['product_content'];
        $product->category_id = $data['category_product'];
        $product->brand_id = $data['brand_product'];

        $get_image = $request->file('product_image');
        if ($get_image) {
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $get_name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move('public/upload/product', $new_image);
            $product->product_image = $new_image;
            $product -> save();
            Session::put('message', 'Cập nhật sản phẩm thành công');
            return Redirect::to('all-product');
        }
        $product -> save();
        Session::put('message', 'Cập nhật sản phẩm thành công');
        return Redirect::to('all-product');
    }
    public function delete_product($product_id)
    {
        $this->AuthLogin();
        Product::where('product_id', $product_id)->delete();
        Session::put('message', 'xoá danh mục sản phẩm thành công');
        return Redirect::to('all-product');
    }
    //End functions Admin pages
    //Function Admin home page
    public function details_product($product_id)
    {
        $cate_product = Category::where('category_status', '1')->orderBy('category_id', 'desc')->get();
        $brand_product = Brand::where('brand_status', '1')->orderBy('brand_id', 'desc')->get();
        $detail_product = Product::
            join('tbl_category_product', 'tbl_category_product.category_id', '=', 'tbl_product.category_id')
            ->join('tbl_brand_product', 'tbl_brand_product.brand_id', '=', 'tbl_product.brand_id')
            ->where('tbl_product.product_id', $product_id)->get();
        foreach ($detail_product as $key => $value) {
            $category_id = $value->category_id;
        }

        $related_product = Product::
            join('tbl_category_product', 'tbl_category_product.category_id', '=', 'tbl_product.category_id')
            ->join('tbl_brand_product', 'tbl_brand_product.brand_id', '=', 'tbl_product.brand_id')
            ->where('tbl_category_product.category_id', $category_id)->whereNotIn('tbl_product.product_id', [$product_id])->get();

        return view('pages.product.show_details')->with('category', $cate_product)->with('brand', $brand_product)->with('product_detail', $detail_product)->with('relate', $related_product);
    }
}
