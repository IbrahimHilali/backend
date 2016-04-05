@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row page">
            <div class="col-md-12 page-title">
                <div class="button-container">
                    <div class="generic">
                        <a href="{{ route('users.create') }}" role="button" class="btn btn-default btn-sm">
                            <span class="fa fa-plus"></span>
                            {{ trans('users.store') }}
                        </a>
                    </div>
                </div>
                <h1>Benutzerverwaltung</h1>
            </div>
            <div class="col-md-12 tabs-container">

                <ul class="nav nav-tabs nav-justified" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#users" aria-controls="users" role="tab"
                           data-toggle="tab">{{ trans('users.users') }}</a>
                    </li>
                    <li role="presentation">
                        <a href="#roles" aria-controls="roles" role="tab"
                           data-toggle="tab">{{ trans('users.roles.title') }}</a>
                    </li>
                    {{-- <li role="presentation">
                        <a href="#permissions" aria-controls="permissions" role="tab"
                           data-toggle="tab">{{ trans('users.permissions') }}</a>
                    </li>--}}
                </ul>
            </div>
            <div class="col-md-12 list-content">
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="users">
                        {{ $users->links() }}
                        <table class="table table-responsive table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ trans('users.name') }}</th>
                                <th>{{ trans('users.email') }}</th>
                                <th>{{ trans('users.created_at') }}</th>
                                <th>{{ trans('users.updated_at') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users->items() as $user)
                                <tr onclick="location.href='{{ route('users.show', ['id' => $user->id]) }}'"
                                    style="cursor: pointer;">
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at->format('d.m.Y H:i:s') }}</td>
                                    <td>{{ $user->updated_at->format('d.m.Y H:i:s') }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        {{ $users->links() }}
                    </div>

                    <div role="tabpanel" class="tab-pane" id="roles">
                        <div class="add-button">
                            <a class="btn btn-primary btn-sm" href="{{ route('roles.create') }}">
                                <i class="fa fa-plus"></i> Rolle hinzufügen
                            </a>
                        </div>
                        {{ $roles->links() }}
                        <table class="table table-responsive table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ trans('users.roles.name') }}</th>
                                <th>{{ trans('users.roles.created_at') }}</th>
                                <th>{{ trans('users.roles.updated_at') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($roles->items() as $role)
                                <tr onclick="location.href='{{ route('roles.show', ['id' => $role->id]) }}'"
                                    style="cursor: pointer;">
                                    <td>{{ $role->id }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>{{ $role->created_at->format('d.m.Y H:i:s') }}</td>
                                    <td>{{ $role->updated_at->format('d.m.Y H:i:s') }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        {{ $roles->links() }}
                    </div>

                    {{-- <div role="tabpanel" class="tab-pane" id="permissions">
                        <ul class="list-group">
                            @foreach($permissions as $permission)
                                <li class="list-group-item">{{ trans($permission->name) }}</li>
                            @endforeach
                        </ul>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
@endsection