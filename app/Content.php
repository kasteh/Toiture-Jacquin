<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $guarded = [];

    protected $fillable = [
        'title', 
        'slug', 
        'text', 
        'category_id', 
        'image'
    ];
    
    public function category(){
        return $this->belongsTo(Category::class);
    }
    
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopeForSubdomain($query, $subdomain)
    {
        return $query->where('slug', 'LIKE', '%' . str_replace('-', '%', $subdomain) . '%');
    }

    public function scopeForSlugVariations($query, string $slug, string $citySlug)
    {
        $modifiedSlug = str_replace("-{$citySlug}", '', $slug);
    
        return $query->where(function($q) use ($slug, $modifiedSlug) {
            $q->where('slug', $slug)
              ->orWhere('slug', 'LIKE', "{$modifiedSlug}%"); // <-- ici le %
        });
    }
}
