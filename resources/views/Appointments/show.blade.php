<?php
$date = new DateTime($appointment->date_and_time);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Info Rendez-vous</title>
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

</head>

<body>
    @include('partials._header');
    @include('partials._sideBare');
    <main id="main" class="main">
        @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ Session::get('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="pagetitle">
            <h1>Rendez-vous</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item">Gestion des Rendez-vous</li>
                    <li class="breadcrumb-item active">Rendez-vous {{ $appointment->id }}</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="card p-3">
            <!---- command details -->
            <h4 class="mb-0 mt-1 ms-1">Détails du rendez-vous</h4>
            <hr>
            @if ($appointment->status == 'pending')
                <p>rendez-vous <span class="text-warning">En attente</span></p>
            @elseif($appointment->status == 'done')
                <p>rendez-vous <span class=" text-success">terminé</span></p>
            @else
                <p>rendez-vous <span class="text-danger">Annulé</span></p>
            @endif
            <p>Client: <a
                    href="/search-client?search={{ $appointment->client->phone_number }}">{{ $appointment->client->last_name }}
                    {{ $appointment->client->first_name }} </a></p>
            <p>Date de rendez-vous: {{ $date->format('Y-m-d à H:i') }}</p>
            <div class="row">
                <div class="col-md-3">
                    <p class="m-0">Détails du rendez-vous:</p>
                </div>
                <div class="col-md-8">
                    <p class="m-0">{{ $appointment->purpose }}</p>
                </div>
            </div>

            @if ($appointment->status == 'pending')
                <div class="row g-0 mt-5">
                    <div class="col-3">
                        <form action="/appointments/{{ $appointment->id }}/reschedule" method="POST">
                            @csrf
                            @method('put')
                            <button type="submit" class="btn btn-outline-primary">Reporter le rendez-vous</button>
                        </form>
                    </div>
                    <div class="col-3">
                        <form action="/appointments/{{ $appointment->id }}/cancel" method="POST">
                            @csrf
                            @method('put')
                            <button type="submit" class="btn btn-outline-danger">Annuler le rendez-vous </button>
                        </form>
                    </div>
                    <div class="col-3">
                        <form action="/appointments/{{ $appointment->id }}/confirm" method="POST">
                            @csrf
                            @method('put')
                            <button type="submit" class="btn btn-outline-success">Rendez-vous terminé</button>
                        </form>
                    </div>
                    <div class="col text-end"> <!-- Align the form to the right -->
                        <form action="/appointments/{{ $appointment->id }}" method="POST">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>
                </div>
            @endif

        </section>

    </main><!-- End #main -->


    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>


    <!-- Template Main JS File -->
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>

</body>

</html>
