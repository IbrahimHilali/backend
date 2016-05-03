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
            @if (!$deployment->inProgress())
                <button class="btn btn-success pull-right" disabled>Änderungen jetzt veröffentlichen</button>
                <h3>Änderungen</h3>
                @if($deployment->last() === null)
                    <p>Es wurden noch keine Änderungen veröffentlicht!</p>
                @endif
            @else
                <h3>Veröffentlichung aktiv</h3>
                <p>Die Daten werden derzeit aktualisiert, weshalb derzeit keine Änderungen veröffentlicht werden können.</p>
            @endif
        </div>
    </div>
</div>
@endsection
