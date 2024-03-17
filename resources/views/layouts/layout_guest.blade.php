<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Home || Truemart Responsive Html5 Ecommerce Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicons -->
    <link rel="shortcut icon" href="{{asset('img\favicon.ico')}}">
    <!-- Fontawesome css -->
    <link rel="stylesheet" href="{{asset('css\font-awesome.min.css')}}">
    <!-- Ionicons css -->
    <link rel="stylesheet" href="{{asset('css\ionicons.min.css')}}">
    <!-- linearicons css -->
    <link rel="stylesheet" href="{{asset('css\linearicons.css')}}">
    <!-- Nice select css -->
    <link rel="stylesheet" href="{{asset('css\nice-select.css')}}">
    <!-- Jquery fancybox css -->
    <link rel="stylesheet" href="{{asset('css\jquery.fancybox.css')}}">
    <!-- Jquery ui price slider css -->
    <link rel="stylesheet" href="{{asset('css\jquery-ui.min.css')}}">
    <!-- Meanmenu css -->
    <link rel="stylesheet" href="{{asset('css\meanmenu.min.css')}}">
    <!-- Nivo slider css -->
    <link rel="stylesheet" href="{{asset('css\nivo-slider.css')}}">
    <!-- Owl carousel css -->
    <link rel="stylesheet" href="{{asset('css\owl.carousel.min.css')}}">
    <!-- Bootstrap css -->
    <link rel="stylesheet" href="{{asset('css\bootstrap.min.css')}}">
    <!-- Custom css -->
    <link rel="stylesheet" href="{{asset('css\default.css')}}">
    <!-- Main css -->
    <link rel="stylesheet" href="{{asset('style.css')}}">
    <link rel="stylesheet" href="{{asset('css/chat.css')}}">
    <link rel="stylesheet" href="{{asset('css/review.css')}}">
    <link rel="stylesheet" href="{{asset('css/detail-product.css')}}">
    <link rel="stylesheet" href="{{asset('css/voucher.css')}}">
    <link rel="stylesheet" href="{{asset('css/custom-search-sug.css')}}">

    <!-- Responsive css -->
    
    <link rel="stylesheet" href="{{asset('css\responsive.css')}}">

    <!-- Modernizer js -->
    <script src="{{asset('js\vendor\modernizr-3.5.0.min.js')}}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> --}}
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="{{asset('js\rating.js')}}"></script>
    <script src="{{ asset('js\custom.js') }}"></script>
    <script>
        var industryListURL = "{{ route('search') }}";
    </script>
</head>

