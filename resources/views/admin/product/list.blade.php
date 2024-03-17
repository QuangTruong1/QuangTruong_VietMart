@extends('layouts.admin')
@section('title', 'Danh sách sản phẩm')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>            
        @endif

        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0 ">Danh sách sản phẩm</h5>
            <div class="form-search form-inline">
                <form action="{{url('admin/product/list')}}" method="get">
                    <input style="max-width: 65%;" type="text" name='key' value="{{request()->input('key')}}" class="form-control form-search" placeholder="Tìm kiếm">
                    <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                </form>
            </div>
        </div>        
        <div class="card-body">
            <div class="analytic">
                @canany(['owner.view'])
                <a href="{{request()->fullUrlWithQuery(['status'=>'stocking'])}}" class="text-primary">Còn hàng<span class="text-muted">({{$count[0]}})</span></a>
                <a href="{{request()->fullUrlWithQuery(['status'=>'outofstock'])}}" class="text-primary">Hết hàng<span class="text-muted">({{$count[1]}})</span></a>
                <a href="{{request()->fullUrlWithQuery(['status'=>'trash'])}}" class="text-primary">Ngừng kinh doanh<span class="text-muted">({{$count[2]}})</span></a>                
                <a href="{{request()->fullUrlWithQuery(['status'=>'censorship'])}}" class="text-primary">Sản phẩm đợi kiểm duyệt<span class="text-muted">({{$count[3]}})</span></a>                
                @endcanany
                @canany(['product.view_cat'])
                <a href="{{request()->fullUrlWithQuery(['status'=>'approved'])}}" class="text-primary">Sản phẩm đã kiểm duyệt<span class="text-muted">({{$count[4]}})</span></a>  
                <a href="{{request()->fullUrlWithQuery(['status'=>'not_approved'])}}" class="text-primary">Sản phẩm đợi kiểm duyệt<span class="text-muted">({{$count[5]}})</span></a>                               
                <form action="{{url('admin/product/excel')}}" method="get">
                    <button class="btn btn-primary">Xuất excel</button>
                </form>
                @endcanany                  
            </div>  
                 
            <form action="{{url('admin/product/action')}}" method="post">
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
                            <th scope="col" class="col-md-2">Ảnh</th>
                            <th scope="col">Tên sản phẩm</th>
                            <th scope="col">Giá</th>
                            <th scope="col">Danh mục</th>
                            <th scope="col">Ngày tạo</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Kiểm duyệt</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $stt = 0;
                        @endphp
                        @foreach ($list_product as $product)
                            @php
                                $stt++;
                            @endphp
                            <tr class="">
                                <td>
                                    <input type="checkbox" name="list_check[]" value="{{$product->id}}">
                                </td>
                                <td>{{$stt}}</td>
                                <td><img src="{{asset($product->thumbnail)}}" class="img-thumbnail rounded"  alt=""></td>
                                <td><a href="#">{{$product->name}}</a></td>
                                <td>{{number_format($product->price, 0, '', '.')}}đ</td>
                                <td>{{ $product->Product_category->cat_name }}</td>
                                <td>{{$product->created_at}}</td>
                                <td>
                                    @if ($product->status == 1)
                                    <span class="badge badge-success">{{$product->Status->name_status}}</span>
                                    @else
                                    <span class="badge badge-warning">{{$product->Status->name_status}}</span>
                                    @endif
                                    
                                </td>
                                <td>
                                    @if ($product->censorship_id == 1)
                                    <span class="badge badge-success">{{$product->Status_censorship->name_censorship}}</span>
                                    @else
                                    <span class="badge badge-warning">{{$product->Status_censorship->name_censorship}}</span>
                                    @endif
                                    
                                </td>
                                <td>
                                    @canany('product.edit')
                                    <a href="{{route('product.edit_product', $product->id)}}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                    @endcanany
                                    <a href="{{route('delete_product', $product->id)}}" onclick="return confirm('Bạn có chắc muốn xóa vĩnh viễn sản phẩm?');" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach                                                      
                    </tbody>
                </table>                
            </form>
            {{$list_product->appends(['status' => $status])->links()}} 
        </div>
        
    </div>
    
</div>
@endsection