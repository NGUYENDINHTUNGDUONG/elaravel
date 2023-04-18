<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryProduct;
use App\Http\Controllers\BrandProduct;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\OrderController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//frontend
Route::get('/', [HomeController::class, 'index']); //chỉ vào HomeController vào file index
Route::get('/trang-chu', [HomeController::class, 'index']); //chỉ vào HomeController vào file index
Route::post('/search', [HomeController::class, 'search']); //chỉ vào HomeController vào file index


//danh mục sản phẩm trang chủ
Route::get('/danh-muc-san-pham/{category_id}', [CategoryProduct::class, 'show_category_home']);
Route::get('/loai-san-pham/{brand_id}', [BrandProduct::class, 'show_brand_home']);
Route::get('/chi-tiet-san-pham/{product_id}', [ProductController::class, 'details_product']);

//backend
//Send Mail
Route::get('/send-mail', [HomeController::class, 'send_mail']);
//login facebook
Route::get('/login-facebook', [LoginController::class, 'login_facebook']);
Route::get('/admin/callback', [LoginController::class, 'callback_facebook']);
Route::get('/admin', [AdminController::class, 'index']); //chỉ vào AdminController vào file index
Route::get('/dashboard', [AdminController::class, 'show_dashboard']); //chỉ vào AdminController vào file index
Route::get('/logout', [AdminController::class, 'logout']);
Route::post('/admin-dashboard', [AdminController::class, 'dashboard']);

//Category Product
Route::get('/add-category-product', [CategoryProduct::class, 'add_category_product']);
Route::get('/edit-category-product/{category_product_id}', [CategoryProduct::class, 'edit_category_product']);
Route::get('/delete-category-product/{category_product_id}', [CategoryProduct::class, 'delete_category_product']);
Route::get('/all-category-product', [CategoryProduct::class, 'all_category_product']);
Route::get('/unactive-category-product/{category_product_id}', [CategoryProduct::class, 'unactive_category_product']);
Route::get('/active-category-product/{category_product_id}', [CategoryProduct::class, 'active_category_product']);

//Route::get('/active-category-product/{category_product_id}', [CategoryProduct::class, 'active_category_product'])->name('active_category');
//Route::get('/unactive-category-product/{category_product_id}', [CategoryProduct::class, 'unactive_category_product'])->name('unactive_category');

Route::post('/save-category-product', [CategoryProduct::class, 'save_category_product']);
Route::post('/update-category-product/{category_product_id}', [CategoryProduct::class, 'update_category_product']);

//Brand Product
Route::get('/add-brand-product', [BrandProduct::class, 'add_brand_product']);
Route::get('/edit-brand-product/{brand_product_id}', [BrandProduct::class, 'edit_brand_product']);
Route::get('/delete-brand-product/{brand_product_id}', [BrandProduct::class, 'delete_brand_product']);
Route::get('/all-brand-product', [BrandProduct::class, 'all_brand_product']);
Route::get('/unactive-brand-product/{brand_product_id}', [BrandProduct::class, 'unactive_brand_product']);
Route::get('/active-brand-product/{brand_product_id}', [BrandProduct::class, 'active_brand_product']);

Route::post('/save-brand-product', [BrandProduct::class, 'save_brand_product']);
Route::post('/update-brand-product/{brand_product_id}', [BrandProduct::class, 'update_brand_product']);

//Product
Route::post('/search-product', [ProductController::class, 'search_product']);
Route::get('/add-product', [ProductController::class, 'add_product']);
Route::get('/edit-product/{product_id}', [ProductController::class, 'edit_product']);
Route::get('/delete-product/{product_id}', [ProductController::class, 'delete_product']);
Route::get('/all-product', [ProductController::class, 'all_product']);
Route::get('/unactive-product/{product_id}', [ProductController::class, 'unactive_product']);
Route::get('/active-product/{product_id}', [ProductController::class, 'active_product']);
Route::post('/save-product', [ProductController::class, 'save_product']);
Route::post('/update-product/{product_id}', [ProductController::class, 'update_product']);

//Check coupon
Route::post('/check-coupon', [CartController::class, 'check_coupon']);
Route::get('/add-coupon', [CouponController::class, 'add_coupon']);
Route::get('/list-coupon', [CouponController::class, 'list_coupon']);
Route::get('/delete-coupon', [CouponController::class, 'delete_coupon']);
Route::get('/unset-coupon', [CouponController::class, 'unset_coupon']);
Route::post('/add-coupon-code', [CouponController::class, 'add_coupon_code']);

//Cart Controller
Route::get('/cart', [CartController::class, 'cart']);
Route::get('/show-cart', [CartController::class, 'show_cart']);
Route::get('/delete-cart-product/{session_id}', [CartController::class, 'delete_cart_product']);
Route::get('/delete-all-product', [CartController::class, 'delete_all_product']);
Route::post('/update-cart', [CartController::class, 'update_cart']);
Route::post('/add-cart-ajax', [CartController::class, 'add_cart_ajax']);


//Checkout Controller
Route::get('/delete-fee', [CheckoutController::class, 'delete_fee']);
Route::get('/login-checkout', [CheckoutController::class, 'login_checkout']);
Route::get('/logout-checkout', [CheckoutController::class, 'logout_checkout']);
Route::post('/add-customer', [CheckoutController::class, 'add_customer']);
Route::post('/login-customer', [CheckoutController::class, 'login_customer']);
Route::get('/show-checkout', [CheckoutController::class, 'show_checkout']);
Route::post('/save-checkout-customer', [CheckoutController::class, 'save_checkout_customer']);
Route::post('/select-delivery-home', [CheckoutController::class, 'select_delivery_home']);
Route::post('/calculate-fee', [CheckoutController::class, 'calculate_fee']);
Route::post('/confirm-order', [CheckoutController::class, 'confirm_order']);

//Manage_order
Route::get('/history', [OrderController::class, 'history']);
Route::get('/print-order/{checkout_code}', [OrderController::class, 'print_order']);
Route::get('/manage-order', [OrderController::class, 'manage_order']);
Route::get('/view-order/{order_code}', [OrderController::class, 'view_order']);
Route::get('/view-history-order/{order_code}', [OrderController::class, 'view_history_order']);
Route::get('/update-qty', [OrderController::class, 'update_qty']);
Route::get('/update-order-qty}', [OrderController::class, 'update_order_qty']);


//Delivery
Route::get('/delivery', [DeliveryController::class, 'delivery']);
Route::post('/select-delivery', [DeliveryController::class, 'select_delivery']);
Route::post('/insert-delivery', [DeliveryController::class, 'insert_delivery']);
Route::post('/select-feeship', [DeliveryController::class, 'select_feeship']);
Route::post('/update-delivery', [DeliveryController::class, 'update_delivery']);


//Send Mail
Route::get('/send-coupon/{start_date}/{end_date}/{coupon_time}/{coupon_condition}/{coupon_number}/{coupon_code}', [MailController::class, 'send_coupon']);
Route::get('/mail-example', [MailController::class, 'mail_example']);
Route::get('/forget-password', [MailController::class, 'forget_password']);
Route::get('/update-new-pass', [MailController::class, 'update_new_pass']);
Route::post('/reset-new-pass', [MailController::class, 'reset_new_pass']);
Route::post('/recover-pass', [MailController::class, 'recover_pass']);
