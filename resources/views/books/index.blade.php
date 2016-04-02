@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 page-title">
                <div class="button-container">
                    <div class="generic">
                    <a href="{{ route('books.create') }}" role="button" class="btn btn-default btn-sm">
                        <span class="fa fa-plus"></span>
                        {{ trans('books.store') }}
                    </a>
                    </div>
                </div>
                <h1>Bücherdatenbank</h1>
            </div>
            <div class="col-md-12 pagination-container">
                {{ $books->links() }}
            </div>
            <div class="col-md-12 list-content">
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
            </div>
            <div class="col-md-12 pagination-container">
                {{ $books->links() }}
            </div>
        </div>
    </div>
@endsection