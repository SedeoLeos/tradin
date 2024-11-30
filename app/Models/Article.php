<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Article extends Model
{
    use SoftDeletes; 

   
    protected $keyType = 'string';
    public $incrementing = false; 
    protected $fillable = ['title', 'slug', 'content', 'primary_category_id'];

   
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->id = (string) Str::uuid(); 
        });
    }

   
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function primaryCategory()
    {
        return $this->belongsTo(Category::class);
    }

    public function media()
    {
        return $this->hasMany(Media::class);
    }

    /**
     * Relation avec les tags.
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'article_tag');
    }

    /**
     * Relation avec les liens sociaux.
     */
    public function socialLinks()
    {
        return $this->hasMany(SocialLink::class);
    }
}
