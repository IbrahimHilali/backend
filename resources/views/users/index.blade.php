@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <ul class="nav nav-tabs nav-justified" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#users" aria-controls="users" role="tab" data-toggle="tab">{{ trans('users.users') }}</a>
                    </li>
                    <li role="presentation">
                        <a href="#roles" aria-controls="roles" role="tab" data-toggle="tab">{{ trans('users.roles') }}</a>
                    </li>
                    <li role="presentation">
                        <a href="#permissions" aria-controls="permissions" role="tab" data-toggle="tab">{{ trans('users.permissions') }}</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="users">
                        {{ $users->links() }}
                        <table class="table table-responsive table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ trans('users.name') }}</th>
                                <th>{{ trans('users.mail') }}</th>
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
                        todo...
                    </div>

                    <div role="tabpanel" class="tab-pane" id="permissions">
                        todo...
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection