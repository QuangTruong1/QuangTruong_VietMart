@extends('layouts.admin')
@section('title', 'Quản lý thông tin chi tiết khác')
@section('content')
<div id="content" class="container-fluid">    
    <div class="row">
        <div class="col-4">
            <div class="card">             
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>            
                @endif
                @can('attribute.add')
                <div class="card-header font-weight-bold">
                    Quản lý thông tin chi tiết khác
                </div>
                <div class="card-body">
                    <form action="{{route('add_attribute')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name">Tên thuộc tính</label>
                            <input class="form-control" type="text" name="name" id="name" value="{{old('name')}}" >
                            @error('name')
                                <small class="form-text text-danger">{{$message}}</small>                    
                            @enderror
                        </div>
                                               
                        <div class="form-group">
                            <label for="">Thuộc loại sản phẩm:</label>
                            <select class="form-control" id="" name="product_cat_id">
                                <option value="">Chọn loại sản phẩm</option>
                                @foreach ($list_product_cat as $item)
                                    <option value="{{ $item->id}}">{{$item->cat_name}}</option>
                                @endforeach
                            </select>
                            @error('product_cat_id')
                                <small class="form-text text-danger">{{$message}}</small>                    
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Thêm mới</button>
                    </form>
                </div>
                @endcan
            </div>
        </div>
        <div class="col-8">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Danh sách
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tên thuộc tính</th>
                                <th scope="col">Thuộc loại sản phẩm</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $stt = 0;
                            @endphp
                            @foreach ($list_attribute as $item)
                            @php
                                $stt++;
                            @endphp
                            <tr>
                                <th scope="row">{{$stt}}</th>
                                <td>{{$item->name}}</td>
                                <td>{{$item->product_cat->cat_name}}</td>
                                <td>
                                    @can('attribute.edit')
                                    <a href="{{route('edit_attribute', $item->id)}}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                    @endcan
                                    @can('attribute.delete')
                                    <a href="{{route('delete_attribute', $item->id)}}" onclick="return confirm('Bạn có chắc muốn xóa vĩnh viễn danh mục sản phẩm?');" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                                    @endcan
                                </td>
                            </tr>    
                            @endforeach
                            
                        
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection