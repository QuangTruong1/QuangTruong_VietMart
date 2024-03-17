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
                                    <li class="@if(isset($industry_id) && $industry_id == $industry->id) active @endif"><a href="{{route('industry_list', ['industry' => $industry->id])}}"><span><img src="{{asset('img\vertical-menu\1.png')}}" alt="menu-icon"></span>{{$industry->name}}</a></li>                                       
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
                    <li class="active"><a href="#">Bài viết</a></li>
                </ul>
            </div>
        </div>
        <!-- Container End -->
    </div>
    <!-- Breadcrumb End -->
    <!-- Blog Page Start Here -->
    <div class="blog ptb-100  ptb-sm-60">
        <div class="container">
            <div class="main-blog">
                <div class="row">
                    @foreach ($list_post as $item)
                          <!-- Single Blog Start -->
                        <div class="col-lg-6 col-sm-12">
                            <div class="single-latest-blog">
                                <div class="blog-img">
                                    <a href="{{route('post.detail', $item->id)}}"><img src="{{asset($item->thumbnail)}}" alt="blog-image"></a>
                                </div>
                                <div class="blog-desc">
                                    <h4><a href="single-blog.html">{{$item->title}}</a></h4>
                                    <ul class="meta-box d-flex">
                                        <li><a href="#">By Truemart</a></li>
                                 
                                    </ul>
                                    <p>{{$item->created_at}}</p>
                                    <p>Aenean vestibulum pretium enim vitae , non commodo urna volutpat . Pellentesque vel lacus  eget est d...</p>
                                    <a class="readmore" href="{{route('post.detail', $item->id)}}">Read More</a>
                                </div>
                                <div class="blog-date">
                                    <span>{{$item->created_at}}</span>

                                </div>
                            </div>
                        </div>
                        <!-- Single Blog End -->
                    @endforeach
                  
                </div>
                <!-- Row End -->
                {{-- {{$list_post->links()}} --}}
                <div class="row">
                    <div class="col-sm-12">
                            <div class="pro-pagination">
                                <ul class="blog-pagination">
                                    @php
                                    $currentPage = $list_post->currentPage();
                                    $lastPage = $list_post->lastPage();
                                    @endphp
                                
                                    @if ($currentPage > 1)
                                        <li><a href="{{ $list_post->url($currentPage - 1) }}"><i class="fa fa-angle-left"></i></a></li>
                                    @endif
                                
                                    @for ($page = 1; $page <= $lastPage; $page++)
                                        <li class="{{ $page == $currentPage ? 'active' : '' }}">
                                            <a href="{{ $list_post->url($page) }}">{{ $page }}</a>
                                        </li>
                                    @endfor
                                
                                    @if ($currentPage < $lastPage)
                                        <li><a href="{{ $list_post->url($currentPage + 1) }}"><i class="fa fa-angle-right"></i></a></li>
                                    @endif
                                </ul>
                                                                  
                                <div class="product-pagination">
                                    <span class="grid-item-list">
                                        Showing {{ $list_post->firstItem() }} to {{ $list_post->lastItem() }} of {{ $list_post->total() }} ({{ $list_post->lastPage() }} Pages)
                                    </span>
                                </div>
                            </div>
                            <!-- Product Pagination Info -->
                    </div>
                </div>
                <!-- Row End -->
            </div>
        </div>
        <!-- Container End -->
    </div>
    <!-- Blog Page End Here -->
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