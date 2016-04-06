@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row page">
            <div class="col-md-12 page-title">
                <h1>
                    @can('users.*')
                    <a class="prev-link" href="{{ route('users.index') }}"><i
                                class="fa fa-caret-left"></i></a>
                    @endcan
                    {{ trans('users.update') }}: {{ $user->name }}</h1>
            </div>
            <div class="col-md-12 page-content">
                @include('info')
                <form class="form-horizontal" action="{{ route('users.update', [$user->id]) }}" method="post">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="inputName" class="col-sm-2 control-label">{{ trans('users.name') }}</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputName" name="name"
                                   value="{{ old('name', $user->name) }}" placeholder="{{ trans('users.name') }}">

                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="inputEmail" class="col-sm-2 control-label">{{ trans('users.email') }}</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="inputEmail" name="email"
                                   value="{{ old('email', $user->email) }}" placeholder="{{ trans('users.email') }}">

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="inputPassword" class="col-sm-2 control-label">{{ trans('users.password') }}</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="inputPassword" name="password"
                                   value="{{ old('password') }}" placeholder="{{ trans('users.password') }}">

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <label for="inputPasswordConfirm"
                               class="col-sm-2 control-label">{{ trans('users.password_confirmation') }}</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="inputPasswordConfirm"
                                   name="password_confirmation"
                                   value="{{ old('password_confirmation') }}"
                                   placeholder="{{ trans('users.password_confirmation') }}">

                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    @can('users.store')
                    <div class="form-group{{ $errors->has('api_only') ? ' has-error' : '' }}">
                        <label class="col-sm-2 control-label">{{ trans('users.api_only') }}</label>
                        <div class="col-sm-10">
                            <label class="radio-inline">
                                <input type="radio" name="api_only" id="api_only1"
                                       value="0" {{ checked(old('api_only', $user->api_only), 0) }}>
                                Nein
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="api_only" id="api_only2"
                                       value="1" {{ checked(old('api_only', $user->api_only), 1) }}>
                                Ja
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            {{ trans('users.roles.name') }}
                        </label>
                        <div class="col-sm-10">
                            <select size="5" class="form-control" multiple name="roles[]" id="roles">
                                @foreach($roles as $role)
                                    <option {{ selected_if($user->roles->contains('id', $role->id)) }} value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @endcan

                    @cannot('users.store')
                    <div class="form-group{{ $errors->has('current_password') ? ' has-error' : '' }}">
                        <label for="inputCurrentPassword" class="col-sm-2 control-label">{{ trans('users.current_password') }}</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="inputCurrentPassword" name="current_password"
                                    placeholder="{{ trans('users.current_password') }}">

                            @if ($errors->has('current_password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('current_password') }}</strong>
                                </span>
                            @else
                                <span class="help-block">
                                    Bitte geben Sie zur Verifizierung Ihrer Identität hier ihr derzeitiges Passwort ein.
                                </span>
                            @endif
                        </div>
                    </div>
                    @endcannot


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