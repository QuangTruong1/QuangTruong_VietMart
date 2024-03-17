<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $table='orders';

    protected $fillable = ['code', 'user_id', 'price'];

    function user(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }

   
}
