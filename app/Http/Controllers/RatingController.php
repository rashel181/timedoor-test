<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;
use App\Models\Book;
use App\Models\Rating;

class RatingController extends Controller
{
    public function create()
    {
        $authors = Author::orderBy('name')->select('id', 'name')->get();
        $ratings = range(1, 10);
        return view('ratings.create', compact('authors', 'ratings'));
    }

    public function store()
    {
        $data = request()->validate([
            'author_id' => ['required', 'exists:authors,id'],
            'book_id' => ['required', 'exists:books,id'],
            'rating' => ['required', 'integer', 'min:1', 'max:10'],
        ]);

        $valid = Book::where('id', $data['book_id'])
            ->where('author_id', $data['author_id'])
            ->exists();
        abort_unless($valid, 422, 'Book tidak dimiliki author tersebut');

        Rating::create([
            'book_id' => $data['book_id'],
            'rating' => $data['rating'],
        ]);

        return redirect()->route('books.index')->with('success', 'Rating saved successfully!');
    }
}
