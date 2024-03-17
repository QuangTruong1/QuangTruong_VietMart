<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wish_list;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class WishlistController extends Controller
{
    //
    function show(){
        $user_id = Auth::user()->id;
        $list_wish_list = Wish_list::with('product')
            ->where('user_id', $user_id)
            ->get();
        return view('wish_list.show', compact('list_wish_list'));
    }
    
    function add($id){
        if (Auth::check()) {
            $user_id = Auth::user()->id;
            //Kiểm tra xem sản phẩm đã tồn tại trong wishlist hay chưa
            $existingWishList = Wish_List::where('user_id', $user_id)->where('product_id', $id)->first();
            if ($existingWishList) {
                // return Redirect::back()->with('add_wishlist_fail', 'Sản phẩm đã tồn tại trong wishlist.');
                return response()->json(['messageFalse' => 'Sản phẩm đã tồn tại trong wishlist']);
            }
            Wish_list::create([
                'user_id' => $user_id,
                'product_id' => $id,
            ]);
            $list_wish_list = Wish_list::with('product')->where('user_id', $user_id)->count();
            return response()->json(['messageTrue' => 'Thêm thành công sản phẩm vào mục yêu thích', 'list_wish_list' => $list_wish_list]);
        } else {
            return response()->json(['message' => 'Bạn phải đăng nhập để thực hiện thao tác này'], 401);
        }
        
        // return Redirect::back()->with('add_wishlist_success', 'Thêm thành công sản phẩm vào mục yêu thích');
        // return redirect('wishlist/show');
    }

    function remove($id){
        Wish_list::find($id)->delete();

        $response = [
            'message' => 'Sản phẩm đã được xóa khỏi giỏ hàng.',
        ];
    
        return response()->json($response);
        // return redirect('wishlist/show');
    }
}
