@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row page">
            <div class="col-md-12 page-title">
                <h1><a class="prev-link" href="{{ referrer_url('last_book_index', route('books.index'), "#book-" . $book->id) }}"><i
                                class="fa fa-caret-left"></i></a> Buchdaten</h1>
            </div>
            <div class="col-md-12 list-content">
                <div class="panel-body">
                    <form class="form-horizontal" action="{{ route('books.update', ['id' => $book->id]) }}"
                          method="post">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

                        @include('partials.form.field', ['field' => 'title', 'model' => $book])
                        @include('partials.form.field', ['field' => 'short_title', 'model' => $book])
                        {{-- @include('partials.form.field', ['field' => 'year', 'model' => $book]) --}}
                        @include('partials.form.field', ['field' => 'volume', 'model' => $book])
                        @include('partials.form.field', ['field' => 'volume_irregular', 'model' => $book])
                        @include('partials.form.field', ['field' => 'edition', 'model' => $book])
                        @include('partials.form.field', ['field' => 'source', 'model' => $book])
                        @include('partials.form.textarea', ['field' => 'notes', 'model' => $book])


                        @include('partials.form.boolean', ['field' => 'grimm', 'model' => $book])

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
                                <a href="{{ route('people.show', ['id' => $personAssociation->person->id]) }}">{{ $personAssociation->person->id }}</a>
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
                                <a href="{{ route('people.book', [$personAssociation->id]) }}"
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
