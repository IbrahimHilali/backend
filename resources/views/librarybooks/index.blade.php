@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row page">
            <div class="col-md-12 page-title">
                <div class="button-container">
                    <div class="search {{ request()->has('title') ? 'active' : '' }}">
                        <form action="{{ url('librarybooks') }}" method="get">
                            <input type="text" class="form-control input-sm" name="title" maxlength="64"
                                   placeholder="Suche" value="{{ request('title') ?: '' }}"/>

                            <button id="search-btn" type="submit" class="btn btn-primary btn-sm">
                                <i class="fa fa-search"></i>
                            </button>
                        </form>
                    </div>
                    @if(request()->has('title'))
                        <div class="reset-search">
                            <a href="{{ url()->filtered(['-title']) }}" class="btn btn-default btn-sm">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    @endif
                    <div class="generic">
                        <a href="{{ route('librarybooks.create') }}" role="button" class="btn btn-default btn-sm">
                            <span class="fa fa-plus"></span>
                            {{ trans('librarybooks.store') }}
                        </a>
                    </div>
                </div>
                <h1>Pers. Grimm-Bibliothek</h1>
            </div>
            @include('partials.prefixSelection', ['route' => 'library'])
            <div class="col-md-12 pagination-container">
                {{ $books->appends($filter->delta())->links() }}
            </div>
            <div class="col-md-12 list-content">
                <div class="add-button">
                    @include('partials.filterSelection')
                </div>
                <table class="table table-responsive table-hover">
                    <thead>
                    <tr>
                        <th>
                            <a href="{{ sort_link('librarybooks', 'cat_id') }}">{{ trans('librarybooks.catalog_id') }} {!! sort_arrow('cat_id') !!}</a>
                        </th>
                        <th>
                            <a href="{{ sort_link('librarybooks', 'title') }}">{{ trans('librarybooks.title') }} {!! sort_arrow('title') !!}</a>
                        </th>
                        <th>
                            <a href="{{ sort_link('librarybooks', 'denecke_teitge') }}">{{ trans('librarybooks.denecke_teitge') }} {!! sort_arrow('denecke_teitge') !!}</a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($books->items() as $book)
                        <tr id="person-{{ $book->id }}"
                            onclick="location.href='{{ route('librarybooks.show', ['id' => $book->id]) }}'"
                            style="cursor: pointer;"
                            class="@if($book->trashed()) bg-danger @endif">
                            <td width="15%">{{ $book->catalog_id }}</td>
                            <td width="40%">{{ $book->title }}</td>
                            <td width="45%">{{ $book->denecke_teitge }}</td>
                        </tr>
                    @empty
                        <tr onclick="location.href='{{ route('librarybooks.create') }}'" style="cursor: pointer;">
                            <td class="empty-list" colspan="6">
                                In der Datenbank ist kein Buch vorhanden.
                                Möchten Sie eins erstellen?
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="col-md-12 pagination-container">
                <div class="pagination-container">
                    {{ $books->appends($filter->delta())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection
