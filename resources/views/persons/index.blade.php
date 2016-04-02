@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 page-title">
                <div class="button-container">
                    <div class="search {{ Request::has('name') ? 'active' : '' }}">
                        <form action="{{ url('persons') }}" method="get">
                            <input type="text" class="form-control input-sm" name="name" maxlength="64" placeholder="Suche" value="{{ Request::has('name') ? Request::get('name') : '' }}" />
                            <button id="search-btn" type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search"></i></button>

                        </form>
                    </div>
                    @if(Request::has('name'))
                        <div class="reset-search">
                            <a href="{{ url('persons') }}" class="btn btn-default btn-sm"><i class="fa fa-times"></i></a>
                        </div>
                    @endif
                </div>
                <h1>Personendatenbank</h1>
            </div>
            <div class="col-md-12 pagination-container">
                {{ $persons->appends(Request::except('page'))->links() }}
            </div>
            <div class="col-md-12 list-content">
                <table class="table table-responsive table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Nachname</th>
                        <th>Vorname</th>
                        <th><span class="glyphicon glyphicon-asterisk"></span></th>
                        <th>&#10013;</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($persons->items() as $person)
                        <tr onclick="location.href='{{ route('persons.show', ['id' => $person->id]) }}'" style="cursor: pointer;" class="@if($person->auto_generated) bg-warning @endif">
                            <td>{{ $person->id }}</td>
                            <td>{{ $person->last_name }}</td>
                            <td>{{ $person->first_name }}</td>
                            <td>{{ (!is_null($person->birth_date)) ? $person->birth_date->format('d.m.Y') : "" }}</td>
                            <td>{{ (!is_null($person->death_date)) ? $person->death_date->format('d.m.Y') : "" }}</td>
                        </tr>
                    @empty
                        <tr onclick="location.href='{{ route('persons.create') }}'" style="cursor: pointer;">
                            <td class="empty-list" colspan="5">In der Datenbank ist keine Person vorhanden. Möchten Sie eine erstellen?</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="col-md-12 pagination-container">
                <div class="pagination-container">
                    {{ $persons->appends(Request::except('page'))->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function() {
            // Prevent submission of search form if search input is empty
            $('#search-btn').on('click', function(ev) {
                if ($('input[name="name"]').val() == '') {
                    ev.preventDefault();
                }
            });
        })
    </script>
@endsection