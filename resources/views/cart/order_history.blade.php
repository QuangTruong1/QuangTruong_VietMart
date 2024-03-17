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
                    <li><a href="#">Trang chủ</a></li>
                    <li class="active"><a href="#">Lịch sử mua hàng</a></li>
                </ul>
            </div>
        </div>
        <!-- Container End -->
    </div>
    <!-- Breadcrumb End -->
    <!-- Wish List Start -->
    <div class="cart-main-area wish-list ptb-100 ptb-sm-60">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <!-- Form Start -->
                    <form action="#">
                        <!-- Table Content Start -->
                        <div class="table-content table-responsive">
                            @if($list_order_history->count() > 0)
                            <table>
                                <thead>
                                    <tr>
                                        <th class="product-thumbnail">Ảnh</th>
                                        <th class="product-name">Tên sản phẩm</th>
                                        <th class="product-quantity">Số lượng</th>
                                        <th class="product-quantity">Kiểu</th>
                                        <th class="product-quantity">Màu</th>
                                        <th class="product-price">Tổng</th>
                                        <th class="product-quantity">Tình trạng</th>
                                        <th class="product-subtotal">Đánh giá</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($list_order_history as $item)
                                        <tr>                                 
                                            <td class="product-thumbnail">
                                                <a href="{{route('product.detail', $item->product_id)}}">
                                                    <img src="{{asset($item->product->thumbnail)}}" alt="cart-image">
                                                </a>
                                            </td>
                                            <td class="product-name"><a href="{{route('product.detail', $item->product_id)}}">{{$item->product->name}}</a></td> 
                                            <td><span>{{$item->quantity}}</span></td>
                                            <td><span>{{$item->type}}</span></td>
                                            <td><span>{{$item->color}}</span></td>
                                            <td class="product-price"><span class="amount">{{number_format($item->total, 0, '', '.')}}đ</span></td>
                                            <td class="product-stock-status">
                                                @if ($item->status_id == 1)
                                                <span class="badge badge-warning">{{$item->status->name}}</span>
                                                @else
                                                <span class="badge badge-success">{{$item->status->name}}</span>
                                                @endif
                                            </td>
                                            {{-- <td class="product-stock-status"><span>{{$item->status->name}}</span></td> --}}
                                            <td class="product-add-to-cart" id="review-link">
                                                @if ($item->status_id == 2)
                                                    <a href="{{route('product.detail', ['id' => $item->product->id, 'focus' => true])}}">Review</a>
                                                @endif
                                            </td>
                                            {{-- <td class="product-add-to-cart" id="review-link"><a href="{{route('product.detail', ['id' => $item->product->id, 'focus' => true])}}">Review</a></td> --}}
                                        </tr>
                                    @endforeach                         
                                </tbody>
                            </table>
                            @else
                            <p>Bạn chưa mua sản phẩm nào trên hệ thống VIETMART</p>
                            @endif
                        </div>
                        <!-- Table Content Start -->
                    </form>
                    <!-- Form End -->
                </div>
            </div>
            <!-- Row End -->
        </div>
    </div>
    <!-- Wish List End -->
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