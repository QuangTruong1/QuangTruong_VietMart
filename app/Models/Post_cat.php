<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post_cat extends Model
{
    use HasFactory;
    public $table = 'post_cat';
    protected $fillable = ['name', 'parent_id', 'slug'];

    function post(){
        return $this->hasMany('App\Models\Post');
    }
}
