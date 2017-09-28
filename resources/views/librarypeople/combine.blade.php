@extends('layouts.app')

@section('title', $person->name . ' | ')

@section('content')
    <div class="container" id="library">
        <div class="row page">
            <div class="col-md-12 page-title">
                <h1>{{ $person->name }} mit anderer Person zusammenführen (insgesamt {{ $person->totalBookCount() }}
                    Bücher)</h1>
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
                                       empty="Es wurde keine Person gefunden!"
                            >
                                <template slot="list-item" scope="props">
                                    @{{ props.item.name }} <strong>[#@{{ props.item.id }}]</strong>
                                </template>
                            </typeahead>
                        </div>
                    </div>
                </form>

                <form id="book-editor" action="{{ route('librarypeople.combine', [$person]) }}"
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
                            <p class="text-danger">
                                Achtung! Diese Person wird gelöscht. Die ausgewählte Person bleibt bestehen
                                und wird um die Bücher ergänzt.
                            </p>

                            <button type="submit" class="btn btn-danger">
                                Personen zusammenführen
                            </button>
                            <a href="{{ route('librarypeople.show', [$person]) }}"
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
