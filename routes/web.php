<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VoucherController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminAttributeController;
use App\Http\Controllers\AdminPostController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminVoucherVietMart;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\VoucherVietMart;

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

Route::get('/', function () {
    return redirect()->route('home');
});
// 'verified'
Route::get('/home', [HomeController::class, 'home'])->name('home');
Route::get('/messages/{receiverId}', [ChatController::class, 'getMessages']);
Route::post('/send', [ChatController::class, 'sendMessage']);
use App\Models\Message;
Route::get('/check-new-messages', [ChatController::class, 'checkNewMessages'])->name('chat.checkNewMessages');



Route::middleware(['auth'])->group(function () {
    //==================================CHAT======================================================
    

    //===============================File manager===============================================
    Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
        \UniSharp\LaravelFilemanager\Lfm::routes();
    });

    //========================================Phần người dùng================================================================
    
    Route::get('/admin', [DashBoardController::class, 'show'])->name('dashboard')->can('dashboard.view');
    //====================Voucher================================
    Route::get('voucher/show', [VoucherController::class, 'show'])->name('voucher.show');
    

    //====================Shopping CART================================
    Route::get('cart/show', [CartController::class, 'show'])->name('cart.show');
    Route::get('cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::get('cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('cart/destroy', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::post('cart/update', [CartController::class, 'update'])->name('cart.update');;
    //Thanh toán
    Route::get('cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('cart/payment', [CartController::class, 'payment'])->name('cart.payment');
    //Tích hợp thanh toán VNPay
    Route::get('cart/payment_VNpay', [CartController::class, 'payment_VNpay'])->name('cart.payment_VNpay');
    //Lịch sử mua hàng
    Route::get('cart/history', [CartController::class, 'history'])->name('cart.history');
    //Voucher sản phẩm
    Route::post('cart/voucher', [CartController::class, 'voucher'])->name('cart.voucher');

    //==================================PRODUCT==================================================
    //Chi tiết sản phẩm
    Route::get('product/detail/{id}', [ProductController::class, 'detail'])->name('product.detail');        
    Route::get('getColorsBySize/{productId}/{sizeId}', [ProductController::class, 'getColorsBySize'])->name('product.getColor');
    //Đánh giá sản phẩm
    Route::post('product/review/{id}', [ProductController::class, 'review'])->name('product.review');
    

    //=====================Wish List================================================
    Route::get('wishlist/show', [WishlistController::class, 'show'])->name('wishlist.show');
    Route::get('wishlist/add/{id}', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::get('wishlist/remove/{id}', [WishlistController::class, 'remove'])->name('wishlist.remove');

    //==================================POST========================================================
    Route::get('post/show', [PostController::class, 'show'])->name('post.show');
    Route::get('post/detail/{id}', [PostController::class, 'detail'])->name('post.detail');



    //========================================Phần admin================================================================

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //=================Voucher VietMart===================
    Route::get('/admin/voucher/list', [AdminVoucherVietMart::class, 'list'])->name('voucher_list')->can('voucher.view');   
    Route::get('/admin/voucher/add', [AdminVoucherVietMart::class, 'add'])->name('add_voucher')->can('voucher.add');
    Route::post('/admin/voucher/store', [AdminVoucherVietMart::class, 'store']);
    Route::get('/admin/voucher/edit/{id}', [AdminVoucherVietMart::class, 'edit'])->name('edit_voucher')->can('voucher.edit');
    Route::post('/admin/voucher/update/{id}', [AdminVoucherVietMart::class, 'update'])->name('update_voucher');
    Route::get('/admin/voucher/delete/{id}', [AdminVoucherVietMart::class, 'delete'])->name('delete_voucher')->can('voucher.delete');

    //=================User===================
    //Xem danh sách user
    Route::get('/admin/user/list', [AdminUserController::class, 'list'])->can('user.view');
    //Thêm user
    Route::get('/admin/user/add', [AdminUserController::class, 'add'])->can('user.add');
    Route::post('/admin/user/store', [AdminUserController::class, 'store']);
    //Xóa user
    Route::get('/admin/user/delete/{id}', [AdminUserController::class, 'delete'])->name('delete_user')->can('user.delete');
    //Các hành động
    Route::post('/admin/user/action', [AdminUserController::class, 'action']);
    //Chỉnh sửa thông tin user
    Route::get('/admin/user/edit/{id}', [AdminUserController::class, 'edit'])->name('user.edit')->can('user.edit');
    Route::post('/admin/user/update/{id}', [AdminUserController::class, 'update'])->name('user.update');

    //=================Product/Category_product============================
    //Danh mục sản phẩm
    Route::get('/shop/industry={industry}', [CategoryController::class, 'list'])->name('industry_list');
    //Tìm kiếm
    Route::get('/search', [CategoryController::class, 'search'])->name('search');
    Route::get('/search-sug', [CategoryController::class, 'search_sug'])->name('search_sug');
    //Xem danh sách sản phẩm/ danh mục/ danh mục ngành/ danh mục phân khúc
    Route::get('/admin/product/list', [AdminProductController::class, 'list'])->middleware('checkProductOwnerPermission');
    Route::get('/admin/product/cat/list', [AdminProductController::class, 'list_cat']);

    //Ngành hàng
    Route::get('/admin/product/industry/list', [AdminProductController::class, 'list_industry'])->can('industry.view');
    Route::post('/admin/product/industry/add', [AdminProductController::class, 'add_industry'])->name('add_industry');
    Route::get('/admin/product/industry/edit/{id}', [AdminProductController::class, 'edit_industry'])->name('edit_industry');
    Route::post('/admin/product/industry/update/{id}', [AdminProductController::class, 'update_industry'])->name('update_industry');
    Route::get('/admin/product/industry/delete/{id}', [AdminProductController::class, 'delete_industry'])->name('delete_industry');

    //Phân khúc
    Route::get('/admin/product/segment/list', [AdminProductController::class, 'list_segment'])->can('segment.view');
    Route::post('/admin/product/segment/add', [AdminProductController::class, 'add_segment'])->name('add_segment');
    Route::get('/admin/product/segment/edit/{id}', [AdminProductController::class, 'edit_segment'])->name('edit_segment');
    Route::post('/admin/product/segment/update/{id}', [AdminProductController::class, 'update_segment'])->name('update_segment');
    Route::get('/admin/product/segment/delete/{id}', [AdminProductController::class, 'delete_segment'])->name('delete_segment');

    //Load các thành phần khi thêm sản phẩm
    Route::get('/get-segments/{id}', [AdminProductController::class, 'getSegments']);
    Route::get('/get-product-cats/{id}', [AdminProductController::class, 'getProductCats']);
    Route::get('/attributes/{product_cat_id}', [AdminAttributeController::class, 'getAttributes']);

    //Quản lý các attribute khác của mỗi loại sản phẩm
    Route::get('/admin/product/attribute/list', [AdminAttributeController::class, 'list_attribute'])->can('attribute.view');
    Route::post('/admin/product/attribute/add', [AdminAttributeController::class, 'add_attribute'])->name('add_attribute');
    Route::get('/admin/product/attribute/edit/{id}', [AdminAttributeController::class, 'edit_attribute'])->name('edit_attribute');
    Route::post('/admin/product/attribute/update/{id}', [AdminAttributeController::class, 'update_attribute'])->name('update_attribute');
    Route::get('/admin/product/attribute/delete/{id}', [AdminAttributeController::class, 'delete_attribute'])->name('delete_attribute');

    //Quản lý giá trị của các attribute
    Route::get('/admin/product/attribute_value/list', [AdminAttributeController::class, 'list_attribute_value'])->can('attribute_value.view');
    Route::post('/admin/product/attribute_value/add', [AdminAttributeController::class, 'add_attribute_value'])->name('add_attribute_value');
    Route::get('/admin/product/attribute_value/edit/{id}', [AdminAttributeController::class, 'edit_attribute_value'])->name('edit_attribute_value');
    Route::post('/admin/product/attribute_value/update/{id}', [AdminAttributeController::class, 'update_attribute_value'])->name('update_attribute_value');
    Route::get('/admin/product/attribute_value/delete/{id}', [AdminAttributeController::class, 'delete_attribute_value'])->name('delete_attribute_value');

    //Xuất file excel products
    Route::get('/admin/product/excel', [AdminProductController::class, 'export'])->name('export_products');

    //==========================================Quản lý các thông tin chung của sản phẩm==================================
    //Material
    Route::get('/admin/product/material/list', [AdminProductController::class, 'list_material']);
    Route::post('/admin/product/material/add', [AdminProductController::class, 'add_material'])->name('add_material');
    Route::get('/admin/product/material/edit/{id}', [AdminProductController::class, 'edit_material'])->name('edit_material');
    Route::post('/admin/product/material/update/{id}', [AdminProductController::class, 'update_material'])->name('update_material');
    Route::get('/admin/product/material/delete/{id}', [AdminProductController::class, 'delete_material'])->name('delete_material');
    //Brand
    Route::get('/admin/product/brand/list', [AdminProductController::class, 'list_brand']);
    Route::post('/admin/product/brand/add', [AdminProductController::class, 'add_brand'])->name('add_brand');
    Route::get('/admin/product/brand/edit/{id}', [AdminProductController::class, 'edit_brand'])->name('edit_brand');
    Route::post('/admin/product/brand/update/{id}', [AdminProductController::class, 'update_brand'])->name('update_brand');
    Route::get('/admin/product/brand/delete/{id}', [AdminProductController::class, 'delete_brand'])->name('delete_brand');
    //Pattern
    Route::get('/admin/product/pattern/list', [AdminProductController::class, 'list_pattern']);
    Route::post('/admin/product/pattern/add', [AdminProductController::class, 'add_pattern'])->name('add_pattern');
    Route::get('/admin/product/pattern/edit/{id}', [AdminProductController::class, 'edit_pattern'])->name('edit_pattern');
    Route::post('/admin/product/pattern/update/{id}', [AdminProductController::class, 'update_pattern'])->name('update_pattern');
    Route::get('/admin/product/pattern/delete/{id}', [AdminProductController::class, 'delete_pattern'])->name('delete_pattern');

    //Thêm sản phẩm
    Route::get('/admin/product/add', [AdminProductController::class, 'add_product'])->can('product.add');
    Route::post('/admin/product/store', [AdminProductController::class, 'store']);
    //Các hành động product
    Route::post('/admin/product/action', [AdminProductController::class, 'action']);
    //Xóa sản phẩm
    Route::get('/admin/product/delete/{id}', [AdminProductController::class, 'delete'])->name('delete_product')->can('product.delete');
    //Edit sản phẩm
    Route::get('/admin/product/edit/{id}', [AdminProductController::class, 'edit_product'])->name('product.edit_product')->can('product.edit');
    Route::post('/admin/product/update/{id}', [AdminProductController::class, 'update_product'])->name('product.update_product');
    //Thêm danh mục sản 
    Route::post('/admin/product/cat/add', [AdminProductController::class, 'add_cat'])->name('add_product_cat');
    //Edit danh mục sản phẩm
    Route::get('/admin/product/cat/edit/{id}', [AdminProductController::class, 'edit_cat'])->name('edit_product_cat');
    Route::post('/admin/product/cat/update/{id}', [AdminProductController::class, 'update_cat'])->name('update_product_cat');
    //Xóa danh mục sản phẩm
    Route::get('/admin/product/cat/delete/{id}', [AdminProductController::class, 'delete_cat'])->name('delete_product_cat');

    //============================POST============================================================
    //Xem bài viết//Danh mục
    Route::get('/admin/post/list', [AdminPostController::class, 'list'])->can('post.view');
    Route::get('/admin/post/cat/list', [AdminPostController::class, 'list_cat']);
    //Thêm bài viết(có tích hợp trình soản thảo và quản lý file)
    Route::get('/admin/post/add', [AdminPostController::class, 'add'])->can('post.add');
    Route::post('/admin/post/store', [AdminPostController::class, 'store']);
    //Xóa bài viết
    Route::get('/admin/post/delete/{id}', [AdminPostController::class , 'delete'])->name('delete_post')->can('post.delete');
    //Các hành động product
    Route::post('/admin/post/action', [AdminPostController::class, 'action']);
    //Edit bài viết
    Route::get('/admin/post/edit/{id}', [AdminPostController::class, 'edit_post'])->name('post.edit_post')->can('post.edit');
    Route::post('/admin/post/update/{id}', [AdminPostController::class, 'update_post'])->name('post.update_post');
    //Thêm danh mục bài viết
    Route::post('/admin/post/cat/add', [AdminPostController::class, 'add_cat'])->name('add_post_cat');
    //Edit danh mục
    Route::get('/admin/post/cat/edit/{id}', [AdminPostController::class, 'edit_cat'])->name('edit_post_cat');
    Route::post('/admin/post/cat/update/{id}', [AdminPostController::class, 'update_cat'])->name('update_post_cat');
    //Xóa danh mục
    Route::get('/admin/post/cat/delete/{id}', [AdminPostController::class, 'delete_cat'])->name('delete_post_cat');

    //==============================Order==============================================================
    //Xem danh sách đơn hàng
    Route::get('/admin/order/list', [AdminOrderController::class, 'list'])->can('order.view');
    //Các hành động order
    Route::post('/admin/order/action', [AdminOrderController::class, 'action']);
    //Xóa bài đơn hàng
    Route::get('/admin/order/delete/{id}', [AdminOrderController::class , 'delete'])->name('delete_order')->can('order.delete');
    //Xóa đơn hàng ở dashboard
    Route::get('/admin/dashboard/delete/{id}', [DashBoardController::class , 'delete'])->name('delete_order_dashboard');
    //Quản lý đánh giá sản phẩm của khách hàng
    Route::get('/admin/product/comments', [AdminOrderController::class, 'list_comment'])->can('reply_comment.view');
    Route::post('/admin/product/reply/{id}', [AdminOrderController::class, 'reply'])->name('rely_comment');

    //================================Permission========================================
    //Thêm permission
    Route::get('/admin/permission/add', [PermissionController::class, 'add'])->name('permission.add')->can('permission.view');
    Route::post('/admin/permission/store', [PermissionController::class, 'store'])->name('permission.store');
    //Edit permission
    Route::get('/admin/permission/edit/{id}', [PermissionController::class, 'edit'])->name('permission.edit');
    Route::post('/admin/permission/update/{id}', [PermissionController::class, 'update'])->name('permission.update');
    //Xóa permission
    Route::get('/admin/permission/delete/{id}', [PermissionController::class, 'delete'])->name('permission.delete');
    //======================================Roles==============================================
    //Hiển thị danh sách role
    Route::get('/admin/role/list', [RoleController::class, 'list'])->name('role.list')->can('role.view');
    //Các hành động
    Route::post('/admin/role/action', [RoleController::class, 'action']);
    //Xóa role
    Route::get('/admin/role/delete/{id}', [RoleController::class , 'delete'])->name('role.delete')->can('role.delete');
    //Thêm vai trò (role)
    Route::get('/admin/role/add', [RoleController::class, 'add'])->name('role.add')->can('role.add');
    Route::post('/admin/role/store', [RoleController::class, 'store'])->name('role.store');
    //Chỉnh sửa vai trò (role)
    Route::get('/admin/role/edit/{id}', [RoleController::class, 'edit'])->name('role.edit')->can('role.edit');
    Route::post('/admin/role/update/{id}', [RoleController::class, 'update'])->name('role.update');

});


require __DIR__.'/auth.php';
