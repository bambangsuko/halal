<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{

    public function index()
    {
        if (empty(request('keyword'))) {
            return redirect(url('/'));
        }

        $posts = Post::whereHas('translations', function ($query) {
            $query->where('title', 'like', '%' . request('keyword') . '%')
                ->orWhere('description', 'like', '%' . request('keyword') . '%');
        })
        ->latest()
            ->paginate(6);
        return view('search.index', [
            'posts' => $posts,
            'search' => true
        ]);
    }
}
