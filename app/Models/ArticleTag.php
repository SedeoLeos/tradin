<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Relations\Pivot;

class ArticleTag extends Pivot
{
    protected $table = 'article_tag';
    
    /**
     * Lien avec l'article.
     */
    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * Lien avec le tag.
     */
    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }
}
