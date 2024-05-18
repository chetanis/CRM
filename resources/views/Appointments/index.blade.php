<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Rendez-vous</title>
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
                        <h1>Liste des rendez-vous</h1>
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                                <li class="breadcrumb-item active">Gestion des rendez-vous</li>
                            </ol>
                        </nav>
                    </div><!-- End Page Title -->
                </div>
                <div class="col-md-6">
                    <div class="search-bar">
                        <form class="d-flex align-items-center" {{-- action="{{ route('search-client') }}" --}} method="GET">
                            <input type="text" name="search" class="form-control me-1"
                                placeholder="Chercher un rendez-vous">
                            <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
                        </form>
                    </div><!-- End Search Bar -->
                </div>
            </div>
        </div>
        <div class="col mb-3 ms-2">

            {{-- @if (!$filter) <a href="/commands" class="btn btn-primary btn-sm">Tous</a> @else <a href="/commands" class="btn btn-outline-primary btn-sm">Tous</a> @endif
            @if ($filter=='done') <a href="/commands?type=done" class="btn btn-success btn-sm">Confirmé</a> @else <a href="/commands?type=done" class="btn btn-outline-success btn-sm">Confirmé</a> @endif
            @if ($filter=='cancelled') <a href="/commands?type=cancelled" class="btn btn-danger btn-sm">Annulé</a> @else <a href="/commands?type=cancelled" class="btn btn-outline-danger btn-sm">Annulé</a> @endif
            @if ($filter=='pending') <a href="/commands?type=pending" class="btn btn-warning btn-sm">En attente</a> @else <a href="/commands?type=pending" class="btn btn-outline-warning btn-sm">En attente</a> @endif --}}
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nom client</th>
                    <th scope="col">Tel client</th>
                    <th scope="col">Date du rendez-vous</th>
                    <th scope="col">Statut</th>
                    <th scope="col">Détails</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($appointments as $appointment)
                    <tr>
                        <th scope="row">{{ $appointment->id }}</th>
                        <td>{{ $appointment->client->last_name }} {{ $appointment->client->first_name }}</td>
                        <td>{{ $appointment->client->phone_number }}</td>
                        <td>{{ $appointment->date_and_time}}</td>
                        @if ($appointment->status == 'pending')
                            <td><span class="badge bg-warning">En attente</span></td>
                        @elseif($appointment->status == 'done')
                            <td><span class="badge bg-success">Confirmé</span></td>
                        @else
                            <td><span class="badge bg-danger">Annulé</span></td>
                        @endif
                        <td>
                            <button onclick="window.location.href='/appointments/{{ $appointment->id }}'"type="button"
                                class="btn btn-outline-primary btn-sm">Consulter</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $appointments->links('vendor.pagination.bootstrap-5') }}
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
