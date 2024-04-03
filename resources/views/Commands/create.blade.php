<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Ajouter Commande</title>
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
            <h1>Ajouoter une Commande</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Gestion des commandes</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <div>
            {{-- client --}}
            <div class="row">

                <div class="col align-items-center">
                    <h5>Client</h5>
                    <!-- client search input -->
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
                <div class="form-group col">
                    <h5 for="payment_method">Méthode de paiement</h5>
                    <!-- Dropdown list of payment methodes -->
                    <select class="form-control" id="payment_method" name="payment_method">
                        <option value="Chèque">Chèque</option>
                        <option value="Virement Bancaire">Virement Bancaire</option>
                        <option value="Espèce">Espèce</option>
                        <option value="En ligne">En ligne</option>
                    </select>
                </div>
            </div>

            {{-- products --}}
            <h5 class="mt-3">Ajouter des produits</h5>
            <div class="row align-items-center">
                <!-- Product search input -->
                <div class="col-md-4">
                    <input list="products" type="text" class="form-control" id="product-search"
                        placeholder="Chercher un produit">
                    <!-- Dropdown list of products (or search results) -->
                    <datalist id="products">
                        @foreach ($products as $product)
                            <option value="{{ $product->name }}" data-price="{{ $product->price }}">Stock actuel:
                                {{ $product->current_stock }}, Prix: {{ $product->price }}DA</option>
                        @endforeach
                    </datalist>
                </div>
                <!-- Quantity input -->
                <div class="col-md-4">
                    <input type="number" id="quantity-input" placeholder="Quantité" class="form-control">
                </div>
                <!-- Add Product button -->
                <div class="col-md-4">
                    <button id="add-product-btn" class="btn btn-primary">Ajouter Produit</button>
                </div>
            </div>

        </div>

        <!-- Selected Products List -->
        <div>
            <h5 class="mt-3">Produits sélectionnés :</h5>
            <ul id="selected-products-list">
                <!-- Selected products will be displayed here -->
            </ul>
        </div>
        <!-- Total price -->
        <div class="row">
            <div class="col">
                <h5 id="total-price" class="mt-3">Prix HT : 0.00 DA</h5>
            </div>
            <div class="col">
                <h5 id="total-price-ttc" class="mt-3">Prix TTC : 0.00 DA</h5>
            </div>
        </div>

        <div class=" mt-3">
            <button id="submit-btn" class="btn btn-primary me-2">Créer la commande.</button>
        </div>
    </main><!-- End #main -->


    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>


    <!-- Template Main JS File -->
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/command.js') }}"></script>

</body>

</html>
