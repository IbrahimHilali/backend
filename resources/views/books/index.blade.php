@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <h1>Bücherdatenbank</h1>

                <p>
                    <a href="{{ route('books.create') }}" role="button" class="btn btn-default">
                        <span class="glyphicon glyphicon-new-window"></span>
                        {{ trans('books.store') }}
                    </a>
                </p>

                {{ $books->links() }}

                <table class="table table-responsive table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Nachname</th>
                        <th>Vorname</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($books->items() as $book)
                        <tr onclick="location.href='{{ route('books.show', ['id' => $book->id]) }}'"
                            style="cursor: pointer;">
                            <td>{{ $book->id }}</td>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->short_title }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {{ $books->links() }}
            </div>
        </div>
    </div>
@endsection