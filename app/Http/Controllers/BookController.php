<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Book;

class BookController extends Controller
{
    public function index()
    {
        $limitOptions = [10, 20, 30, 40, 50, 60, 70, 80, 90, 100];
        $limit = in_array((int)request('limit'), $limitOptions, true) ? (int)request('limit') : 10;
        $q = trim((string)request('q'));

        $ratingStats = DB::table('ratings')
            ->select('book_id', DB::raw('AVG(rating) as avg_rating'), DB::raw('COUNT(*) as voters'))
            ->groupBy('book_id');

        $query = DB::table('books')
            ->leftJoin('authors', 'authors.id', '=', 'books.author_id')
            ->leftJoin('categories', 'categories.id', '=', 'books.category_id')
            ->leftJoinSub($ratingStats, 'rating_stats', function ($join) {
                $join->on('books.id', '=', 'rating_stats.book_id');
            })
            ->select(
                'books.id',
                'books.title',
                'authors.name as author_name',
                'categories.name as category_name',
                DB::raw('COALESCE(rating_stats.avg_rating, 0) as avg_rating'),
                DB::raw('COALESCE(rating_stats.voters, 0) as voters')
            );

        if ($q !== '') {
            $query->where(function ($x) use ($q) {
                $x->where('books.title', 'like', "%{$q}%")
                    ->orWhere('authors.name', 'like', "%{$q}%");
            });
        }

        $books = $query->orderByDesc('avg_rating')
            ->paginate($limit)
            ->withQueryString();

        return view('books.index', compact('books', 'limitOptions', 'limit', 'q'));
    }
}
