@extends('layouts.admin')
@section('title', 'Danh mục ngành hàng')
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
                @can('industry.add')
                <div class="card-header font-weight-bold">
                    Danh mục ngành hàng
                </div>
                <div class="card-body">
                    <form action="{{route('add_industry')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name">Tên ngành hàng</label>
                            <input class="form-control" type="text" name="name" id="name" >
                            @error('name')
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
                    Danh sách ngành hàng
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tên danh mục</th>
                                <th scope="col">Slug</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $stt = 0;
                            @endphp
                            @foreach ($list_industry as $item)
                            @php
                                $stt++;
                            @endphp
                            <tr>
                                <th scope="row">{{$stt}}</th>
                                <td>{{$item->name}}</td>
                                <td>{{$item->slug}}</td>
                                <td>
                                    @can('industry.edit')
                                    <a href="{{route('edit_industry', $item->id)}}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                        
                                    @endcan
                                    @can('industry.delete')
                                    <a href="{{route('delete_industry', $item->id)}}" onclick="return confirm('Bạn có chắc muốn xóa vĩnh viễn danh mục sản phẩm?');" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                                        
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