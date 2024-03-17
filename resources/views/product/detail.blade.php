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
                                    <li class="@if(isset($industry_id) && $industry_id == $industry->id) active @endif"><a href="{{ route('industry_list', ['industry' => $industry->id]) }}"><span><img src="{{ asset('img/vertical-menu/1.png') }}" alt="menu-icon"></span>{{ $industry->name }}</a></li>                                                  
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
                    <li><a href="#">Sản phẩm</a></li>
                    <li class="active"><a href="#">Chi Tiết</a></li>
                </ul>
            </div>
        </div>
        <!-- Container End -->
    </div>
    <!-- Breadcrumb End -->
    <!-- Product Thumbnail Start -->
    <div class="main-product-thumbnail ptb-100 ptb-sm-60">
        <div class="container">
            <div class="thumb-bg">
                <div class="row">
                    <!-- Main Thumbnail Image Start -->
                    <div class="col-lg-5 mb-all-40">
                        @php
                            $stt1 = 2;
                        @endphp

                        <!-- Thumbnail Large Image start -->
                        <div class="tab-content thumbnail-tab-content">
                            <div id="thumb1" class="tab-pane fade show active">
                                <a data-fancybox="images" href="{{ asset($product->thumbnail) }}"><img
                                        style="height:auto" src="{{ asset($product->thumbnail) }}"
                                        alt="product-view"></a>
                            </div>
                            @if ($inventories != null)
                                @foreach ($inventories as $img_product)
                                    <div id="thumb{{ $stt1 }}"
                                        class="tab-pane fade size_lager_id_{{ $img_product->color_id }}_{{ $img_product->size_id }}">
                                        <a data-fancybox="images" href="{{ asset($img_product->image) }}"><img
                                                style="height:auto" src="{{ asset($img_product->image) }}"
                                                alt="product-view"></a>
                                    </div>
                                    @php
                                        $stt1++;
                                    @endphp
                                @endforeach
                            @endif

                        </div>
                        <!-- Thumbnail Large Image End -->
                        <!-- Thumbnail Image End -->
                        @php
                            $stt2 = 2;
                        @endphp
                        <div class="product-thumbnail mt-15">
                            <div class="thumb-menu owl-carousel nav tabs-area" role="tablist">
                                <a class="active" data-toggle="tab" href="#thumb1"><img width="50" height="80"
                                        src="{{ asset($product->thumbnail) }}" alt="product-thumbnail"></a>
                                @if ($inventories != null)
                                    @foreach ($inventories as $img_product)
                                        <a data-toggle="tab" id="size_id_{{ $img_product->color_id }}"
                                            data_sizeId="{{ $img_product->color_id }}"
                                            href="#thumb{{ $stt2 }}"><img width="50" height="80"
                                                src="{{ asset($img_product->image) }}" alt="product-thumbnail"></a>
                                        @php
                                            $stt2++;
                                        @endphp
                                    @endforeach
                                @endif

                            </div>
                        </div>
                        <!-- Thumbnail image end -->
                    </div>
                    <!-- Main Thumbnail Image End -->
                    <!-- Thumbnail Description Start -->
                    <div class="col-lg-7">
                        <div class="thubnail-desc fix">
                            <h3 class="product-header">{{ $product->name }}</h3>
                            <div class="rating-summary fix mtb-10">
                                <div class="rating">
                                    @php
                                        $fullStars = floor($tb_rating); // Số ngôi sao đầy
                                        $halfStar = $tb_rating - $fullStars; // Số nửa ngôi sao
                                        $emptyStars = 5 - $fullStars - ($halfStar >= 0.5 ? 1 : 0); // Số ngôi sao trống
                                    @endphp
                                    @for ($i = 0; $i < $fullStars; $i++)
                                        <i class="fa fa-star"></i>
                                    @endfor
                                    @if ($halfStar >= 0.5)
                                        <i class="fa fa-star-half"></i>
                                    @endif
                                    @for ($i = 0; $i < $emptyStars; $i++)
                                        <i class="fa fa-star-o"></i>
                                    @endfor

                                </div>
                                <div class="rating-feedback">
                                    <a href="#">({{ $count_review }})</a>
                                    <a href="#" id="comment-user">Nhận xét</a>
                                </div>
                            </div>
                            <script>
                                var inventories = {!! json_encode($inventories) !!};
                            </script>
                            <div class="pro-price mtb-30">
                                <p class="d-flex align-items-center"><span class="price priceName"
                                        id="productPrice">{{ number_format($product->price, 0, '', '.') }}đ</span><span
                                        class="saving-price">save 8%</span></p>
                            </div>
                            {{-- <div class="mb-20 pro-desc-details">{!! $product->content !!}</div>                         --}}
                            <div class="product-size mb-20 clearfix">
                                <label>Phân loại</label>
                                <select class="size select-box" name="size" id="sizeSelect"
                                    data-product-id="{{ $product->id }}">
                                    <option value="0" selected>Chọn</option>
                                    @foreach ($sizeNames as $size)
                                        <option value="{{ $size[0] }}">{{ $size[1] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="product-size mb-20 clearfix">
                                <label>Màu Sắc</label>
                                <select class="color" name="color" id="colorSelect">

                                </select>
                            </div>

                            <div class="box-quantity d-flex hot-product2">

                                <div class="pro-actions">
                                    <div class="actions-primary">
                                        {{-- <a href="{{route('cart.add', $product->id)}}" title="" data-original-title="Add to Cart"> + Add To Cart</a> --}}
                                        <a href="#" data-product-id="{{ $product->id }}" data-size-id=""
                                            data-color-id="" class="add-to-cart" title="Add to Cart"> + Thêm vào</a>
                                    </div>
                                    <div class="actions-secondary">                                        
                                        <a href="#" title="WishList" data-product-id="{{ $product->id }}"
                                            class="add-to-wishlist"><i class="lnr lnr-heart"></i> <span>Yêu thích</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="pro-ref mt-20">
                                <p><span class="in-stock"><i
                                            class="ion-checkmark-round"></i>{{ $product->Status->name_status }}</span></p>
                            </div>
                            <div class="socila-sharing mt-25">
                                <ul class="d-flex">
                                    <li>share</li>
                                    <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                    <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                    <li><a href="#"><i class="fa fa-google-plus-official"
                                                aria-hidden="true"></i></a></li>
                                    <li><a href="#"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- Thumbnail Description End -->
                </div>
                <!-- Row End -->
            </div>
        </div>
        <!-- Container End -->
    </div>
    <!-- Product Thumbnail End -->

    <!-- Product Thumbnail Description Start -->
    <div class="thumnail-desc pb-100 pb-sm-60">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <ul class="main-thumb-desc nav tabs-area" role="tablist">
                        <li><a data-toggle="tab" href="#dtail">Chi tiết</a></li>
                        <li><a data-toggle="tab" class="active" href="#review" id="rating-link">Nhận xét</a></li>
                    </ul>

                    <style>
                        .rating-stars i {
                            font-size: 30px;
                        }

                        .reply-comment {
                            margin-bottom: 0.75rem;
                            background-color: #f5f5f5;
                            padding: 0.875rem 0.75rem;
                            position: relative;
                        }

                        .reply-store {
                            color: rgba(0, 0, 0, .87);
                            font-weight: 500;
                            font-size: .875rem;
                            text-transform: capitalize;
                        }

                        .reply-content {
                            color: rgba(0, 0, 0, .65);
                            margin-top: 0.625rem;
                            word-break: break-word;
                        }
                    </style>
                    <!-- Product Thumbnail Tab Content Start -->
                    <div class="tab-content thumb-content border-default">
                        <div id="dtail" class="tab-pane fade ">
                            <div class="detail-block">
                                <h2 class="detail-title">CHI TIẾT SẢN PHẨM</h2>
                                <div class="detail-info">
                                    @if (isset($productInfo_general->brand->name))
                                        <div class="dR8kXc">
                                            <label class="zquA4o eqeCX7">Thương hiệu</label>
                                            <div>{{$productInfo_general->brand->name}}</div>
                                        </div>
                                    @endif                                   
                                    @if (isset($productInfo_general->material->name))
                                        <div class="dR8kXc">
                                            <label class="zquA4o eqeCX7">Chất liệu</label>
                                            <div>{{$productInfo_general->material->name}}</div>
                                        </div> 
                                    @endif
                                    
                                    @if (isset($productInfo_general->pattern->name))
                                        <div class="dR8kXc">
                                            <label class="zquA4o eqeCX7">Mẫu</label>
                                            <div>{{$productInfo_general->pattern->name}}</div>
                                        </div>    
                                    @endif
                                                               
                                </div>
                            </div>
                            <div class="detail-block">
                                <h2 class="detail-title">Mô tả sản phẩm</h2>
                                <div class="detail-info">                                   
                                    <p>{!! $product->content !!}</p>
                                </div>
                            </div>
                        </div>
                        <div id="review" class="tab-pane fade show active">
                            <!-- Reviews Start -->
                            @php
                                $fullStars = floor($tb_rating); // Số ngôi sao đầy
                                $halfStar = $tb_rating - $fullStars; // Số nửa ngôi sao
                                $sumStar = floor(($fullStars + $halfStar) * 2) / 2;
                                $emptyStars = 5 - $fullStars - ($halfStar >= 0.5 ? 1 : 0); // Số ngôi sao trống
                            @endphp
                            <div class="product-rating-overview">
                                <div class="product-rating-overview__briefing">
                                    <div class="product-rating-overview__score-wrapper">
                                        <span class="product-rating-overview__rating-score">{{ $sumStar }}</span>
                                        <span class="product-rating-overview__rating-score-out-of"> trên 5 </span>
                                    </div>
                                    <div class="shopee-rating-stars product-rating-overview__stars">
                                        <div class="shopee-rating-stars__stars">
                                            <!-- Repeated star elements simplified -->
                                            <!-- Use a loop or dynamic content for actual data -->
                                            <div class="shopee-rating-stars__star-wrapper">
                                                <div class="shopee-rating-stars__lit" style="width: 100%;">
                                                    @for ($i = 0; $i < $fullStars; $i++)
                                                        <i class="fa fa-star"></i>
                                                    @endfor
                                                    @if ($halfStar >= 0.5)
                                                        <i class="fa fa-star-half"></i>
                                                    @endif
                                                    @for ($i = 0; $i < $emptyStars; $i++)
                                                        <i class="fa fa-star-o"></i>
                                                    @endfor
                                                </div>
                                            </div>
                                            <!-- Repeat the above structure for each star element -->
                                        </div>
                                    </div>
                                </div>
                                <div class="product-rating-overview__filters">
                                    <!-- Filter elements simplified -->
                                    @php
                                        $fiveStarCount = 0;
                                        $fourStarCount = 0;
                                        $threeStarCount = 0;
                                        $twoStarCount = 0;
                                        $oneStarCount = 0;
                                    @endphp

                                    @foreach ($list_rating as $rating)
                                        @if ($rating->rating_value == 5)
                                            @php $fiveStarCount++; @endphp
                                        @elseif ($rating->rating_value == 4)
                                            @php $fourStarCount++; @endphp
                                        @elseif ($rating->rating_value == 3)
                                            @php $threeStarCount++; @endphp
                                        @elseif ($rating->rating_value == 2)
                                            @php $twoStarCount++; @endphp
                                        @elseif ($rating->rating_value == 1)
                                            @php $oneStarCount++; @endphp
                                        @endif
                                    @endforeach
                                    <div id="allFilter" class="product-rating-overview__filter product-rating-overview__filter--active">tất cả</div>
                                    <div id="fiveStarFilter" class="product-rating-overview__filter">5 Sao ({{$fiveStarCount}})</div>
                                    <div id="fourStarFilter" class="product-rating-overview__filter">4 Sao ({{$fourStarCount}})</div>
                                    <div id="threeStarFilter" class="product-rating-overview__filter">3 Sao ({{$threeStarCount}})</div>
                                    <div id="twoStarFilter" class="product-rating-overview__filter">2 Sao ({{$twoStarCount}})</div>
                                    <div id="oneStarFilter" class="product-rating-overview__filter">1 Sao ({{$oneStarCount}})</div>
                                    {{-- <div id="commentFilter" class="product-rating-overview__filter">Có Bình luận ({{$count_review}})</div> --}}
                                    {{-- <div class="product-rating-overview__filter">Có hình ảnh / video (561)</div> --}}
                                </div>
                            </div>
                            <div class="review border-default universal-padding">
                                <div class="group-title">
                                    <h2>Nhận xét của khách hàng</h2>
                                </div>
                                <p id="noReviewMessage" style="display: none;">Không có nhận xét.</p>
                                @forelse ($list_review as $review)                                                               
                                    @foreach ($list_rating as $rating)
                                        @if ($review->user_id == $rating->user_id && $review->product_id == $rating->product_id)
                                        <ul class="review-list star-rating-{{$rating->rating_value}}">
                                        @endif                                    
                                    @endforeach                                   
                                        <li>Khách hàng: {{ $review->user->name }}</li>
                                        <!-- Single Review List Start -->
                                        <li>
                                            @foreach ($list_rating as $rating)
                                                @if ($rating->user_id == $review->user_id && $review->product_id == $rating->product_id)
                                                    @php
                                                        $fullStars = floor($rating->rating_value); // Số ngôi sao đầy
                                                        $halfStar = $rating->rating_value - $fullStars; // Số nửa ngôi sao
                                                        $emptyStars = 5 - $fullStars - ($halfStar >= 0.5 ? 1 : 0); // Số ngôi sao trống
                                                    @endphp
                                                    @for ($i = 0; $i < $fullStars; $i++)
                                                        <i class="fa fa-star"></i>
                                                    @endfor
                                                    @if ($halfStar >= 0.5)
                                                        <i class="fa fa-star-half"></i>
                                                    @endif
                                                    @for ($i = 0; $i < $emptyStars; $i++)
                                                        <i class="fa fa-star-o"></i>
                                                    @endfor
                                                @endif
                                            @endforeach
                                        </li>
                                        <!-- Single Review List End -->
                                        <li>
                                            {{ $review->created_at }}
                                        </li>
                                        <h4 class="review-mini-title">{{ $review->content }}</h4>                                       
                                         {{-- Hiển thị phản hồi --}}                               
                                        @if ($review->reply()->exists())
                                            <div class="reply-comment">
                                                <div class="reply-store">Phản hồi từ người bán</div>
                                                <div class="reply-content">
                                                    {!! $review->reply->content !!}
                                                </div>
                                            </div>
                                        @endif
                                    </ul>                                                                       
                                    <hr>
                                @empty
                                    <p>Sản phẩm chưa có nhận xét. Bạn hãy là người nhận xét đầu tiền</p>
                                @endforelse
                                @if (count($list_review) >= 1)
                                    {{ $list_review->links() }}                            
                                @endif                                                                                                   
                            </div>
                            <!-- Reviews End -->

                            <!-- Reviews Start -->
                            @if ($check_order && !$check_comment)
                                <div class="review border-default universal-padding mt-30">
                                    <form autocomplete="off" action="{{ route('product.review', $product->id) }}"
                                        method="POST" class="ajax-form">
                                        @csrf
                                        <h2 class="review-title mb-30">Để lại nhận xét về sản phẩm:
                                            <br><span>{{ $product->name }}</span></h2>
                                        <p class="review-mini-title">Đánh giá</p>
                                        <ul class="review-list">
                                            <!-- Single Review List Start -->
                                            <li>
                                                <div class="rating-stars">
                                                    <i class="fa fa-star-o" data-rating="1"></i>
                                                    <i class="fa fa-star-o" data-rating="2"></i>
                                                    <i class="fa fa-star-o" data-rating="3"></i>
                                                    <i class="fa fa-star-o" data-rating="4"></i>
                                                    <i class="fa fa-star-o" data-rating="5"></i>
                                                </div>
                                            </li>
                                            <!-- Single Review List End -->
                                        </ul>
                                        <!-- Reviews Field Start -->
                                        <div class="review-field mt-40">
                                            <div class="form-group">
                                                <label class="req" for="comments">Nhận xét</label>
                                                <textarea class="form-control" rows="5" id="comments" name="content" required="required"></textarea>
                                            </div>
                                            <!-- Hidden field to store the selected rating -->
                                            <input type="hidden" id="rating-value" name="rating">

                                            <button type="submit" class="customer-btn btn-review">Submit Review</button>
                                        </div>
                                    </form>
                                    <!-- Reviews Field Start -->
                                </div>
                            @endif
                            <!-- Reviews End -->
                        </div>
                    </div>
                    <!-- Product Thumbnail Tab Content End -->
                </div>
            </div>
            <!-- Row End -->
        </div>
        <!-- Container End -->
    </div>
    <!-- Product Thumbnail Description End -->
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
                        <span>Faucibus dictum suscipit eget metus. Duis elit sem, sed.</span>
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

    {{-- Đánh giá sao --}}
    @if ($focusReview)
        <script>
            $(document).ready(function() {
                $('#comments').focus();
            });
        </script>
    @endif
@endsection
