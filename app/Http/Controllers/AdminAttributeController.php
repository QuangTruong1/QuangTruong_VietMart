<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\Attribute_value;
use App\Models\Brand;
use App\Models\Material;
use App\Models\Pattern;
use App\Models\Product_category;
use App\Models\Segment;
use Illuminate\Http\Request;

class AdminAttributeController extends Controller
{
    //
            //====================================Quản lý các attribute khác của mỗi loại sản phẩm================================================================
    function list_attribute(){
        $list_product_cat = Product_category::all();
        $list_attribute = Attribute::all();
        $module_active_child = 'private_info';
        return view('admin.product.list_attribute', compact('list_product_cat', 'list_attribute', 'module_active_child'));
    }
    function add_attribute(Request $request){
        $request->validate(
            [
                'name' => 'required',
                'product_cat_id' => 'required',
            ],
            [
                'required' => ':attribute không được để trống',
            ],
            [
                'name' => 'Tên thuộc tính',
                'product_cat_id' => 'Loại sản phẩm',
            ],
        );
        Attribute::create([
            'name' => $request->name,
            'product_cat_id' => $request->product_cat_id, 
        ]);

        return redirect('admin/product/attribute/list')->with('status', 'Thêm thuộc tính mới thành công');
    }

    
    function edit_attribute($id){
        $list_product_cat = Product_category::all();
        $list_attribute = Attribute::all();
        $attribute = Attribute::find($id);

        return view('admin.product.edit_attribute', compact('attribute', 'list_product_cat', 'list_attribute'));
    }

    function update_attribute($id, Request $request){
        $request->validate(
            [
                'name' => 'required',
                'product_cat_id' => 'required',
            ],
            [
                'required' => ':attribute không được để trống',
            ],
            [
                'name' => 'Tên thuộc tính',
                'product_cat_id' => 'Loại sản phẩm',
            ],
        );
        Attribute::where('id', $id)->update([
            'name' => $request->name,
            'product_cat_id' => $request->product_cat_id,
        ]);

        return redirect('admin/product/attribute/list')->with('status', 'Cập nhật thuộc tính thành công');
    }
    function delete_attribute($id){
        Attribute::find($id)->delete();
        return redirect('admin/product/attribute/list')->with('status', 'Xóa thuộc tính thành công');
    }




    
    //====================================Quản lý giá trị các attribute khác của mỗi loại sản phẩm================================================================
    function list_attribute_value(){
        $list_attribute_value = Attribute_value::all();
        $list_attribute = Attribute::all();
        $module_active_child = 'private_info';
        return view('admin.product.list_attribute_value', compact('list_attribute_value', 'list_attribute', 'module_active_child'));
    }
    function add_attribute_value(Request $request){
        $request->validate(
            [
                'value' => 'required',
                'attribute_id' => 'required',
            ],
            [
                'required' => ':attribute không được để trống',
            ],
            [
                'value' => 'Giá trị thuộc tính', 
                'attribute_id' => 'Thuộc tính cha'
            ],
        );
        Attribute_value::create([
            'value' => $request->value,
            'attribute_id' => $request->attribute_id, 
        ]);

        return redirect('admin/product/attribute_value/list')->with('status', 'Thêm giá trị mới thành công');
    }

    
    function edit_attribute_value($id){
        $list_attribute_value = Attribute_value::all();
        $list_attribute = Attribute::all();
        $attribute_value = Attribute_value::find($id);

        return view('admin.product.edit_attribute_value', compact('attribute_value', 'list_attribute_value', 'list_attribute'));
    }

    function update_attribute_value($id, Request $request){
        $request->validate(
            [
                'value' => 'required',
                'attribute_id' => 'required',
            ],
            [
                'required' => ':attribute không được để trống',
            ],
            [
                'value' => 'Giá trị thuộc tính', 
                'attribute_id' => 'Thuộc tính cha'
            ],
        );
        Attribute_value::where('id', $id)->update([
            'value' => $request->value,
            'attribute_id' => $request->attribute_id, 
        ]);

        return redirect('admin/product/attribute_value/list')->with('status', 'Cập nhật giá trị thành công');
    }
    function delete_attribute_value($id){
        Attribute_value::find($id)->delete();
        return redirect('admin/product/attribute_value/list')->with('status', 'Xóa giá trị thành công');
    }

    //======================================Hiển thị khi thêm sản phẩm======================================================

    public function getAttributes($product_cat_id) { 
        $attributes = Attribute::where('product_cat_id', $product_cat_id)->get(); 
        $attributeValues = Attribute_value::whereIn('attribute_id', $attributes->pluck('id'))->get();
        $list_brand = Brand::all();
        $list_material = Material::all();
        $list_pattern = Pattern::all();
        return response()->json([
            'attributes' => $attributes,
            'attributeValues' => $attributeValues,
            'list_brand' => $list_brand,
            'list_material' => $list_material,
            'list_pattern' => $list_pattern,
        ]);
    }


}
