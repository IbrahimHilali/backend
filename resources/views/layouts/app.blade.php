<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title') Grimmbriefwechsel</title>

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet'
          type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link href="{{ url('css/app.css') }}" rel="stylesheet">

    <script>

        window.Laravel = {
            csrfToken: '{{ csrf_token() }}'
        };

    </script>
</head>
<body id="app-layout">
<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                Grimmbriefwechsel - Verwaltung
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                <li class="disabled"><a href="#" onclick="return false">Briefe</a></li>
                @can('people.*')
                    <li {!! active_if(request()->is('people*')) !!}>
                        <a href="{{ route('people.index') }}">{{ trans('people.people') }}</a>
                    </li>
                @endcan
                @can('books.*')
                    <li {!! active_if(request()->is('books*')) !!}>
                        <a href="{{ route('books.index') }}">{{ trans('books.books') }}</a>
                    </li>
                @endcan
                @can('library.*')
                    <li {!! active_if(request()->is('library*')) !!}>
                        <a href="{{ route('librarybooks.index') }}">{{ trans('librarybooks.library') }}</a>
                    </li>
                @endcan
                @can('admin.*')
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ trans('admin.admin') }} <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            @can('users.*')
                                <li {!! active_if(request()->is('users*')) !!}>
                                    <a href="{{ route('users.index') }}">{{ trans('users.users') }}</a>
                                </li>
                                <li class="divider"></li>
                            @endcan
                            @can('admin.deployment')
                                <li>
                                    <a href="{{ route('admin.deployment.index') }}">{{ trans('admin.deployment') }}</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <li>
                    @include('partials.backup-link')
                </li>
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li><a href="{{ url('/login') }}">Login</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ auth()->user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ route('users.show', [auth()->user()->id]) }}"><i
                                            class="fa fa-btn fa-user"></i> Profil</a></li>
                            <li class="divider"></li>
                            <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i> Logout</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
@include('info')
@yield('content')

<!-- JavaScripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script>

    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
        $('[data-toggle="popover"]').popover({html: true});

        $('#danger-zone').submit(function (ev) {
            var confirm = window.confirm("Soll dieser Datensatz wirklich gelöscht werden?");
            return confirm;
        });

        window.setTimeout(function () {
            $('.alert').alert('close');
        }, 2000);
    });
</script>

@yield('scripts')
</body>
</html>
