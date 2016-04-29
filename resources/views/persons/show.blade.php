@extends('layouts.app')

@section('title', $person->fullName() . ' | ')

@section('content')
    <div class="container">
        <div class="row page">
            <div class="col-md-12 page-title">
                <h1><a class="prev-link" href="{{ referrer_url('last_person_index', route('persons.index'), '#person-' . $person->id) }}"><i
                                class="fa fa-caret-left"></i></a> Personendaten: {{ $person->fullName() }}</h1>
            </div>
            <div class="col-md-12 page-content">
                <form action="{{ route('persons.update', ['persons' => $person->id]) }}" class="form-horizontal"
                      method="POST">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
                    @include('partials.form.field', ['field' => 'last_name', 'model' => $person])
                    @include('partials.form.field', ['field' => 'first_name', 'model' => $person])
                    @include('partials.form.field', ['field' => 'birth_date', 'model' => $person])
                    @include('partials.form.field', ['field' => 'death_date', 'model' => $person])
                    @include('partials.form.field', ['field' => 'bio_data', 'model' => $person])
                    @include('partials.form.field', ['field' => 'bio_data_source', 'model' => $person])
                    @include('partials.form.field', ['field' => 'add_bio_data', 'model' => $person])
                    @include('partials.form.field', ['field' => 'source', 'model' => $person])

                    @include('partials.form.boolean', ['field' => 'is_organization', 'model' => $person])
                    @include('partials.form.boolean', ['field' => 'auto_generated', 'model' => $person])

                    <div class="button-bar row">
                        <div class="col-sm-10 col-md-offset-2">
                            <button type="submit" class="btn btn-primary">Speichern</button>
                            <a href="{{ referrer_url('last_person_index', route('persons.index')) }}"
                               class="btn btn-link">Abbrechen</a>
                        </div>
                    </div>
                </form>

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
                        <div class="add-button">
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                    data-target="#addPrint">
                                <i class="fa fa-plus"></i> Druck hinzufügen
                            </button>
                        </div>
                        <table class="table table-responsive">
                            <thead>
                            <tr>
                                <th colspan="2">Eintrag</th>
                                <th colspan="2">Jahr</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="print in prints" is="in-place"
                                :print-id="print.id" :print-entry="print.entry" :print-year="print.year"
                                base-url="{{ route('persons.prints.index', [$person->id]) }}">
                            </tr>
                            </tbody>
                        </table>
                        <div class="modal fade" id="addPrint" role="dialog" aria-labelledby="addPrintTitle">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button class="close" data-dismiss="modal" aria-label="Schließen">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title" id="addPrintTitle">Druck hinzufügen</h4>
                                    </div>
                                    <form @submit.prevent="storePrint" id="createPrintForm"
                                          action="{{ route('persons.prints.store', ['persons' => $person->id]) }}"
                                          class="form-inline" method="POST">
                                        <div class="modal-body">
                                            {{ csrf_field() }}
                                            <div class="form-group">
                                                <label for="entry">Eintrag: </label>
                                                <input type="text" class="form-control input-sm" name="entry"
                                                       v-el:create-entry-field v-model="createEntry">
                                            </div>
                                            <div class="form-group">
                                                <label for="year">Jahr: </label>
                                                <input type="text" class="form-control input-sm" name="year"
                                                       v-model="createYear">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                                Schließen
                                            </button>
                                            <button type="submit" class="btn btn-primary">Speichern</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="inheritances">
                        <div class="add-button">
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                    data-target="#addInheritance">
                                <i class="fa fa-plus"></i> Nachlass hinzufügen
                            </button>
                        </div>
                        <table class="table table-responsive">
                            <thead>
                            <tr>
                                <th colspan="3">Eintrag</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="inheritance in inheritances" is="inheritance-in-place"
                                :inheritance-id="inheritance.id" :inheritance-entry="inheritance.entry"
                                base-url="{{ route('persons.inheritances.index', [$person->id]) }}">
                            </tr>
                            </tbody>
                        </table>
                        <div class="modal fade" id="addInheritance" role="dialog" aria-labelledby="addInheritanceTitle">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button class="close" data-dismiss="modal" aria-label="Schließen">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title" id="addInheritanceTitle">Nachlass hinzufügen</h4>
                                    </div>
                                    <form @submit.prevent="storeInheritance"
                                          action="{{ route('persons.inheritances.store', ['persons' => $person->id]) }}"
                                          class="form-inline" id="createInheritanceForm" method="POST">
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="entry">Eintrag: </label>
                                                <input type="text" class="form-control input-sm" name="entry"
                                                       v-el:create-entry-field v-model="createEntry">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                                Schließen
                                            </button>
                                            <button type="submit" class="btn btn-primary">Speichern</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="books">
                        <div class="add-button">
                            @can('books.assign')
                            <a href="{{ route('persons.add-book', [$person->id]) }}" role="button"
                               class="btn btn-primary btn-sm">
                                <i class="fa fa-plus"></i> Buch hinzufügen
                            </a>
                            @endcan
                        </div>
                        <table class="table table-responsive">
                            <thead>
                            <tr>
                                <th># Buch</th>
                                <th>Kurztitel</th>
                                <th>Titel</th>
                                <th>Seite</th>
                                <th>Zeile</th>
                                <th class="action-column"></th>
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
                                    <td class="action-column">
                                        <a href="{{ route('persons.book', [$bookAssociation->id]) }}">
                                            <i class="fa fa-link"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
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

                @can('people.delete')
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h1 class="panel-title">Gefahrenzone</h1>
                    </div>

                    <div class="panel-body">
                        <p>
                        <form id="danger-zone" action="{{ route('persons.destroy', ['id' => $person->id]) }}"
                              method="post"
                              class="form-inline">
                            {{ csrf_field() }}
                            {{ method_field('delete') }}
                            <button class="btn btn-danger">
                                <span class="fa fa-trash"></span>
                                {{ trans('people.delete') }}
                            </button>
                        </form>
                        </p>
                    </div>
                </div>
                @endcan
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var BASE_URL = "{{ route('persons.show', [$person->id]) }}";
    </script>
    <script src="{{ url('js/persons.js') }}"></script>
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
