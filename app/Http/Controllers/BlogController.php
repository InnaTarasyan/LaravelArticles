<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;

class BlogController extends Controller
{
    public function listAll()
    {
        $articles =  Blog::all();
        return view('index')->with('articles', $articles);
    }

    public function article($id)
    {
        $article = Blog::find($id);
        return view('article')->with('article', $article);
    }
}
