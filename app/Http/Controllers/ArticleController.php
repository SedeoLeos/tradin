<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class ArticleController extends Controller
{

    public function index()
    {
        return Inertia::render('Articles/Index', [
            'canLogin' => route('login') ? true : false,
            'canRegister' => route('register') ? true : false,

        ]);
    }


    public function show($slug)
    {
        

        // Return the article along with additional data
        return Inertia::render('Articles/Show', [
            'canLogin' => route('login') ? true : false,
            'canRegister' => route('register') ? true : false,
        ]);
    }
}
