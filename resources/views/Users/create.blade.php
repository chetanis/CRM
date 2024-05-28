<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Ajouter utilisateur</title>
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
            <h1>Ajouter un nouveau utilisateur</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Gestion des utilisateurs</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <!-- add Product form -->
        <form id="productForm" action="{{ route('create-user') }}" method="POST">
            @csrf
            <div class="row mb-3">
                <label for="yourUsername" class="col-md-4 col-lg-3 col-form-label">Nom d'utilisateur</label>
                <div class="col-md-3">
                    <input type="text" name="username" class="form-control" id="yourUsername" required>
                </div>
            </div>

            <div class="row mb-3">
                <label for="full_name" class="col-md-4 col-lg-3 col-form-label">Nom complet</label>
                <div class="col-md-3">
                    <input type="text" name="full_name" class="form-control" id="full_name" required>
                </div>
            </div>

            <div class="row mb-3">
                <label for="yourPassword" class="col-md-4 col-lg-3 col-form-label">mot de passe</label>
                <div class="col-md-3">
                    <input type="password" name="password" class="form-control" id="yourPassword" required>
                </div>
            </div>

            <div class="row mb-3">
                <label for="privilege" class="col-md-4 col-lg-3 col-form-label">Privilege</label>
                <div class="col-md-3">
                    <select class="form-control" id="privilege" name="privilege">
                        <option value="user">User</option>
                        <option value="superuser">Super User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
            </div>

            <label for="notes" class="col-sm-2 col-form-label">Notes</label>
            <div class="col-sm-10">
                <textarea name="notes" id="notes" class="form-control" style="height: 100px"></textarea>
            </div>

            <div class="mt-3 ms-3 row">
                <button type="submit" class="btn btn-primary col-2">Cree l'utilisateur</button>
                <button type="reset" class="btn btn-secondary col-2 ms-2">Reset</button>
            </div>
        </form>
        <!-- end form -->

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
