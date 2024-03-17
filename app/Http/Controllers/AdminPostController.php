<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Post_cat;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminPostController extends Controller
{
    //
    function __construct(){
        $this->middleware(function($request, $next){
            session(['module_active' => 'post']);
            return $next($request);
        });  
    }
    function list(Request $request){

        $status = $request->input('status');
        $list_act = [
            'delete'=> "Xóa",
        ];
        
        if($status == 'approved'){
            $list_act = [
                'delete'=> "Xóa",
                'not_approved' => 'Hủy duyệt'
            ];
            $list_post = Post::with('post_cat', 'censorship')->where('censorship_id', '=', 1)->paginate(5);  
        }  
        else if($status == 'not_approved'){
            $list_act = [
                'delete'=> "Xóa",
                'approved' => 'Duyệt'
            ];
            $list_post = Post::with('post_cat', 'censorship')->where('censorship_id', '=', 2)->paginate(5);  
        }
        else if($status == 'trash'){
            $list_act = [
                'restore' => "Khôi phục bài viết",
                'force' => 'Xóa vĩnh viễn',
            ];
            $list_post = Post::with('post_cat', 'censorship') -> onlyTrashed()->paginate(5); 
        }
        else{
            $key = "";
            if($request->input('key')){
                $key = $request->input('key');               
            }    
            $list_post = Post::with('post_cat', 'censorship') -> where('title', 'like', '%' . $key . '%')->paginate(5);  
        }
        $count_product_approved = Post::where('censorship_id', '=', 1)->count(); 
        $count_product_not_approved = Post::where('censorship_id', '=', 2)->count(); 
        $count_product_trash = Post::with('post_cat') -> onlyTrashed()->count();
        $count = [$count_product_approved, $count_product_not_approved, $count_product_trash];

        return view('admin.post.list', compact('list_post', 'count', 'list_act'));
    }

    function action(Request $request){
        $list_check = $request-> input('list_check');
        if($list_check){            
            //Thực hiện tác vụ
            if(!empty($list_check)){
                $act = $request->input('act');
                if($act == ''){
                    return redirect('admin/post/list')->with('status', 'Vui lòng chọn hành động');
                }
                if($act == "delete"){
                    Post::destroy($list_check);
                    return redirect('admin/post/list')->with('status', 'Xóa thành công các phần tử đã chọn');
                }
                else if($act == "approved"){
                    Post::whereIn('id', $list_check)->update(['censorship_id' => 1]);
                    return redirect('admin/post/list')->with('status', 'Duyệt thành công các phần tử đã chọn');
                }
                else if($act == "not_approved"){
                    Post::whereIn('id', $list_check)->update(['censorship_id' => 2]);
                    return redirect('admin/post/list')->with('status', 'Hủy duyệt thành công các phần tử đã chọn');
                }
                else if($act == "restore"){
                    Post::withTrashed()->whereIn('id', $list_check) -> restore();
                    return redirect('admin/post/list')->with('status', 'Khôi phục thành công các phần tử đã chọn');
                }
                else{
                    Post::withTrashed()->whereIn('id', $list_check) -> forceDelete();
                    return redirect('admin/post/list')->with('status', 'Xóa vĩnh viễn thành công các phần tử đã chọn');
                }
            }            
        }
        else{
            return redirect('admin/post/list')->with('status', 'Vui lòng chọn phần tử để thực hiện thao tác');
        }
    }


    function add(){
        $list_post_cat = Post_cat::all();
        // $list_censorship = Status_censorship::all();
        return view('admin.post.add', compact('list_post_cat'));
       
    }

    function store(Request $request){
        $request -> validate(
            [
                'title' => 'required',
                'content' => 'required',
                'post_cat' => 'required',
                'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:21000000',
            ],
            [
                'required' => ':attribute không được để trống',
            ],
            [
                'title' => 'Tiêu đề',
                'content' => 'Nội dung bài viết',
                'post_cat' => 'Danh mục bài viết',
                'file' => 'Ảnh chính bài viết',
            
            ],
        );
        $input = $request->all();
        //Kiểm tra ảnh
        if($request-> hasFile('file')){
            $file = $request->file;
            //Lấy tên file
            $filename = $file -> getClientOriginalName();

            // $file -> move('public/images', $file -> getClientOriginalName());           
            $file -> move('public/img/blog', $file -> getClientOriginalName());           

            $thumbnail = 'img/blog/'.$filename;
            $input['thumbnail'] = $thumbnail;
        }
        $input['slug'] = Str::slug($request->title);
        $input['censorship_id'] = 2;
        $input['post_cat_id'] = $request->post_cat;
        Post::create($input);

        return redirect('admin/post/list')->with('status', 'Thêm bài viết thành công');
    }
    function delete($id){
        if($id != null){
            $post = Post::find($id);
            $post->forceDelete();
            return redirect('admin/post/list')->with('status', 'Xóa thành công');
        }
        return redirect('admin/post/list')->with('status', 'Xóa không thành công');
        
    }

    function edit_post($id){
        $post = Post::find($id);
        $list_post_cat = Post_cat::all();
        return view('admin/post/edit', compact('post', 'list_post_cat'));
    }

    function update_post(Request $request, $id){
        $request -> validate(
            [
                'title' => 'required',
                'content' => 'required',
                'post_cat' => 'required',
                'file' => 'image|mimes:jpeg,png,jpg,gif|max:21000000',
            ],
            [
                'required' => ':attribute không được để trống',
            ],
            [
                'title' => 'Tiêu đề',
                'content' => 'Nội dung bài viết',
                'post_cat' => 'Danh mục bài viết',
                'file' => 'Ảnh chính bài viết',
            
            ],
        );
        //Kiểm tra ảnh
        if($request-> hasFile('file')){
            $file = $request->file;
            //Lấy tên file
            $filename = $file -> getClientOriginalName();
            $file -> move('public/images', $file -> getClientOriginalName());           

            $thumbnail = 'images/'.$filename;
        }else{
            $thumbnail = Post::find($id)->thumbnail;
        }

        Post::where('id', $id)->update(
            [
                'title' => $request->title,
                'content' => $request->content,
                'thumbnail' => $thumbnail,
                'post_cat_id' => $request->post_cat,
            ]
        );
        return redirect('admin/post/list')->with('status', 'Cập nhật bài viết thành công');
    }

    //========================Danh mục bài viết========================================================================================
    function list_cat(){
        $list_post_cat = Post_cat::all();
        return view('admin/post/list_cat', compact('list_post_cat'));
    }
    function add_cat(Request $request){
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
        $slug = '';
        if($request->parent_id == ""){
            $parent_id = 0;
            $slug = Str::slug($request->name, '-');
        }else{
            $find = Post_cat::find($request->parent_id);
            $parent_id = $request->parent_id;
            $slug = $find->slug . '/'. Str::slug($request->name, '-');
        }
        Post_cat::create([
            'name' => $request->name,
            'parent_id' => $parent_id,
            'slug' => $slug,
        ]);

        return redirect('admin/post/cat/list')->with('status', 'Thêm danh mục bài viết thành công');
    }

    function edit_cat($id){
        $list_post_cat = Post_cat::all();
        $post_cat = Post_cat::find($id);
        return view('admin/post/edit_cat', compact('list_post_cat', 'post_cat'));
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
        $slug = '';
        if($request->parent_id == ""){
            $parent_id = 0;
            $slug = Str::slug($request->name, '-');
        }else{
            $find = Post_cat::find($request->parent_id);
            $parent_id = $request->parent_id;
            $slug = $find->slug . '/'. Str::slug($request->name, '-');
        }
        Post_cat::where('id', $id) -> update([
            'name' => $request->name,
            'parent_id' => $parent_id,
            'slug' => $slug,
        ]);

        return redirect('admin/post/cat/list')->with('status', 'Chỉnh sửa danh mục bài viết thành công');
    }

    function delete_cat($id){
        Post_cat::where('id', $id)->delete();
        return redirect('admin/post/cat/list')->with('status', 'Xóa danh mục bài viết thành công');
    }

}
