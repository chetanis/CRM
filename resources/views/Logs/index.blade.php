<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Journal d'activité</title>
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
                        <h1>Journal d'activité</h1>
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                                <li class="breadcrumb-item active">Gestion des utilisateurs</li>
                            </ol>
                        </nav>
                    </div><!-- End Page Title -->
                </div>
            </div>
        </div>
        <form method="GET" action="{{ route('logs') }}" class="mb-4">
            <div class="form-row row">
                <div class="form-group col-md-2">
                    <label for="user_id">Nom d'utilisateur</label>
                    <input type="text" class="form-control" id="user_id" name="user_id"
                        value="{{ request('user_id') }}">
                </div>
                <div class="form-group col-md-2">
                    <label for="table">Table</label>
                    <select class="form-control" id="table" name="table">
                        <option value="">Tous</option>
                        @foreach ($uniqueTables as $table)
                            <option value="{{ $table }}" {{ request('table') == $table ? 'selected' : '' }}>
                                {{ ucfirst($table) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label for="action">Action</label>
                    <select class="form-control" id="action" name="action">
                        <option value="">Tous</option>
                        @foreach ($uniqueActions as $action)
                            <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                                {{ ucfirst($action) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label for="start_date">Date de début</label>
                    <input type="date" class="form-control" id="start_date" name="start_date"
                        value="{{ request('start_date') }}">
                </div>
                <div class="form-group col-md-2">
                    <label for="end_date">Date de fin</label>
                    <input type="date" class="form-control" id="end_date" name="end_date"
                        value="{{ request('end_date') }}">
                </div>
                <div class=" col-md-1 align-self-end">
                    <button type="submit" class="btn btn-primary">Chercher</button>
                </div>
            </div>
        </form>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Date/heur</th>
                    <th scope="col">utilisateur</th>
                    <th scope="col">Actoin</th>
                    <th scope="col">details</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($logs as $log)
                    <tr>
                        <th scope="row">{{ $log->id }}</th>
                        <td>{{ $log->created_at->format('d-m-Y à H:i') }}</td>
                        <td><a href="/users/{{ $log->user_id }}"> {{ $log->user->username }}</a></td>
                        <td>{{ $log->action }}</td>
                        <td>{{ $log->details }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $logs->links('vendor.pagination.bootstrap-5') }}
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
