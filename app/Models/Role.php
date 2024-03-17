<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description'];

    //Tạo liên kết n-n giữa role và permission thông qua bảng role_permission
    public function permissions(){
        return $this->belongsToMany(Permission::class, 'role_permission');
    }
}
