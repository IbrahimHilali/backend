@extends('layouts.app')

@section('title', $person->fullName() . ' | ')

@section('content')
    <div class="container">
        <div class="row page">
            <div class="col-md-12 page-title">
                <h1><a class="prev-link"
                       href="{{ referrer_url('last_person_index', route('people.index'), '#person-' . $person->id) }}"><i
                                class="fa fa-caret-left"></i></a> Personendaten: {{ $person->fullName() }}</h1>
            </div>
            @if($person->trashed())
                <div class="col-md-12 deleted-record-info">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-1">
                            <div class="media">
                                <div class="media-left">
                                    <i class="fa fa-trash-o fa-5x"></i>
                                </div>
                                <div class="media-body media-middle">
                                    <h4 class="media-heading">Die Person wurde gelöscht</h4>
                                    <p>Das bedeutet, dass sie nicht mehr für die Veröffentlichung berücksichtigt wird
                                        und nicht mehr sichtbar ist.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 delete-btn-container">
                            <form action="{{ route('people.restore', [$person->id]) }}" method="POST">
                                {{ csrf_field() }}
                                <button type="submit" class="btn">Wiederherstellen</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
            <div class="col-md-12 page-content">
                <form action="{{ route('people.update', ['people' => $person->id]) }}" class="form-horizontal"
                      method="POST">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
                    @include('partials.form.field', ['field' => 'last_name', 'model' => $person, 'disabled' => $person->trashed()])
                    @include('partials.form.field', ['field' => 'first_name', 'model' => $person, 'disabled' => $person->trashed()])
                    @include('partials.form.field', ['field' => 'birth_date', 'model' => $person, 'disabled' => $person->trashed()])
                    @include('partials.form.field', ['field' => 'death_date', 'model' => $person, 'disabled' => $person->trashed()])
                    @include('partials.form.field', ['field' => 'bio_data', 'model' => $person, 'disabled' => $person->trashed()])
                    @include('partials.form.field', ['field' => 'bio_data_source', 'model' => $person, 'disabled' => $person->trashed()])
                    @include('partials.form.field', ['field' => 'add_bio_data', 'model' => $person, 'disabled' => $person->trashed()])
                    @include('partials.form.field', ['field' => 'source', 'model' => $person, 'disabled' => $person->trashed()])

                    @include('partials.form.boolean', ['field' => 'is_organization', 'model' => $person, 'disabled' => $person->trashed()])
                    @include('partials.form.boolean', ['field' => 'auto_generated', 'model' => $person, 'disabled' => $person->trashed()])

                    @unless($person->trashed())
                        <div class="button-bar row">
                            <div class="col-sm-10 col-md-offset-2">
                                <button type="submit" class="btn btn-primary">Speichern</button>
                                <a href="{{ referrer_url('last_person_index', route('people.index')) }}"
                                   class="btn btn-link">Abbrechen</a>
                            </div>
                        </div>
                    @endunless
                </form>

                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#prints" data-toggle="tab">Drucke</a>
                    </li>
                    <li>
                        <a href="#inheritances" data-toggle="tab">Nachlässe</a>
                    </li>
                    <li>
                        <a href="#references" data-toggle="tab">Referenzen</a>
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
                        @unless($person->trashed())
                            <div class="add-button">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#addPrint">
                                    <i class="fa fa-plus"></i> Druck hinzufügen
                                </button>
                            </div>
                        @endunless
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
                                base-url="{{ route('people.prints.index', [$person->id]) }}"
                                editable="{{ !$person->trashed() }}">
                            </tr>
                            </tbody>
                        </table>
                        @include('people.printDialog')
                    </div>
                    <div role="tabpanel" class="tab-pane" id="inheritances">
                        @unless($person->trashed())
                            <div class="add-button">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#addInheritance">
                                    <i class="fa fa-plus"></i> Nachlass hinzufügen
                                </button>
                            </div>
                        @endunless
                        <table class="table table-responsive">
                            <thead>
                            <tr>
                                <th colspan="3">Eintrag</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="inheritance in inheritances" is="inheritance-in-place"
                                :inheritance-id="inheritance.id" :inheritance-entry="inheritance.entry"
                                base-url="{{ route('people.inheritances.index', [$person->id]) }}"
                                editable="{{ !$person->trashed() }}">
                            </tr>
                            </tbody>
                        </table>
                        @include('people.inheritanceDialog')
                    </div>
                    <div role="tabpanel" class="tab-pane" id="references">
                        @unless($person->trashed())
                            <div class="add-button">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#addReference">
                                    <i class="fa fa-plus"></i> Referenz hinzufügen
                                </button>
                            </div>
                        @endunless
                        <table class="table table-responsive">
                            <thead>
                            <tr>
                                <th># Person</th>
                                <th>Name</th>
                                <th>Notiz</th>
                                <th class="action-column"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($person->references as $reference)
                                <tr>
                                    <td>{{ $reference->reference->id }}</td>
                                    <td>{{ $reference->reference->fullName() }}</td>
                                    <td>{{ $reference->notes }}</td>
                                    <td>ä</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="books">
                        @unless($person->trashed())
                            <div class="add-button">
                                @can('books.assign')
                                    <a href="{{ route('people.add-book', [$person->id]) }}" role="button"
                                       class="btn btn-primary btn-sm">
                                        <i class="fa fa-plus"></i> Buch hinzufügen
                                    </a>
                                @endcan
                            </div>
                        @endunless
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
                                        <a href="{{ route('people.book', [$bookAssociation->id]) }}">
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
                    @unless($person->trashed())
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <h1 class="panel-title">Gefahrenzone</h1>
                            </div>

                            <div class="panel-body">
                                <p>
                                <form id="danger-zone" action="{{ route('people.destroy', ['id' => $person->id]) }}"
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
                    @endunless
                @endcan
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var BASE_URL = "{{ route('people.show', [$person->id]) }}";
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
