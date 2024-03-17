<?php

namespace App\Http\Controllers;

use App\Models\Industry;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class CategoryController extends Controller
{
    //
    function list($industry, Request $request){
        $industry_id = $industry;
        $list_product = Industry::findOrFail($industry_id)
                        ->segment()
                        ->join('product_category', 'segments.id', '=', 'product_category.segment_id')
                        ->join('products', 'product_category.id', '=', 'products.product_cat_id')
                        ->where('products.censorship_id', 1)
                        ->select('products.*');
        if($request->query('segment')){
            $segment_id = $request->query('segment');
            $list_product = Industry::findOrFail($industry_id)
                            ->segment()
                            ->join('product_category', 'segments.id', '=', 'product_category.segment_id')
                            ->join('products', 'product_category.id', '=', 'products.product_cat_id')
                            ->where('products.censorship_id', 1)
                            ->where('segments.id', $segment_id)
                            ->select('products.*');
        }
        if($request->query('orderby')){
            $orderby = $request->query('orderby');
            switch($orderby){
                case 'name_asc':
                    $list_product = $list_product->orderby('name', 'asc');
                    break;
                case 'name_desc':
                    $list_product = $list_product->orderby('name', 'desc');
                    break;
                case 'price_max':
                    $list_product = $list_product->orderby('price', 'asc');
                    break;
                case 'price_min':
                    $list_product = $list_product->orderby('price', 'desc');
                    break;
                default:
                    $list_product = $list_product->orderby('name', 'asc');
            }
        }
        
        if($request->query('min_price') != null && $request->query('max_price') != null){
            $min_price = $request->query('min_price');
            $max_price = $request->query('max_price');
            $list_product = $list_product -> whereBetween('price', [$min_price, $max_price]);
        }
        $list_product = $list_product->paginate(6);
        if ($request->ajax()) {
            // Trả về JSON cho các yêu cầu Ajax
            return response()->json(View::make('shop.product_list', compact('list_product'))->render());
        }
        return view('shop.list', compact('industry_id', 'list_product'));
    }

    function search(Request $request){
        $keyword = $request->query('keyword');
        $list_product = Product::where('censorship_id', 1)->where('name', 'like', '%'. $keyword. '%');
        if($request->query('order_by')){
            $orderby = $request->query('order_by');
            switch($orderby){
                case 'name_asc':
                    $list_product = $list_product->orderby('name', 'asc');
                    break;
                case 'name_desc':
                    $list_product = $list_product->orderby('name', 'desc');
                    break;
                case 'price_max':
                    $list_product = $list_product->orderby('price', 'asc');
                    break;
                case 'price_min':
                    $list_product = $list_product->orderby('price', 'desc');
                    break;
                default:
                    $list_product = $list_product->orderby('name', 'asc');
            }
        }
        if($request->query('min_price') != null && $request->query('max_price') != null){
            $min_price = $request->query('min_price');
            $max_price = $request->query('max_price');
            $list_product = $list_product -> whereBetween('price', [$min_price, $max_price]);
        }
        $list_product = $list_product->paginate(6);
        if ($request->ajax()) {
            return response()->json(View::make('shop.product_list', compact('list_product'))->render());
        }
        return view('shop.search', compact('list_product'));
    }

    function search_sug(Request $request){

        $query = $request->input('query');

        $results = Product::where('censorship_id', 1)->where('name', 'LIKE', '%' . $query . '%')->get();

        return response()->json($results);

    }
}
