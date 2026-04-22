<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Contracts\View\View;

class BlogController extends Controller
{
    public function show(Post $post): View
    {
        return view('blog.show', ['post' => $post]);
    }
}
