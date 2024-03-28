<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Commandes</title>
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

        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="pagetitle">
                        <h1>Liste des commandes</h1>
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                                <li class="breadcrumb-item active">Gestion des commandes</li>
                            </ol>
                        </nav>
                    </div><!-- End Page Title -->
                </div>
                <div class="col-md-6">
                    <div class="search-bar">
                        <form class="d-flex align-items-center" {{--action="{{ route('search-client') }}"--}} method="GET">
                            <input type="text" name="search" class="form-control me-1"
                                placeholder="Chercher une commande">
                            <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
                        </form>
                    </div><!-- End Search Bar -->
                </div>
            </div>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nom client</th>
                    <th scope="col">Tel client</th>
                    <th scope="col">Montant</th>
                    <th scope="col">Date de commande</th>
                    <th scope="col">Statut</th>
                    <th scope="col">Détails</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($commands as $command)
                    <tr>
                        <th scope="row">{{ $command->id }}</th>
                        <td>{{ $command->client->last_name }} {{ $command->client->first_name }}</td>
                        <td>{{ $command->client->phone_number }}</td>
                        <td>{{ $command->total_price }} DA</td>
                        <td>{{ $command->created_at->format('d/m/Y') }}</td>
                        @if ($command->type == 'pending')
                            <td><span class="badge bg-warning">En attente</span></td>
                        @elseif($command->type == 'done')
                            <td><span class="badge bg-success">Confirmé</span></td>
                        @else
                            <td><span class="badge bg-danger">Annulé</span></td>
                        @endif
                        <td>
                            <button onclick="window.location.href='/commands/{{ $command->id }}'" type="button"
                                class="btn btn-outline-primary btn-sm">Consulter</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $commands->links('vendor.pagination.bootstrap-5') }}
    </main><!-- End #main -->


    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>


    <!-- Template Main JS File -->
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
