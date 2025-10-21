@extends('layouts.app')
@section('content')
    <h2>Input Rating</h2>

    <p><a href="{{ route('books.index') }}">Back to Books</a></p>

    <form method="post" action="{{ route('ratings.store') }}">
        @csrf
        <p>
            <label>Author:</label><br>
            <select id="author_id" name="author_id" required>
                <option value="">-- Select Author --</option>
                @foreach ($authors as $a)
                    <option value="{{ $a->id }}">{{ $a->name }}</option>
                @endforeach
            </select>
        </p>

        <p>
            <label>Book:</label><br>
            <select id="book_id" name="book_id" required>
                <option value="">-- Select Book --</option>
            </select>
        </p>

        <p>
            <label>Rating:</label><br>
            <select name="rating" required>
                @foreach ($ratings as $r)
                    <option value="{{ $r }}">{{ $r }}</option>
                @endforeach
            </select>
        </p>

        <p>
            <button type="submit">Submit Rating</button>
            <a href="{{ route('books.index') }}">Cancel</a>
        </p>
    </form>

    <script>
        document.getElementById('author_id').addEventListener('change', async function() {
            const authorId = this.value;
            const bookSelect = document.getElementById('book_id');

            if (!authorId) {
                bookSelect.innerHTML = '<option value="">-- Select Book --</option>';
                return;
            }

            try {
                const res = await fetch('/authors/' + authorId + '/books');
                const books = await res.json();

                bookSelect.innerHTML = '<option value="">-- Select Book --</option>';
                books.forEach(b => {
                    const opt = document.createElement('option');
                    opt.value = b.id;
                    opt.textContent = b.title;
                    bookSelect.appendChild(opt);
                });
            } catch (error) {
                console.error('Error loading books:', error);
                bookSelect.innerHTML = '<option value="">Error loading books</option>';
            }
        });
    </script>
@endsection
