@extends('layouts.admin')
@section('title', 'Danh sách người dùng')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>            
        @endif

        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0 ">Danh sách Voucher trên hệ thống VietMart</h5>
            <div class="form-search form-inline">
                <form action="{{url('admin/voucher/list')}}" method="get">
                    <input style="max-width: 65%;" type="text" name='key' value="{{request()->input('key')}}" class="form-control form-search" placeholder="Tìm kiếm">
                    <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="analytic">
                <a href="{{request()->fullUrlWithQuery(['status'=>'valid'])}}" class="text-primary">Voucher còn hoạt động<span class="text-muted">({{$count[0]}})</span></a>
                <a href="{{request()->fullUrlWithQuery(['status'=>'invalid'])}}" class="text-primary">Voucher hết hạn(hết lượt) sử dụng<span class="text-muted">({{$count[1]}})</span></a>                
            </div>
            <form action="{{url('admin/user/action')}}" method="post">
                @csrf
                <div class="form-action form-inline py-3">
                    <select class="form-control mr-1" name="act" id="">
                        <option>Chọn</option>
                        @foreach ($list_act as $key => $value)
                            <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                        
                    </select>
                    <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
                </div>
                <table class="table table-striped table-checkall">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" name="checkall">
                            </th>
                            <th scope="col">#</th>
                            <th scope="col">Tên chương trình</th>  
                            <th scope="col">Mã code</th>
                            <th scope="col">Thời gian bắt đầu</th>
                            <th scope="col">Thời gian kết thúc</th>
                            <th scope="col">Kiểu giảm</th>
                            <th scope="col">Giá trị giảm</th>
                            <th scope="col">Giá trị giảm tối đa</th>
                            <th scope="col">Giá trị đơn hàng tối thiểu</th>
                            <th scope="col">Số lượt sử dụng</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($vouchers->total() > 0)
                            @php
                                $stt = 0;
                            @endphp
                            @foreach ($vouchers as $voucher)
                                @php
                                    $stt++;
                                @endphp
                                <tr>
                                    <td>
                                        <input type="checkbox" name="list_check[]" value="{{$voucher->id}}">
                                    </td>
                                    <td>{{$stt}}</td>
                                    <td>{{$voucher->program_name}}</td>
                                    <td>{{$voucher->voucher_code}}</td>                        
                                    <td>{{$voucher->start_date}}</td>                        
                                    <td>{{$voucher->end_date}}</td>                        
                                    <td>{{$voucher->discount_type}}</td>                        
                                    <td>{{$voucher->discount_value}}</td>                        
                                    <td>
                                        @if ($voucher->discount_value != null)
                                            {{$voucher->max_discount}}                                        
                                        @else
                                            <p>aa</p>
                                        @endif
                                    </td>
                                    <td>{{$voucher->min_order_value}}</td>                          
                                    <td>{{$voucher->usage_limit}}</td>                          
                                    <td>
                                        @canany('voucher.edit')
                                        <a href="{{route('edit_voucher', $voucher->id)}}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                        @endcanany
                                        @canany('voucher.delete')
                                        <a href="{{route('delete_voucher', $voucher->id)}}" onclick="return confirm('Bạn có chắc chắn muốn xóa ?')" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>    
                                        @endcanany
                                    </td>
                                </tr>
                            @endforeach      
                        @else  
                            <tr>
                                <td colspan="7" class="bg-white"><p>Không tìm thấy bản ghi</p></td>
                            </tr> 
                            
                        @endif
                    </tbody>
                </table>
            </form>

            {{-- Tạo dòng phân trang tự động --}}
            {{$vouchers->appends(['status' => $status])->links()}} 
        </div>
    </div>
</div>
@endsection