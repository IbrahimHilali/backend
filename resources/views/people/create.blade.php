@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row page">
            <div class="col-md-12 page-title">
                <h1><a class="prev-link" href="{{ referrer_url('last_person_index', route('people.index')) }}"><i
                                class="fa fa-caret-left"></i></a> Person erstellen</h1>
            </div>
            <div class="col-md-12 page-content">
                <form action="{{ route('people.store') }}" class="form-horizontal"
                      method="POST">
                    {{ csrf_field() }}
                    @include('partials.form.field', ['field' => 'last_name', 'model' => 'people'])
                    @include('partials.form.field', ['field' => 'first_name', 'model' => 'people'])
                    @include('partials.form.field', ['field' => 'birth_date', 'model' => 'people'])
                    @include('partials.form.field', ['field' => 'death_date', 'model' => 'people'])
                    @include('partials.form.field', ['field' => 'bio_data', 'model' => 'people'])
                    @include('partials.form.field', ['field' => 'bio_data_source', 'model' => 'people'])
                    @include('partials.form.field', ['field' => 'add_bio_data', 'model' => 'people'])
                    @include('partials.form.field', ['field' => 'source', 'model' => 'people'])

                    @include('partials.form.boolean', ['field' => 'is_organization', 'model' => 'people'])
                    @include('partials.form.boolean', ['field' => 'auto_generated', 'model' => 'people'])

                    <div class="button-bar row">
                        <div class="col-sm-10 col-md-offset-2">
                            <button type="submit" class="btn btn-primary">Speichern</button>
                            <a href="{{ referrer_url('last_person_index', route('people.index')) }}"
                               class="btn btn-link">Abbrechen</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- <script>
        var BASE_URL = "{{ route('people.create') }}";
    </script>
    <script src="{{ url('js/persons.js') }}"></script>
    <script>

    </script>--}}
@endsection
