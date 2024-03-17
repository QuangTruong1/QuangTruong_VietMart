<?php

namespace App\Http\Controllers;

use App\Exports\ProductExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Attribute_value;
use App\Models\Color;
use App\Models\General_info;
use App\Models\Industry;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Product_category;
use App\Models\Segment;
use  App\Models\Attribute;
use App\Models\Brand;
use App\Models\Images;
use App\Models\Material;
use App\Models\Pattern;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    //
    function __construct(){
        $this->middleware(function($request, $next){
            session(['module_active' => 'product']);
            return $next($request);
        });  
    }
   
    function list(Request $request){
        
        $status = $request->input('status');
        $list_act = [
            'delete'=> "Ngừng kinh doanh",
            'outofstock' => "Hết hàng"
        ];
        
        if($status == 'stocking'){
           
            $list_product = Product::with('Product_category', 'Status', 'Status_censorship') -> where('status', '=', 1)->where('censorship_id', '=', 1);  
        }
        else if($status == 'outofstock'){
            $list_act = [
                'delete'=> "Ngừng kinh doanh",
                'stocking' => "Còn hàng"
            ];
            $list_product = Product::with('Product_category', 'Status', 'Status_censorship') -> where('status', '=', 2)->where('censorship_id', '=', 1);  
        }      
        else if($status == 'trash'){
            $list_act = [
                'restore' => "Khôi phục kinh doanh",
                'force' => 'Xóa vĩnh viễn',
            ];
            $list_product = Product::with('Product_category', 'Status', 'Status_censorship') -> onlyTrashed(); 
        }
        else if($status == 'approved'){
            $list_act = [
                'not_approved' => "Hủy duyệt sản phẩm",
            ];
            $list_product = Product::with('Product_category', 'Status', 'Status_censorship') -> where('censorship_id', '=', 1);   
        }
        else if($status == 'not_approved'){
            $list_act = [
                'approved' => "Duyệt sản phẩm",
            ];
            $list_product = Product::with('Product_category', 'Status', 'Status_censorship') -> where('censorship_id', '=', 2);   
        }
        else if($status == 'censorship'){
            $list_act = [                
                'force' => 'Xóa vĩnh viễn',
            ];
            $list_product = Product::with('Product_category', 'Status', 'Status_censorship')-> where('status', '=', 2) -> where('censorship_id', '=', 2);  
        }
        else{
            $key = "";
            if($request->input('key')){
                $key = $request->input('key');               
            }    
            $list_product = Product::with('Product_category', 'Status', 'Status_censorship') -> where('name', 'like', '%' . $key . '%');  
        }
        $count_product_stocking = Product::where('status', '=', 1)->where('censorship_id', '=', 1)->count(); 
        $count_product_outofstock = Product::where('status', '=', 2)->where('censorship_id', '=', 1)->count(); 
        $count_product_trash = Product::with('Product_category') -> onlyTrashed()->count();
        $count_product_censorship = Product::where('status', '=', 2)->where('censorship_id', '=', 2)->count(); 
        $count_product_approved = Product::where('censorship_id', '=', 1)->count(); 
        $count_product_not_approved = Product::where('censorship_id', '=', 2)->count(); 


        if (Auth::user()->hasPermission('owner.view')) {
            $user_id = Auth::user()->id;
            $list_product = $list_product->where('user_id', $user_id);
            $count_product_stocking = Product::where('status', '=', 1)->where('censorship_id', '=', 1)->where('user_id', $user_id)->count(); 
            $count_product_outofstock = Product::where('status', '=', 2)->where('censorship_id', '=', 1)->where('user_id', $user_id)->count(); 
            $count_product_trash = Product::with('Product_category')->where('user_id', $user_id) -> onlyTrashed()->count();
            $count_product_censorship = Product::where('status', '=', 2)->where('censorship_id', '=', 2)->where('user_id', $user_id)->count(); 
            $count_product_approved = Product::where('censorship_id', '=', 1)->where('user_id', $user_id)->count(); 
            $count_product_not_approved = Product::where('censorship_id', '=', 2)->where('user_id', $user_id)->count(); 
        }
        $list_product = $list_product->paginate(5);
        
        
        $count = [$count_product_stocking, $count_product_outofstock, $count_product_trash, $count_product_censorship, $count_product_approved, $count_product_not_approved];
       
        return view('admin.product.list', compact('list_product', 'list_act', 'count', 'status'));
    }

    function action(Request $request){
        $list_check = $request-> input('list_check');
        if($list_check){            
            //Thực hiện tác vụ
            if(!empty($list_check)){
                $act = $request->input('act');
                if($act == ''){
                    return redirect('admin/product/list')->with('status', 'Vui lòng chọn hành động');
                }
                if($act == "delete"){
                    Product::destroy($list_check);
                    return redirect('admin/product/list')->with('status', 'Xóa thành công các phần tử đã chọn');
                }
                else if($act == "restore"){
                    Product::withTrashed()->whereIn('id', $list_check) -> restore();
                    return redirect('admin/product/list')->with('status', 'Khôi phục thành công các phần tử đã chọn');
                }
                else if($act == "outofstock"){
                    Product::whereIn('id', $list_check)->update(['status' => '2']);
                    return redirect('admin/product/list')->with('status', 'Thao tác thành công các phần tử đã chọn');
                }else if($act == "stocking"){
                    Product::whereIn('id', $list_check)->update(['status' => '1']);
                    return redirect('admin/product/list')->with('status', 'Thao tác thành công các phần tử đã chọn');
                }
                else if($act == "approved"){
                    Product::whereIn('id', $list_check)->update(['censorship_id' => '1', 'status' => '1']);
                    return redirect('admin/product/list')->with('status', 'Thao tác thành công các phần tử đã chọn');
                }
                else if($act == "not_approved"){
                    Product::whereIn('id', $list_check)->update(['censorship_id' => '2']);
                    return redirect('admin/product/list')->with('status', 'Thao tác thành công các phần tử đã chọn');
                }
                else{
                    Product::withTrashed()->whereIn('id', $list_check) -> forceDelete();
                    return redirect('admin/product/list')->with('status', 'Xóa vĩnh viễn thành công các phần tử đã chọn');
                }
            }            
        }
        else{
            return redirect('admin/product/list')->with('status', 'Vui lòng chọn phần tử để thực hiện thao tác');
        }
    }

   

    function add_product(Request $request){
        $list_product_cat = Product_category::all();
        $list_industry = Industry::all();
       
        return view('admin.product.add_product', compact('list_product_cat', 'list_industry'));
    }

  

    function store(Request $request){
         
        if (!$request->has('material_id')) {
            // Nếu không tồn tại, gán giá trị null vào trường 'material_id' bằng phương thức merge
            $request->merge(['material_id' => null]);
        }
        if (!$request->has('pattern_id')) {
            // Nếu không tồn tại, gán giá trị null vào trường 'material_id' bằng phương thức merge
            $request->merge(['pattern_id' => null]);
        }
        $request -> validate(
            [
                'name' => 'required',
                // 'price' => 'required',
                'content' => 'required',
                'description' => 'required',
                'industry' => 'required',
                'segment' => 'required',
                'product_cat' => 'required',
                'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:21000000',
                'brand_id' => 'required',
                // 'material_id' => 'required',
                // 'pattern_id' => 'required',
                'colors.*' => 'required|string',
                'sizes.*' => 'required|string',
                'quantities.*' => 'required|integer|min:1',
            ],
            [
                'required' => ':attribute không được để trống',
                'mimes' => 'Chỉ chấp nhận ảnh có đuôi jpeg, png, jpg, gif',
                'max' => 'Chỉ chấp nhận ảnh dưới 20mb',
            ],
            [
                'name' => 'Tên sản phẩm',
                // 'price' => 'Giá',
                'content' => 'Mô tả ngắn',
                'description' => 'Chi tiết sản phẩm',
                'file' => 'Ảnh sản phẩm',
                'industry' => 'Ngành hàng',
                'segment' => 'Phân khúc sản phẩm',
                'product_cat' => 'Loại sản phẩm',
                'brand_id' => 'Thương hiệu',
                'material_id' => 'Chất liệu',
                'pattern_id' => 'Mẫu',
            ]
        );
        // dd($request->input('quantities'));
        $input = $request -> all();   
        $prices = $request->input('prices');
        $minPrice = min($prices);     

        //Kiểm tra ảnh
        if($request-> hasFile('file')){
            $file = $request->file;
            //Lấy tên file
            $filename = $file -> getClientOriginalName();
            // $file -> move('public/images', $file -> getClientOriginalName());           
            $file -> move('public/img/products', $file -> getClientOriginalName());           

            $thumbnail = 'img/products/'.$filename;
            $input['thumbnail'] = $thumbnail;
        }
        $input['user_id'] = Auth::id();     
        $input['price'] = $minPrice;
        $input['status'] = 2;
        $input['censorship_id'] = 2;
        $input['product_cat_id'] = $request->product_cat;
        $product = Product::create($input);
       
        //Lưu thông chung
        General_info::create(
            [
                'product_id' => $product->id,
                'brand_id' => $request->brand_id,
                'material_id' => $request->material_id,
                'pattern_id' => $request->pattern_id,
            ]
        );
        
        // Lưu các giá trị vào bảng "attribute_product"
        $product->values()->attach($request->input('attribute_values'));
        
        //Lưu các giá trị của thông tin bán hàng
        $colors = $request->input('colors');
        $sizes = $request->input('sizes');
        
        $quantities = $request->input('quantities');
        $images = $request->file('images_detail');
        foreach ($colors as $index => $color) {
            $size = $sizes[$index];
            $quantity = $quantities[$index];
            $price = $prices[$index];
            //Lưu ảnh riêng của từng loại
            
            $image = $images[$index];
            $imageName = $image->getClientOriginalName();
            $image -> move('public/img/products', $image -> getClientOriginalName());
            $img_detail = 'img/products/'.$imageName;

            $colorModel = Color::firstOrCreate(['name' => $color]);
            $sizeModel = Size::firstOrCreate(['name' => $size]);

            Inventory::create([
                'product_id' => $product->id,
                'color_id' => $colorModel->id,
                'size_id' => $sizeModel->id,
                'price' => $price,
                'quantity' => $quantity,
                'image' => $img_detail,
            ]);

        }

        return redirect('admin/product/list')->with('status', 'Thêm sản phẩm thành công');
    }
    function delete($id){
        if($id != null){
            $product = Product::find($id);
            $product->forceDelete();
            return redirect('admin/product/list')->with('status', 'Xóa thành công');
        }
        return redirect('admin/product/list')->with('status', 'Xóa không thành công');
        
    }

    function edit_product($id){
        $product = Product::with('Product_category')->find($id);
        $list_industry = Industry::all();
        $list_segment = Segment::where('industry_id', $product->Product_category->segment->industry->id) -> get();
        $list_product_cat = Product_category::where('segment_id', $product->Product_category->segment->id) -> get();
        $list_brand = Brand::all();
        $list_material = Material::all();
        $list_pattern = Pattern::all();
        return view('admin.product.edit_product', compact(['product', 'list_product_cat', 'list_industry', 'list_segment', 'list_brand', 'list_material', 'list_pattern']));
    }
   
    function update_product($id, Request $request){
        
        if (!$request->has('material_id')) {
            // Nếu không tồn tại, gán giá trị null vào trường 'material_id' bằng phương thức merge
            $request->merge(['material_id' => null]);
        }
        if (!$request->has('pattern_id')) {
            // Nếu không tồn tại, gán giá trị null vào trường 'material_id' bằng phương thức merge
            $request->merge(['pattern_id' => null]);
        }
        $request -> validate(
            [
                'name' => 'required',
                'price' => 'required',
                'content' => 'required',
                'description' => 'required',
                'industry' => 'required',
                'segment' => 'required',
                'product_cat' => 'required',
                'file' => 'image|mimes:jpeg,png,jpg,gif|max:21000000',
                'brand_id' => 'required',
                // 'material_id' => 'required',
                // 'pattern_id' => 'required',
            ],
            [
                'required' => ':attribute không được để trống',
                'mimes' => 'Chỉ chấp nhận ảnh có đuôi jpeg, png, ipg, gif',
                'max' => 'Chỉ chấp nhận ảnh dưới 20mb',
            ],
            [
                'name' => 'Tên sản phẩm',
                'price' => 'Giá',
                'content' => 'Mô tả ngắn',
                'description' => 'Chi tiết sản phẩm',
                'file' => 'Ảnh sản phẩm',
                'industry' => 'Ngành hàng',
                'segment' => 'Phân khúc sản phẩm',
                'product_cat' => 'Loại sản phẩm',
                'brand_id' => 'Thương hiệu',
                'material_id' => 'Chất liệu',
                'pattern_id' => 'Mẫu',
            ]
        );
       
        //Kiểm tra ảnh
        if($request-> hasFile('file')){
            $file = $request->file;
            //Lấy tên file
            $filename = $file -> getClientOriginalName();
            $file -> move('public/images', $file -> getClientOriginalName());           

            $thumbnail = 'images/'.$filename;
        }else{
            $thumbnail = Product::find($id)->thumbnail;
        }
        Product::where(['id' => $id]) -> update([
            'name' => $request->name,
            'content' => $request->content,
            'description' => $request->description,
            'price' => $request->price,
            'thumbnail' => $thumbnail,
            'product_cat_id' => $request->product_cat,
        ]);

        $product = Product::find($id);

        General_info::where('product_id', $product->id) -> update(
            [
                'product_id' => $product->id,
                'brand_id' => $request->brand_id,
                'material_id' => $request->material_id,
                'pattern_id' => $request->pattern_id,
            ]
        );

        if($request->attribute_values){
            $product->values()->sync($request->input('attribute_values', []));
        }
        return redirect('admin/product/list?status=approved')->with('status', 'Cập nhật thành công');
    }


    //===============================Loại sản phẩm================================================================
    function list_cat(Request $request){
        $list_product_cat = Product_category::all();
        $list_segment = Segment::all();
        return view('admin.product.list_cat', compact('list_product_cat', 'list_segment'));
    }
    function add_cat(Request $request){
        $request->validate(
            [
                'name' => 'required',
                'segment_id' => 'required',
            ],
            [
                'required' => ':attribute không được để trống',
            ],
            [
                'name' => 'Tên danh mục',
                'segment_id' => 'Phân khúc của loại sản phẩm',
            ],
        );
        Product_category::create([
            'cat_name' => $request->name,
            'segment_id' => $request->segment_id,
            'slug' => Str::slug($request->name, '-'),
        ]);

        return redirect('admin/product/cat/list')->with('status', 'Thêm danh mục sản phẩm thành công');
    }

    function edit_cat($id){
        $list_product_cat = Product_category::all();
        $list_segment = Segment::all();
        $product_cat = Product_category::find($id);
        return view('admin.product.edit_cat', compact('list_product_cat', 'product_cat', 'list_segment'));
    }

    function update_cat($id, Request $request){
        $request->validate(
            [
                'name' => 'required',
            ],
            [
                'required' => ':attribute không được để trống',
            ],
            [
                'name' => 'Tên danh mục'
            ],
        );
        Product_category::where('id', $id)->update([
            'cat_name' => $request->name,
            'segment_id' => $request->segment_id,
            'slug' => Str::slug($request->name, '-'),
        ]);

        return redirect('admin/product/cat/list')->with('status', 'Chỉnh sửa danh mục sản phẩm thành công');
    }
    function delete_cat($id){
        Product_category::find($id)->delete();
        return redirect('admin/product/cat/list')->with('status', 'Xóa danh mục sản phẩm thành công');
    }

    //===============================Ngành sản phẩm================================================================
    function list_industry(Request $request){
        $list_industry = Industry::all();
        if($request->industry){
            $industry_id = $request->industry;
            return view('admin.product.industry_list', compact('list_industry', 'industry_id'));
        }
        return view('admin.product.industry_list', compact('list_industry'));
    }
    function add_industry(Request $request){
        $request->validate(
            [
                'name' => 'required',
            ],
            [
                'required' => ':attribute không được để trống',
            ],
            [
                'name' => 'Tên ngành hàng'
            ],
        );
        Industry::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-'),
        ]);

        return redirect('admin/product/industry/list')->with('status', 'Thêm ngành sản phẩm mới thành công');
    }

    function edit_industry($id){
        $list_industry = Industry::all();
        $industry = Industry::find($id);

        return view('admin.product.edit_industry', compact('industry', 'list_industry'));
    }

    function update_industry($id, Request $request){
        $request->validate(
            [
                'name' => 'required',
            ],
            [
                'required' => ':attribute không được để trống',
            ],
            [
                'name' => 'Tên ngành hàng'
            ],
        );
        Industry::where('id', $id)->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-'),
        ]);

        return redirect('admin/product/industry/list')->with('status', 'Cập nhật ngành sản phẩm thành công');
    }

    function delete_industry($id){
        Industry::find($id)->delete();
        return redirect('admin/product/industry/list')->with('status', 'Xóa ngành sản phẩm thành công');
    }

    //===============================Phân khúc sản phẩm================================================================
    function list_segment(){
        $list_segment = Segment::all();
        $list_industry = Industry::all();
        return view('admin.product.segment_list', compact('list_segment', 'list_industry'));
    }
    function add_segment(Request $request){
        $request->validate(
            [
                'name' => 'required',
                'industry_id' => 'required',
            ],
            [
                'required' => ':attribute không được để trống',
            ],
            [
                'name' => 'Tên phân khúc',
                'industry_id' => 'Ngành hàng'
            ],
        );
        Segment::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-'),
            'industry_id' => $request->industry_id, 
        ]);

        return redirect('admin/product/segment/list')->with('status', 'Thêm phân khúc sản phẩm mới thành công');
    }

    function edit_segment($id){
        $list_industry = Industry::all();
        $list_segment = Segment::all();
        $segment = Segment::find($id);

        return view('admin.product.edit_segment', compact('segment', 'list_industry', 'list_segment'));
    }

    function update_segment($id, Request $request){
        $request->validate(
            [
                'name' => 'required',
                'industry_id' => 'required',
            ],
            [
                'required' => ':attribute không được để trống',
            ],
            [
                'name' => 'Tên phân khúc',
                'industry_id' => 'Ngành hàng'
            ],
        );
        Segment::where('id', $id)->update([
            'name' => $request->name,
            'industry_id' => $request->industry_id,
            'slug' => Str::slug($request->name, '-'),
        ]);

        return redirect('admin/product/segment/list')->with('status', 'Cập nhật phân khúc sản phẩm thành công');
    }

    function delete_segment($id){
        Segment::find($id)->delete();
        return redirect('admin/product/segment/list')->with('status', 'Xóa phân khúc sản phẩm thành công');
    }


    //================================Load các phần tương ứng khi thêm sản phẩm============================================
    public function getSegments($id){
        $segments = Segment::where('industry_id', $id)->get();

        return response()->json($segments);
    }

    public function getProductCats($id)
    {
        $productCats = Product_category::where('segment_id', $id)->get();

        return response()->json($productCats);
    }

    //===================================Quản lý các thông tin chung================================================================================

    //Material
    function list_material(){
        $list_material = Material::all();
        $list_industry = Industry::all();
        $module_active_child = 'general_info';
        return view('admin.product.general_info.list_material', compact('list_material', 'module_active_child', 'list_industry'));
    }
    function add_material(Request $request){
        $request->validate(
            [
                'name' => 'required',
                'industry_id' => 'required',
            ],
            [
                'required' => ':attribute không được để trống',
            ],
            [
                'name' => 'Tên chất liệu',
                'industry_id' => 'Ngành hàng'
            ],
        );
        $list_id_fashion = ['8', '9'];
        $list_electronic_device = ['10'];
        if(in_array($request->industry_id, $list_id_fashion)){
            $industry_id = 8;
        }
        else if(in_array($request->industry_id, $list_electronic_device)){
            $industry_id = 10;
        }
        else{
            $industry_id = $request->industry_id;
        }
        Material::create([
            'name' => $request->name,
            'industry_id' => $industry_id,
        ]);

        return redirect('admin/product/material/list')->with('status', 'Thêm mới thành công');
    }

    function edit_material($id){
        $list_material = Material::all();
        $material = Material::find($id);
        $list_industry = Industry::all();
        return view('admin.product.general_info.edit_material', compact('material', 'list_material', 'list_industry'));
    }

    function update_material($id, Request $request){
        $request->validate(
            [
                'name' => 'required',
                'industry_id' => 'required',
            ],
            [
                'required' => ':attribute không được để trống',
            ],
            [
                'name' => 'Tên chất liệu',
                'industry_id' => 'Ngành hàng'
            ],
        );
        Material::where('id', $id)->update([
            'name' => $request->name,
        ]);

        return redirect('admin/product/material/list')->with('status', 'Cập nhật thông tin thành công');
    }

    function delete_material($id){
        Material::find($id)->delete();
        return redirect('admin/product/material/list')->with('status', 'Xóa thành công');
    }

    //Brand
    function list_brand(){
        $list_brand = Brand::all();
        $list_industry = Industry::all();
        $module_active_child = 'general_info';
        return view('admin.product.general_info.list_brand', compact('list_brand', 'list_industry', 'module_active_child'));
    }
    function add_brand(Request $request){
        $request->validate(
            [
                'name' => 'required',
                'industry_id' => 'required',
            ],
            [
                'required' => ':attribute không được để trống',
            ],
            [
                'name' => 'Tên thương hiệu',
                'industry_id' => 'Ngành hàng'
            ],
        );
        $list_id_fashion = ['8', '9'];
        $list_electronic_device = ['10'];
        if(in_array($request->industry_id, $list_id_fashion)){
            $industry_id = 8;
        }
        else if(in_array($request->industry_id, $list_electronic_device)){
            $industry_id = 10;
        }
        else{
            $industry_id = $request->industry_id;
        }
        Brand::create([
            'name' => $request->name,
            'industry_id' => $industry_id,
        ]);

        return redirect('admin/product/brand/list')->with('status', 'Thêm mới thành công');
    }

    function edit_brand($id){
        $list_brand = Brand::all();
        $brand = Brand::find($id);
        $list_industry = Industry::all();
        return view('admin.product.general_info.edit_brand', compact('brand', 'list_brand', 'list_industry'));
    }

    function update_brand($id, Request $request){
        $request->validate(
            [
                'name' => 'required',
                'industry_id' => 'required',
            ],
            [
                'required' => ':attribute không được để trống',
            ],
            [
                'name' => 'Tên thương hiệu',
                'industry_id' => 'Ngành hàng'
            ],
        );
        $list_id_fashion = ['8', '9'];
        $list_electronic_device = ['10'];
        if(in_array($request->industry_id, $list_id_fashion)){
            $industry_id = 8;
        }
        if(in_array($request->industry_id, $list_electronic_device)){
            $industry_id = 10;
        }
        Brand::where('id', $id)->update([
            'name' => $request->name,
            'industry_id' => $industry_id,
        ]);

        return redirect('admin/product/brand/list')->with('status', 'Cập nhật thông tin thành công');
    }

    function delete_brand($id){
        Brand::find($id)->delete();
        return redirect('admin/product/brand/list')->with('status', 'Xóa thành công');
    }

    //Pattern
    function list_pattern(){
        $list_pattern = Pattern::all();
        $list_industry = Industry::all();
        $module_active_child = 'general_info';
        return view('admin.product.general_info.list_pattern', compact('list_pattern', 'module_active_child', 'list_industry'));
    }
    function add_pattern(Request $request){
        $request->validate(
            [
                'name' => 'required',
                'industry_id' => 'required',
            ],
            [
                'required' => ':attribute không được để trống',
            ],
            [
                'name' => 'Tên mẫu',
                'industry_id' => 'Ngành hàng'
            ],
        );
        $list_id_fashion = ['8', '9'];
        $list_electronic_device = ['10'];
        if(in_array($request->industry_id, $list_id_fashion)){
            $industry_id = 8;
        }
        else if(in_array($request->industry_id, $list_electronic_device)){
            $industry_id = 10;
        }
        else{
            $industry_id = $request->industry_id;
        }
        Pattern::create([
            'name' => $request->name,
            'industry_id' => $industry_id,
        ]);

        return redirect('admin/product/pattern/list')->with('status', 'Thêm mới thành công');
    }

    function edit_pattern($id){
        $list_pattern = Pattern::all();
        $pattern = Pattern::find($id);
        $list_industry = Industry::all();
        return view('admin.product.general_info.edit_pattern', compact('pattern', 'list_pattern', 'list_industry'));
    }

    function update_pattern($id, Request $request){
        $request->validate(
            [
                'name' => 'required',
                'industry_id' => 'required',
            ],
            [
                'required' => ':attribute không được để trống',
            ],
            [
                'name' => 'Tên mẫu',
                'industry_id' => 'Ngành hàng'
            ],
        );
        Pattern::where('id', $id)->update([
            'name' => $request->name,
        ]);

        return redirect('admin/product/pattern/list')->with('status', 'Cập nhật thông tin thành công');
    }

    function delete_pattern($id){
        Pattern::find($id)->delete();
        return redirect('admin/product/pattern/list')->with('status', 'Xóa thành công');
    }

    //Xuất excel products
    public function export()
    {
        return Excel::download(new ProductExport(), 'products'.'.xlsx');
    }
}
