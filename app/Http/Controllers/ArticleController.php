<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\CategoryResource;
use App\Models\Article;
use App\Models\Category;
use Inertia\Inertia;

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


        return Inertia::render('Articles/Index', [
            'articles' =>$articles,
            'categories' => Category::all(), 
            'canLogin' => route('login') ? true : false,
            'canRegister' => route('register') ? true : false,
            'filters' => $searchRequest->only(['search']),
        ]);
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
        return Inertia::render('Articles/Show', [
            'article' => $article,
            'categories' => Category::all(),
            'tags' => $article->tags,                   // Pass the tags of the article
            'media' => $article->media,                 // Pass the media related to the article
            'socialLinks' => $article->socialLinks,     // Pass the social links related to the article
            'canLogin' => route('login') ? true : false,
            'canRegister' => route('register') ? true : false,
        ]);
    }
    
}
