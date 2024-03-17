@extends('layouts.admin')
@section('title', 'Chỉnh sửa thông tin sản phẩm')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Sửa thông tin sản phẩm
        </div>
        <div class="card-body">
            <form action="{{route('product.update_product', $product->id)}}" method="POST" enctype="multipart/form-data">
                @csrf   
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="name">Tên sản phẩm</label>
                            <input class="form-control" type="text" name="name" id="name" value="{{$product->name}}">
                            @error('name')
                                <small class="form-text text-danger">{{$message}}</small>                    
                            @enderror
                        </div>
                    </div>
                    <div class="col-12">                    
                        <div class="form-group">
                            <label for="name">Giá</label>
                            <input class="form-control" type="text" name="price" id="name" value="{{$product->price}}">
                            @error('price')
                                <small class="form-text text-danger">{{$message}}</small>                    
                            @enderror
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="intro">Mô tả sản phẩm</label>
                            <textarea name="content" class="form-control" id="intro" cols="30" rows="5">{{$product->content}}</textarea>
                            @error('content')
                                <small class="form-text text-danger">{{$message}}</small>                    
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="intro">Chi tiết sản phẩm</label>
                    <textarea name="description" class="form-control" id="intro" cols="30" rows="5">{{$product->description}}</textarea>
                    @error('description')
                        <small class="form-text text-danger">{{$message}}</small>                    
                    @enderror
                </div>

                <div class="form-group">
                    <label for="thumbnail">Ảnh sản phẩm</label>
                    <input class="form-control-file" name="file" type="file" id="thumbnail">
                </div>

                <div class="form-group">
                    <label for="industry-select">Ngành hàng:</label>
                    <select id="industry-select" class="form-control" name="industry">
                        <option value="{{$product->Product_category->segment->industry->id}}">{{$product->Product_category->segment->industry->name}}</option>
                        @foreach ($list_industry as $item)   
                            @if ($item->id != $product->Product_category->segment->industry->id)
                                <option value="{{$item->id}}">{{$item->name}}</option>   
                            @endif                                                                
                        @endforeach
                    </select>
                    @error('industry')
                        <small class="form-text text-danger">{{$message}}</small>                    
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="segment-select">Phân khúc:</label>
                    <select id="segment-select" class="form-control" name="segment">
                        <option value="{{$product->Product_category->segment->id}}">{{$product->Product_category->segment->name}}</option>
                        @foreach ($list_segment as $item)   
                            @if ($item->id != $product->Product_category->segment->id)
                                <option value="{{$item->id}}">{{$item->name}}</option>   
                            @endif                                                                
                        @endforeach
                    </select>
                    @error('segment')
                        <small class="form-text text-danger">{{$message}}</small>                    
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="product-cat-select">Loại sản phẩm:</label>
                    <select id="product-cat-select" class="form-control" name="product_cat">
                        <option value="{{$product->Product_category->id}}">{{$product->Product_category->cat_name}}</option>
                        @foreach ($list_product_cat as $item)   
                            @if ($item->id != $product->Product_category->id)
                                <option value="{{$item->id}}">{{$item->cat_name}}</option>   
                            @endif                                                                
                        @endforeach
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

                <fieldset >
                    <legend>Thông tin chi tiết</legend>
                    {{-- Thông tin chung của sản phẩm --}}
                    @if(isset($product->general_info->brand_id))
                    <div id="brand-box" class="form-group">
                        <label for="brand">Thương hiệu:</label>
                        <select id="brand" class="form-control" name="brand_id">
                            <option value="{{$product->general_info->brand_id}}">{{$product->general_info->brand->name}}</option>
                            @foreach ($list_brand as $item)   
                                @if ($item->id != $product->general_info->brand_id)
                                    @if ($item->industry_id == $product->Product_category->segment->industry->id)
                                        <option value="{{$item->id}}">{{$item->name}}</option>   
                                    @endif
                                @endif                                                                
                            @endforeach
                        </select>
                        @error('brand_id')
                            <small class="form-text text-danger">{{$message}}</small>                    
                        @enderror
                    </div>
                    @else
                    <div id="brand-box" class="form-group">
                        <label for="brand">Thương hiệu:</label>
                        <select id="brand" class="form-control" name="brand_id"> 
                            <option value="">Chọn thương hiệu</option>
                            @foreach ($list_brand as $item)   
                                <option value="{{$item->id}}">{{$item->name}}</option>                                                              
                            @endforeach
                        </select>
                        @error('brand_id')
                            <small class="form-text text-danger">{{$message}}</small>                    
                        @enderror
                    </div>
                    @endif
                    
                    @if ($product->general_info->pattern_id != null)
                        @if(isset($product->general_info->material_id))
                        <div id="material-box" class="form-group">
                            <label for="material">Chất liệu:</label>
                            <select id="material" class="form-control" name="material_id">
                                <option value="{{$product->general_info->material_id}}">{{$product->general_info->material->name}}</option>
                                @foreach ($list_material as $item)   
                                    @if ($item->id != $product->general_info->material_id)
                                        <option value="{{$item->id}}">{{$item->name}}</option>   
                                    @endif                                                                
                                @endforeach
                            </select>
                            @error('material_id')
                                <small class="form-text text-danger">{{$message}}</small>                    
                            @enderror
                        </div>
                        @else
                        <div id="brand-box" class="form-group">
                            <label for="material">Chất liệu:</label>
                            <select id="material" class="form-control" name="material_id">
                                <option value="">Chọn chất liệu</option>
                                @foreach ($list_material as $item)   
                                    <option value="{{$item->id}}">{{$item->name}}</option>                                                               
                                @endforeach
                            </select>
                            @error('material_id')
                                <small class="form-text text-danger">{{$message}}</small>                    
                            @enderror
                        </div>
                        @endif
                    @endif
                    

                   
                    @if ($product->general_info->pattern_id != null)
                        @if(isset($product->general_info->pattern_id))
                        <div id="pattern-box" class="form-group">
                            <label for="pattern">Mẫu:</label>
                            <select id="pattern" class="form-control" name="pattern_id">
                                <option value="{{$product->general_info->pattern_id}}">{{$product->general_info->pattern->name}}</option>
                                @foreach ($list_pattern as $item)   
                                    @if ($item->id != $product->general_info->pattern_id)
                                        <option value="{{$item->id}}">{{$item->name}}</option>   
                                    @endif                                                                
                                @endforeach
                            </select>
                            @error('pattern_id')
                                <small class="form-text text-danger">{{$message}}</small>                    
                            @enderror
                        </div>
                        @else
                        <div id="brand-box" class="form-group">
                            <label for="pattern">Mẫu:</label>
                            <select id="pattern" class="form-control" name="pattern_id">
                                <option value="">Chọn mẫu</option>
                                @foreach ($list_pattern as $item)   
                                    <option value="{{$item->id}}">{{$item->name}}</option>                                                                
                                @endforeach
                            </select>
                            @error('pattern_id')
                                <small class="form-text text-danger">{{$message}}</small>                    
                            @enderror
                        </div>
                        @endif
                    @endif
                    
                    
                    {{-- Thông tin chi tiết khác của riêng mỗi loại sản phẩm --}}
                    <div id="attribute-box" class="form-group"></div>

                </fieldset>
                
            

                <button type="submit" class="btn btn-primary">Lưu</button>
            </form>
        </div>
    </div>
</div>
    
@endsection