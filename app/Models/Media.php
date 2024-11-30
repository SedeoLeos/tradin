<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Media extends Model
{
    use HasFactory;
    protected $table = 'medias';
    protected $keyType = 'string';
    public $incrementing = false; 

    protected $fillable = [
        'article_id',
        'type',
        'url',
        'slug',
    ];

    protected static function boot()
    {
        parent::boot();

        // Générer l'UUID au moment de la création
        static::creating(function ($media) {
            $media->id = $media->id ?? (string) Str::uuid(); // Génère un UUID si ce n'est pas déjà défini
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
