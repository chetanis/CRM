<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Ajouter Produit</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('imgs/icons/djezzy.png') }}" rel="icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">


    <!-- stylesheets -->
    <link href="{{asset('bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href=" {{asset('css/style.css')}}" rel="stylesheet">
    <link href=" {{asset('bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">

    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body>
    @include('partials._header');
    @include('partials._sideBare');
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Ajouter un nouveau produit</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">Gestion des produits</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <!-- add Product form -->
        <form id="productForm" action="{{ route('products.store') }}" method="POST">
            @csrf
            <div class="row mb-3">
                <label for="name" class="col-md-4 col-lg-3 col-form-label">Nom du produit</label>
                <div class="col-md-5">
                    <input name="name" type="text" class="form-control" id="name">
                </div>
            </div>
            <div class="row mb-3">
                <label for="category" class="col-md-4 col-lg-3 col-form-label">Catégorie</label>
                <div class="col-md-3">
                    <input name="category" type="text" class="form-control" id="category">
                </div>
            </div>
            <div class="row mb-3">
                <label for="purchase_price" class="col-md-4 col-lg-3 col-form-label">Prix d'achat</label>
                <div class="col-md-3">
                    <input name="purchase_price" type="number" step="0.01" min="0" class="form-control" id="purchase_price">
                </div>
            </div>
            <div class="row mb-3">
                <label for="price" class="col-md-4 col-lg-3 col-form-label">Prix</label>
                <div class="col-md-3">
                    <input name="price" type="number" step="0.01" min="0" class="form-control" id="price">
                </div>
            </div>
            <div class="row mb-3">
                <label for="current_stock" class="col-md-4 col-lg-3 col-form-label">Stock actuel</label>
                <div class="col-md-3">
                    <input name="current_stock" value="0" type="number" min="0" class="form-control" id="current_stock">
                </div>
            </div>
            <div class="row mb-3">
                <label for="minimum_stock" class="col-md-4 col-lg-3 col-form-label">Stock minimum</label>
                <div class="col-md-3">
                    <input name="minimum_stock" value="0" type="number" min="0" class="form-control" id="minimum_stock">
                </div>
            </div>
            <div class="row mb-3">
                <label for="description" class="col-md-4 col-lg-3 col-form-label">Description</label>
                <div class="col-md-8">
                    <textarea name="description" id="description" class="form-control" style="height: 100px"></textarea>
                </div>
            </div>
            <div class="text-center mt-3">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
            </div>
        </form>        
        <!-- end form -->
    </main><!-- End #main -->


    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>


    <!-- Template Main JS File -->
    <script src="{{ asset('jquery/jquery-3.7.1.min.js') }}"></script>
    <script src="{{asset('js/script.js')}}"></script>
    <script src="{{asset('bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('js/notifications.js') }}"></script>
    <script>
        document.getElementById('clientForm').addEventListener('keydown', function(event) {
            // Check if the pressed key is Enter
            if (event.key === 'Enter') {
                // Prevent the form submission
                event.preventDefault();
            }
        });
    </script>

</body>

</html>