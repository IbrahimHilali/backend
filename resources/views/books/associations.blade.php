@extends('layouts.app')

@section('content')
    <div class="container" id="associations">
        <div class="row page">
            <div class="col-md-12 page-title">
                <h1><a class="prev-link" href="{{ route('books.show', [$book]) }}"><i
                                class="fa fa-caret-left"></i></a> Personen
                    in {{ str_limit($book->short_title, 60) }} {{-- isset($book->year) ? '(' . $book->year . ')' : '' --}}
                </h1>
            </div>
            <div class="col-md-12 page-content">
                <form class="form-horizontal">
                    @include('partials.form.field', ['field' => 'short_title', 'model' => $book, 'disabled' => true])
                    @include('partials.form.field', ['field' => 'title', 'model' => $book, 'disabled' => true])
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
                    <div class="form-group">
                        <label for="searchPerson" class="col-sm-2 control-label">Person suchen:</label>
                        <div class="col-sm-10">
                            <typeahead id="searchPerson"
                                       placeholder="Person suchen"
                                       src="{{ url('people/search') }}?name="
                                       :prepare-response="prepareResponse"
                                       :on-hit="personSelected"
                                       result="person"
                                       template-name="person"
                                       template="@{{ item.last_name }}, @{{ item.first_name }} <em class='pull-right'>@{{ item.bio_data }}</em>"
                                       empty="Es wurde keine Person gefunden!"
                            >
                            </typeahead>
                        </div>
                    </div>
                </form>

                <form action="{{ route('books.associations.store', [$book->id]) }}" class="form-horizontal"
                      method="POST">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('person') ? ' has-error' : '' }}">
                        <input type="hidden" name="person" :value="person.id">
                        <label class="col-sm-2 control-label">Person</label>
                        <div class="col-sm-5">
                            <input class="form-control" readonly
                                   :value="person.last_name">
                        </div>
                        <div class="col-sm-5">
                            <input class="form-control" readonly
                                   :value="person.first_name">
                        </div>
                    </div>

                    <div class="form-group" v-if="person">
                        <div class="col-sm-offset-2 col-sm-5">
                            <input class="form-control" readonly
                                   :value="person.bio_data">
                        </div>
                        <div class="col-sm-5">
                            <input class="form-control" readonly
                                   :value="person.source">
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

                    <div class="form-group{{ $errors->has('page') || $errors->has('page_to') || $errors->has('line') ? ' has-error' : '' }}">
                        <label class="col-sm-2 control-label">Seite</label>
                        <div class="col-sm-2">
                            <input class="form-control" name="page"
                                   v-el:page-field
                                   value="{{ old('page') }}">
                        </div>
                        <label class="col-sm-1 control-label" style="text-align: center;">bis</label>
                        <div class="col-sm-2">
                            <input class="form-control" name="page_to"
                                   value="{{ old('page_to') }}">
                        </div>
                        <label class="col-sm-2 control-label">Zeile</label>
                        <div class="col-sm-3">
                            <input class="form-control" name="line"
                                   value="{{ old('line') }}">
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('page') || $errors->has('page_to') || $errors->has('line') ? ' has-error' : '' }}">
                        <div class="col-sm-offset-2 col-sm-10">
                            @if ($errors->has('page'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('page') }}</strong>
                                </span>
                            @endif

                            @if ($errors->has('page_to'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('page_to') }}</strong>
                                </span>
                            @endif

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
                            <a href="{{ route('books.show', [$book->id]) }}#books"
                               class="btn btn-link">Abbrechen</a>
                        </div>
                    </div>
                </form>

                <table class="table table-striped" id="associations">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Vorkommen</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($persons as $person)
                        <tr>
                            <td>{{ $person->last_name }}, {{ $person->first_name }}</td>
                            <td>
                                <p data-toggle="collapse" data-target="#associations-{{ $person->id }}"
                                   aria-expanded="false"
                                   class="collapsed collapse-head">
                                    {{ $person->bookAssociations->count() }} Vorkommen, erstes auf
                                    Seite {{ $person->bookAssociations[0]->page }}
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
                            <td>
                                <button @click="fillOccurrenceForm({{ $person }})" class="btn btn-sm btn-primary">
                                <i class="fa fa-plus"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var BASE_URL = "{{ route('books.show', [$book->id]) }}";
    </script>
    <script src="{{ url('js/associations.js') }}"></script>
    <script>

        // Tab auto selection
        var url = document.location.toString();
        if (url.match('#')) {
            $('.nav-tabs a[href="#' + url.split('#')[1] + '"]').tab('show');
        }

        $('.nav-tabs a').on('shown.bs.tab', function (e) {
            window.location.hash = e.target.hash;
        });
    </script>
@endsection
