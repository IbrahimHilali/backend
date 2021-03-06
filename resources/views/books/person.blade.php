@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row page">
            <div class="col-md-12 page-title">
                <h1>Buch-Person-Verknüpfung</h1>
            </div>
            <div class="col-md-12 page-content">
                <div class="row">
                    <div class="col-md-9">
                        <table class="table table-responsive">
                            <tr>
                                <th class="text-center">
                                    Person
                                </th>
                                <td></td>
                                <th class="text-center">
                                    Buch
                                </th>
                            </tr>
                            <tr>
                                <td class="text-center" style="width: 40%;">
                                    <a href="{{ route('people.show', [$association->person->id]) }}"
                                       data-toggle="tooltip"
                                       title="{{ trans('people.open') }}">
                                        <i class="fa fa-arrow-left"></i>
                                    </a>
                                    {{ $association->person->id }}
                                </td>
                                <td class="text-center" style="width: 20%; vertical-align: middle" rowspan="3">
                                    <span class="fa fa-user fa-2x"></span>
                                    <span class="fa fa-refresh fa-2x"></span>
                                    <span class="fa fa-book fa-2x"></span>
                                </td>
                                <td class="text-center" style="width: 40%;">
                                    {{ $association->book->id }}
                                    <a href="{{ route('books.show', [$association->book->id]) }}"
                                       data-toggle="tooltip"
                                       title="{{ trans('books.open') }}">
                                        <i class="fa fa-arrow-right"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">{{ $association->person->last_name }}</td>
                                <td class="text-center">{{ $association->book->title }}</td>
                            </tr>
                            <tr>
                                <td class="text-center">{{ $association->person->first_name }}</td>
                                <td class="text-center">{{ $association->book->short_title }}</td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    Seite {{ $association->page }}
                                    @if($association->page_to)
                                        - {{ $association->page_to }}
                                    @endif
                                    @if($association->line)
                                        <br>
                                        Zeile {{ $association->line }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    {{ $association->page_description }}
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-3">
                        <div class="thumbnail">
                            <img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iMjQyIiBoZWlnaHQ9IjIwMCIgdmlld0JveD0iMCAwIDI0MiAyMDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzEwMCV4MjAwCkNyZWF0ZWQgd2l0aCBIb2xkZXIuanMgMi42LjAuCkxlYXJuIG1vcmUgYXQgaHR0cDovL2hvbGRlcmpzLmNvbQooYykgMjAxMi0yMDE1IEl2YW4gTWFsb3BpbnNreSAtIGh0dHA6Ly9pbXNreS5jbwotLT48ZGVmcz48c3R5bGUgdHlwZT0idGV4dC9jc3MiPjwhW0NEQVRBWyNob2xkZXJfMTUzYWFkZjYzZDEgdGV4dCB7IGZpbGw6I0FBQUFBQTtmb250LXdlaWdodDpib2xkO2ZvbnQtZmFtaWx5OkFyaWFsLCBIZWx2ZXRpY2EsIE9wZW4gU2Fucywgc2Fucy1zZXJpZiwgbW9ub3NwYWNlO2ZvbnQtc2l6ZToxMnB0IH0gXV0+PC9zdHlsZT48L2RlZnM+PGcgaWQ9ImhvbGRlcl8xNTNhYWRmNjNkMSI+PHJlY3Qgd2lkdGg9IjI0MiIgaGVpZ2h0PSIyMDAiIGZpbGw9IiNFRUVFRUUiLz48Zz48dGV4dCB4PSI4OS44NTE1NjI1IiB5PSIxMDUuMzYyNSI+MjQyeDIwMDwvdGV4dD48L2c+PC9nPjwvc3ZnPg=="
                                 alt="placeholder"
                                 class="img-responsive">
                            <div class="caption">
                                <p class="text-danger text-center">
                                    Kein Scan vorhanden
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <h1 class="panel-title">Gefahrenzone</h1>
                            </div>

                            <div class="panel-body">
                                <form id="danger-zone" class="form-inline"
                                      action="{{ route('people.book.delete', [$association]) }}" method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('delete') }}
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fa fa-trash"></i>
                                        Verknüpfung aufheben
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
