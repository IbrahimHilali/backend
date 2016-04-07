@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row page">
            <div class="col-md-12 page-title">
                <h1><a class="prev-link" href="{{ referrer_url('last_person_index', route('persons.index')) }}"><i
                                class="fa fa-caret-left"></i></a> Buch hinzufügen</h1>
            </div>
            <div class="col-md-12 page-content">
                @include('info')

                <form action="{{ route('persons.add-book', [$person->id]) }}" class="form-horizontal"
                      method="GET">
                    <div class="row">
                        <label class="col-sm-2 control-label">Buch suchen</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-primary">
                                        <span class="fa fa-search"></span>
                                    </button>
                                </div>
                                <input class="form-control" name="search"
                                       value="{{ request()->get('search') }}"
                                       placeholder="Buchtitel">
                                <div class="input-group-btn">
                                    <a href="{{ route('persons.add-book', [$person->id]) }}"
                                       class="btn btn-default"><i class="fa fa-times"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <form action="{{ route('persons.add-book.store', [$person->id]) }}" class="form-horizontal"
                      method="POST">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <div class="text-center">
                                {{ $books->links() }}
                            </div>
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('book') ? ' has-error' : '' }}">
                        <label class="col-sm-2 control-label">Buch</label>
                        <div class="col-sm-10">
                            <div class="list-group">
                                @foreach($books->items() as $book)
                                    <input class="check-helper" name="book" value="{{ $book->id }}" type="radio"
                                           style="display: none;"
                                           id="book-{{ $book->id }}" {{ checked(old('book'), $book->id) }}>
                                    <label class="list-group-item text-center"
                                           for="book-{{ $book->id }}">
                                        {{ $book->title }}
                                        <em style="font-weight: 300;">
                                            @if($book->year)
                                                - {{ $book->year }}
                                            @endif
                                            @if($book->volume)
                                                - Bd. {{ $book->volume }}
                                            @endif
                                            @if($book->volume_irregular)
                                                - i. Bd. {{ $book->volume_irregular }}
                                            @endif
                                            @if($book->edition)
                                                - Ed. {{ $book->edition }}
                                            @endif
                                        </em>
                                    </label>
                                @endforeach
                            </div>

                            @if ($errors->has('book'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('book') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('page') || $errors->has('page_to') || $errors->has('line') ? ' has-error' : '' }}">
                        <label class="col-sm-2 control-label">Seite</label>
                        <div class="col-sm-2">
                            <input class="form-control" name="page"
                                   value="{{ old('page') }}">

                            @if ($errors->has('page'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('page') }}</strong>
                                </span>
                            @endif
                        </div>
                        <label class="col-sm-1 control-label" style="text-align: center;">bis</label>
                        <div class="col-sm-2">
                            <input class="form-control" name="page_to"
                                   value="{{ old('page_to') }}">

                            @if ($errors->has('page_to'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('page_to') }}</strong>
                                </span>
                            @endif
                        </div>
                        <label class="col-sm-2 control-label">Zeile</label>
                        <div class="col-sm-3">
                            <input class="form-control" name="line"
                                   value="{{ old('line') }}">

                            @if ($errors->has('line'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('line') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('page_description') ? ' has-error' : '' }}">
                        <label class="col-sm-2 control-label">Notiz</label>
                        <div class="col-sm-10">
                            <input class="form-control" name="page_description"
                                   value="{{ old('page_description') }}">

                            @if ($errors->has('page_description'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('page_description') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="button-bar row">
                        <div class="col-sm-10 col-md-offset-2">
                            <button type="submit" class="btn btn-primary">Speichern</button>
                            <a href="{{ route('persons.show', [$person->id]) }}#books"
                               class="btn btn-link">Abbrechen</a>
                        </div>
                    </div>
                </form>

                <hr>

                <div class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Nachname</label>
                        <div class="col-sm-10">
                            <input class="form-control" name="last_name"
                                   value="{{ $person->last_name }}" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Vorname</label>
                        <div class="col-sm-10">
                            <input class="form-control" name="first_name"
                                   value="{{ $person->first_name }}" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Geburtsdatum</label>
                        <div class="col-sm-10">
                            <input class="form-control" name="birth_date"
                                   value="{{ $person->birth_date }}" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Todesdatum</label>
                        <div class="col-sm-10">
                            <input class="form-control" name="death_date"
                                   value="{{ $person->death_date }}" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Biographische Daten</label>
                        <div class="col-sm-10">
                            <input class="form-control" name="bio_data"
                                   value="{{ $person->bio_data }}" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- <script>
        var BASE_URL = "{{ route('persons.create') }}";
    </script>
    <script src="{{ url('js/persons.js') }}"></script>
    <script>

    </script>--}}
@endsection