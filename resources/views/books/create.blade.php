@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row page">
            <div class="col-md-12 page-title">
                <h1><a class="prev-link" href="{{ referrer_url('last_book_index', route('books.index')) }}"><i
                                class="fa fa-caret-left"></i></a> Buch hinzufügen</h1>
            </div>
            <div class="col-md-12 page-content">

                <form class="form-horizontal" action="{{ route('books.store') }}"
                      method="post">
                    {{ csrf_field() }}

                    @include('partials.form.field', ['field' => 'title', 'model' => 'books'])
                    @include('partials.form.field', ['field' => 'short_title', 'model' => 'books'])
                    {{-- @include('partials.form.field', ['field' => 'year', 'model' => 'books]) --}}
                    @include('partials.form.field', ['field' => 'volume', 'model' => 'books'])
                    @include('partials.form.field', ['field' => 'volume_irregular', 'model' => 'books'])
                    @include('partials.form.field', ['field' => 'edition', 'model' => 'books'])
                    @include('partials.form.field', ['field' => 'source', 'model' => 'books'])

                    @include('partials.form.textarea', ['field' => 'notes', 'model' => 'books'])
                    @include('partials.form.boolean', ['field' => 'grimm', 'model' => 'books'])

                    <div class="form-group">
                        <div class="col-sm-10 col-sm-offset-2">
                            @can('books.store')
                            <button type="submit" class="btn btn-primary">
                                <span class="fa fa-floppy-o"></span>
                                Speichern
                            </button>

                            <a href="{{ route('books.index') }}" role="button" class="btn btn-default">
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
