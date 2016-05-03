@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row page">
        <div class="col-md-12 page-title">
            <h1>{{ trans('admin.publish') }}</h1>
        </div>
        <div class="col-md-12 page-content">
            <p>Die in der Verwaltungssoftware vorgenommenen Änderungen sind nicht sofort öffentlich sichtbar, sondern müssen zunächst veröffentlicht werden.</p>
            <p>Drücken Sie dazu auf den Button mit der Aufschrift "Änderungen jetzt veröffentlichen", um diese freizugeben.</p>
            <button class="btn btn-success pull-right" disabled>Änderungen jetzt veröffentlichen</button>
            <h3>Änderungen</h3>
            <p>Diese Funktion steht derzeit noch nicht zur Verfügung.</p>
        </div>
    </div>
</div>
@endsection
