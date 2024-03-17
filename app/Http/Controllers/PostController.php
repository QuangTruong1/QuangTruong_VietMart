<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //
    function show(){
        $list_post = Post::where('censorship_id', '=', 1)->paginate(4);
        return view('post.show', compact('list_post'));
    }

    function detail($id) {
        $post = Post::find($id);

        return view('post.detail', compact('post'));
    }
}
