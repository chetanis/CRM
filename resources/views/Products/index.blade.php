<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Produits</title>
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
                        <h1>Liste des produits</h1>
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                                <li class="breadcrumb-item active">Gestion des produits</li>
                            </ol>
                        </nav>
                    </div><!-- End Page Title -->
                </div>
                <div class="col-md-6">
                    <div class="search-bar">
                        <form class="d-flex align-items-center" action="{{-- route('search-product') --}}" method="GET">
                            <input type="text" name="search" class="form-control me-1"
                                placeholder="Chercher produit">
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
                    <th scope="col">Nom</th>
                    <th scope="col">Categorie</th>
                    <th scope="col">Stock actuel</th>
                    <th scope="col">Gérer le stock</th>
                    <th scope="col">Détails</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <th scope="row">{{ $product->id }}</th>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category }}</td>
                        <td>{{ $product->current_stock }}</td>
                        <td>
                            <button data-bs-toggle="modal" data-bs-target="#manageStockModal{{ $product->id }}"
                                type="button" class="btn btn-outline-primary btn-sm">ajouter au stock</button>
                        </td>
                        <td>
                            <button onclick="window.location.href='/products/{{$product->id}}'" type="button"
                                class="btn btn-outline-primary btn-sm">Consulter</button>
                        </td>
                    </tr>
                    <!-- Manage Stock Modal -->
                    <div class="modal fade" id="manageStockModal{{ $product->id }}" tabindex="-1"
                        aria-labelledby="manageStockModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="manageStockModalLabel">Gérer le stock de {{ $product->name }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{-- route('manage-stock', ['id' => $product->id]) --}}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="quantity" class="form-label">Quantité à ajouter:</label>
                                            <input type="number" class="form-control" id="quantity" name="quantity"
                                                required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Mettre à jour le stock</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
        {{ $products->links('vendor.pagination.bootstrap-5') }}
    </main><!-- End #main -->


    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>


    <!-- Template Main JS File -->
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
