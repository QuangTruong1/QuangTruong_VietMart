<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_category extends Model
{
    use HasFactory;
    public $table = "product_category";
    protected $fillable = ['cat_name', 'parent_id', 'slug', 'segment_id'];

    function Product(){
        return $this -> hasMany('App\Models\Product');
    }

    public function segment(){
        return $this->belongsTo(Segment::class, 'segment_id');
    }
}
