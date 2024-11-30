<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SocialLink extends Model
{
    use HasFactory;
    protected $keyType = 'string';
    public $incrementing = false; 

    protected $fillable = [
        'article_id',
        'platform',
        'link',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($socialLink) {
            $socialLink->id = $socialLink->id ?? (string) Str::uuid(); // Génère un UUID si ce n'est pas déjà défini
        });
    }

    /**
     * Relation avec l'article.
     */
    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
