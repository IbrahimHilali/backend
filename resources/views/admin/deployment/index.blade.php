@extends('layouts.app')

@section('content')
    <div class="container" id="deployment">
        <div class="row page">
            <div class="col-md-12 page-title">
                <h1>{{ trans('admin.deployment') }}</h1>
            </div>
            <div class="col-md-12 page-content">
                <p>Die in der Verwaltungssoftware vorgenommenen Änderungen sind nicht sofort öffentlich sichtbar,
                    sondern müssen zunächst veröffentlicht werden.</p>
                <p>Drücken Sie dazu auf den Button mit der Aufschrift "Änderungen jetzt veröffentlichen", um diese
                    freizugeben.</p>
                @if (!$deployment->inProgress())
                    <button class="btn btn-success pull-right" @click="deploy($event)">Änderungen jetzt
                    veröffentlichen</button>
                    <h3>Änderungen</h3>
                    @if($deployment->last() === null)
                        <p>Es wurden noch keine Änderungen veröffentlicht!</p>
                    @endif
                @else
                    <h3>Veröffentlichung wird durchgeführt</h3>
                    <p>Die Daten werden derzeit aktualisiert, weshalb derzeit keine Änderungen veröffentlicht werden
                        können.</p>
                @endif
                <ul>
                    <li v-for="message in messages">
                        <span v-if="message.type == 'update'">Bereits @{{ message.amount }}
                            Einträge freigegeben</span>
                        <span v-if="message.type == 'start'">Freigabe gestartet</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var BASE_URL = "{{ route('admin.deployment.index') }}";
        var PUSHER_KEY = "{{ config('broadcasting.connections.pusher.key') }}";
        var PUSHER_CLUSTER = "{{ config('broadcasting.connections.pusher.options.cluster') }}";
        var USER_ID = "{{ auth()->user()->id }}";
    </script>
    <script src="{{ url('js/deployment.js') }}"></script>
@endsection
