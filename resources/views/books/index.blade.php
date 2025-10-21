@extends('layouts.app')
@section('content')
    <h2>List of books with filter</h2>

    <p>
        <a href="{{ route('authors.top') }}">Top Authors</a> |
        <a href="{{ route('ratings.create') }}">Input Rating</a>
    </p>

    <form method="get" action="{{ route('books.index') }}">
        <label>List shown:</label>
        <select name="limit">
            @foreach ($limitOptions as $opt)
                <option value="{{ $opt }}" {{ $opt == $limit ? 'selected' : '' }}>{{ $opt }}</option>
            @endforeach
        </select>

        <label>Search:</label>
        <input type="text" name="q" value="{{ $q }}" placeholder="book or author name">
        <button type="submit">SUBMIT</button>
    </form>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <table border="1" cellpadding="8" cellspacing="0" style="width: 100%; margin-top: 20px;">
        <thead>
            <tr style="background: #f0f0f0;">
                <th>No</th>
                <th>Book Name</th>
                <th>Category</th>
                <th>Author</th>
                <th>Avg Rating</th>
                <th>Voters</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($books as $i => $b)
                <tr>
                    <td>{{ ($books->currentPage() - 1) * $books->perPage() + $i + 1 }}</td>
                    <td>{{ $b->title }}</td>
                    <td>{{ $b->category_name ?? '-' }}</td>
                    <td>{{ $b->author_name ?? '-' }}</td>
                    <td>{{ number_format($b->avg_rating ?? 0, 2) }}</td>
                    <td>{{ $b->voters }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if ($books->hasPages())
        <div style="text-align: center; margin: 20px 0;">
            <p style="color: #666; margin-bottom: 10px;">
                Showing {{ $books->firstItem() }} to {{ $books->lastItem() }} of {{ $books->total() }} results
            </p>

            <div style="display: inline-block;">
                @for ($i = max(1, $books->currentPage() - 2); $i <= min($books->lastPage(), $books->currentPage() + 2); $i++)
                    @if ($i == $books->currentPage())
                        <span
                            style="padding: 8px 12px; margin: 0 2px; border: 1px solid #007bff; background: #007bff; color: white;">{{ $i }}</span>
                    @else
                        <a href="{{ $books->url($i) }}"
                            style="padding: 8px 12px; margin: 0 2px; border: 1px solid #ddd; background: white; color: #007bff; text-decoration: none;">{{ $i }}</a>
                    @endif
                @endfor
            </div>
        </div>
    @endif
@endsection
