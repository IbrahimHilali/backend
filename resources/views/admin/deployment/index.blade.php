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
                <div class="pull-right">
                    <button class="btn btn-danger" @click="blankify($event)" :disabled="blankStarted">
                    <i class="fa fa-circle-o-notch fa-btn fa-spin" v-if="blankStarted"></i>
                    Veröffentlichung zurücksetzen
                    </button>
                    <button class="btn btn-success" @click="deploy($event)" :disabled="started"><i
                            class="fa fa-circle-o-notch fa-btn fa-spin" v-if="started"></i> Änderungen jetzt
                    veröffentlichen</button>
                </div>
                <h3>Änderungen</h3>
                <p v-if="blank">Es wurden noch keine Änderungen veröffentlicht!</p>
                <div class="changes" v-if="!blank && history != []">
                    <h4>Personen</h4>
                    <table class="table table-striped">
                        <tbody>
                        <tr v-for="entity in history['Grimm\\Person']">
                            <td v-if="!entity.entity.trashed">
                                <a :href="entity.entity.links.self">
                                    @{{ entity.entity.first_name }} @{{ entity.entity.last_name }}
                                </a>
                            </td>
                            <td v-if="entity.entity.trashed">
                                @{{ entity.entity.first_name }} @{{ entity.entity.last_name }} (Gelöscht)
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    @{{ history["Grimm\\Person"] | json }}
                    <h4>Bücher</h4>
                    <table class="table table-striped">
                        <tbody>
                        <tr v-for="entity in history['Grimm\\Book']">
                            <td v-if="!entity.entity.trashed">
                                <a :href="entity.entity.links.self">
                                    @{{ entity.entity.short_title }}
                                </a>
                            </td>
                            <td v-if="entity.entity.trashed">
                                @{{ entity.entity.short_title }} (Gelöscht)
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    @{{ history["Grimm\\Books"] | json }}
                </div>
                <div v-if="started">
                    <h4>Personen</h4>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped active" role="progressbar"
                             :aria-valuenow="personProgress" aria-valuemin="0" style="width: 100%;">
                            @{{ personProgress }} / @{{ people }}
                        </div>
                    </div>
                    <h4>Bücher</h4>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped active" role="progressbar"
                             :aria-valuenow="personProgress" aria-valuemin="0" style="width: 100%;">
                            @{{ bookProgress }} / @{{ books }}
                        </div>
                    </div>
                </div>
                <div v-if="done">
                    <p>Veröffentlichung abgeschlossen!</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var BASE_URL = "{{ route('admin.deployment.index') }}";
        var HISTORY_URL = "{{ route('history.since') }}";
        var PUSHER_KEY = "{{ config('broadcasting.connections.pusher.key') }}";
        var PUSHER_CLUSTER = "{{ config('broadcasting.connections.pusher.options.cluster') }}";
        var USER_ID = "{{ auth()->user()->id }}";
    </script>
    <script src="{{ url('js/deployment.js') }}"></script>
@endsection
