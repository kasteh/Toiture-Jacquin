<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $guarded = [];
    
    public function departement(){
        return $this->belongsTo(Departement::class,'departement_code','code');
    }
    
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
