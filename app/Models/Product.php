<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['name', 'content', 'description', 'price', 'thumbnail', 'status', 'censorship_id' , 'product_cat_id', 'user_id'];

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function general_info(){
        return $this->hasOne(General_info::class, 'product_id');
    }
    public function values(){
        return $this -> belongsToMany(Attribute_value::class, 'product_value');
    }
    public function wishLists()
    {
        return $this->hasMany(WishList::class);
    }
    function Status(){
        return $this -> belongsTo('App\Models\Status', 'status');
    }
    function Status_censorship(){
        return $this -> belongsTo('App\Models\Status_censorship', 'censorship_id');
    }

    function Product_category(){
        return $this -> belongsTo('App\Models\Product_category', 'product_cat_id');
    }       

    function User(){
        return $this -> belongsTo('App\Models\User');
    }

    function order(){
        return $this -> hasMany('App\Models\Order');
    }
}
