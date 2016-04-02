@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 page-title">
                <h1>{{ trans('users.roles.create') }}</h1>
            </div>
            <div class="col-md-12 page-content">
                <form class="form-horizontal" action="{{ route('roles.store') }}" method="post">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="inputName" class="col-sm-2 control-label">{{ trans('users.name') }}</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputName" name="name"
                                   value="{{ old('name') }}" placeholder="{{ trans('users.name') }}">

                            @if ($errors->has('name'))
                                <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            {{ trans('users.users') }}
                        </label>
                        <div class="col-sm-10">
                            @foreach($users as $user)
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="users[]" value="{{ $user->id }}">
                                        {{ $user->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            {{ trans('users.permissions') }}
                        </label>
                        <div class="col-sm-10">
                            @foreach($permissions as $permission)
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}">
                                        {{ trans($permission->name) }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">
                                <span class="glyphicon glyphicon-floppy-disk"></span> {{ trans('form.save') }}
                            </button>

                            <a href="{{ route('users.index') }}" role="button" class="btn btn-default">
                                {{ trans('form.abort') }}
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection