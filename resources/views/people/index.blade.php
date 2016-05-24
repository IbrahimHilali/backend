@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row page">
            <div class="col-md-12 page-title">
                <div class="button-container">
                    <div class="search {{ request()->has('name') ? 'active' : '' }}">
                        <form action="{{ url('people') }}" method="get">
                            <input type="text" class="form-control input-sm" name="name" maxlength="64"
                                   placeholder="Suche" value="{{ request('name') ?: '' }}"/>
                            <button id="search-btn" type="submit" class="btn btn-primary btn-sm"><i
                                        class="fa fa-search"></i></button>

                        </form>
                    </div>
                    @if(request()->has('name'))
                        <div class="reset-search">
                            <a href="{{ url('people') }}" class="btn btn-default btn-sm"><i
                                        class="fa fa-times"></i></a>
                        </div>
                    @endif
                    <div class="generic">
                        <a href="{{ route('people.create') }}" role="button" class="btn btn-default btn-sm">
                            <span class="fa fa-plus"></span>
                            {{ trans('people.store') }}
                        </a>
                    </div>
                </div>
                <h1>Personendatenbank</h1>
            </div>
            @include('partials.prefixSelection', ['route' => 'people'])
            <div class="col-md-12 pagination-container">
                {{ $people->appends(request()->except(['page', 'trash']))->links() }}
            </div>
            <div class="col-md-12 list-content">
                <div class="add-button">
                    <a href="{{ route('people.index') }}?trash={{ (int)!session('person.trash', 0) }}" type="button" class="btn btn-{{ (session('person.trash', 0)) ? 'danger' : 'default' }} btn-sm" data-toggle="tooltip" data-placement="bottom" title="Gelöschte Elemente anzeigen">
                        <i class="fa fa-trash-o"></i>
                    </a>
                </div>
                <table class="table table-responsive table-hover">
                    <thead>
                    <tr>
                        <th>
                            <a href="{{ sort_link('people', 'last_name') }}">Name {!! sort_arrow('last_name') !!}</a>
                        </th>
                        <th><a href="{{ sort_link('people', 'bio_data') }}">{{ trans('people.bio_data') }} {!! sort_arrow('bio_data') !!}</a></th>
                        <th><a href="{{ sort_link('people', 'add_bio_data') }}">{{ trans('people.add_bio_data') }} {!! sort_arrow('add_bio_data') !!}</a></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($people->items() as $person)
                        <tr id="person-{{ $person->id }}"
                            onclick="location.href='{{ route('people.show', ['id' => $person->id]) }}'"
                            style="cursor: pointer;" class="@if($person->auto_generated) bg-warning @endif @if($person->trashed()) bg-danger @endif">
                            <td>{{ $person->fullName() }}</td>
                            <td>{{ $person->bio_data }}</td>
                            <td>{{ str_limit($person->add_bio_data,50, '[...]') }}</td>
                        </tr>
                    @empty
                        <tr onclick="location.href='{{ route('people.create') }}'" style="cursor: pointer;">
                            <td class="empty-list" colspan="6">In der Datenbank ist keine Person vorhanden. Möchten Sie
                                eine erstellen?
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="col-md-12 pagination-container">
                <div class="pagination-container">
                    {{ $people->appends(request()->except(['page', 'trash']))->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function () {
            // Prevent submission of search form if search input is empty
            $('#search-btn').on('click', function (ev) {
                if ($('input[name="name"]').val() == '') {
                    ev.preventDefault();
                }
            });
        })
    </script>
@endsection
