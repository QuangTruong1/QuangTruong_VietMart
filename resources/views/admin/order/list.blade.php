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
           
                <table class="table table-striped table-checkall">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Mã</th>
                            <th scope="col">Khách hàng</th>
                            <th scope="col">Giá trị</th>
                            <th scope="col">Thời gian</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $stt=0;
                        @endphp
                        @foreach ($list_order as $order)
                            @if ($order->user)
                                @php
                                    $stt++;
                                @endphp
                                <tr>
                                    <td>{{$stt}}</td>
                                    <td>{{$order->code}}</td>
                                    <td>
                                    {{$order->user->name}}
                                    </td>
                                    <td>{{number_format($order->price, 0, '', '.')}}đ</td>
                                    <td>{{$order->created_at}}</td>
                                    <td>
                                        <a href="{{route('delete_order_dashboard', $order->id)}}" onclick="return confirm('Bạn có chắc muốn hủy Đơn hàng?');" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endif   
                        @endforeach        
                    </tbody>
                </table>
      
            {{$list_order->links()}}
        </div>
    </div>
</div>
    
@endsection