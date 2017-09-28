@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row page">
            <div class="col-md-12 page-title">
                <div class="button-container">
                    <div class="search {{ request()->has('name') ? 'active' : '' }}">
                        <form action="{{ url('librarypeople') }}" method="get">
                            <input type="text" class="form-control input-sm" name="name" maxlength="64"
                                   placeholder="Suche" value="{{ request('name') ?: '' }}"/>

                            <button id="search-btn" type="submit" class="btn btn-primary btn-sm">
                                <i class="fa fa-search"></i>
                            </button>
                        </form>
                    </div>
                    @if(request()->has('name'))
                        <div class="reset-search">
                            <a href="{{ url()->filtered(['-name']) }}" class="btn btn-default btn-sm">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    @endif
                </div>

                <h1>
                    Personenregister - Grimm-Bibliothek
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="{{ route('librarybooks.index') }}" role="button" class="btn-link">
                        <span class="fa fa-university"></span>

                        Zur Bibliothek
                    </a>
                </h1>
            </div>
            @include('partials.prefixSelection', ['route' => 'library'])
            <div class="col-md-12 pagination-container">
                {{ $people->appends($filter->delta())->links() }}
            </div>
            <div class="col-md-12 list-content">
                <div class="add-button">
                    @include('partials.filterSelection')
                </div>
                <table class="table table-responsive table-hover">
                    <thead>
                    <tr>
                        <th>
                            <a href="{{ sort_link('librarypeople', 'id') }}"># {!! sort_arrow('id') !!}</a>
                        </th>
                        <th>
                            <a href="{{ sort_link('librarypeople', 'name') }}">{{ trans('librarypeople.name') }} {!! sort_arrow('name') !!}</a>
                        </th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($people->items() as $person)
                        <tr id="book-{{ $person->id }}"
                            onclick="location.href='{{ route('librarypeople.show', ['id' => $person->id]) }}'"
                            style="cursor: pointer;"
                            class="@if($person->trashed()) bg-danger @endif">
                            <td width="15%">{{ $person->id }}</td>
                            <td>{{ $person->name }}</td>
                            <td width="5%">{{ $person->totalBookCount() }}</td>
                            <th width="5%"><span class="fa fa-trash"></span></th>
                        </tr>
                    @empty
                        <tr style="cursor: pointer;">
                            <td class="empty-list" colspan="6">
                                In der Datenbank ist keine Person vorhanden.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="col-md-12 pagination-container">
                <div class="pagination-container">
                    {{ $people->appends($filter->delta())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection
