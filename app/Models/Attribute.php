<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;
    public $table = 'attributes';

    protected $fillable = ['name', 'product_cat_id'];

    public function attribute_value(){
        return $this->hasMany(Attribute::class, 'id');
    }
    public function product_cat(){
        return $this->belongsTo(Product_category::class, 'product_cat_id');
    }
}
