<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status_censorship extends Model
{
    use HasFactory;

    public $table = "status_censorship";
    protected $fillable = ['censorship_name'];

    function Product(){
        return $this -> hasMany('App\Models\Product');
    }

}
