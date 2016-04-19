@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row page">
            <div class="col-md-12 page-title">
                <h1><a class="prev-link" href="{{ referrer_url('last_book_index', route('books.index')) }}"><i
                                class="fa fa-caret-left"></i></a> Buchdaten</h1>
            </div>
            <div class="col-md-12 list-content">
                <div class="panel-body">
                    <form class="form-horizontal" action="{{ route('books.update', ['id' => $book->id]) }}"
                          method="post">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label class="col-sm-2 control-label" for="inputTitle">Titel</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="title" id="inputTitle"
                                       value="{{ old('title', $book->title) }}">

                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('short_title') ? ' has-error' : '' }}">
                            <label class="col-sm-2 control-label" for="inputShortTitle">Kurztitel</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="short_title" id="inputShortTitle"
                                       value="{{ old('short_title', $book->short_title) }}">

                                @if ($errors->has('short_title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('short_title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        {{-- <div class="form-group{{ $errors->has('year') ? ' has-error' : '' }}">
                            <label class="col-sm-2 control-label" for="inputYear">Jahr</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="year" id="inputYear"
                                       value="{{ old('year', $book->year) }}">

                                @if ($errors->has('year'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('year') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>--}}
                        <div class="form-group{{ $errors->has('volume') ? ' has-error' : '' }}">
                            <label class="col-sm-2 control-label" for="inputVolume">Band</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="volume" id="inputVolume"
                                       value="{{ old('volume', $book->volume) }}">

                                @if ($errors->has('volume'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('volume') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('volume_irregular') ? ' has-error' : '' }}">
                            <label class="col-sm-2 control-label" for="inputVolumeIrregular">Zusatzband</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="volume_irregular" id="inputVolumeIrregular"
                                       value="{{ old('volume_irregular', $book->volume_irregular) }}">

                                @if ($errors->has('volume_irregular'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('volume_irregular') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('edition') ? ' has-error' : '' }}">
                            <label class="col-sm-2 control-label" for="inputEdition">Edition</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="edition" id="inputEdition"
                                       value="{{ old('edition', $book->edition) }}">

                                @if ($errors->has('edition'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('edition') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('source') ? ' has-error' : '' }}">
                            <label class="col-sm-2 control-label" for="inputSource">Herkunft</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="source" id="inputSource"
                                       value="{{ old('source', $book->source) }}">

                                @if ($errors->has('source'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('source') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('notes') ? ' has-error' : '' }}">
                            <label class="col-sm-2 control-label" for="inputNotes">Notizen</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="notes" id="inputNotes" cols="30" rows="10">{{ old('notes', $book->notes) }}</textarea>

                                @if ($errors->has('notes'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('notes') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('grimm') ? ' has-error' : '' }}">
                            <label class="col-sm-2 control-label">Grimmwerk</label>
                            <div class="col-sm-10">
                                <label class="radio-inline">
                                    <input type="radio" name="grimm" id="grimm1"
                                           value="0" {{ checked(old('grimm', $book->grimm), 0) }}>
                                    Nein
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="grimm" id="grimm2"
                                           value="1" {{ checked(old('grimm', $book->grimm), 1) }}>
                                    Ja
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-10 col-sm-offset-2">
                                @can('books.update')
                                <button type="submit" class="btn btn-primary">
                                    <span class="fa fa-floppy-o"></span>
                                    Speichern
                                </button>

                                <button type="reset" class="btn btn-link">
                                    Änderungen zurücksetzen
                                </button>
                                @endcan
                            </div>
                        </div>
                    </form>
                </div>
                <div class="add-button">
                    <a href="{{ route('books.associations.index', [$book->id]) }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus"></i> Person hinzufügen
                    </a>
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
                                <a href="{{ route('persons.book', [$personAssociation->id]) }}"
                                   data-toggle="tooltip" data-title="Verknüpfung">
                                    <span class="fa fa-link"></span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <h1 class="panel-title">Gefahrenzone</h1>
                            </div>

                            <div class="panel-body">
                                <p>
                                <form id="danger-zone" action="{{ route('books.destroy', ['id' => $book->id]) }}" method="post" class="form-inline">
                                    {{ csrf_field() }}
                                    {{ method_field('delete') }}
                                    <button class="btn btn-danger">
                                        <span class="fa fa-trash"></span>
                                        {{ trans('books.delete') }}
                                    </button>
                                </form>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection
