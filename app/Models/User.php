<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;

    public function vouchers()
    {
        return $this->belongsToMany(VoucherVietMart::class, 'custom_voucher_pivot', 'user_id', 'voucher_id');
    }
    public function wishLists()
    {
        return $this->hasMany(WishList::class);
    }
    public function roles(){
        return $this->belongsToMany(Role::class, 'user_role');
    }
    public function hasPermission($permission){
        foreach ($this->roles as $role){
            if($role->permissions->where('slug', $permission)->count() > 0){
                return true;
            }
        }
        return false;
    }
    function Posts(){
        return $this -> hasMany('App\Models\Post');
    }

    function Order(){
        return $this -> hasMany('App\Models\Order');
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
