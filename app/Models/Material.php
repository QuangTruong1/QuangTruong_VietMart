<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;
    public $table="materials";
    protected $fillable = ['name', 'industry_id'];
    public function general_info(){
        return $this->belongsTo(General_info::class);
    }
    public function industry(){
        return $this->belongsTo(Industry::class, 'industry_id');
    }
}
