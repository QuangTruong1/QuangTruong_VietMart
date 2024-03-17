@extends('layouts.admin')
@section('title', 'Chỉnh sửa thông tin danh mục bài viết')
@section('content')
<div id="content" class="container-fluid">
    <div class="row">
        <div class="col-4">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Danh mục bài viết
                </div>
                <div class="card-body">
                    <form action="{{route('update_post_cat', $post_cat->id)}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name">Tên danh mục</label>
                            <input class="form-control" type="text" name="name" id="name" value="{{$post_cat->name}}">
                        </div>
                        <div class="form-group">
                            <label for="">Danh mục cha</label>
                            <select class="form-control" id="" name="parent_id">
                                @if ($post_cat->parent_id == 0)
                                    <option value="">Chính nó</option>
                                    @foreach ($list_post_cat as $cat_item)
                                        @if ($cat_item->id != $post_cat->parent_id)
                                            <option value="{{ $cat_item->id}}">{{$cat_item->name}}</option>
                                        @endif
                                    @endforeach
                                @else
                                    @foreach ($list_post_cat as $cat_item)
                                        @if ($cat_item->id == $post_cat->parent_id)
                                            <option value="{{ $cat_item->id}}">{{$cat_item->name}}</option>
                                        @endif
                                    @endforeach
                                    <option value="">Chính nó</option>
                                    @foreach ($list_post_cat as $cat_item)        
                                        @if ($cat_item->id != $post_cat->id)
                                            <option value="{{ $cat_item->id}}">{{$cat_item->name}}</option>
                                        @endif
                                    @endforeach
                                @endif
                                
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Trạng thái</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="2" checked>
                                <label class="form-check-label" for="exampleRadios1">
                                    Chờ duyệt
                                </label>
                            </div>
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
                                <th scope="col">Danh mục cha</th>
                                <th scope="col">Slug</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $stt = 0;
                            @endphp
                            @foreach ($list_post_cat as $cat_item)
                            @php
                                $stt++;
                            @endphp
                            <tr>
                                <th scope="row">{{$stt}}</th>
                                <td>{{$cat_item->name}}</td>
                                <td>{{$cat_item->parent_id}}</td>
                                <td>{{$cat_item->slug}}</td>
                                <td>
                                    <a href="{{route('edit_post_cat', $cat_item->id)}}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                    <a href="{{route('delete_post_cat', $cat_item->id)}}" onclick="return confirm('Bạn có chắc muốn xóa vĩnh viễn danh mục?');" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
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