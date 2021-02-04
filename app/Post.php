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
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
