@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 page-title">
                <h1>Personendatenbank</h1>
            </div>
            <div class="col-md-12 pagination-container">
                {{ $persons->links() }}
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
                    @foreach($persons->items() as $person)
                        <tr onclick="location.href='{{ route('persons.show', ['id' => $person->id]) }}'" style="cursor: pointer;" class="@if($person->auto_generated) bg-warning @endif">
                            <td>{{ $person->id }}</td>
                            <td>{{ $person->last_name }}</td>
                            <td>{{ $person->first_name }}</td>
                            <td>{{ (!is_null($person->birth_date)) ? $person->birth_date->format('d.m.Y') : "" }}</td>
                            <td>{{ (!is_null($person->death_date)) ? $person->death_date->format('d.m.Y') : "" }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-md-12 pagination-container">
                <div class="pagination-container">
                    {{ $persons->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection