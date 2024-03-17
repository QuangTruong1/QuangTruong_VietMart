<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    //
    function home(){
        $list_product = Product::where('censorship_id', 1)->get();
        // $userId = Auth::user()->id;
        // $user = User::find($userId);
        // // Lấy danh sách voucher của người dùng
        // $userVouchers = $user->vouchers;
        // dd($userVouchers[1]->voucher_code);
        return view('guest.home', compact('list_product'));
    }
}
