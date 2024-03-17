<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Order;
use App\Models\Order_detail;
use App\Models\Rating;
use App\Models\Reply_comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminOrderController extends Controller
{
    //
    function __construct(){
        $this->middleware(function($request, $next){
            session(['module_active' => 'order']);
            return $next($request);
        });  
    }
    function list(Request $request){
        $status = $request->input('status');
        $list_act = [
            'delete'=> "Xóa",
        ];
        
        if($status == 'finish'){
            $list_order = Order::with('user');  
        }  
        else if($status == 'unfinished'){
            $list_act = [
                'finish_order' => 'Hoàn thành',
            ];
            $list_order = Order::with('user');  
        }
        else if($status == 'trash'){
            $list_act = [
                'restore' => "Khôi phục",
                'force' => 'Xóa vĩnh viễn',
            ];
            $list_order = Order::with('user') -> onlyTrashed(); 
        }
        else{
            $key = "";
            if($request->input('key')){
                $key = $request->input('key');               
            }    
            
            $list_order = Order::with('user') -> where('code', 'like', '%' . $key . '%');  
        }
        $count_order_trash = Order::with('user') -> onlyTrashed()->count();
        

        if(Auth::user()->hasPermission('owner.view')){
            $owner_id = Auth::user()->id;
            if($status == 'finish'){
                $list_order_detail = Order_detail::with('order', 'product', 'status') ->where('owner_id', $owner_id)->where('status_id' , '=', 2);  
            }  
            else if($status == 'unfinished'){
                $list_order_detail = Order_detail::with('order', 'product', 'status') ->where('owner_id', $owner_id)->where('status_id' , '=', 1);  
            }
            else if($status == 'trash'){
                $list_act = [
                    'restore' => "Khôi phục",
                    'force' => 'Xóa vĩnh viễn',
                ];
                $list_order_detail = Order_detail::with('order', 'product', 'status')->where('owner_id', $owner_id) -> onlyTrashed(); 
            }
            else{
                $key = "";
                if($request->input('key')){
                    $key = $request->input('key');               
                }    
                
                $list_order_detail = Order_detail::with('order', 'product', 'status')->where('owner_id', $owner_id);  
            }
            // $list_order_detail = Order_detail::with('order', 'product', 'status') ->where('owner_id', $owner_id);
            $count_order_finish = Order_detail::where('status_id', '=', 2)->where('owner_id', $owner_id)->count(); 
            $count_order_unfinished = Order_detail::where('status_id', '=', 1)->where('owner_id', $owner_id)->count(); 
            $count_order_trash = Order_detail::with('user', 'product', 'status')->where('owner_id', $owner_id) -> onlyTrashed()->count();
            $list_order_detail = $list_order_detail->orderBy('created_at', 'desc')->paginate(5);
            $count = [$count_order_finish, $count_order_unfinished, $count_order_trash];
            return view('admin.order.list_detail', compact('list_order_detail', 'count', 'list_act'));
        
        }
        
        $list_order = $list_order->paginate(5);
        $count = [ $count_order_trash];

        return view('admin.order.list', compact('list_order', 'count', 'list_act'));
    }

    function action(Request $request){        
        $list_check = $request-> input('list_check');
        if($list_check){            
            //Thực hiện tác vụ
            if(!empty($list_check)){
                $act = $request->input('act');
                if($act == ''){
                    return redirect('admin/order/list?status=finish')->with('status', 'Vui lòng chọn hành động');
                }
                if($act == "delete"){
                    Order_detail::destroy($list_check);
                    return redirect('admin/order/list?status=finish')->with('status', 'Xóa thành công các phần tử đã chọn');
                }
                else if($act == "restore"){
                    Order_detail::withTrashed()->whereIn('id', $list_check) -> restore();
                    return redirect('admin/order/list?status=finish')->with('status', 'Khôi phục thành công các phần tử đã chọn');
                }
                else if($act == "finish_order"){
                    Order_detail::whereIn('id', $list_check)->update(['status_id' => '2']);
                    return redirect('admin/order/list?status=finish')->with('status', 'Thao tác thành công các phần tử đã chọn');
                }
                else{
                    
                    Order_detail::withTrashed()->whereIn('id', $list_check) -> forceDelete();
                    return redirect('admin/order/list?status=finish')->with('status', 'Xóa vĩnh viễn thành công các phần tử đã chọn');
                }
            }            
        }
        else{
            return redirect('admin/order/list?status=finish')->with('status', 'Vui lòng chọn phần tử để thực hiện thao tác');
        }
    }

    function delete($id){
        if($id != null){
            $order = Order_detail::find($id);
            $order->delete();
            return redirect('admin/order/list')->with('status', 'Xóa thành công');
        }
        return redirect('admin/order/list')->with('status', 'Xóa không thành công');
        
    }

    function list_comment(Request $request){
        $store_id = Auth::user()->id;
        $status = $request->input('status');
        if($status == 'wait_reply'){
            $list_comment = Comment::where('status_comment_id', 1);
        }
        else{
            $list_comment = Comment::where('status_comment_id', 2);
        }
        $list_comment = $list_comment->whereHas('product', function($q) use ($store_id) {
            $q->where('user_id', $store_id);
        })->paginate(10);
        $count_comment_wait_reply = Comment::whereHas('product', function($q) use ($store_id) {
            $q->where('user_id', $store_id);
        })->where('status_comment_id', 1)->count();
        $count_comment_reply = Comment::whereHas('product', function($q) use ($store_id) {
            $q->where('user_id', $store_id);
        })->where('status_comment_id', 2)->count();
        $count = [$count_comment_wait_reply, $count_comment_reply];

        $ratings = Rating::get();

        return view('admin.order.list_comment', compact('list_comment', 'count', 'ratings'));
    }

    function reply($id, Request $request){
        if($request->reply_content != ''){
            Reply_comment::create(
                [
                    'content' => $request->reply_content,
                    'comment_id' => $id, 
                ]
            );
            Comment::where('id', $id)->update(
                [
                    'status_comment_id' => 2,
                ]
            );
        }
        return redirect('admin/product/comments')->with('status', 'Phản hồi thành công');
    }

}
