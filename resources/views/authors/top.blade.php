@extends('layouts.app')
@section('content')
    <h2>Top 10 Most Famous Authors</h2>

    <p><a href="{{ route('books.index') }}">Back to Books</a></p>

    <table border="1" cellpadding="8" cellspacing="0" style="width: 100%;">
        <thead>
            <tr style="background: #f0f0f0;">
                <th>Rank</th>
                <th>Author Name</th>
                <th>Total Voters</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($authors as $i => $a)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $a->name }}</td>
                    <td>{{ $a->voters }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
