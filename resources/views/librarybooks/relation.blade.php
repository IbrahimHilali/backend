@extends('layouts.app')

@section('title', $book->catalog_id . ': ' . $book->title . ' | ')

@section('content')
    <div class="container" id="library">
        <div class="row page">
            <div class="col-md-12 page-title">
                <h1>{{ trans('librarybooks.relations.' . $name . '.name') }} hinzufügen: {{ $book->title }}</h1>
            </div>

            <div class="col-md-12 page-content">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label for="searchPerson" class="col-sm-2 control-label">Person suchen:</label>
                        <div class="col-sm-10">
                            <typeahead id="searchPerson"
                                       placeholder="Person suchen"
                                       src="{{ url('librarypeople/search') }}?name="
                                       :prepare-response="prepareResponse"
                                       :on-hit="personSelected"
                                       result="person"
                                       template-name="person"
                                       template="@{{ item.name }}"
                                       empty="Es wurde keine Person gefunden!"
                            >
                            </typeahead>
                        </div>
                    </div>
                </form>

                <form id="book-editor" action="{{ route('librarybooks.relation', [$book, $name]) }}"
                      class="form-horizontal"
                      method="POST">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('person') ? ' has-error' : '' }}">
                        <input type="hidden" name="person" :value="person.id">
                        <label class="col-sm-2 control-label">Person</label>
                        <div class="col-sm-5">
                            <input class="form-control" readonly
                                   :value="person.name">
                        </div>
                        <div class="col-sm-5">
                            <input class="form-control" readonly
                                   :value="person.note">
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('person') ? ' has-error' : '' }}">
                        <div class="col-sm-offset-2 col-sm-10">
                            @if ($errors->has('person'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('person') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="button-bar row">
                        <div class="col-sm-10 col-md-offset-2">
                            <button type="submit" class="btn btn-primary">Verknüpfung speichern</button>
                            <a href="{{ route('librarybooks.show', [$book]) }}"
                               class="btn btn-link">Abbrechen</a>
                        </div>
                    </div>
                </form>

                <hr>

                <form action="{{ route('librarypeople.store') }}"
                      class="form-horizontal"
                      method="POST">
                    {{ csrf_field() }}

                    <div class="row">
                        <div class="col-sm-10 col-md-offset-2">
                            <p>Person noch nicht vorhanden? Neue anlegen...</p>
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('book') ? ' has-error' : '' }}">
                        <div class="col-sm-offset-2 col-sm-10">
                            @if ($errors->has('book'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('book') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('relation') ? ' has-error' : '' }}">
                        <div class="col-sm-offset-2 col-sm-10">
                            @if ($errors->has('relation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('relation') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <input type="hidden" name="book" value="{{ $book->id }}">
                    <input type="hidden" name="relation" value="{{ $name }}">

                    @include('partials.form.field', ['field' => 'name', 'model' => 'librarypeople'])
                    @include('partials.form.field', ['field' => 'note', 'model' => 'librarypeople'])

                    <div class="button-bar row">
                        <div class="col-sm-10 col-md-offset-2">
                            <button type="submit" class="btn btn-primary">Person speichern</button>
                            <a href="{{ route('librarybooks.show', [$book]) }}"
                               class="btn btn-link">Abbrechen</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ url('js/library.js') }}"></script>
@endsection
