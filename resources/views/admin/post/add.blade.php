@extends('layouts.admin')
@section('title', 'Thêm bài viết')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Thêm bài viết
        </div>
        <div class="card-body">
            <form action="{{url('admin/post/store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                @csrf
                <div class="form-group">
                    <label for="name">Tiêu đề bài viết</label>
                    <input class="form-control" type="text" name="title" id="name">
                    @error('title')
                        <small class="form-text text-danger">{{$message}}</small>                    
                    @enderror
                </div>
                <div class="form-group">
                    <label for="content">Nội dung bài viết</label>
                    <textarea name="content" class="form-control" id="content" cols="30" rows="5"></textarea>
                    @error('content')
                        <small class="form-text text-danger">{{$message}}</small>                    
                    @enderror
                </div>
                <div class="form-group">
                    <label for="thumbnail">Ảnh chính bài viết</label>
                    <input class="form-control-file" name="file" type="file" id="thumbnail">
                    @error('file')
                        <small class="form-text text-danger">{{$message}}</small>                    
                    @enderror
                </div>

                <div class="form-group">
                    <label for="">Danh mục</label>
                    @php
                        $stt=0;
                    @endphp
                    <select class="form-control" id="" name="post_cat">
                        <option value="">Chọn danh mục</option>
                        @foreach ($list_post_cat as $post)
                            <option value="{{$post->id}}">{{$post->name}}</option>
                        @endforeach
                    </select>
                    @error('post_cat')
                        <small class="form-text text-danger">{{$message}}</small>                    
                    @enderror
                </div>          
                <button type="submit" class="btn btn-primary">Thêm mới</button>
            </form>
        </div>
    </div>
</div>
    
@endsection