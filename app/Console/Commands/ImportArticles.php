<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Media;
use App\Models\SocialLink;
use Illuminate\Console\Command;

class ImportArticles extends Command
{
    protected $signature = 'import:articles';
    protected $description = 'Importation des articles avec images, catégories, tags et liens sociaux.';

    public function handle()
    {
        $filePath = storage_path('app/feed.json');

        if (!file_exists($filePath)) {
            $this->error("Le fichier JSON est introuvable.");
            return;
        }

        $articles = json_decode(file_get_contents($filePath), true);

        // Initialiser la barre de progression
        $this->output->progressStart(count($articles)); // Démarre la barre de progression

        foreach ($articles as $data) {
            // Éviter les doublons d'articles (basé sur le slug)
            $existingArticle = Article::where('slug', $data['slug'])->first();
            if ($existingArticle) {
                $this->info("L'article '{$data['title']}' existe déjà. Ignoré.");
                continue;
            }

            // Gestion des catégories
            $primaryCategory = $data['categories']['primary'] ?? $data['categories']['additional'][0] ?? null;
            $categoryIds = [];
            if ($primaryCategory) {
                $primary = Category::firstOrCreate(['name' => $primaryCategory]);
                $categoryIds[] = $primary->id;
            }
            foreach ($data['categories']['additional'] ?? [] as $additional) {
                $category = Category::firstOrCreate(['name' => $additional]);
                $categoryIds[] = $category->id;
            }

            // Insertion de l'article
            $article = Article::create([
                'title' => $data['title'],
                'slug' => $data['slug'],
                'content' => $data['content'][0]['content'] ?? '',
                'primary_category_id' => $primaryCategory ? $primary->id : null,
            ]);

            // Lier les catégories additionnelles
            $article->categories()->sync($categoryIds);

            // Gérer les images
            if (isset($data['media'])) {
                foreach ($data['media'] as $mediaData) {
                    if ($mediaData['media']['type'] === 'image') {
                        $media = Media::create([
                            'article_id' => $article->id,
                            'type' => $mediaData['media']['type'],
                            'url' => $mediaData['media']['attributes']['url'],
                            'slug' => $mediaData['media']['slug'],
                        ]);
                    }
                }
            }

            // Gérer les tags sociaux
            if (isset($data['social'])) {
                foreach ($data['social'] as $socialData) {
                    SocialLink::create([
                        'article_id' => $article->id,
                        'platform' => $socialData['name'],
                        'link' => $socialData['link'],
                    ]);
                }
            }

            // Gérer les tags
            if (isset($data['tags'])) {
                foreach ($data['tags'] as $tagData) {
                    $tag = Tag::firstOrCreate([
                        'slug' => $tagData['slug'],
                        'name' => $tagData['name'],
                    ]);
                    $article->tags()->attach($tag->id);
                }
            }

            // Mettre à jour la barre de progression après chaque article
            $this->output->progressAdvance();
        }

        // Fin de la barre de progression
        $this->output->progressFinish();

        $this->info("Importation terminée !");
    }
}
