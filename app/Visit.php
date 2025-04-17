<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $guarded = [];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function departement(){
        return $this->belongsTo(Departement::class);
    }

    public function city(){
        return $this->belongsTo(City::class);
    }
}
