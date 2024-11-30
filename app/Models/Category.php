<?php 
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    // Spécifie que l'ID est une chaîne de caractères (UUID)
    protected $keyType = 'string';
    public $incrementing = false; // Désactive l'auto-incrémentation de l'ID
    protected $fillable = ['name'];

    // Lors de la création de la catégorie, générer un UUID pour l'ID
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->id = (string) Str::uuid(); // Générer un UUID
        });
    }

    // Relation avec les articles (relation plusieurs-à-plusieurs)
    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }
}
