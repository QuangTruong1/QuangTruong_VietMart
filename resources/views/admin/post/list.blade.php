@extends('layouts.admin')
@section('title', 'Danh sách bài viết')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>            
        @endif
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0 ">Danh sách bài viết</h5>
            <div class="form-search form-inline">
                <form action="{{url('admin/post/list')}}" method="get">
                    <input style="max-width: 65%;" type="text" name='key' value="{{request()->input('key')}}" class="form-control form-search" placeholder="Tìm kiếm">
                    <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="analytic">
                <a href="{{request()->fullUrlWithQuery(['status'=>'approved'])}}" class="text-primary">Đã được duyệt<span class="text-muted">({{$count[0]}})</span></a>
                <a href="{{request()->fullUrlWithQuery(['status'=>'not_approved'])}}" class="text-primary">Chưa được duyệt<span class="text-muted">({{$count[1]}})</span></a>
                <a href="{{request()->fullUrlWithQuery(['status'=>'trash'])}}" class="text-primary">Đã xóa<span class="text-muted">({{$count[2]}})</span></a>                
            </div>
            <form action="{{url('admin/post/action')}}" method="post">
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
                            <th scope="col">Tiêu đề</th>
                            <th scope="col">Danh mục</th>
                            <th scope="col">Ngày tạo</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $stt=0;
                        @endphp
                        @foreach ($list_post as $post)
                        @php
                            $stt++;
                        @endphp
                            <tr>
                                <td>
                                    <input type="checkbox" name="list_check[]" value="{{$post->id}}">
                                </td>
                                <td scope="row">{{$stt}}</td>
                                <td><img src="{{asset($post->thumbnail)}}" class="img-thumbnail rounded" alt=""></td>
                                <td><a href="">{{$post->title}}</a></td>
                                <td>{{$post->post_cat->name}}</td>
                                <td>{{$post->created_at}}</td>
                                <td><span class="badge badge-success">{{$post->censorship->name_censorship}}</span></td>
                                <td>
                                    <a href="{{route('post.edit_post', $post->id)}}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                    <a href="{{route('delete_post', $post->id)}}" onclick="return confirm('Bạn có chắc muốn xóa vĩnh viễn sản phẩm?');" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </form>
            {{$list_post->links()}} 
        </div>
    </div>
</div>
    
@endsection