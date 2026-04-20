<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('index', [
            'latestPosts' => Post::query()
                ->latest('pubDate')
                ->take(3)
                ->get(),
        ]);
    }
}
