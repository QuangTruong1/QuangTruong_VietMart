<?php

namespace App\Http\Controllers;

use App\Models\VoucherVietMart;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    //
    function show(){
        $list_voucher = VoucherVietMart::where('usage_limit', '>', 0)->where('end_date', '>', now())->get();        
        return view('voucher.show', compact('list_voucher'));
    }
}
