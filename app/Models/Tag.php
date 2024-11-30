<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Tag extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'name',
        'slug',
    ];

    protected static function boot()
    {
        parent::boot();

        // Générer l'UUID au moment de la création
        static::creating(function ($tag) {
            $tag->id = $tag->id ?? (string) Str::uuid(); // Génère un UUID si ce n'est pas déjà défini
        });
    }
    /**
     * Relation many-to-many avec les articles.
     */
    public function articles()
    {
        return $this->belongsToMany(Article::class, 'article_tag');
    }
}
