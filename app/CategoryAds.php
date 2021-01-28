<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryAds extends Model {
    /**
    * Table database
    */
    protected $table = 'category_ads';

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'name',
    ];
    
}
