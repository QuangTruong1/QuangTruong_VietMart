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
                            <li class="active"><a href="#">Đăng ký</a></li>
                        </ul>
                    </div>
                </div>
                <!-- Container End -->
            </div>
            <!-- Breadcrumb End -->
           <!-- Register Account Start -->
            <div class="register-account ptb-100 ptb-sm-60">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="register-title">
                                <h3 class="mb-10">ĐĂNG KÝ TÀI KHOẢN</h3>
                                <p class="mb-10">Nếu bạn đã có tài khoản với chúng tôi, vui lòng đăng nhập tại trang đăng nhập</p>
                            </div>
                        </div>
                    </div>
                    <!-- Row End -->
                    <div class="row">
                        <div class="col-sm-12">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <fieldset>
                                    <legend>Thông tin cá nhân</legend>
                                    <div class="form-group d-md-flex align-items-md-center">
                                        <label class="control-label col-md-2" for="name"><span class="require">*</span>Họ và tên</label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" name="name" id="name" value="{{old('name')}}" placeholder="Nhập họ và tên..." required autofocus autocomplete="name">
                                        </div>
                                        @error('name')                        
                                            <small class="text-danger">{{$message}}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group d-md-flex align-items-md-center">
                                        <label class="control-label col-md-2" for="email"><span class="require">*</span>Email</label>
                                        <div class="col-md-10">
                                            <input type="email" class="form-control" name="email" id="email" value="{{old('email')}}" placeholder="Nhập email..." required autocomplete="username">
                                        </div>
                                        @error('email')                        
                                            <small class="text-danger">{{$message}}</small>
                                        @enderror
                                    </div>
                                    {{-- <div class="form-group d-md-flex align-items-md-center">
                                        <label class="control-label col-md-2" for="number"><span class="require">*</span>Telephone</label>
                                        <div class="col-md-10">
                                            <input type="email" class="form-control" id="number" placeholder="Telephone">
                                        </div>
                                    </div> --}}
                                </fieldset>
                                <fieldset>                                    
                                    <div class="form-group d-md-flex align-items-md-center">
                                        <label class="control-label col-md-2" for="password"><span class="require">*</span>Mật khẩu:</label>
                                        <div class="col-md-10">
                                            <input type="password" name="password" class="form-control" id="password" placeholder="Nhập mật khẩu..."  required autocomplete="new-password">
                                        </div>
                                        @error('password')                        
                                            <small class="text-danger">{{$message}}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group d-md-flex align-items-md-center">
                                        <label class="control-label col-md-2" for="password_confirmation"><span class="require">*</span>Xác nhận mật khẩu</label>
                                        <div class="col-md-10">
                                            <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Nhập lại mật khẩu..." required autocomplete="new-password">
                                        </div>
                                        @error('password_confirmation')                        
                                            <small class="text-danger">{{$message}}</small>
                                        @enderror
                                    </div>
                                </fieldset>
                                {{-- <fieldset class="newsletter-input">
                                    <legend>Newsletter</legend>
                                    <div class="form-group d-md-flex align-items-md-center">
                                        <label class="col-md-2 control-label">Subscribe</label>
                                        <div class="col-md-10 radio-button">
                                             <label class="radio-inline"><input type="radio" name="optradio">Yes</label>
                                             <label class="radio-inline"><input type="radio" name="optradio">No</label>
                                        </div>
                                    </div>
                                </fieldset> --}}
                                <div class="terms">
                                    <div class="float-md-right">
                                        {{-- <span>I have read and agree to the <a href="#" class="agree"><b>Privacy Policy</b></a></span>
                                        <input type="checkbox" name="agree" value="1"> &nbsp; --}}
                                        <input type="submit" value="Tiếp tục" class="return-customer-btn">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Row End -->
                </div>
                <!-- Container End -->
            </div>
            <!-- Register Account End -->
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

{{-- <x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ml-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}
