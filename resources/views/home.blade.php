@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Letzte Änderungen</div>

                    <div class="panel-body">
                        <h3>Personen</h3>

                        <ul>
                            @foreach($latestPeopleUpdated as $person)
                                <li>
                                    <a href="{{ route('persons.show', ['id' => $person->id]) }}">{{ $person->first_name }} {{ $person->last_name }}</a>
                                    ({{ $person->updated_at->format('d.m.Y H:i:s') }})
                                </li>
                            @endforeach
                        </ul>

                        <h3>Bücher</h3>

                        <ul>
                            @foreach($latestBooksUpdated as $book)
                                <li>
                                    <a href="{{ route('books.show', ['id' => $book->id]) }}">{{ $book->title }}</a>
                                    ({{ $book->updated_at->format('d.m.Y H:i:s') }})
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Zuletzt hinzugefügt</div>

                    <div class="panel-body">
                        <h3>Personen</h3>

                        <ul>
                            @foreach($latestPeopleCreated as $person)
                                <li>
                                    <a href="{{ route('persons.show', ['id' => $person->id]) }}">{{ $person->first_name }} {{ $person->last_name }}</a>
                                    ({{ $person->updated_at->format('d.m.Y H:i:s') }})
                                </li>
                            @endforeach
                        </ul>

                        <h3>Bücher</h3>

                        <ul>
                            @foreach($latestBooksCreated as $book)
                                <li>
                                    <a href="{{ route('books.show', ['id' => $book->id]) }}">{{ $book->title }}</a>
                                    ({{ $book->updated_at->format('d.m.Y H:i:s') }})
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
