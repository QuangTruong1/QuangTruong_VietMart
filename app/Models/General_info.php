<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class General_info extends Model
{
    use HasFactory;
    public $table="general_info";
    protected $fillable = ['product_id', 'brand_id', 'material_id', 'pattern_id'];

    public function brand(){
        return $this->belongsTo(Brand::class, 'brand_id');
    }
    public function material(){
        return $this->belongsTo(Material::class, 'material_id');
    }
    public function pattern(){
        return $this->belongsTo(Pattern::class, 'pattern_id');
    }
}
