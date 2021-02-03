<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model {
    /**
    * Table database
    */
    protected $table = 'posts';

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'user_id','title','body',
    ];

    /**
    * One to one relationships
    */
    // 1 profile dimiliki oleh 1 user
    // public function user()
    // {
    //     return $this->belongsTo('App\User');
    // }
}
