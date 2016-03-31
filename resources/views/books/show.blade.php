@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h1 class="panel-title">Buchdaten</h1>
                    </div>

                    <div class="panel-body">
                        <form class="form-horizontal" action="{{ route('books.update', ['id' => $book->id]) }}"
                              method="post">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}

                            @include('info')

                            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                <label class="col-sm-2 control-label">Titel</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="title" value="{{ old('title', $book->title) }}">

                                    @if ($errors->has('title'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('short_title') ? ' has-error' : '' }}">
                                <label class="col-sm-2 control-label">Kurztitel</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="short_title"
                                           value="{{ old('short_title', $book->short_title) }}">

                                    @if ($errors->has('short_title'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('short_title') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('year') ? ' has-error' : '' }}">
                                <label class="col-sm-2 control-label">Jahr</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="year"
                                           value="{{ old('year', $book->year) }}">

                                    @if ($errors->has('year'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('year') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('volume') ? ' has-error' : '' }}">
                                <label class="col-sm-2 control-label">Band</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="volume"
                                           value="{{ old('volume', $book->volume) }}">

                                    @if ($errors->has('volume'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('volume') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('volume_irregular') ? ' has-error' : '' }}">
                                <label class="col-sm-2 control-label">Zusatzband</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="volume_irregular"
                                           value="{{ old('volume_irregular', $book->volume_irregular) }}">

                                    @if ($errors->has('volume_irregular'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('volume_irregular') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('edition') ? ' has-error' : '' }}">
                                <label class="col-sm-2 control-label">Edition</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="edition"
                                           value="{{ old('edition', $book->edition) }}">

                                    @if ($errors->has('edition'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('edition') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-10 col-sm-offset-2">
                                    <button type="submit" class="btn btn-primary">
                                        <span class="glyphicon glyphicon-save"></span>
                                        Speichern
                                    </button>

                                    <button type="reset" class="btn btn-default">
                                        <span class="glyphicon glyphicon-refresh"></span>
                                        Änderungen zurücksetzen
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <table class="table table-responsive">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Nachname</th>
                            <th>Vorname</th>
                            <th>Seite</th>
                            <th>Zeile</th>
                            <th>Notiz</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($book->personAssociations as $personAssociation)
                            <tr>
                                <td>
                                    <a href="{{ route('persons.show', ['id' => $personAssociation->person->id]) }}">{{ $personAssociation->person->id }}</a>
                                </td>
                                <td>{{ $personAssociation->person->last_name }}</td>
                                <td>{{ $personAssociation->person->first_name }}</td>
                                <td>
                                    {{ $personAssociation->page }}
                                    @if($personAssociation->page_to)
                                        bis {{ $personAssociation->page_to }}
                                    @endif
                                </td>
                                <td>{{ $personAssociation->line }}</td>
                                <td>{{ $personAssociation->page_description }}</td>
                                <td>
                                    <a href="{{ route('books.person', ['book_id' => $book->id, 'person_id' => $personAssociation->person->id]) }}"
                                       data-toggle="tooltip" data-title="Verknüpfung">
                                        <span class="glyphicon glyphicon-link"></span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection