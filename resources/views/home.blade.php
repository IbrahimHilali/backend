@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

        </div>
        <div class="row">
            <div class="col-md-8">
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
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">Schnellstart</div>
                    <div class="panel-body">
                        <div class="row button-box">
                            @can('letters.store')
                            <div>
                                <a href="{{ url('/') }}"><i class="fa fa-envelope-o fa-4x"></i>
                                <h5>Brief anlegen</h5></a>
                            </div>
                            @endcan
                            @can('people.store')
                            <div>
                                <a href="{{ route('persons.create') }}"><i class="fa fa-users fa-4x"></i>
                                <h5>Neue Person</h5></a>
                            </div>
                            @endcan
                            @can('books.store')
                            <div>
                                <a href="{{ route('books.create') }}"><i class="fa fa-book fa-4x"></i>
                                <h5>Neues Buch</h5></a>
                            </div>
                            @endcan
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">Zahlen und Fakten</div>

                    <div class="panel-body">
                        <div class="row button-box">
                            <div class="col-md-4">
                                <h2>0</h2>
                                <h4>Briefe</h4>
                            </div>
                            <div class="col-md-4">
                                <h2>{{ \Grimm\Person::count() }}</h2>
                                <h4>Personen</h4>
                            </div>
                            <div class="col-md-4">
                                <h2>{{ \Grimm\Book::count() }}</h2>
                                <h4>Bücher</h4>
                            </div>
                        </div>
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
