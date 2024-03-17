@extends('layouts.admin')
@section('title', 'Thêm voucher')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Chỉnh sửa voucher
        </div>
        <div class="card-body">
            <form action="{{route('update_voucher', $voucher->id)}}" method="POST">
                @csrf                
                <div class="form-group">
                    <div class="row">
                        <div class="col-3">
                            <label for="voucher_category">Loại mã</label>
                        </div>
                        <div class="col-6">
                            <select class="form-control" name="voucher_cat" id="voucher_category">
                                <option  value="1">Voucher toàn hệ thống Viet Mart</option>                        
                            </select>
                        </div>                                               
                    </div>                                                          
                </div>
                
                <div class="form-group">
                    <div class="row">
                        <div class="col-3">
                            <label for="name_voucher">Tên chương trình giảm giá</label>
                        </div>
                        <div class="col-6">
                            <input class="form-control" type="text" name="name_voucher" id="name_voucher" value="{{$voucher->program_name}}">
                            @error('name_voucher')                        
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>                                                
                    </div>                                                                 
                </div>
                <div class="form-group">   
                    <div class="row">
                        <div class="col-3">
                            <label for="voucher_text">Mã voucher</label>
                        </div>
                        <div class="col-6">
                            <input class="form-control" maxlength="5" type="text" name="voucher_text" id="voucher_text" value="{{$voucher->voucher_code}}">  
                            <small>Vui lòng chỉ nhập các kí tự chữ cái (A-Z), số (0-9); tối đa 5 kí tự.
                                Mã giảm giá đầy đủ là: HANG
                            </small><br>
                            @error('voucher_text')                        
                                <small class="text-danger">{{$message}}</small>
                            @enderror  
                        </div>                        
                    </div>                                                                           
                </div>
                <div class="form-group">
                    <div class="row pt-2">
                        <div class="col-3">
                            <label for="password_confirmation">Thời gian sử dụng mã</label>
                        </div>
                        
                        <div class="col-3">
                            <input type="datetime-local" id="start_time" name="start_time" class="form-control" value="{{$voucher->start_date}}" required >
                        </div>
                        <div class="col-3">
                            <input type="datetime-local" id="end_time" name="end_time" class="form-control" value="{{$voucher->end_date}}" required>
                        </div>         
                    </div>                        
                </div>

                <div class="form-group">
                    <div class="row pt-2">
                        <div class="col-3">
                            <label for="">Loại giảm giá | Mức giảm</label>
                        </div>                       
                        <div class="col-6">
                            <div class="row">
                                <div class="col-4">
                                    <select class="form-control" id="discount_type" name="discount_type">
                                        <option value="fixed" {{ $voucher->discount_type === 'fixed' ? 'selected' : '' }}>Theo số tiền</option>
                                        <option value="percentage" {{ $voucher->discount_type === 'percentage' ? 'selected' : '' }}>Theo phần trăm</option>                                    
                                    </select>
                                </div>
                                <div class="col-8">
                                    
                                    <div class="row" id="fixedDiscountInput" style="{{ $voucher->discount_type === 'fixed' ? '' : 'display: none' }}">
                                        <input class="form-control" type="text" name="discount_value_fixed" placeholder="Nhập số tiền muốn giảm" value="{{$voucher->discount_value}}">
                                    </div>
                                    <div class="row" id="percentageDiscountInput" style="{{ $voucher->discount_type === 'percentage' ? '' : 'display: none' }}">
                                        <div class="input-group mb-3">
                                            <input type="number" class="form-control" min="1" max="100" name="discount_value_percen" placeholder="Nhập giá trị lớn hơn 1%"  value="{{$voucher->discount_type !== 'fixed' ? $voucher->discount_value : ''}}">
                                            <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2">|  % Giảm</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    
                                </div>
                            </div>                            
                        </div>
                    </div>                    
                </div>
                <div class="form-group" id="maxDiscountInputGroup" style="{{ $voucher->discount_type === 'percentage' ? '' : 'display: none' }}">
                    <div class="row">
                        <div class="col-3">
                            <label for="max_discount">Mức giảm tối đa</label>
                        </div>
                        <div class="col-6">
                            <input class="form-control" min="0" type="number" name="max_discount" value="{{$voucher->max_discount}}">
                        </div>
                    </div>
                </div>

                <div class="form-group"> 
                    <div class="row">
                        <div class="col-3">
                            <label for="min_order_value">Giá trị đơn hàng tối thiểu</label>
                        </div>
                        <div class="col-6">
                            <input class="form-control" min="0" type="number" name="min_order_value" id="min_order_value" value="{{$voucher->min_order_value}}">  
                            @error('min_order_value')                        
                                <small class="text-danger">{{$message}}</small>
                            @enderror 
                        </div>                        
                    </div>                                                          
                </div>
                <div class="form-group">  
                    <div class="row">
                        <div class="col-3">
                            <label for="usage_limit">Tổng lượt sử dụng tối đa</label>
                        </div>
                        <div class="col-6">
                            <input class="form-control" min="0" type="number" name="usage_limit" id="usage_limit" value="{{$voucher->usage_limit}}">   
                            @error('usage_limit')                        
                                <small class="text-danger">{{$message}}</small>
                            @enderror 
                        </div>                        
                    </div>                                                                                                 
                </div>
                <button type="submit" value="Thêm mới" name="btn-edit" class="btn btn-primary">Lưu</button>
            </form>
        </div>
    </div>
</div>
    
@endsection