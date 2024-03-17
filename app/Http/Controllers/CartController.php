<?php

namespace App\Http\Controllers;

use App\Mail\OrderEmail;
use App\Models\Color;
use App\Models\Order;
use App\Models\Order_detail;
use App\Models\Order_history;
use App\Models\Product;
use App\Models\Inventory;
use App\Models\User;
use App\Models\VoucherVietMart;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
class CartController extends Controller
{   
    //
    function show(){       
        session()->forget(['discount', 'voucher_applied']);
        $userId = Auth::user()->id;
        $cart = Cart::session($userId);
        foreach ($cart->getContent() as $item) {            
            $originalPrice = session('original_prices.' . $item->id, $item->price);
            $cart->update($item->id, [        
                'price' => $originalPrice,
                'discount_applied' => false,
            ]);            
        }


        
        return view('cart.show');
    }
    
    function add(Request $request){
        $price = $request->input('price');
        $id = $request->input('id');
        $color_id = $request->input('colorId');
        $size_id = $request->input('sizeId');
        // Cart::destroy();
        if (Auth::check()) {
            // $product = Product::find($id); 
            $product = Inventory::where('product_id', $id)
                        ->where('size_id', $size_id)
                        ->where('color_id', $color_id)
                        ->where('price', $price)
                        -> first();  
            $userId = Auth::user()->id; 
            if($product){
                Cart::session($userId)->add([
                    'id' => $product->id, 
                    'name' => $product->product->name,        
                    'quantity' => 1, 
                    'price' => $price,
                    'attributes' => array(
                        'type' => $product->size->name,
                        'color' => $product->color->name,
                        'thumbnail' => $product->image,
                        'product_id' => $product->product_id,
                        'originalPrice'=> $price,
                        'discount_applied' => false,
                    ),
                ]);                
            }         
            session(['original_prices.' . $product->id => $price]);
        // return Redirect::back()->with('add_cart_success', 'Thêm thành công sản phẩm vào giỏ hàng');
            $cartCount = Cart::session($userId)->getContent()->count();
            return response()->json(['message' => 'Thêm thành công sản phẩm vào giỏ hàng', 'cartCount' => $cartCount]);
        } else {
            return response()->json(['message' => 'Bạn phải đăng nhập để thực hiện thao tác này'], 401);
        }
    }
    public function remove($id){
        $userId = Auth::user()->id;     
        Cart::session($userId)->remove($id);
        $response = [
            'message' => 'Sản phẩm đã được xóa khỏi giỏ hàng.',
        ];
    
        return response()->json($response);
        // return redirect('cart/show');
    }
    function destroy(){
        $userId = Auth::user()->id;     
        Cart::session($userId)->clear();
        return redirect('cart/show');
    }

    


    
    function checkout(Request $request){
        $userId = Auth::user()->id; 
        $list_cart =  Cart::session($userId)->getContent();
        $total_sum = Cart::session($userId)->getTotal();
        return view('cart.checkout', compact('list_cart', 'total_sum'));
    }

