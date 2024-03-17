@extends('layouts.layout_guest')
@section('content')
            <!-- Categorie Menu & Slider Area Start Here -->
            <div class="main-page-banner home-3">
                <div class="container">
                    <div class="row">
                        <!-- Vertical Menu Start Here -->
                        <div class="col-xl-3 col-lg-4 d-none d-lg-block">
                            <div class="vertical-menu mb-all-30">
                                <nav>
                                    <ul class="vertical-menu-list">
                                        @foreach ($list_industry as $industry)                                   
                                            <li class=""><a href="{{route('industry_list', ['industry' => $industry->id])}}"><span><img src="{{asset('img\vertical-menu\1.png')}}" alt="menu-icon"></span>{{$industry->name}}</a></li>                                       
                                        @endforeach
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <!-- Vertical Menu End Here -->
                    </div>
                    <!-- Row End -->
                </div>
                <!-- Container End -->           
            </div>
            <!-- Categorie Menu & Slider Area End Here -->
            <!-- Breadcrumb Start -->
            <div class="breadcrumb-area mt-30">
                <div class="container">
                    <div class="breadcrumb">
                        <ul class="d-flex align-items-center">
                            <li><a href="index.html">Home</a></li>
                            <li class="active"><a href="cart.html">Cart</a></li>
                        </ul>
                    </div>
                </div>
                <!-- Container End -->
            </div>
            <!-- Breadcrumb End -->
            <!-- Cart Main Area Start -->
            <div class="cart-main-area ptb-100 ptb-sm-60">
                <div class="container">                  
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <!-- Form Start -->
                            @if (Cart::session(Auth::user()->id)->getContent()->count() > 0)
                            <form action="{{route('cart.update')}}" method="POST">
                                @csrf 
                                <!-- Table Content Start -->
                                <div class="table-content table-responsive mb-30">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th class="product-thumbnail">Image</th>
                                                <th class="product-name">Product name</th>
                                                <th class="product-type">Type</th>
                                                <th class="product-type">Color</th>
                                                <th class="product-price-main">Price</th>
                                                <th class="product-quantity">Quantity</th>
                                                <th class="product-subtotal">Total</th>
                                                <th class="product-remove">Remove</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                           @foreach (Cart::session(Auth::user()->id)->getContent() as $item)
                                                <tr>
                                                    <td class="product-thumbnail">
                                                        <a href="{{route('product.detail', $item->attributes->product_id)}}"><img src="{{asset($item->attributes->thumbnail)}}" alt="cart-image"></a>
                                                    </td>
                                                    <td class="product-name"><a href="{{route('product.detail', $item->attributes->product_id)}}">{{$item->name}}</a></td>
                                                    <td class="product-name"><span>{{$item->attributes->type}}</span></td>
                                                    <td class="product-name"><span>{{$item->attributes->color}}</span></td>
                                                    @if ($item->attributes->discount_applied == true)
                                                        <td class="product-price-main"><span class="amount">{{number_format($item->price, 0, '', '.')}}đ</span></td>
                                                        <td class="product-quantity"><input class="quantity-input" data-price="{{$item->price}}" data-product-id="{{$item->id}}" min="1" type="number" name="quantity[{{$item->id}}]" value="{{$item->quantity}}"></td>
                                                        <td class="product-subtotal product-price" data-product-id="{{$item->id}}">{{number_format($item->price * $item->quantity, 0, '', '.')}}đ</td>
                                                    @else
                                                        <td class="product-price-main"><span class="amount">{{number_format($item->attributes->originalPrice, 0, '', '.')}}đ</span></td>
                                                        <td class="product-quantity"><input class="quantity-input" data-price="{{$item->attributes->originalPrice}}" data-product-id="{{$item->id}}" min="1" type="number" name="quantity[{{$item->id}}]" value="{{$item->quantity}}"></td>
                                                        <td class="product-subtotal product-price" data-product-id="{{$item->id}}">{{number_format($item->attributes->originalPrice * $item->quantity, 0, '', '.')}}đ</td>
                                                    @endif
                                                    
                                                    <td class="product-remove"> 
                                                        <a href="javascript:void(0);" onclick="removeFromCart('{{ $item->id }}')">
                                                            <i class="fa fa-times" aria-hidden="true"></i>
                                                          </a>                                                          
                                                    </td>
                                                   
                                    
                                                </tr>  
                                            
                                            @endforeach                              
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                                <!-- Table Content Start -->
                                <div class="row">
                                   <!-- Cart Button Start -->
                                    <div class="col-md-4 col-sm-12">                                       
                                        <div class="buttons-cart">
                                            {{-- <input type="submit" name="btn_update" value="Update Cart"> --}}
                                            <a href="{{route('home')}}">Back</a>
                                            <a href="{{route('cart.destroy')}}">Clear Cart</a>
                                            <a href="{{route('cart.show')}}">Hủy voucher</a>                                            
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="mb-10">
                                            <form class="row" action="{{route('cart.voucher')}}" method="POST">  
                                                @csrf
                                                <div class="col-auto">
                                                    <input class="form-control" type="text" id="voucherInput" name="voucher_text" placeholder="Nhập mã giảm giá ở đây" aria-label="default input example">
                                                </div>
                                                <div class="col-auto">                                                                                          
                                                    <button class="btn btn-dark btn-voucher">Áp dụng</button>
                                                </div>
                                            </form>
                                        </div>
                                        
                                    </div>
                                    <!-- Cart Button Start -->
                                    <!-- Cart Totals Start -->
                                    <div class="col-md-4 col-sm-12">
                                        <div class="cart_totals float-md-right text-md-right">
                                            <h2>Cart Totals</h2>
                                            <br>
                                            <table class="float-md-right">
                                                <tbody>
                                                    <tr class="cart-subtotal">
                                                        <th>Khuyến mãi</th>
                                                        <td><span class="amount">0</span></td>
                                                    </tr>
                                                    <tr class="order-total">
                                                        <th>Tổng tiền</th>
                                                        <td>
                                                            <strong><span class="amount total-amount">{{number_format(Cart::session(Auth::user()->id)->getTotal(), 0, '', '.')}} VNĐ</span></strong>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div class="wc-proceed-to-checkout">
                                                <a href="{{route('cart.checkout')}}">Proceed to Checkout</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Cart Totals End -->
                                </div>
                                <!-- Row End -->
                            {{-- </form> --}}
                            <!-- Form End -->
                            @else
                                <p>Không có sản phẩm trong giỏ hàng</p>
                            @endif                           
                        </div>
                    </div>                    
                     <!-- Row End -->
                </div>
            </div>
            <!-- Cart Main Area End -->
            <!-- Support Area Start Here -->
            <div class="support-area bdr-top">
                <div class="container">
                    <div class="d-flex flex-wrap text-center">
                        <div class="single-support">
                            <div class="support-icon">
                                <i class="lnr lnr-gift"></i>
                            </div>
                            <div class="support-desc">
                                <h6>Great Value</h6>
                                <span>Nunc id ante quis tellus faucibus dictum in eget.</span>
                            </div>
                        </div>
                        <div class="single-support">
                            <div class="support-icon">
                                <i class="lnr lnr-rocket"></i>
                            </div>
                            <div class="support-desc">
                                <h6>Worlwide Delivery</h6>
                                <span>Quisque posuere enim augue, in rhoncus diam dictum non</span>
                            </div>
                        </div>
                        <div class="single-support">
                            <div class="support-icon">
                               <i class="lnr lnr-lock"></i>
                            </div>
                            <div class="support-desc">
                                <h6>Safe Payment</h6>
                                <span>Duis suscipit elit sem, sed mattis tellus accumsan.</span>
                            </div>
                        </div>
                        <div class="single-support">
                            <div class="support-icon">
                               <i class="lnr lnr-enter-down"></i>
                            </div>
                            <div class="support-desc">
                                <h6>Shop Confidence</h6>
                                <span>Faucibus dictum suscipit eget metus. Duis  elit sem, sed.</span>
                            </div>
                        </div>
                        <div class="single-support">
                            <div class="support-icon">
                               <i class="lnr lnr-users"></i>
                            </div>
                            <div class="support-desc">
                                <h6>24/7 Help Center</h6>
                                <span>Quisque posuere enim augue, in rhoncus diam dictum non.</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Container End -->
            </div>
            <!-- Support Area End Here -->
@endsection