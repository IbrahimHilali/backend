@extends('layouts.app')

@section('title', $person->name . ' | ')

@section('content')
    <div class="container" id="library">
        <div class="row page">
            <div class="col-md-12 page-title">
                <h1>Personendaten: {{ $person->name }}</h1>
            </div>

            @if($person->trashed())
                <div class="col-md-12 deleted-record-info">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-1">
                            <div class="media">
                                <div class="media-left">
                                    <i class="fa fa-trash-o fa-5x"></i>
                                </div>
                                <div class="media-body media-middle">
                                    <h4 class="media-heading">Die Person wurde gelöscht</h4>
                                    <p>Das bedeutet, dass sie nicht mehr sichtbar ist.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 delete-btn-container">
                            <form action="{{-- route('librarypeople.restore', [$person->id]) --}}" method="POST">
                                {{ csrf_field() }}
                                <button type="submit" disabled class="btn">Wiederherstellen</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-md-12 page-content">
                <form class="form-horizontal" onsubmit="alert('coming soon...'); return false;">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}

                    @include('partials.form.field', ['field' => 'name', 'model' => $person])
                    @include('partials.form.field', ['field' => 'note', 'model' => $person])

                    @unless($person->trashed())
                        <div class="form-group">
                            <div class="col-sm-10 col-sm-offset-2">
                                @can('library.update')
                                    <button type="submit" class="btn btn-primary">
                                        <span class="fa fa-floppy-o"></span>
                                        Speichern
                                    </button>

                                    <button type="reset" class="btn btn-link">
                                        Änderungen zurücksetzen
                                    </button>

                                    <a href="{{ route('librarypeople.combine', [$person]) }}" class="btn btn-danger"
                                       onclick="return confirm('Achtung! Diese Person wirklich zusammen führen?')">
                                        <span class="fa fa-exclamation-triangle"></span>
                                        Person mit anderer zusammenführen
                                    </a>
                                @endcan
                            </div>
                        </div>
                    @endunless
                </form>

                <hr>

                <h3>Verfasst</h3>

                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Kurztitel</th>
                        <th>Titel</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($person->written as $book)
                        <tr onclick="location.href='{{ route('librarybooks.show', [$book]) }}'"
                            style="cursor: pointer;">
                            <td>{{ $book->id }}</td>
                            <td>{{ $book->shorttitle }}</td>
                            <td>{{ \Illuminate\Support\Str::words($book->title, 20) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="text-align: center;">kein Buch verfasst</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                <hr>

                <h3>Herausgegeben</h3>

                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Kurztitel</th>
                        <th>Titel</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($person->edited as $book)
                        <tr onclick="location.href='{{ route('librarybooks.show', [$book]) }}'"
                            style="cursor: pointer;">
                            <td>{{ $book->id }}</td>
                            <td>{{ $book->shorttitle }}</td>
                            <td>{{ \Illuminate\Support\Str::words($book->title, 20) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="text-align: center;">kein Buch herausgegeben</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                <hr>

                <h3>Übersetzt</h3>

                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Kurztitel</th>
                        <th>Titel</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($person->translated as $book)
                        <tr onclick="location.href='{{ route('librarybooks.show', [$book]) }}'"
                            style="cursor: pointer;">
                            <td>{{ $book->id }}</td>
                            <td>{{ $book->shorttitle }}</td>
                            <td>{{ \Illuminate\Support\Str::words($book->title, 20) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="text-align: center;">kein Buch übersetzt</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                <hr>

                <h3>Illustiert</h3>

                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Kurztitel</th>
                        <th>Titel</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($person->illustrated as $book)
                        <tr onclick="location.href='{{ route('librarybooks.show', [$book]) }}'"
                            style="cursor: pointer;">
                            <td>{{ $book->id }}</td>
                            <td>{{ $book->shorttitle }}</td>
                            <td>{{ \Illuminate\Support\Str::words($book->title, 20) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="text-align: center;">kein Buch illustriert</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                <div>
                    @include('logs.entity-activity', ['entity' => $person])
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ url('js/library.js') }}"></script>
@endsection
