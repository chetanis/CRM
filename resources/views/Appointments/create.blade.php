<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Ajouter Rendez-vous</title>
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
        @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ Session::get('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="pagetitle">
            <h1>Ajouter un rendez-vous</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Gestion des rendez-vous</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <div>
            {{-- client --}}
            <div class="row">
                <!-- client search input -->
                <div class="col align-items-center">
                    <h5>Client :</h5>
                    <div>
                        <input list="clients" type="text" class="form-control" id="client-search"
                            placeholder="Chercher un client">
                        <!-- Dropdown list of clients (or search results) -->
                        <datalist id="clients">
                            @foreach ($clients as $client)
                                <option value="{{ $client->phone_number }}" data-id="{{ $client->id }}">
                                    {{ $client->last_name }}
                                    {{ $client->first_name }}</option>
                            @endforeach
                        </datalist>
                    </div>
                </div>
                <!-- appointmet date and time -->
                <div class="col form-group">
                    <h5 for="date_and_time">Date et heure :</h5>
                    <input type="datetime-local" name="date_and_time" id="date_and_time" class="form-control">
                </div>
            </div>
            <div class="mt-3">
                <h5 for="notes" >Détails du rendez-vous :</h5>
                <div class="col-sm-10">
                    <textarea name="details" id="details" class="form-control" style="height: 100px"></textarea>
                </div>
            </div>
        </div>



        <div class=" mt-3">
            <button id="submit-btn" class="btn btn-primary me-2">Créer le rendez-vous.</button>
        </div>
    </main><!-- End #main -->


    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>


    <!-- Template Main JS File -->
    <script src="{{ asset('jquery/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/appointment.js') }}"></script>
    <script src="{{ asset('js/notifications.js') }}"></script>

</body>

</html>
