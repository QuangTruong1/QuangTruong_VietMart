<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Order_detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashBoardController extends Controller
{
    //
    function __construct(){
        $this->middleware(function($request, $next){
            session(['module_active' => 'dashboard']);
            return $next($request);
        });    

    }
    function show(){
        $list_order = Order::with('user')->orderBy('created_at', 'desc');
        $sum_order_trash = Order::onlyTrashed()->count();
        $count_order = Order::count();
        $total = Order::sum('price');

        if(Auth::user()->hasPermission('owner.view')){
            $owner_id = Auth::user()->id;
            $list_order_detail = Order_detail::with('order', 'product', 'status')->where('owner_id', $owner_id);
            $sum_order_trash = Order_detail::onlyTrashed()->where('owner_id', $owner_id)->count();
            $count_order_finished = Order_detail::where('status_id', '=', 2)->where('owner_id', $owner_id)->count();
            $count_order_unfinished = Order_detail::where('status_id', '=', 1)->where('owner_id', $owner_id)->count();
            $total = Order_detail::where('owner_id', $owner_id)->sum('total');
            $count = [$count_order_finished, $count_order_unfinished];
            $list_order_detail = $list_order_detail->paginate(5);
            $monthlyRevenue = Order_detail::where('owner_id', $owner_id)
                ->select(
                    Order_detail::raw('MONTH(created_at) as month'),
                    Order_detail::raw('SUM(price) as total_amount')
                )
                ->groupBy(Order_detail::raw('MONTH(created_at)'))
                ->orderBy('month')
                ->pluck('total_amount', 'month')
                ->toArray();     
            $allMonths = range(1, 10);
            $monthlyData = array_fill_keys($allMonths, 0);

            // Gộp dữ liệu thực tế vào mảng kết quả
            $monthlyResult = array_merge($monthlyData, $monthlyRevenue);

            // Lấy mảng giá trị để truyền vào biểu đồ Highcharts
            $dataForChart = array_values($monthlyResult);              
            return view('admin.dashboard_owner', compact('count', 'list_order_detail', 'total', 'sum_order_trash', 'dataForChart'));
        }
        $list_order = $list_order->paginate(5);
        $count = [$count_order];
        return view('admin.dashboard', compact('count', 'list_order', 'total', 'sum_order_trash'));
    }

    function delete($id){
        if($id != null){
            $order = Order::find($id);
            $order->forceDelete();
            return redirect('admin')->with('status', 'Xóa thành công');
        }
        return redirect('admin')->with('status', 'Xóa không thành công');
        
    }
}
