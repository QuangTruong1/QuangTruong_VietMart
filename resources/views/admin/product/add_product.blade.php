@extends('layouts.admin')
@section('title', 'Thêm sản phẩm')
@section('content')
<style>
    .form-group-container {
            display: flex;
        }
        .form-group {
            margin-right: 10px; 
        }
</style>
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Thêm sản phẩm
        </div>
        <div class="card-body">
            <form action="{{url('admin/product/store')}}" method="POST" enctype="multipart/form-data">
                @csrf   
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="name">Tên sản phẩm</label>
                            <input class="form-control" type="text" name="name" id="name" value="{{old('name')}}">
                            @error('name')
                                <small class="form-text text-danger">{{$message}}</small>                    
                            @enderror
                        </div>                      
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="intro">Mô tả sản phẩm</label>
                            <textarea name="content" class="form-control" id="intro" cols="30" rows="5">{{old('content')}}</textarea>
                            @error('content')
                                <small class="form-text text-danger">{{$message}}</small>                    
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="intro">Chi tiết sản phẩm</label>
                    <textarea name="description" class="form-control" id="intro" cols="30" rows="5">{{old('description')}}</textarea>
                    @error('description')
                        <small class="form-text text-danger">{{$message}}</small>                    
                    @enderror
                </div>

                <div class="form-group">
                    <label for="thumbnail">Ảnh sản phẩm</label>
                    <input class="form-control-file" name="file" type="file" id="thumbnail" onchange="previewImage(this);">
                    <img id="image-preview" src="#" alt="Preview" style="display: none; max-width: 200px; max-height: 100px">
                    @error('file')
                        <small class="form-text text-danger">{{$message}}</small>                    
                    @enderror
                </div>
                <script>
                    function previewImage(input) {
                        
                        if (input.files && input.files[0]) {                           
                            var reader = new FileReader();
                    
                            reader.onload = function (e) {
                                $('#image-preview').attr('src', e.target.result);
                                $('#image-preview').show();
                            }
                    
                            reader.readAsDataURL(input.files[0]);
                        }
                    }
                </script>
                <div class="form-group">
                    <label for="industry-select">Ngành hàng:</label>
                    <select id="industry-select" class="form-control" name="industry">
                        <option value="">Chọn ngành hàng</option>
                        @foreach ($list_industry as $item)                        
                            <option value="{{$item->id}}">{{$item->name}}</option>                                                
                        @endforeach
                    </select>
                    @error('industry')
                        <small class="form-text text-danger">{{$message}}</small>                    
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="segment-select">Phân khúc:</label>
                    <select id="segment-select" class="form-control" name="segment">
                        <option value="">Chọn phân khúc</option>
                        <!-- Các tùy chọn cho phân khúc -->
                    </select>
                    @error('segment')
                        <small class="form-text text-danger">{{$message}}</small>                    
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="product-cat-select">Loại sản phẩm:</label>
                    <select id="product-cat-select" class="form-control" name="product_cat">
                        <option value="">Chọn loại sản phẩm</option>
                        <!-- Các tùy chọn cho loại sản phẩm -->
                    </select>
                    @error('product_cat')
                        <small class="form-text text-danger">{{$message}}</small>                    
                    @enderror
                </div>
                <style>
                    fieldset {
                      border: 1px solid #ccc;
                      border-radius: 5px;
                      padding: 10px;
                    }
                  </style>
                <fieldset id="fieldset-private-info" style="display: none;">
                    <legend>Thông tin chi tiết </legend>
                    {{-- Thông tin chung của sản phẩm --}}
                    <div id="brand-box" class="form-group"></div>

                    <div id="material-box" class="form-group"></div>

                    <div id="pattern-box" class="form-group"></div>
                    {{-- Thông tin chi tiết khác của riêng mỗi loại sản phẩm --}}
                    <div id="attribute-box" class="form-group"></div>
                </fieldset>
                <fieldset id="fieldset-sale-info" style="display: none;">
                    <legend>Thông tin bán hàng</legend>
                    <button type="button" id="addDetails">Thêm</button>

                    <div class="form-group-container" id="sale-info">
                        {{-- Màu sắc --}}
                        <div id="color-box" class="form-group">
                            <label>Màu sắc:</label>
                            <input type="text" name="colors[]">
                            @error('colors')
                                <small class="form-text text-danger">{{$message}}</small>                    
                            @enderror
                        </div>
                        {{-- Kiểu/size --}}
                        <div id="size-box" class="form-group">
                            <label>Kiểu/size:</label>
                            <input type="text" name="sizes[]">
                            @error('sizes')
                                <small class="form-text text-danger">{{$message}}</small>                    
                            @enderror
                        </div>
                        {{-- Giá --}}
                        <div id="size-box" class="form-group">
                            <label>Giá bán:</label>
                            <input type="text" name="prices[]">
                            @error('price')
                                <small class="form-text text-danger">{{$message}}</small>                    
                            @enderror
                        </div>
                        {{-- Số lượng --}}
                        <div id="quantity-box" class="form-group">
                            <label>Số lượng:</label>
                            <input type="number" name="quantities[]" min="1">
                            @error('quantities')
                                <small class="form-text text-danger">{{$message}}</small>                    
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="file" name="images_detail[]" multiple>
                        </div>
                    </div>

                    <div id="child" >

                    </div>
                    
                </fieldset>
                

                <button type="submit" class="btn btn-primary">Thêm mới</button>
            </form>
        </div>
    </div>
</div>
    
@endsection