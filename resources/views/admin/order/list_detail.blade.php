@extends('layouts.admin')
@section('title', 'Danh sách đơn hàng')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>            
        @endif
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0 ">Danh sách đơn hàng</h5>
            <div class="form-search form-inline">
                <div class="form-search form-inline">
                    <form action="{{url('admin/order/list')}}" method="get">
                        <input style="max-width: 65%;" type="text" name='key' value="{{request()->input('key')}}" class="form-control form-search" placeholder="Tìm kiếm">
                        <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="analytic">
                <a href="{{request()->fullUrlWithQuery(['status'=>'finish'])}}" class="text-primary">Hoàn thành<span class="text-muted">({{$count[0]}})</span></a>
                <a href="{{request()->fullUrlWithQuery(['status'=>'unfinished'])}}" class="text-primary">Đang xử lý<span class="text-muted">({{$count[1]}})</span></a>
                <a href="{{request()->fullUrlWithQuery(['status'=>'trash'])}}" class="text-primary">Đã xóa<span class="text-muted">({{$count[2]}})</span></a>                
            </div>
            <form action="{{url('admin/order/action')}}" method="post">
                @csrf
                <div class="form-action form-inline py-3">
                    <select class="form-control mr-1" name="act" id="">
                        <option value ="">Chọn</option>
                        @foreach ($list_act as $key => $value)
                            <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                        
                    </select>
                    <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
                </div>
                <table class="table table-striped table-checkall">
                    <thead>
                        <tr>
                            <th scope="col">
                                <input name="checkall" type="checkbox">
                            </th>
                            <th scope="col">#</th>
                            <th scope="col">Mã đơn hàng</th>
                            <th scope="col">Tên sản phẩm</th>
                            <th scope="col">Kiểu/Loại</th>
                            <th scope="col">Màu</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Giá trị</th>
                            <th scope="col">Tổng giá trị</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Thời gian</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $stt=0;
                        @endphp
                        @foreach ($list_order_detail as $order_detail)
                            @php
                                $stt++;
                            @endphp
                            <tr>
                                <td>
                                    <input type="checkbox" name="list_check[]" value="{{$order_detail->id}}">
                                </td>
                                <td>{{$stt}}</td>
                                <td>{{$order_detail->order->code}}</td>
                                <td>{{$order_detail->product->name}}</td>
                                <td>{{$order_detail->type}}</td>
                                <td>{{$order_detail->color}}</td>
                                <td>{{$order_detail->quantity}}</td>
                                <td>{{number_format($order_detail->price, 0, '', '.')}}</td>
                                <td>{{number_format($order_detail->total, 0, '', '.')}}</td>
                                <td>
                                    @if ($order_detail->status_id == 1)
                                    <span class="badge badge-warning">{{$order_detail->status->name}}</span>
                                    @else
                                    <span class="badge badge-success">{{$order_detail->status->name}}</span>
                                    @endif
                                </td>
                                <td>{{$order_detail->created_at}}</td>
                                <td>
                                    <a href="{{route('delete_order', $order_detail->id)}}" onclick="return confirm('Bạn có chắc muốn hủy Đơn hàng?');" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach        
                    </tbody>
                </table>
            </form>
            {{$list_order_detail->links()}}
        </div>
    </div>
</div>
    
@endsection