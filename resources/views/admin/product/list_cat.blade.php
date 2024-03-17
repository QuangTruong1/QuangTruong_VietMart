@extends('layouts.admin')
@section('title', 'Danh mục loại sản phẩm')
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
                @can('product.add_cat')
                <div class="card-header font-weight-bold">
                    Danh mục loại sản phẩm
                </div>
                <div class="card-body">
                    <form action="{{route('add_product_cat')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name">Tên loại</label>
                            <input class="form-control" type="text" name="name" id="name" value="{{old('name')}}">
                            @error('name')
                                <small class="form-text text-danger">{{$message}}</small>                    
                            @enderror
                        </div>                       
                        <div class="form-group">
                            <label for="">Thuộc phân khúc</label>
                            <select class="form-control" id="" name="segment_id">
                                <option value="">Chọn phân khúc sản phẩm</option>
                                @foreach ($list_segment as $item)
                                    <option value="{{ $item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                            @error('segment_id')
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
                                <th scope="col">Tên danh mục</th>
                                <th scope="col">Danh mục phân khúc</th>
                                <th scope="col">Slug</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $stt = 0;
                            @endphp
                            @foreach ($list_product_cat as $cat_item)
                            @php
                                $stt++;
                            @endphp
                            <tr>
                                <th scope="row">{{$stt}}</th>
                                <td>{{$cat_item->cat_name}}</td>
                                <td>{{$cat_item->segment->name}}</td>
                                <td>{{$cat_item->slug}}</td>
                                <td>
                                    @can('product.edit_cat')
                                    <a href="{{route('edit_product_cat', $cat_item->id)}}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                        
                                    @endcan
                                    @can('product.delete_cat')
                                    <a href="{{route('delete_product_cat', $cat_item->id)}}" onclick="return confirm('Bạn có chắc muốn xóa vĩnh viễn danh mục sản phẩm?');" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                                        
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