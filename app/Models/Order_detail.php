<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order_detail extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $table='order_detail';
    protected $fillable = ['order_id', 'user_id', 'product_id','type', 'color', 'quantity', 'price', 'total', 'status_id', 'owner_id'];


    function order(){
        return $this->belongsTo('App\Models\Order', 'order_id');
    }
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
