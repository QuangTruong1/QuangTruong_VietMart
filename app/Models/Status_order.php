<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status_order extends Model
{
    use HasFactory;
    public $table = 'status_order';
    protected $fillable = ['name'];

    function order(){
        return $this -> hasMany('App\Models\Order');
    }
}
