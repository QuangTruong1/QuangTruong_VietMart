<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable= ['title', 'content', 'post_cat_id', 'censorship_id', 'thumbnail', 'slug'];

    function post_cat(){
        return $this->belongsTo('App\Models\Post_cat', 'post_cat_id');
    }
    function censorship(){
        return $this->belongsTo('App\Models\Status_censorship', 'censorship_id');
    }
}
