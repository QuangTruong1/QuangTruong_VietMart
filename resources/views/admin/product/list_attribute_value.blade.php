@extends('layouts.admin')
@section('title', 'Quản lý giá trị thuộc tính')
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
                @can('attribute_value.add')
                <div class="card-header font-weight-bold">
                    Quản lý giá trị thuộc tính
                </div>
                <div class="card-body">
                    <form action="{{route('add_attribute_value')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="value">Giá trị</label>
                            <input class="form-control" type="text" name="value" id="value" value="{{old('value')}}">
                            @error('value')
                                <small class="form-text text-danger">{{$message}}</small>                    
                            @enderror
                        </div>                       
                        <div class="form-group">
                            <label for="">Thuộc tính cha:</label>
                            <select class="form-control" id="" name="attribute_id">
                                <option value="">Chọn thuộc tính cha</option>
                                @foreach ($list_attribute as $item)
                                    <option value="{{ $item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                            @error('attribute_id')
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
                                <th scope="col">Giá trị</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $stt = 0;
                            @endphp
                            @foreach ($list_attribute_value as $item)
                            @php
                                $stt++;
                            @endphp
                            <tr>
                                <th scope="row">{{$stt}}</th>
                                <td>{{$item->attribute->name}}</td>
                                <td>{{$item->value}}</td>
                                <td>
                                    @can('attribute_value.edit')
                                    <a href="{{route('edit_attribute_value', $item->id)}}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                        
                                    @endcan
                                    @can('attribute_value.delete')
                                    <a href="{{route('delete_attribute_value', $item->id)}}" onclick="return confirm('Bạn có chắc muốn xóa vĩnh viễn danh mục sản phẩm?');" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                                        
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