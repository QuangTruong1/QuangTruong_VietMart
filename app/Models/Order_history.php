<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_history extends Model
{
    use HasFactory;
    public $table = 'order_history';

    protected $fillable = ['user_id', 'product_id', 'quantity', 'total', 'status_id'];

    function user(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    function product(){
        return $this->belongsTo('App\Models\Product', 'product_id');
    }

    function status(){
        return $this->belongsTo('App\Models\Status_order', 'status_id');
    }
}
