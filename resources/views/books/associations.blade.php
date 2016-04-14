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
                    <tr>
                        <td>Mustermann, Max</td>
                        <td>
                            <p data-toggle="collapse" data-target="#associations-1" aria-expanded="false" class="collapsed collapse-head">5 Vorkommen, erstes auf Seite 10</p>
                            <table class="table collapse" id="associations-1">
                                <tbody>
                                <tr>
                                    <td>Seite 10 - 11</td>
                                    <td>Zeile 19</td>
                                </tr>
                                <tr>
                                    <td>Seite 12 - 15</td>
                                    <td>Zeile 17</td>
                                </tr>
                                <tr>
                                    <td>Seite 16</td>
                                    <td>Zeile 17</td>
                                </tr>
                                <tr>
                                    <td>Seite 27</td>
                                    <td>Zeile 17</td>
                                </tr>
                                <tr>
                                    <td>Seite 38</td>
                                    <td>Zeile 17</td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>Musterfrau, Erika</td>
                        <td>
                            <p data-toggle="collapse" data-target="#associations-2" aria-expanded="false" class="collapsed collapse-head">2 Vorkommen, erstes auf Seite 10</p>
                            <table class="table collapse" id="associations-2">
                                <tbody>
                                <tr>
                                    <td>Seite 10 - 11</td>
                                    <td>Zeile 19</td>
                                </tr>
                                <tr>
                                    <td>Seite 12 - 15</td>
                                    <td>Zeile 17</td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
