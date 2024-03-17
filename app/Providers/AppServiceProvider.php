<?php

namespace App\Providers;

use App\Models\Industry;
use App\Models\User;
use App\Models\Wish_list;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Paginator::useBootstrap();
        View::composer(['cart.show', 'guest.home', 'cart.checkout', 'cart.confirm_order' , 'cart.order_history', 'product.detail', 'post.show', 'post.detail', 'shop.list', 'wish_list.show', 'shop.search', 'auth.login' , 'auth.register', 'auth.forgot-password', 'voucher.show'], function ($view) {
            if(Auth::user()){
                 // Lấy ID của người dùng hiện tại
                $user_id = Auth::user()->id;
                $users = User::where('id', '!=', $user_id)-> whereHas('roles', function ($query) {
                    $query->whereIn('role_id', [9, 11]);
                })->get();
                          
                // Lấy danh sách sản phẩm trong wishlist của người dùng
                $list_wish_list = Wish_list::with('product')->where('user_id', $user_id)->get();
                $view->with(
                    [
                        'list_wish_list' => $list_wish_list,
                        'users' => $users,
                    ]
                );
            }
           

            
            $list_industry = Industry::with('segment.product_cat')->get();
            // Truyền danh sách vào view
            $view->with(
                [
                   
                    'list_industry' => $list_industry,
                ]
            );
        });
    }
}
