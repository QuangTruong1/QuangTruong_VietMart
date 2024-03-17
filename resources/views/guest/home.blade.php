@extends('layouts.layout_guest')
@section('content')

            <!-- Main Header Area End Here -->
        <!-- Categorie Menu & Slider Area Start Here -->
        <div class="main-page-banner pb-50 off-white-bg">
            <div class="container">
                <div class="row">
                    <!-- Vertical Menu Start Here -->
                    <div class="col-xl-3 col-lg-4 d-none d-lg-block">
                        <div class="vertical-menu mb-all-30">
                            <nav>
                                <ul class="vertical-menu-list">
                                    @foreach ($list_industry as $industry)                                   
                                        <li class="@if(isset($industry_id) && $industry_id == $industry->id) active @endif"><a href="{{ route('industry_list', ['industry' => $industry->id]) }}"><span><img src="{{ asset('img/vertical-menu/1.png') }}" alt="menu-icon"></span>{{ $industry->name }}</a></li>                                                  
                                    @endforeach
                                    
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <!-- Vertical Menu End Here -->
                    <!-- Slider Area Start Here -->
                    <div class="col-xl-9 col-lg-8 slider_box">
                        <div class="slider-wrapper theme-default">
                            <!-- Slider Background  Image Start-->
                            <div id="slider" class="nivoSlider">
                                <a href="shop.html"><img src="{{asset('img\slider\1.jpg')}}" data-thumb="img/slider/1.jpg')}}" alt="" title="#htmlcaption"></a>
                                <a href="shop.html"><img src="{{asset('img\slider\2.jpg')}}" data-thumb="img/slider/2.jpg')}}" alt="" title="#htmlcaption2"></a>
                            </div>
                            <!-- Slider Background  Image Start-->
                        </div>
                    </div>
                    <!-- Slider Area End Here -->
                </div>
                <!-- Row End -->
            </div>
            <!-- Container End -->
        </div>
        <!-- Categorie Menu & Slider Area End Here -->
        <!-- Brand Banner Area Start Here -->
        <div class="image-banner pb-50 off-white-bg">
            <div class="container">
                <div class="col-img">
                    <a href="#"><img src="{{asset('img\banner\h1-banner.jpg')}}" alt="image banner"></a>
                </div>
            </div>
            <!-- Container End -->
        </div>
        <!-- Brand Banner Area End Here -->
        <!-- Hot Deal Products Start Here -->
        <div class="hot-deal-products off-white-bg pb-90 pb-sm-50">
            <div class="container">
               <!-- Product Title Start -->
               <div class="post-title pb-30">
                   <h2>Giảm giá</h2>
               </div>
               <!-- Product Title End -->
                <!-- Hot Deal Product Activation Start -->
                <div class="hot-deal-active owl-carousel">
                    @foreach ($list_product as $product)
                         <!-- Single Product Start -->
                        <div class="single-product">
                            <!-- Product Image Start -->
                            <div class="pro-img">
                                <a href="{{route('product.detail', $product->id)}}">
                                    <img style="max-width:100%; height: 220px" class="primary-img" src="{{asset($product->thumbnail)}}" alt="single-product">                                    
                                </a>
                                <div class="countdown" data-countdown="2024/02/10"></div>
                                {{-- <a href="#" class="quick_view" data-toggle="modal" data-target="#myModal" title="Quick View"><i class="lnr lnr-magnifier"></i></a> --}}
                            </div>
                            <!-- Product Image End -->
                            <!-- Product Content Start -->
                            <div class="pro-content">
                                <div style="text-align:center" class="pro-info">
                                    <h4><a href="product.html">{{$product->name}}</a></h4>
                                    <p><span class="price priceName">{{number_format($product->price, 0, '', '.')}}đ</span></p>                            
                                </div>
                                <div  class="pro-actions">
                                    <div class="actions-primary">                                        
                                        {{-- <a href="#" data-product-id="{{ $product->id }}" class="add-to-cart" title="Add to Cart"> + Add To Cart</a> --}}
                                    </div>
                                    <div style="margin-top: 25px" class="actions-secondary">     
                                        <a href="#" title="WishList" data-product-id="{{ $product->id }}" class="add-to-wishlist"><i style="color: red"  class="lnr lnr-heart"></i> <span style="color: red;" >Add to WishList</span></a>
                                    </div>
                                </div>
                            </div>
                            <!-- Product Content End -->
                        </div>
                        <!-- Single Product End -->
                    @endforeach
                   
                </div>
                <!-- Hot Deal Product Active End -->

            </div>
            <!-- Container End -->
        </div>
        <!-- Hot Deal Products End Here -->
        <!-- Hot Deal Products End Here -->

        <!-- Big Banner Start Here -->
        <div class="big-banner mt-100 pb-85 mt-sm-60 pb-sm-45">
            <div class="container banner-2">
                <div class="banner-box">
                    <div class="col-img">
                        <a href="#"><img src="{{asset('img\banner\banner3-1.jpg')}}" alt="banner 3"></a>
                    </div>
                    <div class="col-img">
                        <a href="#"><img src="{{asset('img\banner\banner3-2.jpg')}}" alt="banner 3"></a>
                    </div>
                </div>
                <div class="banner-box">
                    <div class="col-img">
                        <a href="#"><img src="{{asset('img\banner\banner3-3.jpg')}}" alt="banner 3"></a>
                    </div>
                </div>
                <div class="banner-box">
                    <div class="col-img">
                        <a href="#"><img src="{{asset('img\banner\banner3-4.jpg')}}" alt="banner 3"></a>
                    </div>
                    <div class="col-img">
                        <a href="#"><img src="{{asset('img\banner\banner3-5.jpg')}}" alt="banner 3"></a>
                    </div>
                </div>
                <div class="banner-box">
                    <div class="col-img">
                        <a href="#"><img src="{{asset('img\banner\banner3-6.jpg')}}" alt="banner 3"></a>
                    </div>
                </div>
                <div class="banner-box">
                    <div class="col-img">
                        <a href="#"><img src="{{asset('img\banner\banner3-7.jpg')}}" alt="banner 3"></a>
                    </div>
                    <div class="col-img">
                        <a href="#"><img src="{{asset('img\banner\banner3-8.jpg')}}" alt="banner 3"></a>
                    </div>
                </div>
            </div>
            <!-- Container End -->
        </div>
        <!-- Big Banner End Here -->       
        <!-- Like Products Area Start Here -->
        <div class="like-product ptb-95 off-white-bg pt-sm-50 pb-sm-55 ">
            <div class="container">
                <div class="like-product-area"> 
                    <h2 class="section-ttitle2 mb-30">Gợi ý hôm nay </h2>
                    <!-- Arrivals Product Activation Start Here -->
                    <div class="like-pro-active owl-carousel">
                        @for ($i = 0; $i < count($list_product); $i += 2)
                        <!-- Double Product Start -->
                        <div class="double-product">
                            
                            <!-- Single Product Start -->
                           <div class="single-product">
                               <!-- Product Image Start -->
                               <div class="pro-img">
                                   <a href="{{route('product.detail', $list_product[$i]->id)}}">
                                       <img style="max-width: 100%; height: 220px" class="primary-img" src="{{asset($list_product[$i]->thumbnail)}}" alt="single-product">                                      
                                   </a>                                                                     
                               </div>
                               <!-- Product Image End -->
                               <!-- Product Content Start -->
                               <div class="pro-content">
                                   <div style="text-align:center" class="pro-info">
                                       <h4><a href="product.html">{{$list_product[$i]->name}}</a></h4>
                                       <p><span class="price priceName">{{number_format($list_product[$i]->price, 0, '', '.')}}đ</span></p>                            
                                   </div>
                                   <div  class="pro-actions">
                                       <div class="actions-primary">                                        
                                           {{-- <a href="#" data-product-id="{{ $product[$i]->id }}" class="add-to-cart" title="Add to Cart"> + Add To Cart</a> --}}
                                       </div>
                                       <div style="margin-top: 25px" class="actions-secondary">     
                                           <a href="#" title="WishList" data-product-id="{{ $list_product[$i]->id }}" class="add-to-wishlist"><i style="color: red"  class="lnr lnr-heart"></i> <span style="color: red;" >Add to WishList</span></a>
                                       </div>
                                   </div>
                               </div>
                               <!-- Product Content End -->
                           </div>
                           <!-- Single Product End -->
                           @if ($i + 1 < count($list_product))
                           <!-- Single Product Start -->
                           <div class="single-product">
                            <!-- Product Image Start -->
                            <div class="pro-img">
                                <a href="{{route('product.detail', $list_product[$i + 1]->id)}}">
                                    <img style="max-width: 100%; height: 220px" class="primary-img" src="{{asset($list_product[$i + 1]->thumbnail)}}" alt="single-product">                                    
                                </a>                                                          
                            </div>
                            <!-- Product Image End -->
                            <!-- Product Content Start -->
                            <div class="pro-content">
                                <div style="text-align:center" class="pro-info">
                                    <h4><a href="product.html">{{$list_product[$i + 1]->name}}</a></h4>
                                    <p><span class="price priceName">{{number_format($list_product[$i + 1]->price, 0, '', '.')}}đ</span></p>                            
                                </div>
                                <div  class="pro-actions">
                                    <div class="actions-primary">                                        
                                        {{-- <a href="#" data-product-id="{{ $product->id }}" class="add-to-cart" title="Add to Cart"> + Add To Cart</a> --}}
                                    </div>
                                    <div style="margin-top: 25px" class="actions-secondary">     
                                        <a href="#" title="WishList" data-product-id="{{ $list_product[$i + 1]->id }}" class="add-to-wishlist"><i style="color: red"  class="lnr lnr-heart"></i> <span style="color: red;" >Add to WishList</span></a>
                                    </div>
                                </div>
                            </div>
                            <!-- Product Content End -->
                        </div>
                        <!-- Single Product End -->
                        @endif
                                              
                        </div>
                        <!-- Double Product End -->   
                        @endfor                   
                    </div>
                    <!-- Arrivals Product Activation End Here -->
                </div>
                <!-- main-product-tab-area-->
            </div>
            <!-- Container End -->
        </div>
        <!-- Lile Products Area End Here -->
        <!-- Brand Banner Area Start Here -->
        <div class="main-brand-banner pt-95 pb-100 pt-sm-55 pb-sm-60">
            <div class="container">
                <div class="section-ttitle mb-20">
                    <h2>Tài trợ</h2>
               </div>
                <div class="row no-gutters">
                    <div class="col-lg-3">
                        <div class="col-img">
                            <img src="{{asset('img\banner\h1-band1.jpg')}}" alt="">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <!-- Brand Banner Start -->
                        <div class="brand-banner owl-carousel">
                            <div class="single-brand">
                                <a href="#"><img class="img" src="{{asset('img\brand\1.jpg')}}" alt="brand-image"></a>
                                <a href="#"><img src="{{asset('img\brand\2.jpg')}}" alt="brand-image"></a>
                                <a href="#"><img src="{{asset('img\brand\3.jpg')}}" alt="brand-image"></a>
                            </div>
                            <div class="single-brand">
                                <a href="#"><img class="img" src="{{asset('img\brand\1.jpg')}}" alt="brand-image"></a>
                                <a href="#"><img src="{{asset('img\brand\2.jpg')}}" alt="brand-image"></a>
                                <a href="#"><img src="{{asset('img\brand\3.jpg')}}" alt="brand-image"></a>
                            </div>
                            <div class="single-brand">
                                <a href="#"><img src="{{asset('img\brand\1.jpg')}}" alt="brand-image"></a>
                                <a href="#"><img src="{{asset('img\brand\2.jpg')}}" alt="brand-image"></a>
                                <a href="#"><img src="{{asset('img\brand\3.jpg')}}" alt="brand-image"></a>

                            </div>
                            <div class="single-brand">
                                <a href="#"><img src="{{asset('img\brand\2.jpg')}}" alt="brand-image"></a>
                                <a href="#"><img src="{{asset('img\brand\3.jpg')}}" alt="brand-image"></a>
                                <a href="#"><img src="{{asset('img\brand\4.jpg')}}" alt="brand-image"></a>
                            </div>
                            <div class="single-brand">
                                <a href="#"><img src="{{asset('img\brand\2.jpg')}}" alt="brand-image"></a>
                                <a href="#"><img src="{{asset('img\brand\3.jpg')}}" alt="brand-image"></a>
                                <a href="#"><img src="{{asset('img\brand\4.jpg')}}" alt="brand-image"></a>
                            </div>
                            <div class="single-brand">
                                <a href="#"><img src="{{asset('img\brand\2.jpg')}}" alt="brand-image"></a>
                                <a href="#"><img src="{{asset('img\brand\3.jpg')}}" alt="brand-image"></a>
                                <a href="#"><img src="{{asset('img\brand\4.jpg')}}" alt="brand-image"></a>
                            </div>
                            <div class="single-brand">
                                <a href="#"><img src="{{asset('img\brand\2.jpg')}}" alt="brand-image"></a>
                                <a href="#"><img src="{{asset('img\brand\3.jpg')}}" alt="brand-image"></a>
                                <a href="#"><img src="{{asset('img\brand\4.jpg')}}" alt="brand-image"></a>
                            </div>
                        </div>
                        <!-- Brand Banner End -->                        

                    </div>
                    <div class="col-lg-3">
                        <div class="col-img">
                            <img src="{{asset('img\banner\h1-band2.jpg')}}" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container End -->
        </div>
        <!-- Brand Banner Area End Here -->
        <div class="big-banner pb-100 pb-sm-60">
            <div class="container big-banner-box">
                <div class="col-img">
                    <a href="#">
                    <img src="{{asset('img\banner\5.jpg')}}" alt="">
                    </a>
                </div>
                <div class="col-img">
                    <a href="#">
                    <img src="{{asset('img\banner\h1-banner3.jpg')}}" alt="">
                    </a>
                </div>
            </div>
            <!-- Container End -->
        </div>
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