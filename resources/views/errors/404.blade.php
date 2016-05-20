@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row page">
            <div class="col-md-12 page-title error-title">
                <h1>Fehler 404: Ressource nicht gefunden.</h1>
            </div>
            <div class="col-md-12 page-content">
                <p>Die angeforderte Ressource wurde nicht gefunden. Entweder wurde die Person, das Buch oder der Brief
                    bereits aus der Datenbank gelöscht oder es wurde eine falsche Aktion angefordert.</p>
                <h3>Möglichkeiten von hier</h3>
                <ul>
                    <li><a href="{{ route('home') }}">Zurück zur Startseite</a></li>
                    <li><a href="{{ route('people.index') }}">Zur Personenverwaltung</a></li>
                    <li><a href="{{ route('books.index') }}">Zur Bücherverwaltung</a></li>
                </ul>
            </div>
        </div>
    </div>
@endsection
