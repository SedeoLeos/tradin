<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;


class ArticleController extends Controller
{

    public function index(SearchRequest $searchRequest, CategoryRequest $categoryRequest)
    {
        $query = Article::query();

        // Filtrage par catégorie
        if ($categoryRequest->has('category')) {
            $category = $categoryRequest->input('category');
            $query->whereHas('categories', function ($q) use ($category) {
                $q->where('name', $category);
            });
        }

        // Recherche dans les articles
        if ($searchRequest->has('search')) {
            $searchTerm = $searchRequest->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                    ->orWhere('content', 'like', '%' . $searchTerm . '%');
            });
        }

        $articles = $query->with(['categories', 'primaryCategory'])
            ->paginate(10);

        return ArticleResource::collection($articles);
    }


    public function show($slug)
    {
        // Retrieve the article along with its related categories, media, tags, and social links
        $article = Article::where('slug', $slug)
            ->with([
                'categories',          // Related categories
                'primaryCategory',     // Related primary category
                'media',               // Related media (images, videos, etc.)
                'tags',                // Related tags
                'socialLinks',         // Related social links
            ])
            ->firstOrFail();

        if (!$article) {
            return response()->json(['error' => 'Article not found'], 404);
        }

        // Return the article along with additional data
        return new ArticleResource($article);
    }
}
