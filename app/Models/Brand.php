<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    public $table="brands";
    protected $fillable = ['name', 'industry_id'];
    
    public function general_info(){
        return $this->hasMany(General_info::class);
    }

    public function industry(){
        return $this->belongsTo(Industry::class, 'industry_id');
    }
  
}