<body>
    <style>
        .vertical-menu-list .active a{
            color:#E62E04;
        }
    </style>
    {{-- Kiểm tra đánh giá sản phẩm đã có--}}
    {{-- --Thành công --}}
    {{-- @if(Session::has('success_review'))
    <script>
        $(document).ready(function() {
            $('#success_review').modal('show');
        });
    </script>
    @endif --}}
    <div class="modal fade" id="success_review" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Thông báo</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal">Đóng</button>
                
            </div>
        </div>
        </div>
    </div>
    {{-- --Không thành công --}}
    {{-- @if(Session::has('check_review'))
    <script>
        $(document).ready(function() {
            $('#check_review').modal('show');
        });
    </script>
    @endif --}}
    <div class="modal fade" id="check_review" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Thông báo</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal">Đóng</button>
                
            </div>
        </div>
        </div>
    </div>

    <div class="modal fade" id="add_cart_success" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Thông báo</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <a href="{{ route('cart.show') }}" class="btn btn-primary">Đến mục giỏ hàng</a>
            </div>
          </div>
        </div>
    </div>

    <div class="modal fade" id="add_wishlist_success" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Thông báo</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <a href="{{ route('wishlist.show') }}" class="btn btn-primary">Đến mục yêu thích</a>
            </div>
          </div>
        </div>
    </div>
    
    <div class="modal fade" id="add_wishlist_fail" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Thông báo</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                
            </div>
          </div>
        </div>
    </div>

    <div class="modal fade" id="add_voucher_success" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Thông báo</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Đóng</button>                
            </div>
          </div>
        </div>
    </div>


    <!-- Main Wrapper Start Here -->
    <div class="wrapper">
        <!-- Banner Popup Start -->
        <div class="popup_banner">
            <span class="popup_off_banner">×</span>
            <div class="banner_popup_area">
                    <img src="{{asset('img\banner\pop-banner.jpg')}}" alt="">
            </div>
        </div>
        <!-- Banner Popup End -->
       <!-- Newsletter Popup Start -->
        <div class="popup_wrapper">
            <div class="test">
                <span class="popup_off">Close</span>
                <div class="subscribe_area text-center mt-60">
                    <h2>Newsletter</h2>
                    <p>Subscribe to the Truemart mailing list to receive updates on new arrivals, special offers and other discount information.</p>
                    <div class="subscribe-form-group">
                        <form action="#">
                            <input autocomplete="off" type="text" name="message" id="message" placeholder="Enter your email address">
                            <button type="submit">subscribe</button>
                        </form>
                    </div>
                    <div class="subscribe-bottom mt-15">
                        <input type="checkbox" id="newsletter-permission">
                        <label for="newsletter-permission">Don't show this popup again</label>
                    </div>
                </div>
            </div>
        </div>
        <!-- Newsletter Popup End -->
        <!-- Main Header Area Start Here -->
        <header>
            <!-- Header Top Start Here -->
            <div class="header-top-area">
                <div class="container">
                    <!-- Header Top Start -->
                    <div class="header-top">
                        <ul>
                            <li><a href="#">Miễn phí giao hàng</a></li>
                            <li><a href="#">Uy tín</a></li>
                            <li><a href="#">Chất lượng</a></li>
                            @php
                                if(Auth::user()){
                                    $user = Auth::user();
                                    // Lấy vai trò của người dùng thông qua bảng user_role
                                    $roles = $user->roles; 
                                    $user_check = $roles->first()->pivot->role_id;
                                }                              
                            @endphp 
                            @if (isset($user_check) && $user_check == 11)
                                <li><a href="{{route('dashboard')}}">Trang bán hàng</a></li>                
                            @endif
                        </ul>
                        <ul>                                          
                            <li><span>Ngôn ngữ</span> <a href="#">Tiếng Việt<i class="lnr lnr-chevron-down"></i></a>
                                <!-- Dropdown Start -->
                                <ul class="ht-dropdown">
                                    <li><a href="#"><img src="{{asset('img\header\1.jpg')}}" alt="language-selector">English</a></li>
                                    <li><a href="#"><img src="{{asset('img\header\2.jpg')}}" alt="language-selector">Francis</a></li>
                                </ul>
                                <!-- Dropdown End -->
                            </li>
                            <li><span>Đơn vị</span><a href="#"> VNĐ <i class="lnr lnr-chevron-down"></i></a>
                                <!-- Dropdown Start -->
                                <ul class="ht-dropdown">
                                    <li><a href="#">&#36; USD</a></li>
                                    <li><a href="#"> € Euro</a></li>
                                    <li><a href="#">&#163; Pound Sterling</a></li>
                                </ul>
                                <!-- Dropdown End -->
                            </li>
                            <li><a href="#">Tài khoản<i class="lnr lnr-chevron-down"></i></a>
                                <!-- Dropdown Start -->
                                <ul class="ht-dropdown">
                                    @if (Route::has('login'))
                                        @auth                                     
                                            <li>
                                                <x-dropdown-link :href="route('profile.edit')">
                                                    {{ __('Thông tin') }}
                                                </x-dropdown-link>                
                                            </li>
                                            <li>
                                                <form method="POST" action="{{ route('logout') }}">
                                                    @csrf
                                                    <x-dropdown-link :href="route('logout')"
                                                            onclick="event.preventDefault();
                                                                        this.closest('form').submit();">
                                                        {{ __('Đăng xuất') }}
                                                    </x-dropdown-link>
                                                </form>
                                            </li>
                                        @else
                                            <li>
                                                <a href="{{ route('login') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Đăng nhập</a>
                                            </li>
                                            <li>
                                                @if (Route::has('register'))
                                                    <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Đăng ký</a></li>                                       
                                                @endif
                                            </li>
                                           
                                        @endauth
                                    @endif
                                </ul>
                                <!-- Dropdown End -->
                                
                            </li> 
                        </ul>
                    </div>
                    <!-- Header Top End -->
                </div>
                <!-- Container End -->
            </div>
            <!-- Header Top End Here -->
            
            <!-- Header Middle Start Here -->
            <div class="header-middle ptb-15">
                <div class="container">
                    <div class="row align-items-center no-gutters">
                        <div class="col-lg-3 col-md-12">
                            <div class="logo mb-all-30">
                                <a href="{{route('home')}}"><img src="{{asset('img\logo\logoVietMart.jpg')}}" alt="logo-image"></a>
                            </div>
                        </div>
                        <!-- Categorie Search Box Start Here -->
                        <div class="col-lg-5 col-md-8 ml-auto mr-auto col-10">
                            <div style="position: relative;" class="categorie-search-box">
                                <form action="{{url('search')}}" method="GET" id="search-form">
                                    <input type="text" id="searchInput" name="keyword" placeholder="Nhập nội dung tìm kiếm...">
                                    <button><i class="lnr lnr-magnifier"></i></button>
                                </form>
                            </div>
                            <div id="searchResults"></div>
                        </div>
                        <!-- Categorie Search Box End Here -->
                        <!-- Cart Box Start Here -->
                        <div class="col-lg-4 col-md-12">
                            <div class="cart-box mt-all-30">
                                <ul class="d-flex justify-content-lg-end justify-content-center align-items-center">
                                    <li><a href="{{route('cart.show')}}"><i class="lnr lnr-cart"></i><span class="my-cart"><span class="total-pro">@if (Auth::user()){{Cart::session(Auth::user()->id)->getContent()->count()}}@else 0 @endif</span><span>Giỏ hàng</span></span></a>
                                        
                                        <ul class="ht-dropdown cart-box-width">
                                            @if (Auth::user() && Cart::session(Auth::user()->id)->getContent()->count() > 0)
                                            <li>
                                                @foreach (Cart::session(Auth::user()->id)->getContent() as $item)
                                                <!-- Cart Box Start -->
                                                <div class="single-cart-box">
                                                    <div class="cart-img">
                                                        <a href="{{route('product.detail', $item->id)}}"><img src="{{asset($item->attributes->thumbnail)}}" alt="cart-image"></a>
                                                        <span class="pro-quantity">{{$item->quantity}}X</span>
                                                    </div>
                                                    <div class="cart-content">
                                                        <h6><a href="product.html">{{$item->name}}</a></h6>
                                                        <span class="cart-price">{{number_format($item->price, 0, '', '.')}}đ</span>
                                                        {{-- <span>Size: S</span>
                                                        <span>Color: Yellow</span> --}}
                                                    </div>
                                                    
                                                    <button style="border: none; background-color: transparent" class="del-icone" onclick="removeFromCart('{{ $item->id }}')"><i class="ion-close"></i></button>
                                                </div>
                                                <!-- Cart Box End --> 
                                                @endforeach
                                                                                  
                                                <!-- Cart Footer Inner Start -->
                                                <div class="cart-footer">
                                                   <ul class="price-content">
                                                       <li>Total <span>{{number_format(Cart::session(Auth::user()->id)->getTotal(), 0, '', '.')}} VNĐ</span></li>
                                                   </ul>
                                                    <div class="cart-actions text-center">
                                                        <a class="cart-checkout" href="{{route('cart.checkout')}}">Checkout</a>
                                                    </div>
                                                </div>
                                                <!-- Cart Footer Inner End -->
                                            </li>
                                            @else
                                                <li>
                                                    <p>Không có sản phẩm trong giỏ hàng</p>
                                                </li>
                                            @endif
                                        </ul>
                                      
                                       
                                    </li>
                                    <li><a href="{{route('wishlist.show')}}"><i class="lnr lnr-heart"></i><span class="my-cart"><span>Yêu </span><span class="count-wishlist">thích @if(isset($list_wish_list))({{$list_wish_list->count()}})@else (0) @endif </span></span></a>
                                    </li>
                                    <li><a href="{{route('cart.history')}}"><i class="lnr lnr-user"></i><span class="my-cart"><span>Lịch </span><span>sử</span></a>



                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- Cart Box End Here -->
                    </div>
                    <!-- Row End -->
                </div>
                <!-- Container End -->
            </div>
            <!-- Header Middle End Here -->
            <!-- Header Bottom Start Here -->
            <div class="header-bottom  header-sticky">
                <div class="container">
                    <div class="row align-items-center">
                         <div class="col-xl-3 col-lg-4 col-md-6 vertical-menu d-none d-lg-block">
                            <span class="categorie-title">Danh mục ngành hàng</span>
                        </div>                       
                        <div class="col-xl-9 col-lg-8 col-md-12 ">
                            <nav class="d-none d-lg-block">
                                <ul class="header-bottom-list d-flex list-header">
                                    <li class="{{ Request::routeIs('home') ? 'active' : '' }}"><a href="{{route('home')}}">Trang chủ</a></li>
                                    <li class="{{ Request::routeIs('post.show') ? 'active' : '' }}"><a href="{{route('post.show')}}">Bài viết</a></li>
                                    {{-- <li><a href="#">About us</a></li>
                                    <li><a href="#">contact us</a></li> --}}
                                    <li class="{{ Request::routeIs('voucher.show') ? 'active' : '' }}"><a href="{{route('voucher.show')}}">Mã giảm giá</a></li>
                                </ul>
                            </nav>
                            <div class="mobile-menu d-block d-lg-none">
                                <nav>
                                    <ul>
                                        <li><a href="{{route('home')}}">Trang chủ</a></li>            
                                        <li><a href="{{route('post.show')}}">Bài viết</a></li>                             
                                        <li><a href="#">about us</a></li>
                                        <li><a href="#">contact us</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <!-- Row End -->
                </div>
                <!-- Container End -->
            </div>
            <!-- Header Bottom End Here -->
            <!-- Mobile Vertical Menu Start Here -->
            <div class="container d-block d-lg-none">
                <div class="vertical-menu mt-30">
                    <span class="categorie-title mobile-categorei-menu">Danh mục ngành hàng</span>
                    <nav>  
                        <div id="cate-mobile-toggle" class="category-menu sidebar-menu sidbar-style mobile-categorei-menu-list menu-hidden ">
                            <ul>                  
                                @foreach ($list_industry as $industry)                                   
                                <li class=""><a href="{{route('industry_list', ['industry' => $industry->id])}}"><span><img src="{{asset('img\vertical-menu\1.png')}}" alt="menu-icon"></span>{{$industry->name}}</a></li>                                   
                                @endforeach
                            </ul>
                        </div>
                        <!-- category-menu-end -->
                    </nav>
                </div>
            </div>
            <!-- Mobile Vertical Menu Start End -->
        </header>

        <div id="wp-content">
            @yield('content')            
        </div>

        <!-- Footer Area Start Here -->
        <footer class="off-white-bg2 pt-95 bdr-top pt-sm-55">
            <!-- Footer Top Start -->
            <div class="footer-top">
                <div class="container">
                    <!-- Signup Newsletter Start -->
                    <div class="row mb-60">
                         <div class="col-xl-7 col-lg-7 ml-auto mr-auto col-md-8">
                            <div class="news-desc text-center mb-30">
                                 <h3>Sign Up For Newsletters</h3>
                                 <p>Be the First to Know. Sign up for newsletter today</p>
                             </div>
                             <div class="newsletter-box">
                                 <form action="#">
                                      <input class="subscribe" placeholder="your email address" name="email" id="subscribe" type="text">
                                      <button type="submit" class="submit">subscribe!</button>
                                 </form>
                             </div>
                         </div>
                    </div> 
                    <!-- Signup-Newsletter End -->                   
                    <div class="row">
                        <!-- Single Footer Start -->
                        <div class="col-lg-2 col-md-4 col-sm-6">
                            <div class="single-footer mb-sm-40">
                                <h3 class="footer-title">Information</h3>
                                <div class="footer-content">
                                    <ul class="footer-list">
                                        <li><a href="about.html">About Us</a></li>
                                        <li><a href="#">Delivery Information</a></li>
                                        <li><a href="#">Privacy Policy</a></li>
                                        <li><a href="contact.html">Terms & Conditions</a></li>
                                        <li><a href="login.html">FAQs</a></li>
                                        <li><a href="login.html">Return Policy</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- Single Footer Start -->
                        <!-- Single Footer Start -->
                        <div class="col-lg-2 col-md-4 col-sm-6">
                            <div class="single-footer mb-sm-40">
                                <h3 class="footer-title">Customer Service</h3>
                                <div class="footer-content">
                                    <ul class="footer-list">
                                        <li><a href="contact.html">Contact Us</a></li>
                                        <li><a href="#">Returns</a></li>
                                        <li><a href="#">Order History</a></li>
                                        <li><a href="wishlist.html">Wish List</a></li>
                                        <li><a href="#">Site Map</a></li>
                                        <li><a href="#">Gift Certificates</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- Single Footer Start -->
                        <!-- Single Footer Start -->
                        <div class="col-lg-2 col-md-4 col-sm-6">
                            <div class="single-footer mb-sm-40">
                                <h3 class="footer-title">Extras</h3>
                                <div class="footer-content">
                                    <ul class="footer-list">
                                        <li><a href="#">Newsletter</a></li>
                                        <li><a href="#">Brands</a></li>
                                        <li><a href="#">Gift Certificates</a></li>
                                        <li><a href="#">Affiliate</a></li>
                                        <li><a href="#">Specials</a></li>
                                        <li><a href="#">Site Map</a></li>      
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- Single Footer Start -->
                        <!-- Single Footer Start -->
                        <div class="col-lg-2 col-md-4 col-sm-6">
                            <div class="single-footer mb-sm-40">
                                <h3 class="footer-title">My Account</h3>
                                <div class="footer-content">
                                    <ul class="footer-list">
                                        <li><a href="contact.html">Contact Us</a></li>
                                        <li><a href="#">Returns</a></li>
                                        <li><a href="#">My Account</a></li>
                                        <li><a href="#">Order History</a></li>
                                        <li><a href="wishlist.html">Wish List</a></li>
                                        <li><a href="#">Newsletter</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- Single Footer Start -->
                        <!-- Single Footer Start -->
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="single-footer mb-sm-40">
                                <h3 class="footer-title">My Account</h3>
                                <div class="footer-content">
                                    <ul class="footer-list address-content">
                                        <li><i class="lnr lnr-map-marker"></i> Address: 169-C, Technohub, Dubai Silicon Oasis.</li>
                                        <li><i class="lnr lnr-envelope"></i><a href="#"> mail Us: Support@truemart.com </a></li>
                                        <li>
                                            <i class="lnr lnr-phone-handset"></i> Phone: (+800) 123 456 789)
                                        </li>
                                    </ul>
                                    <div class="payment mt-25 bdr-top pt-30">
                                        <a href="#"><img class="img" src="{{asset('img\payment\1.png')}}" alt="payment-image"></a>
                                    </div>                                   
                                </div>
                            </div>
                        </div>
                        <!-- Single Footer Start -->
                    </div>
                    <!-- Row End -->
                </div>
                <!-- Container End -->
            </div>
            <!-- Footer Top End -->
            <!-- Footer Middle Start -->
            <div class="footer-middle text-center">
                <div class="container">
                    <div class="footer-middle-content pt-20 pb-30">
                            <ul class="social-footer">
                                <li><a href="https://www.facebook.com/"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="https://twitter.com/"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="https://plus.google.com/"><i class="fa fa-google-plus"></i></a></li>
                                <li><a href="https://www.linkedin.com/"><i class="fa fa-linkedin"></i></a></li>
                                <li><a href="#"><img src="{{asset('img\icon\social-img1.png')}}" alt="google play"></a></li>
                                <li><a href="#"><img src="{{asset('img\icon\social-img2.png')}}" alt="app store"></a></li>
                            </ul>
                    </div>
                </div>
                <!-- Container End -->
            </div>
            <!-- Footer Middle End -->
            <!-- Footer Bottom Start -->
            <div class="footer-bottom pb-30">
                <div class="container">

                     <div class="copyright-text text-center">                    
                        <p>Copyright © 2018 <a target="_blank" href="#">Truemart</a> All Rights Reserved.</p>
                     </div>
                </div>
                <!-- Container End -->
            </div>    
    {{-- ============================================== CHAT BOX ========================================== --}}
         <div id="app">
            <div class="container-fluid h-100 box_chat">
                <div class="row justify-content-center h-100">
                    <div class="col-md-4 col-xl-3 chat"><div class="card mb-sm-3 mb-md-0 contacts_card">
                        <div class="card-header">
                            <div class="input-group">
                                <input type="text" placeholder="Search..." name="" class="form-control search">
                                <div class="input-group-prepend">
                                    <span class="input-group-text search_btn"><i class="fas fa-search"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body contacts_body">
                            <ul id="user-list" class="contacts">
                                @if (isset($users))
                                @foreach($users as $user)
                                    
                                <li class="user" data-user-id="{{ $user->id }}">
                                    <div class="d-flex bd-highlight">
                                        <div class="img_cont">
                                            <img src="https://static.turbosquid.com/Preview/001292/481/WV/_D.jpg" class="rounded-circle user_img">
                                            <span class="online_icon"></span>
                                        </div>
                                        <div class="user_info">
                                            <p class="info_name">{{ $user->name }}</p>
                                            <p>Online</p>
                                        </div>
                                    </div>
                                </li>
                            @endforeach  
                                @endif
                               
                            </ul>               
                        </div>
                        <div class="card-footer"></div>
                    </div></div>
                    <div class="col-md-8 col-xl-6 chat">
                        <div class="card">
                            <div style="background-color: black;" class="card-header msg_head">
                                <div class="d-flex bd-highlight">
                                    <div class="img_cont">
                                        <img src="https://static.turbosquid.com/Preview/001292/481/WV/_D.jpg" class="rounded-circle user_img">
                                        <span class="online_icon"></span>
                                    </div>
                                    <div class="user_info">
                                        <span></span>
                                        {{-- <p>1767 Messages</p> --}}
                                    </div>                                  
                                </div>
                            </div>
                    
                            <div id="chat-messages" class="card-body msg_card_body ">
                                                                                  
                            </div>
                            
                            <div class="card-footer">
                                <div class="input-group" >
                                    <form id="chat-form" data-receiver-id ="">
                                       
                                        <input type="text" id="messageInput">
                                        <input type="submit" value="send">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 

        
            <!-- Footer Bottom End -->
        </footer>
        <!-- Footer Area End Here -->
    </div>

   <!-- Nút Chat -->
  <div id="chatButton" style="position: fixed; bottom: 10px; right: 20px; z-index:999999 ; background-color: #E62E04; border-radius: 50%; padding: 15px; cursor: pointer;">
        <h6 style="color: white">Chat</h6>
  </div>

  <!-- JavaScript để chuyển đổi hiển thị hộp chat -->
  <script>
    // Đợi tài liệu tải trước khi thêm sự kiện nhấp chuột
    document.addEventListener("DOMContentLoaded", function() {
      const chatButton = document.getElementById("chatButton");
      const chatBox = document.querySelector(".box_chat");

      chatButton.addEventListener("click", function() {
        chatBox.classList.toggle("active");
      });

    });
  </script>
    <!-- Main Wrapper End Here -->
    <script src="{{asset('js\app-guest.js')}}"></script>
    <!-- jquery 3.2.1 -->
    <script src="{{asset('js\vendor\jquery-3.2.1.min.js')}}"></script>
    <!-- Countdown js -->
    <script src="{{asset('js\jquery.countdown.min.js')}}"></script>
    <!-- Mobile menu js -->
    <script src="{{asset('js\jquery.meanmenu.min.js')}}"></script>
    <!-- ScrollUp js -->
    <script src="{{asset('js\jquery.scrollUp.js')}}"></script>
    <!-- Nivo slider js -->
    <script src="{{asset('js\jquery.nivo.slider.js')}}"></script>
    <!-- Fancybox js -->
    <script src="{{asset('js\jquery.fancybox.min.js')}}"></script>
    <!-- Jquery nice select js -->
    <script src="{{asset('js\jquery.nice-select.min.js')}}"></script>
    <!-- Jquery ui price slider js -->
    <script src="{{asset('js\jquery-ui.min.js')}}"></script>
    <!-- Owl carousel -->
    <script src="{{asset('js\owl.carousel.min.js')}}"></script>
    <!-- Bootstrap popper js -->
    <script src="{{asset('js\popper.min.js')}}"></script>
    <!-- Bootstrap js -->
    <script src="{{asset('js\bootstrap.min.js')}}"></script>
    <!-- Plugin js -->
    <script src="{{asset('js\plugins.js')}}"></script>
    <!-- Main activaion js -->
    <script src="{{asset('js\main.js')}}"></script>

   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.15.2/echo.js" integrity="sha512-Sl4N4gyjM9NG4XKXIs6VMJc1wng99fzpFvuQIfiTPS+/WfIl3o4Gw/Vkh9qjV0HAHizA9xSmocpuiqbHy0CjBA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.1/axios.min.js" integrity="sha512-bPh3uwgU5qEMipS/VOmRqynnMXGGSRv+72H/N260MQeXZIK4PG48401Bsby9Nq5P5fz7hy5UGNmC/W1Z51h2GQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{asset('js\address.js')}}"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="{{asset('js\chat.js')}}"></script>
    
</body>

</html> 