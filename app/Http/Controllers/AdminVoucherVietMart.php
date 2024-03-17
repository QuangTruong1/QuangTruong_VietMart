<?php

namespace App\Http\Controllers;

use App\Models\VoucherVietMart;
use Illuminate\Http\Request;

class AdminVoucherVietMart extends Controller
{
    function __construct(){
        $this->middleware(function($request, $next){
            session(['module_active' => 'voucher']);
            return $next($request);
        });    

    }
    //
    function list(Request $request){
        $status = $request->input('status');
        $list_act = [
            'delete' => 'Xóa'
        ];
        if($status == 'valid'){
            $vouchers = VoucherVietMart::where('usage_limit', '>', 0)->where('end_date', '>=', now()); 
        }
        else if($status == 'invalid'){
            $vouchers = VoucherVietMart::where('usage_limit', '<=' , 0)->orWhere('end_date', '<', now());
        }
        else{
            $key = "";
            if($request->input('key')){
                $key = $request->input('key');               
            }    
            $vouchers = VoucherVietMart::where('program_name', 'like', '%' . $key . '%');  
        }
        $count_voucher_valid = VoucherVietMart::where('usage_limit', '>', 0)->where('end_date', '>=', now())->count();
        $count_voucher_invalid = VoucherVietMart::where('usage_limit', '<=', 0)->orWhere('end_date', '<', now())->count();
        $count = [$count_voucher_valid, $count_voucher_invalid];
        $vouchers = $vouchers->paginate(6);
        return view('admin.voucher.list', compact(['vouchers', 'count', 'list_act', 'status']));
    }
    function action(Request $request){
        $list_check = $request-> input('list_check');
        if($list_check){            
            //Thực hiện tác vụ
            if(!empty($list_check)){
                $act = $request->input('act');
                if($act == ''){
                    return redirect('admin/product/list')->with('status', 'Vui lòng chọn hành động');
                }
                if($act == "delete"){
                    VoucherVietMart::withTrashed()->whereIn('id', $list_check) -> forceDelete();
                    return redirect('admin/voucher/list')->with('status', 'Xóa thành công các phần tử đã chọn');
                }
            }            
        }
        else{
            return redirect('admin/voucher/list')->with('status', 'Vui lòng chọn phần tử để thực hiện thao tác');
        }
    }

    function add(){
        return view('admin.voucher.add');
    }
    function store(Request $request){         
        if($request->input('btn-add')){
            $discount_value = 0;
            if($request->discount_type == 'fixed'){
                $discount_value = $request->discount_value_fixed;
            }else{
                $discount_value = $request->discount_value_percen;
            }
            $request->validate(
                [
                    'voucher_cat' => 'required',
                    'name_voucher' => 'required',
                    'voucher_text' => 'required|min:5|max:5',
                    'start_time' => 'required|date',
                    'end_time' => 'required|date|after:start_time',
                    'discount_type' => 'required',               
                    'max_discount' => 'nullable|numeric',
                    'min_order_value' => 'required|numeric',
                    'usage_limit' => 'required|numeric',
                ],
                [
                    'required' => "Không được để trống",
                    'numeric' => "Dữ liệu phải là số",
                    'min' => "Mã voucher phải đủ 5 ký tự",
                    'max' => "Mã voucher phải đủ 5 ký tự",
                ]
            );
    
            // Lưu dữ liệu vào cơ sở dữ liệu          
            VoucherVietMart::create([
                'program_name' => $request->name_voucher,
                'voucher_code' => $request->voucher_text,
                'start_date' => $request->start_time,
                'end_date' => $request->end_time,
                'discount_type' => $request->discount_type,
                'discount_value' => $discount_value,
                'max_discount' => $request->max_discount,
                'min_order_value' => $request->min_order_value,
                'usage_limit' => $request->usage_limit
            ]);               
    
            // Redirect hoặc thực hiện các công việc khác sau khi lưu dữ liệu thành công
            return redirect('admin/voucher/list?status=valid')->with('status', 'Voucher đã được thêm mới thành công!');
        }
    }
    
    function delete(Request $request, $id){
        if($id != null){
            $voucher = VoucherVietMart::find($id);
            $voucher->forceDelete();
            return redirect('admin/voucher/list?status=valid')->with('status', 'Xóa thành công');
        }
        return redirect('admin/voucher/list/list?status=valid')->with('status', 'Xóa không thành công');
        
    }

    function edit($id){
        $voucher = VoucherVietMart::find($id);
        return view('admin.voucher.edit', compact(['voucher']));
    }

    function update($id, Request $request){
        if($request->input('btn-edit')){
            $discount_value = 0;
            if($request->discount_type == 'fixed'){
                $discount_value = $request->discount_value_fixed;
                $max_discount = null;
            }else{
                $discount_value = $request->discount_value_percen;
                $max_discount = $request->max_discount;
            }
            $request->validate(
                [
                    'voucher_cat' => 'required',
                    'name_voucher' => 'required',
                    'voucher_text' => 'required|min:5|max:5',
                    'start_time' => 'required|date',
                    'end_time' => 'required|date|after:start_time',
                    'discount_type' => 'required',               
                    'max_discount' => 'nullable|numeric',
                    'min_order_value' => 'required|numeric',
                    'usage_limit' => 'required|numeric',
                ],
                [
                    'required' => "Không được để trống",
                    'numeric' => "Dữ liệu phải là số",
                    'min' => "Mã voucher phải đủ 5 ký tự",
                    'max' => "Mã voucher phải đủ 5 ký tự",
                ]
            );
    
            // Cập nhật liệu vào cơ sở dữ liệu    
            $voucher = VoucherVietMart::find($id);
            VoucherVietMart::where('id', $voucher->id)->update([
                'program_name' => $request->name_voucher,
                'voucher_code' => $request->voucher_text,
                'start_date' => $request->start_time,
                'end_date' => $request->end_time,
                'discount_type' => $request->discount_type,
                'discount_value' => $discount_value,
                'max_discount' => $max_discount,
                'min_order_value' => $request->min_order_value,
                'usage_limit' => $request->usage_limit
            ]);               
    
            // Redirect hoặc thực hiện các công việc khác sau khi lưu dữ liệu thành công
            return redirect('admin/voucher/list?status=valid')->with('status', 'Chỉnh sửa thông tin Voucher thành công!');
        }
    }
}
