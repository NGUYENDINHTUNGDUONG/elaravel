<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

session_start();

class CategoryProduct extends Controller
{
    //Functions Admin pages
    public function AuthLogin()
    {
        $admin_id = Session::get('admin_id');
        if ($admin_id) {
            return Redirect::to('dashboard');
        } else {
            return Redirect::to('admin')->send();
        }
    }
    public function add_category_product()
    {
        $this->AuthLogin();
        return view('admin.category.add_category_product');//file chả về view
    }
    public function all_category_product()
    {
        $this->AuthLogin();
        $all_category_product = Category::orderby('category_id', 'ASC')->get();
        $maneger_category_product = view('admin.category.all_category_product')->with('all_category_product', $all_category_product);
        return view('admin_layout')->with('admin.category.all_category_product', $maneger_category_product);
    }
    public function save_category_product(Request $request)
    //thêm danh mục sản phẩm
    {
        $this->AuthLogin();
        $data = $request->all();
        $category = new Category();//tạo mới db
        $category->category_name = $data['category_product_name'];
        $category->category_desc = $data['category_product_desc'];
        $category->category_status = $data['category_product_status'];
        //add các dữ liệu theo từng trường
        $category->save();
        Session::put('message', 'Thêm danh mục sản phẩm thành công');
        return Redirect::to('add-category-product');
    }
    public function active_category_product($category_product_id)
    {
        $this->AuthLogin();
        Category::where('category_id', $category_product_id)->update(['category_status' => 0]);
        Session::put('message', 'Không kích hoạt danh mục thành công');
        return Redirect::to('all-category-product');
    }
    public function unactive_category_product($category_product_id)
    {
        $this->AuthLogin();
        Category::where('category_id', $category_product_id)->update(['category_status' => 1]);
        Session::put('message', 'Kích hoạt danh mục thành công');
        return Redirect::to('all-category-product');
    }
    public function edit_category_product($category_product_id)
    {
        $this->AuthLogin();
        $edit_category_product = category::find($category_product_id);
        $maneger_category_product = view('admin.category.edit_category_product')->with('edit_category_product', $edit_category_product);
        return view('admin_layout')->with('admin.category.edit_category_product', $maneger_category_product);
    }
    public function update_category_product(Request $request, $category_product_id)
    {
        $this->AuthLogin();
        $data = $request->all();
        $category =  category::find($category_product_id);
        $category->category_name = $data['category_product_name'];
        $category->category_desc = $data['category_product_desc'];
        $category->save();
        Session::put('message', 'Cập nhật danh mục sản phẩm thành công');
        return Redirect::to('all-category-product');
    }
    public function delete_category_product($category_product_id)
    {
        $this->AuthLogin();
        Category::where('category_id', $category_product_id)->delete();
        Session::put('message', 'xoá danh mục sản phẩm thành công');
        return Redirect::to('all-category-product');
    }
    //End functions Admin pages
    //Function Admin home page
    public function show_category_home($category_id)
    {
        $cate_product = Category::where('category_status', '1')->orderBy('category_id', 'desc')->get();
        $brand_product = Brand::where('brand_status', '1')->orderBy('brand_id', 'desc')->get();
        $category_by_id = Product::join('tbl_category_product', 'tbl_product.category_id', '=', 'tbl_category_product.category_id')->where('tbl_product.category_id', $category_id,)->get();
        $category_name = Category::where('tbl_category_product.category_id', $category_id)->limit(1)->get();
        return view('pages.category.show_category')->with('category', $cate_product)->with('brand', $brand_product)->with('category_by_id', $category_by_id)->with('category_name', $category_name);
    }
}
