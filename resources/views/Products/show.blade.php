<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Info Produit</title>
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
        <div class="pagetitle">
            <h1>Détails du produit</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item">Gestion des Produits</li>
                    <li class="breadcrumb-item active">Produit {{$product->id}}</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section profile">
            <div class="row">
                <div class="col-md-12">

                    <div class="card">
                        <div class="card-body pt-3">
                            <!-- Bordered Tabs -->
                            <ul class="nav nav-tabs nav-tabs-bordered">

                                <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="tab"
                                        data-bs-target="#profile-overview">Vue générale</button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link " data-bs-toggle="tab"
                                        data-bs-target="#profile-edit">Modifier produit</button>
                                </li>

                            </ul>
                            <div class="tab-content pt-2">
                                {{-- Show Product details --}}
                                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                    <h5 class="card-title">Détails du produit</h5>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label ">Nom</div>
                                        <div class="col-lg-9 col-md-8">{{ $product->name }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Catégorie</div>
                                        <div class="col-lg-9 col-md-8">{{ $product->category->name }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Prix</div>
                                        <div class="col-lg-9 col-md-8">{{ $product->price }} DA</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Prix d'achat</div>
                                        <div class="col-lg-9 col-md-8">{{ $product->purchase_price }} DA</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Stock actuel</div>
                                        <div class="col-lg-9 col-md-8">{{ $product->current_stock }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">En suspens</div>
                                        <div class="col-lg-9 col-md-8">{{ $product->on_hold }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Stock minimum</div>
                                        <div class="col-lg-9 col-md-8">{{ $product->minimum_stock }}</div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Vendu</div>
                                        <div class="col-lg-9 col-md-8">{{ $product->sold }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Description</div>
                                        <div class="col-lg-9 col-md-8">{{ $product->description }}</div>
                                    </div>
                                    
                                    <div class="col-lg-9 mt-5 col-md-8 d-flex justify-content-center">
                                        <form id="delete-product-form" method="POST" action="/products/{{ $product->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Supprimer le product</button>
                                        </form>
                                    </div>
                                </div>
                                {{-- Product details ends --}}

                                {{-- Edit Product --}}
                                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                                    <!-- Product Edit Form -->
                                    <form method="POST" action="/products/{{ $product->id }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="row mb-3">
                                            <label for="name" class="col-md-4 col-lg-3 col-form-label">Nom</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="name" type="text" value="{{ $product->name }}"
                                                    class="form-control" id="name">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="category" class="col-md-4 col-lg-3 col-form-label">Catégorie</label>
                                            <div class="col-md-3">
                                                <select name="category_id" class="form-control" id="category">
                                                    <option value="{{$product->category->id}}">{{$product->category->name}}</option>
                                                    @foreach ($categories as $category)
                                                        @if ($category->id == $product->category->id)
                                                            @continue
                                                        @endif
                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="price" class="col-md-4 col-lg-3 col-form-label">Prix</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="price" type="number" step="0.01"
                                                    value="{{ $product->price }}" class="form-control"
                                                    id="price">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="purchase_price" class="col-md-4 col-lg-3 col-form-label">Prix d'achat</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="purchase_price" type="number" step="0.01"
                                                    value="{{ $product->purchase_price }}" class="form-control"
                                                    id="purchase_price">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="current_stock" class="col-md-4 col-lg-3 col-form-label">Stock
                                                actuel</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="current_stock" type="number"
                                                    value="{{ $product->current_stock }}" class="form-control"
                                                    id="current_stock">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="minimum_stock" class="col-md-4 col-lg-3 col-form-label">Stock
                                                minimum</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="minimum_stock" type="number"
                                                    value="{{ $product->minimum_stock }}" class="form-control"
                                                    id="minimum_stock">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="description"
                                                class="col-md-4 col-lg-3 col-form-label">Description</label>
                                            <div class="col-md-8 col-lg-9">
                                                <textarea name="description" id="description" class="form-control" style="height: 100px">{{ $product->description }}</textarea>
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </form><!-- End Product Edit Form -->


                                </div>

                            </div><!-- End Bordered Tabs -->

                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main><!-- End #main -->


    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>


    <!-- Template Main JS File -->
    <script src="{{ asset('jquery/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/notifications.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#delete-product-form').on('submit', function(e) {
                e.preventDefault(); // Prevent the form from submitting immediately
                
                if (confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')) {
                    this.submit(); // Submit the form if the user confirms
                }
            });
        });
    </script>

</body>

</html>
