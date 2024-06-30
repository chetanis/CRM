<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Utilisateurs</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('imgs/icons/djezzy.png') }}" rel="icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">


    <!-- stylesheets -->
    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href=" {{ asset('css/style.css') }}" rel="stylesheet">
    <link href=" {{ asset('bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body>
    @include('partials._header');
    @include('partials._sideBare');
    <main id="main" class="main">

        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="pagetitle">
                        <h1>Liste des utilisateurs</h1>
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                                <li class="breadcrumb-item active">Gestion des utilisateurs</li>
                            </ol>
                        </nav>
                    </div><!-- End Page Title -->
                </div>
                <div class="col-md-6">
                    <div class="search-bar">
                        <form class="d-flex align-items-center" action="{{ route('search-user') }}" method="GET">
                            <input type="text" name="search" class="form-control me-1"
                                placeholder="Chercher utilisateur">
                            <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
                        </form>
                    </div><!-- End Search Bar -->
                </div>
            </div>
        </div>
        
        @if (auth()->user()->privilege !== 'master')
        <div class="col mb-3 ms-2">

            @if (!$filter)
                <a href="/users" class="btn btn-primary btn-sm">Tous</a>
            @else
                <a href="/users" class="btn btn-outline-primary btn-sm">Tous</a>
            @endif
            @if ($filter == 'admin')
                <a href="/users?type=admin" class="btn btn-danger btn-sm">Administrateur</a>
            @else
                <a href="/users?type=admin" class="btn btn-outline-danger btn-sm">Administrateur</a>
            @endif
            @if ($filter == 'superuser')
                <a href="/users?type=superuser" class="btn btn-success btn-sm">Manager</a>
            @else
                <a href="/users?type=superuser" class="btn btn-outline-success btn-sm">Manager</a>
            @endif
            @if ($filter == 'user')
                <a href="/users?type=user" class="btn btn-warning btn-sm">Agent</a>
            @else
                <a href="/users?type=user" class="btn btn-outline-warning btn-sm">Agent</a>
            @endif
        </div>
        @endif

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">nom d'utilisateur</th>
                    <th scope="col">Nom complet</th>
                    <th scope="col">Privilege</th>
                    <th scope="col">Date de début</th>
                    <th scope="col">Détails</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <th scope="row">{{ $user->id }}</th>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->full_name }}</td>
                        @if ($user->privilege == 'admin')
                            <td>Administrateur</td>
                        @elseif ($user->privilege == 'user')
                            <td>Agent</td>
                        @else
                            <td>Manger</td>
                        @endif
                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                        <td>
                            <button onclick="window.location.href='/users/{{ $user->id }}'" type="button"
                                class="btn btn-outline-primary btn-sm">Consulter</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $users->links('vendor.pagination.bootstrap-5') }}
    </main><!-- End #main -->


    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>


    <!-- Template Main JS File -->
    <script src="{{ asset('jquery/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/notifications.js') }}"></script>
</body>

</html>
