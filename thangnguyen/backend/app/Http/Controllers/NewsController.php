<?php

// app/Http/Controllers/NewsController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class NewsController extends Controller
{
    public function index()
    {
        $news = Post::all();
        return response()->json($news);
    }
}

