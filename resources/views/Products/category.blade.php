<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Catégorie</title>
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

        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="pagetitle">
                        <h1>Liste des catégories</h1>
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                                <li class="breadcrumb-item active">Gestion des produits</li>
                            </ol>
                        </nav>
                    </div><!-- End Page Title -->
                </div>
                {{-- <div class="col-md-6">
                    <div class="search-bar">
                        <form class="d-flex align-items-center" action="{{ route('search-product') }}" method="GET">
                            <input type="text" name="search" class="form-control me-1"
                                placeholder="Chercher produit">
                            <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
                        </form>
                    </div><!-- End Search Bar -->
                </div> --}}
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#createCategory">Créer une catégorie</button>
                </div>
            </div>

            <div class="modal fade" id="createCategory" tabindex="-1" aria-labelledby="createCategory"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createCategory">Créer une catégorie</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('categories.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="result" class="form-label">Nom de la nouvelle catégorie</label>
                                    <input name="name" type="text" class="form-control" id="name" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Créer la catégorie</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nom de catégorie </th>
                        <th scope="col">Nombre de produits</th>
                        <th scope="col">Modifier</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($list as $line)
                        <tr>
                            <th scope="row">{{ $line['category']->id }}</th>
                            <td>{{ $line['category']->name }}</td>
                            <td>{{ $line['products'] }}</td>
                            <td>
                                <button data-bs-toggle="modal"
                                    data-bs-target="#manageCategoyModal{{ $line['category']->id }}" type="button"
                                    class="btn btn-outline-primary btn-sm">Modifier</button>
                            </td>
                        </tr>
                        <!-- Manage category Modal -->
                        <div class="modal fade" id="manageCategoyModal{{ $line['category']->id }}" tabindex="-1"
                            aria-labelledby="manageCategoyModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="manageCategoyModalLabel">Changer le nom de
                                            {{ $line['category']->name }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('categories.update', $line['category']->id) }}"
                                            method="POST">
                                            @method('PUT')
                                            @csrf
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Nouveau nom:</label>
                                                <input type="text" class="form-control" id="name"
                                                    name="name" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Mettre à jour</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
            {{-- {{ $products->links('vendor.pagination.bootstrap-5') }} --}}
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
