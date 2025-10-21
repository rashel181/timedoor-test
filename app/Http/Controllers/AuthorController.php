<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;
use Illuminate\Support\Facades\DB;

class AuthorController extends Controller
{
    public function top()
    {
        $authors = Author::query()
            ->join('books', 'books.author_id', '=', 'authors.id')
            ->join('ratings', 'ratings.book_id', '=', 'books.id')
            ->where('ratings.rating', '>', 5)
            ->groupBy('authors.id', 'authors.name')
            ->select('authors.id', 'authors.name', DB::raw('COUNT(ratings.id) AS voters'))
            ->orderByDesc('voters')
            ->limit(10)
            ->get();

        return view('authors.top', compact('authors'));
    }

    public function books(Author $author)
    {
        return response()->json(
            $author->books()->select('id', 'title')->orderBy('title')->get()
        );
    }
}
