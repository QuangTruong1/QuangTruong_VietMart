<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    public $table = 'ratings';
    
    protected $fillable = ['rating_value', 'user_id', 'product_id'];

    function user(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    function product(){
        return $this->belongsTo('App\Models\Product', 'product_id');
    }
    public function comment()
    {
        return $this->hasOne(Comment::class, 'rating_id');
    }
}
