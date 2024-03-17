<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute_value extends Model
{
    use HasFactory;
    public $table = 'attribute_value';

    protected $fillable = ['value', 'attribute_id'];

    public function attribute(){
        return $this -> belongsTo(Attribute::class, 'attribute_id');
    }
}
