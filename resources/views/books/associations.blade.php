@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row page">
            <div class="col-md-12 page-title">
                <h1><a class="prev-link" href="{{ route('books.show', [$book]) }}"><i
                                class="fa fa-caret-left"></i></a> Personen
                    in {{ $book->title }} {{ isset($book->year) ? '(' . $book->year . ')' : '' }}</h1>
            </div>
            <div class="col-md-12 page-content">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label for="bookTitle" class="col-sm-2 control-label">Buchtitel:</label>
                        <div class="col-sm-10">
                            <p class="form-control-static">{{ $book->title }}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="bookTitle" class="col-sm-2 control-label">Kurztitel:</label>
                        <div class="col-sm-10">
                            <p class="form-control-static">{{ $book->short_title }}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="bookTitle" class="col-sm-2 control-label">Band:</label>
                        <div class="col-sm-10">
                            <p class="form-control-static">
                                {{ $book->volume or '?' }}
                                @if ($book->volume_irregular !== null)
                                    .{{ $book->volume_irregular }}
                                @endif
                                @if ($book->edition !== null)
                                    , {{ $book->edition }}. Auflage
                                @endif</p>
                        </div>
                    </div>
                </form>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Vorkommen</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($persons as $person)
                        <tr>
                            <td>{{ $person->last_name }}, {{ $person->first_name }}</td>
                            <td>
                                <p data-toggle="collapse" data-target="#associations-{{ $person->id }}" aria-expanded="false"
                                   class="collapsed collapse-head">
                                    {{ $person->bookAssociations->count() }} Vorkommen, erstes auf Seite {{ $person->bookAssociations[0]->page }}
                                </p>
                                <table class="table collapse" id="associations-{{ $person->id }}">
                                    <tbody>
                                    @foreach($person->bookAssociations as $association)
                                        <tr>
                                            <td>
                                                Seite {{ $association->page }}
                                                @if($association->page_to)
                                                    - {{ $association->page_to }}
                                                @endif
                                            </td>
                                            <td>
                                                @if($association->line)
                                                    Zeile {{ $association->line }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
