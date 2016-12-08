@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row page">
            <div class="col-md-12 page-title">
                <h1><a class="prev-link" href="{{ referrer_url('last_book_index', route('library.index')) }}"><i
                                class="fa fa-caret-left"></i></a> Buch hinzufügen</h1>
            </div>
            <div class="col-md-12 page-content">

                <form class="form-horizontal" action="{{ route('library.store') }}"
                      method="post">
                    {{ csrf_field() }}

                    @include('partials.form.field', ['field' => 'catalog_id', 'model' => 'librarybooks'])
                    @include('partials.form.field', ['field' => 'title', 'model' => 'librarybooks'])

                    <div class="form-group">
                        <div class="col-sm-10 col-sm-offset-2">
                            @can('library.store')
                            <button type="submit" class="btn btn-primary">
                                <span class="fa fa-floppy-o"></span>
                                Speichern
                            </button>

                            <a href="{{ route('library.index') }}" role="button" class="btn btn-default">
                                {{ trans('form.abort') }}
                            </a>
                            @endcan
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
