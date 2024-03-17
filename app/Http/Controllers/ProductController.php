<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Comment;
use App\Models\Reply_comment;
use App\Models\Images;
use App\Models\Inventory;
use App\Models\Order_detail;
use App\Models\Product;
use App\Models\Rating;
use App\Models\General_info;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ProductController extends Controller
{
    function detail($id){
        $product = Product::find($id);    
        $productInfo_general = General_info::with(['brand', 'material', 'pattern'])->where("product_id", $id)->first();           
        $productCatId = $product->product_cat_id;
        $attributes = Attribute::where('product_cat_id', $productCatId)->get();
       
        $tb_rating = Rating::where('product_id', $id)->avg('rating_value');
        $count_review = Comment::where('product_id', $id)->count();
        $list_review = Comment::with(['user', 'product', 'rating', 'reply'])                                
                                ->where('comments.product_id', $id)                                   
                                ->paginate(10); 

   
       
        $list_rating = Rating::with('user', 'product')->where('product_id', $id)->get();
        $focusReview = request('focus') == true ? true : false;

        $user_id = Auth::user()->id;
        $check_order =  Order_detail::where('user_id', $user_id)->where('product_id', $id)->where('status_id', 2)->first();
        $check_comment = Comment::where('user_id', $user_id)->where('product_id', $id)->first();

        if ($product) {
            $inventories = $product->inventories; 
            $inventories = $inventories->sortBy('price');
            // Lặp qua danh sách inventory để lấy size và hiển thị thông tin
            $sizeIds = [];
            foreach ($inventories as $inventory) {
                $size = $inventory->size; 
                if ($size && !in_array($size->id, $sizeIds)) {
                    $sizeNames[] = [$size->id, $size->name];
                    $sizeIds[] = $size->id;
                }
                    
            }
        }        
        return view('product.detail', compact('productInfo_general', 'check_order', 'check_comment', 'product', 'tb_rating', 'count_review', 'list_review', 'list_rating', 'focusReview', 'sizeNames', 'inventories'));
    }

    function getColorsBySize($productId, $sizeId) {
        $colors = Inventory::where('product_id', $productId)
            ->where('size_id', $sizeId)
            ->pluck('color_id');
        $colorData = Color::whereIn('id', $colors)->select('id', 'name')->get();
    
        return response()->json($colorData);
    }

    function review($id, Request $request){
        $user_id = Auth::user()->id;

        $check_order =  Order_detail::where('user_id', $user_id)->where('product_id', $id)->first();
        if(!$check_order){
            return response()->json(['check_review' => 'Vui lòng trải nghiệm sản phẩm để có những nhận xét chính xác nhất']);
        }

        $check = Comment::where('user_id', $user_id)->where('product_id', $id)->first();
        if ($check) {
            // Nếu đã nhận xét rồi, bạn có thể hiển thị thông báo hoặc thực hiện các hành động khác tùy ý
            // return Redirect::back()->with('check_review', 'Bạn đã có nhận xét về sản phẩm này');
            return response()->json(['check_review' => 'Bạn đã có nhận xét về sản phẩm này']);
        }
        $rating = Rating::create(
            [
                'rating_value' => $request->rating,
                'user_id' => $user_id,
                'product_id' => $id,
            ]
        );
        Comment::create(
            [
                'content' => $request->content,
                'rating_id' => $rating->id,
                'user_id' => $user_id,
                'product_id' => $id,
                'status_comment_id' => 1,
            ]
        );
        
        // return Redirect::back()->with('success_review', 'Cảm ơn bạn đã nhận xét sản phẩm của chúng tôi');
        return response()->json(['success_review' => 'Cảm ơn bạn đã nhận xét sản phẩm của chúng tôi']);
    }
}
