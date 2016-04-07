@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row page">
            <div class="col-md-12 page-title">
                <h1><a class="prev-link" href="{{ referrer_url('last_person_index', route('persons.index')) }}"><i
                                class="fa fa-caret-left"></i></a> Person erstellen</h1>
            </div>
            <div class="col-md-12 page-content">
                @include('info')
                <form action="{{ route('persons.store') }}" class="form-horizontal"
                      method="POST">
                    {{ csrf_field() }}
                    <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                        <label class="col-sm-2 control-label">Nachname</label>
                        <div class="col-sm-10">
                            <input class="form-control" name="last_name"
                                   value="{{ old('last_name', '') }}">
                            @if ($errors->has('last_name'))
                                <span class="help-block">
                                            <strong>{{ $errors->first('last_name') }}</strong>
                                        </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                        <label class="col-sm-2 control-label">Vorname</label>
                        <div class="col-sm-10">
                            <input class="form-control" name="first_name"
                                   value="{{ old('first_name', '') }}">
                            @if ($errors->has('first_name'))
                                <span class="help-block">
                                            <strong>{{ $errors->first('first_name') }}</strong>
                                        </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('birth_date') ? ' has-error' : '' }}">
                        <label class="col-sm-2 control-label">Geburtsdatum</label>
                        <div class="col-sm-10">
                            <input class="form-control" name="birth_date"
                                   value="{{ old('birth_date', '') }}" placeholder="Format: 24.01.1781">
                            @if ($errors->has('birth_date'))
                                <span class="help-block">
                                            <strong>{{ $errors->first('birth_date') }}</strong>
                                        </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('death_date') ? ' has-error' : '' }}">
                        <label class="col-sm-2 control-label">Todesdatum</label>
                        <div class="col-sm-10">
                            <input class="form-control" name="death_date"
                                   value="{{ old('death_date', '') }}" placeholder="Format: 24.01.1781">
                            @if ($errors->has('death_date'))
                                <span class="help-block">
                                            <strong>{{ $errors->first('death_date') }}</strong>
                                        </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('bio_data') ? ' has-error' : '' }}">
                        <label class="col-sm-2 control-label">Biographische Daten</label>
                        <div class="col-sm-10">
                            <input class="form-control" name="bio_data"
                                   value="{{ old('bio_data', '') }}">
                            @if ($errors->has('bio_data'))
                                <span class="help-block">
                                            <strong>{{ $errors->first('bio_data') }}</strong>
                                        </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('bio_data_source') ? ' has-error' : '' }}">
                        <label class="col-sm-2 control-label">Quelle der biogr. Daten</label>
                        <div class="col-sm-10">
                            <input class="form-control" name="bio_data_source"
                                   value="{{ old('bio_data_source', '') }}">
                            @if ($errors->has('bio_data_source'))
                                <span class="help-block">
                                            <strong>{{ $errors->first('bio_dat_source') }}</strong>
                                        </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('add_bio_data') ? ' has-error' : '' }}">
                        <label class="col-sm-2 control-label">zusätzl. Daten</label>
                        <div class="col-sm-10">
                            <input class="form-control" name="add_bio_data"
                                   value="{{ old('add_bio_data', '') }}">
                            @if ($errors->has('add_bio_data'))
                                <span class="help-block">
                                            <strong>{{ $errors->first('add_bio_data') }}</strong>
                                        </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('source') ? ' has-error' : '' }}">
                        <label class="col-sm-2 control-label">Quelle</label>
                        <div class="col-sm-10">
                            <input class="form-control" name="source" value="{{ old('source', '') }}">
                            @if ($errors->has('source'))
                                <span class="help-block">
                                            <strong>{{ $errors->first('source') }}</strong>
                                        </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('is_organization') ? ' has-error' : '' }}">
                        <label class="col-sm-2 control-label">Organisation</label>
                        <div class="col-sm-10">
                            <label class="radio-inline">
                                <input type="radio" name="is_organization" id="is_organization1"
                                       value="0" {{ checked(old('is_organization', 0), 0) }}>
                                Nein
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="is_organization" id="is_organization2"
                                       value="1" {{ checked(old('is_organization', 0), 1) }}>
                                Ja
                            </label>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('auto_generated') ? ' has-error' : '' }}">
                        <label class="col-sm-2 control-label">Generiert</label>
                        <div class="col-sm-10">
                            <label class="radio-inline">
                                <input type="radio" name="auto_generated" id="auto_generated1"
                                       value="0" {{ checked(old('auto_generated', 0), 0) }}>
                                Nein
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="auto_generated" id="auto_generated2"
                                       value="1" {{ checked(old('auto_generated', 0), 1) }}>
                                Ja
                            </label>

                        </div>
                    </div>
                    <div class="button-bar row">
                        <div class="col-sm-10 col-md-offset-2">
                            <button type="submit" class="btn btn-primary">Speichern</button>
                            <a href="{{ referrer_url('last_person_index', route('persons.index')) }}"
                               class="btn btn-link">Abbrechen</a>
                        </div>
                    </div>
                </form>
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