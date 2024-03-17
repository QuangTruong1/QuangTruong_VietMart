@extends('layouts.adminPost')
@section('title', 'Chỉnh sửa thông tin sản phẩm')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Chỉnh sửa bài viết
        </div>
        <div class="card-body">
            <form action="{{route('post.update_post', $post->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @csrf
                <div class="form-group">
                    <label for="name">Tiêu đề bài viết</label>
                    <input class="form-control" type="text" name="title" id="name" value="{{$post->title}}">
                    @error('title')
                        <small class="form-text text-danger">{{$message}}</small>                    
                    @enderror
                </div>
                <div class="form-group">
                    <label for="content">Nội dung bài viết</label>
                    <textarea name="content" class="form-control" id="content" cols="30" rows="5">{{$post->content}}</textarea>
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
                        <option value="{{$post->post_cat_id}}">{{$post->post_cat->name}}</option>
                        @foreach ($list_post_cat as $item)
                            @if ($item->id != $post->post_cat_id)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endif
                        @endforeach
                    </select>
                    @error('post_cat')
                        <small class="form-text text-danger">{{$message}}</small>                    
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Lưu</button>
            </form>
        </div>
    </div>
</div>
    
@endsection