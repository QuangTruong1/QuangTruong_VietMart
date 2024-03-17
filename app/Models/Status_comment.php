<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status_comment extends Model
{
    use HasFactory;
    public $table = 'status_comment';
    protected $fillable = ['name'];

    function comment(){
        return $this -> hasMany(Comment::class);
    }
}
