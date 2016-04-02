@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 page-title">
                <h1>Personendaten</h1>
            </div>
            <div class="col-md-12 list-content">
                <div class="panel-body">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Nachname</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="last_name" value="{{ $person->last_name }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Vorname</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="first_name" value="{{ $person->first_name }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Geburtsdatum</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="birth_date"
                                       value="{{ (!is_null($person->birth_date)) ? $person->birth_date->format('d.m.Y') : "" }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Todesdatum</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="death_date"
                                       value="{{ (!is_null($person->death_date)) ? $person->death_date->format('d.m.Y') : "" }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Biographische Daten</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="bio_data" value="{{ $person->bio_data }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Quelle der biogr. Daten</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="bio_data_source"
                                       value="{{ $person->bio_data_source }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">zusätzl. Daten</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="add_bio_data" value="{{ $person->add_bio_data }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Quelle</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="source" value="{{ $person->source }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Organisation</label>
                            <div class="col-sm-10">
                                <label class="radio-inline">
                                    <input type="radio" name="is_organization" id="is_organization1"
                                           value="0" {{ checked(old('is_organization', $person->is_organization), 0) }}>
                                    Nein
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="is_organization" id="is_organization2"
                                           value="1" {{ checked(old('is_organization', $person->is_organization), 1) }}>
                                    Ja
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Generiert</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="auto_generated"
                                       value="{{ $person->auto_generated }}">
                            </div>
                        </div>
                    </form>
                </div>

                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#prints" data-toggle="tab">Drucke</a>
                    </li>
                    <li>
                        <a href="#inheritances" data-toggle="tab">Nachlässe</a>
                    </li>
                    <li>
                        <a href="#books" data-toggle="tab">Bücher</a>
                    </li>
                    <li>
                        <a href="#information" data-toggle="tab">Informationen</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="prints">
                        <table class="table table-responsive">
                            <thead>
                            <tr>
                                <th colspan="2">Eintrag</th>
                                <th colspan="2">Jahr</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($person->prints as $print)
                                <tr is="in-place" print-id="{{ $print->id }}" print-entry="{{ $print->entry }}"
                                    print-year="{{ $print->year }}" base-url="{{ url('persons/' . $person->id . '/prints/' . $print->id) }}"></tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="inheritances">
                        <table class="table table-responsive">
                            <thead>
                            <tr>
                                <th>Eintrag</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($person->inheritances as $inheritance)
                                <tr>
                                    <td>{{ $inheritance->entry }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="books">
                        <table class="table table-responsive">
                            <thead>
                            <tr>
                                <th># Buch</th>
                                <th>Kurztitel</th>
                                <th>Titel</th>
                                <th>Seite</th>
                                <th>Zeile</th>
                                <th>Notiz</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($person->bookAssociations as $bookAssociation)
                                <tr>
                                    <td>{{ $bookAssociation->book->id }}</td>
                                    <td>{{ $bookAssociation->book->short_title }}</td>
                                    <td>{{ $bookAssociation->book->title }}</td>
                                    <td>
                                        {{ $bookAssociation->page }}
                                        @if($bookAssociation->page_to)
                                            bis {{ $bookAssociation->page_to }}
                                        @endif
                                    </td>
                                    <td>{{ $bookAssociation->line }}</td>
                                    <td>{{ $bookAssociation->page_description }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <p>
                            <a href="{{ route('persons.add-book', ['id' => $person->id]) }}" role="button"
                               class="btn btn-default">
                                Buch hinzufügen
                            </a>
                        </p>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="information">
                        <table class="table table-responsive">
                            <thead>
                            <tr>
                                <th>Code</th>
                                <th>Wert</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($person->information as $information)
                                <tr class="@if($information->code->error_generated) bg-danger @endif">
                                    <td>{{ $information->code->name }}</td>
                                    <td>{{ $information->data }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ url('js/persons.js') }}"></script>
@endsection