    function payment(Request $request){
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'home_number' => 'required',
                'province' => 'required',
                'district' => 'required',
                'ward'=> 'required',
            ],
            [
                'required' => ':attribute không được để trống',
            ],
            [
                'name' => 'Họ và tên',
                'email' => 'Địa chỉ email xác nhận đơn hàng',
                'phone' => 'Số điện thoai người nhận',
                'province' => 'Thành phố',
                'district' => 'Quận/huyện',
                'ward' => 'Xã/phường'
            ],
        );

        $user_id = Auth::user()->id;

        $prefix = 'VIETMART'; // Tiền tố mã đơn hàng (tùy chọn)
        $length = 6; // Độ dài mã đơn hàng (tùy chọn)
    
        // Tạo mã đơn hàng ngẫu nhiên
        $randomCode = Str::random($length);
    
        // Kết hợp tiền tố và mã đơn hàng ngẫu nhiên
        $orderCode = $prefix . $randomCode;
        $order = Order::create(
            [
                'code' => $orderCode,
                'user_id' => $user_id,
                'price' => Cart::session($user_id)->getTotal(),
            ]
        );

        foreach(Cart::session($user_id)->getContent() as $product){
            $owner_id = Inventory::find($product->id)->product->user_id;    
            Order_detail::create(
                [
                    'order_id' => $order->id,
                    'user_id' => $user_id,
                    'product_id' => Inventory::find($product->id)->product_id,
                    'type' => $product->attributes->type, 
                    'color' => $product->attributes->color, 
                    'quantity' => $product->quantity,
                    'price' => $product->price,
                    'total' => $product->price * $product->quantity,
                    'status_id' => 1,
                    'owner_id' => $owner_id,
                ]
            );

            // Order_history::create(
            //     [
            //         'user_id' => $user_id,
            //         'product_id' => Inventory::find($product->id)->product_id,
            //         'quantity' => $product->quantity,
            //         'total' => $product->price * $product->quantity,
            //         'status_id' => 1,
            //     ]
            // );
        }
        $data = [
            'name' => $request->name,
            'address' => $request->address,
            'home_number' => $request->home_number,
            'phone' => $request->phone,
            'total' => Cart::session($user_id)->getTotal(),
            'cart' => Cart::session($user_id)->getContent(),
        ];
        Mail::to($request->email)->send(new OrderEmail($data));
        Cart::session($user_id)->clear();
        return view('cart.confirm_order');
    }

   function history(){
        $userId = Auth::user()->id; 
        $list_order_history = Order_detail::with('product', 'status', 'user')->where('user_id', $userId)->get();
        return view('cart.order_history', compact('list_order_history'));
   }


   //Tích hợp thanh toán VNpay
   function payment_VNpay(){
        $userId = Auth::user()->id; 
        $total = Cart::session($userId)->getTotal();
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://localhost/DoAn/vietmart/cart/checkout";
        $vnp_TmnCode = "3Y2173AY"; //Mã định danh merchant kết nối (Terminal Id)
        $vnp_HashSecret = "ULNOUVIMZUBXJAJJHEGOVSJEJABWSKOP"; //Secret key
        $startTime = date("YmdHis");
        $expire = date('YmdHis',strtotime('+15 minutes',strtotime($startTime)));

        error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $vnp_TxnRef = rand(1,10000); //Mã giao dịch thanh toán tham chiếu của merchant
        $vnp_Amount = $total; // Số tiền thanh toán
        $vnp_Locale = 'vn'; //Ngôn ngữ chuyển hướng thanh toán
        $vnp_BankCode = 'NCB'; //Mã phương thức thanh toán
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR']; //IP Khách hàng thanh toán

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount* 100,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => "Thanh toan VNPay test",
            "vnp_OrderType" => "other",
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_ExpireDate"=>$expire
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }  
        header('Location: ' . $vnp_Url); 
        die();    
   }

    function update(Request $request){  
        $userId = Auth::user()->id;     
        $data = $request->get('quantity');
        foreach($data as $key => $val){
            Cart::session($userId)->update($key, [
                'quantity' => array(
                    'relative' => false,
                    'value' => $val,
                ),
            ]);
        }
        $discount = 0;
        $newTotal = 0;
        $oldPriceDiscount = 0;
        $quantitySum = 0;
        if (session('voucher_applied', false)){
            $cart = Cart::session($userId);
            $voucher = session('voucher');                                                 
                if($voucher['discount_type'] == "percentage"){               
                    foreach ($cart->getContent() as $item) {
                        $quantitySum += $item->quantity;
                    }                 
                    $discountPercentage = $voucher['discount_value'] / 100;                
                    foreach ($cart->getContent() as $item) {                                                        
                        $newPriceDiscount = max($item->attributes->originalPrice * (1- $discountPercentage), 0);                  
                        // Cập nhật giá sản phẩm trong giỏ hàng
                        $cart->update($item->id, [
                            'price' => $newPriceDiscount, 
                            'discount_applied' => true,
                        ]);
                        $oldPriceDiscount += $item->attributes->originalPrice * $discountPercentage * $item->quantity ;
                
                    }     
                    $discount = $oldPriceDiscount;   
                    $newTotal = $cart->getTotal();

                    if($discount > $voucher['max_discount']){
                        foreach ($cart->getContent() as $item) {                                                          
                            $cart->update($item->id, [
                                'price' => $item->attributes->originalPrice,       
                            ]);                                      
                        }
                        $discount = 0;
                        $newTotal = 0;
                        // Tính toán giảm giá cần chia đều cho từng sản phẩm
                        $discountPerItem = $voucher['max_discount'] / $quantitySum;
                        foreach ($cart->getContent() as $item) {
                                    
                            // Tính giảm giá cho mỗi sản phẩm
                            $itemDiscount = $discountPerItem;

                            // Giảm giá không dưới 0
                            $newPriceDiscount = max($item->attributes->originalPrice - $itemDiscount, 0);
                            // Cập nhật giá sản phẩm trong giỏ hàng
                            $cart->update($item->id, [
                                'price' => $newPriceDiscount, // Giảm giá không dưới 0
                                'discount_applied' => true,
                            ]);
                    
                        $discount += ($itemDiscount*$item->quantity);
                        }
                    }                                                     
                    $newTotal = $cart->getTotal();                                                         
                
                }else 
                if($voucher['discount_type'] == "fixed"){            
                    $quantitySum = 0;
                    foreach ($cart->getContent() as $item) {
                        $quantitySum += $item->quantity;
                    }                
                    // Tính toán giảm giá cần chia đều cho từng sản phẩm
                    $discountPerItem = $voucher['discount_value'] / $quantitySum;
                    foreach ($cart->getContent() as $item) {
                                
                        // Tính giảm giá cho mỗi sản phẩm
                        $itemDiscount = $discountPerItem;

                        // Giảm giá không dưới 0
                        $newPriceDiscount = max($item->attributes->originalPrice - $itemDiscount, 0);
                        // Cập nhật giá sản phẩm trong giỏ hàng
                        $cart->update($item->id, [
                            'price' => $newPriceDiscount, // Giảm giá không dưới 0
                            'discount_applied' => true,
                        ]);
                
                    $discount += ($itemDiscount*$item->quantity);
                    }                                                   
                    $newTotal = $cart->getTotal();                                            
                    // Lưu giá trị chiết khấu vào session
                    session(['discount' => $discount]);
                    // Lưu giá trị giảm %
                    session(['discountValue' => $voucher['discount_value']]);
                }       
                return response()->json([
                    'success' => true,
                    'discountValue' => $newTotal,
                    'discountPrice' => $discount,
                ]);                                
        }
       
        
        return response()->json(['success' => true]);             
    }
   //Voucher

   public function voucher(Request $request)
{
    $voucher_text = $request->input('voucher_text');
    $userId = Auth::user()->id;
    $cart = Cart::session($userId);
    $flat = false;
    // Lấy danh sách voucher của người dùng
    // $user = User::find($userId);
    // $userVouchers = $user->vouchers;
    $listVoucher = VoucherVietMart::all(); 
    if (session('voucher_applied')) {
        return response()->json([
            'success' => false,
            'message' => 'Đã có mã giảm giá, chỉ được dùng 1 mã cho mỗi đơn hàng',
        ]);
    }
    foreach($listVoucher as $voucher){    
        if ($voucher->voucher_code === $voucher_text) {  
            if($cart->getTotal() < $voucher->min_order_value){
                return response()->json([
                    'success' => false,
                    'message' => 'Áp dụng không thành công, đơn hàng chưa đạt giá trị tối thiểu',
                ]);
            }
            if($voucher->usage_limit <= 0 ){
                return response()->json([
                    'success' => false,
                    'message' => 'Mã giảm giá đã hết lượt sử dụng',
                ]);
            }
            session()->forget(['discount', 'voucher_applied']);          
            $discount = 0;
            $newTotal = 0;
            $oldPriceDiscount = 0;
            $quantitySum = 0;
            if($voucher->discount_type === "percentage"){   
                session(['voucher' => $voucher]);            
                foreach ($cart->getContent() as $item) {
                    $quantitySum += $item->quantity;
                }                 
                $discountPercentage = $voucher->discount_value / 100;                
                foreach ($cart->getContent() as $item) {                                                        
                     $newPriceDiscount = max($item->attributes->originalPrice * (1- $discountPercentage), 0);                  
                     // Cập nhật giá sản phẩm trong giỏ hàng
                    $cart->update($item->id, [
                        'price' => $newPriceDiscount, // Giảm giá không dưới 0
                        'discount_applied' => true,
                    ]);
                    $oldPriceDiscount += $item->attributes->originalPrice * $discountPercentage * $item->quantity ;
             
                }     
                $discount = $oldPriceDiscount;   
                $newTotal = $cart->getTotal();
                if($discount > $voucher->max_discount){
                    foreach ($cart->getContent() as $item) {                                                          
                        $cart->update($item->id, [
                            'price' => $item->attributes->originalPrice,       
                        ]);                                      
                    }
                    $discount = 0;
                    $newTotal = 0;
                      // Tính toán giảm giá cần chia đều cho từng sản phẩm
                    $discountPerItem = $voucher->max_discount / $quantitySum;
                    foreach ($cart->getContent() as $item) {
                                   
                        // Tính giảm giá cho mỗi sản phẩm
                        $itemDiscount = $discountPerItem;
    
                        // Giảm giá không dưới 0
                        $newPriceDiscount = max($item->attributes->originalPrice - $itemDiscount, 0);
                        // Cập nhật giá sản phẩm trong giỏ hàng
                        $cart->update($item->id, [
                            'price' => $newPriceDiscount, // Giảm giá không dưới 0
                            'discount_applied' => true,
                        ]);
                
                       $discount += ($itemDiscount*$item->quantity);
                    }
                }                                                     
                $newTotal = $cart->getTotal();                         
            
                // Lưu giá trị chiết khấu vào session
                session(['discount' => $discount]);
                // Lưu giá trị giảm %
                session(['discountValue' => $voucher->discount_value]);
            
            }else if($voucher->discount_type === "fixed"){ 
                session(['voucher' => $voucher]);
                session()->forget(['discount', 'voucher_applied']);
                $quantitySum = 0;
                foreach ($cart->getContent() as $item) {
                    $quantitySum += $item->quantity;
                }                
                // Tính toán giảm giá cần chia đều cho từng sản phẩm
                $discountPerItem = $voucher->discount_value / $quantitySum;
                foreach ($cart->getContent() as $item) {
                               
                    // Tính giảm giá cho mỗi sản phẩm
                    $itemDiscount = $discountPerItem;

                    // Giảm giá không dưới 0
                    $newPriceDiscount = max($item->attributes->originalPrice - $itemDiscount, 0);
                    // Cập nhật giá sản phẩm trong giỏ hàng
                    $cart->update($item->id, [
                        'price' => $newPriceDiscount, // Giảm giá không dưới 0
                        'discount_applied' => true,
                    ]);
            
                   $discount += ($itemDiscount*$item->quantity);
                }                                                   
                $newTotal = $cart->getTotal();                         
            
                // Lưu giá trị chiết khấu vào session
                session(['discount' => $discount]);
                // Lưu giá trị giảm %
                session(['discountValue' => $voucher->discount_value]);
            }
               
    
            // Đánh dấu rằng mã giảm giá đã được áp dụng
            
            session(['voucher_applied' => true]);
            $flat = true;
            return response()->json([
                'success' => true,
                'newTotal' => $newTotal,
                'discount' => $discount,
                'message' => 'Mã giảm giá đã được áp dụng.'
            ]);
        }
        
    }
    if($flat == false){
        foreach ($cart->getContent() as $item) {
            $originalPrice = session('original_prices.' . $item->id, $item->price);
            $cart->update($item->id, [
                'price' => $originalPrice,
                'discount_applied' => false,
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Áp dụng mã không thành công']);
    }
    
}

}
