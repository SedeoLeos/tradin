<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;


class CategoryController extends Controller
{
    /**
     * Récupérer toutes les catégories
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Récupérer toutes les catégories avec leurs articles (si nécessaire)
        $categories = Category::all();
        return  CategoryResource::collection($categories);
    }

    /**
     * Récupérer une catégorie par son ID
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Trouver la catégorie par ID
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }

        return new  CategoryResource($category);
    }
}
