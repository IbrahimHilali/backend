@extends('layouts.app')

@section('title', $person->name . ' | ')

@section('content')
    <div class="container" id="library">
        <div class="row page">
            <div class="col-md-12 page-title">
                <h1>Personendaten: {{ $person->name }}</h1>
            </div>

            <div class="col-md-12 page-content">
                <form class="form-horizontal">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}

                    @include('partials.form.field', ['field' => 'name', 'model' => $person, 'disabled' => true])
                    @include('partials.form.field', ['field' => 'note', 'model' => $person, 'disabled' => true])

                    <hr>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Verfasst</label>
                        <div class="col-sm-10">
                            <ul class="form-control-static">
                                @forelse($person->written as $book)
                                    <li>{{ $book->title }}</li>
                                @empty
                                    <li>kein Buch verfasst</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Herausgegeben</label>
                        <div class="col-sm-10">
                            <ul class="form-control-static">
                                @forelse($person->edited as $book)
                                    <li>{{ $book->title }}</li>
                                @empty
                                    <li>kein Buch herausgegeben</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Übersetzt</label>
                        <div class="col-sm-10">
                            <ul class="form-control-static">
                                @forelse($person->translated as $book)
                                    <li>{{ $book->title }}</li>
                                @empty
                                    <li>kein Buch übersetzt</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Illustiert</label>
                        <div class="col-sm-10">
                            <ul class="form-control-static">
                                @forelse($person->illustrated as $book)
                                    <li>{{ $book->title }}</li>
                                @empty
                                    <li>kein Buch illustriert</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </form>

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
