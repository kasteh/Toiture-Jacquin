<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    protected $with = ['contents'];

    public function contents(){
        return $this->hasMany(Content::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
