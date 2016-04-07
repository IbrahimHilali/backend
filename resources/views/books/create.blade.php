@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row page">
            <div class="col-md-12 page-title">
                <h1><a class="prev-link" href="{{ referrer_url('last_book_index', route('books.index')) }}"><i
                                class="fa fa-caret-left"></i></a> Buchdaten</h1>
            </div>
            <div class="col-md-12 page-content">

                <form class="form-horizontal" action="{{ route('books.store') }}"
                      method="post">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                        <label class="col-sm-2 control-label" for="inputTitle">Titel</label>
                        <div class="col-sm-10">
                            <input class="form-control" name="title" id="inputTitle"
                                   value="{{ old('title') }}">

                            @if ($errors->has('title'))
                                <span class="help-block">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('short_title') ? ' has-error' : '' }}">
                        <label class="col-sm-2 control-label" for="inputShortTitle">Kurztitel</label>
                        <div class="col-sm-10">
                            <input class="form-control" name="short_title" id="inputShortTitle"
                                   value="{{ old('short_title') }}">

                            @if ($errors->has('short_title'))
                                <span class="help-block">
                                            <strong>{{ $errors->first('short_title') }}</strong>
                                        </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('year') ? ' has-error' : '' }}">
                        <label class="col-sm-2 control-label" for="inputYear">Jahr</label>
                        <div class="col-sm-10">
                            <input class="form-control" name="year" id="inputYear"
                                   value="{{ old('year') }}">

                            @if ($errors->has('year'))
                                <span class="help-block">
                                            <strong>{{ $errors->first('year') }}</strong>
                                        </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('volume') ? ' has-error' : '' }}">
                        <label class="col-sm-2 control-label" for="inputVolume">Band</label>
                        <div class="col-sm-10">
                            <input class="form-control" name="volume" id="inputVolume"
                                   value="{{ old('volume') }}">

                            @if ($errors->has('volume'))
                                <span class="help-block">
                                            <strong>{{ $errors->first('volume') }}</strong>
                                        </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('volume_irregular') ? ' has-error' : '' }}">
                        <label class="col-sm-2 control-label" for="inputVolumeIrregular">Zusatzband</label>
                        <div class="col-sm-10">
                            <input class="form-control" name="volume_irregular" id="inputVolumeIrregular"
                                   value="{{ old('volume_irregular') }}">

                            @if ($errors->has('volume_irregular'))
                                <span class="help-block">
                                            <strong>{{ $errors->first('volume_irregular') }}</strong>
                                        </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('edition') ? ' has-error' : '' }}">
                        <label class="col-sm-2 control-label" for="inputEdition">Edition</label>
                        <div class="col-sm-10">
                            <input class="form-control" name="edition" id="inputEdition"
                                   value="{{ old('edition') }}">

                            @if ($errors->has('edition'))
                                <span class="help-block">
                                            <strong>{{ $errors->first('edition') }}</strong>
                                        </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10 col-sm-offset-2">
                            @can('books.store')
                            <button type="submit" class="btn btn-primary">
                                <span class="glyphicon glyphicon-save"></span>
                                Speichern
                            </button>

                            <a href="{{ route('books.index') }}" role="button" class="btn btn-default">
                                {{ trans('form.abort') }}
                            </a>
                            @endcan
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection