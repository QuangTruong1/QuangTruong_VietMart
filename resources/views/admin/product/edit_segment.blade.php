@extends('layouts.admin')
@section('title', 'Chỉnh sửa thông tin phân khúc')
@section('content')
<div id="content" class="container-fluid">    
    <div class="row">
        <div class="col-4">
            <div class="card">   

                <div class="card-header font-weight-bold">
                    Danh mục phân khúc
                </div>
                <div class="card-body">
                    <form action="{{route('update_segment', $segment->id)}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name">Tên phân khúc</label>
                            <input class="form-control" type="text" name="name" id="name" value="{{$segment->name}}">
                            @error('name')
                                <small class="form-text text-danger">{{$message}}</small>                    
                            @enderror
                        </div>                       
                        <div class="form-group">
                            <label for="">Danh mục cha</label>
                            <select class="form-control" id="" name="industry_id">
                                <option value="{{$segment->industry_id}}">{{$segment->industry->name}}</option>
                                    @foreach ($list_industry as $item)
                                        @if ($item->id != $segment->industry_id)
                                            <option value="{{ $item->id}}">{{$item->name}}</option>
                                        @endif
                                    @endforeach                                                      
                            </select>
                            @error('industry_id')
                                <small class="form-text text-danger">{{$message}}</small>                    
                            @enderror
                        </div>



                        <button type="submit" class="btn btn-primary">Thêm mới</button>
                    </form>
                </div>
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
                                <th scope="col">Thuộc ngành hàng</th>
                                <th scope="col">Slug</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $stt = 0;
                            @endphp
                            @foreach ($list_segment as $item)
                            @php
                                $stt++;
                            @endphp
                            <tr>
                                <th scope="row">{{$stt}}</th>
                                <td>{{$item->name}}</td>
                                <td>{{$item->industry->name}}</td>
                                <td>{{$item->slug}}</td>
                                <td>
                                    @can('segment.edit')
                                    <a href="{{route('edit_segment', $item->id)}}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                    @endcan
                                    @can('segment.delete')
                                    <a href="{{route('delete_segment', $item->id)}}" onclick="return confirm('Bạn có chắc muốn xóa vĩnh viễn danh mục sản phẩm?');" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
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