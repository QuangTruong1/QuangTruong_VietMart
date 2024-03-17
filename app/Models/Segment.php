<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Segment extends Model
{
    use HasFactory;
    public $table = 'segments';

    protected $fillable = ['name', 'slug', 'industry_id'];

    public function industry(){
        return $this->belongsTo(Industry::class, 'industry_id');
    }

    public function product_cat(){
        return $this->hasMany(Product_category::class);
    }

}
