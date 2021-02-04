<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements
    AuthenticatableContract,
    AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     * 
     * $fillable berfungsi utk memberikan izin kolom mana saja dari database
     *  user ini yang bisa kita pakai.
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'api_token'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * $hidden berfungsi agar kolom tidak ditampilkan ketika kita melakukan
     * query utk mendapatkan semua data dari kolom yg ada di table users.
     * 
     * @var array
     */
    protected $hidden = [
        'password', 'api_token'
    ];

    /**
    * One to one relationships
    */
    // 1 user hanya memiliki 1 profile, nama fungsi singular
    public function profile()
    {
        return $this->hasOne('App\Profile');
    }

    /**
    * One to many relationships
    */
    // 1 user bisa memiliki banyak post, nama fungsi plural
    public function posts()
    {
        return $this->hasMany('App\Post');
        // return $this->hasMany('App\Post', 'user_id', 'id');
    }
}
