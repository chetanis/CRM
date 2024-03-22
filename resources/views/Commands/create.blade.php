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

</head>

<body>
    @include('partials._header');
    @include('partials._sideBare');
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Ajouoter une Commande</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Gestion des commandes</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <!-- Product Selection -->
        <div>
            <!-- Dropdown list of products (or search results) -->
            <h5>Ajouter des produits</h5>
            <div class="row align-items-center">
                <!-- Product search input -->
                <div class="col-md-4">
                    <input list="products" type="text" class="form-control" id="product-search"
                        placeholder="Chercher un produit">
                    <datalist id="products">
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}"></option>
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
            <h2>Selected Products</h2>
            <ul id="selected-products-list">
                <!-- Selected products will be displayed here -->
            </ul>
        </div>
    </main><!-- End #main -->


    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>


    <!-- Template Main JS File -->
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const productSearchInput = document.getElementById('product-search');
            const quantityInput = document.getElementById('quantity-input');
            const addProductBtn = document.getElementById('add-product-btn');
            const selectedProductsList = document.getElementById('selected-products-list');

            addProductBtn.addEventListener('click', function() {
                const productName = productSearchInput.value.trim();
                const quantity = parseInt(quantityInput.value);

                if (!productName || quantity <= 0) {
                    alert('Please select a product and enter a valid quantity.');
                    return;
                }

                // Check if the product is already selected
                const existingProduct = document.querySelector(
                    `#selected-products-list li[data-name="${productName}"]`);
                if (existingProduct) {
                    const existingQuantity = parseInt(existingProduct.dataset.quantity);
                    existingProduct.dataset.quantity = existingQuantity + quantity;
                    existingProduct.textContent =
                        `${productName} - Quantity: ${existingProduct.dataset.quantity}`;
                } else {
                    const listItem = document.createElement('li');
                    listItem.dataset.name = productName;
                    listItem.dataset.quantity = quantity;
                    listItem.textContent = `${productName} - Quantity: ${quantity}`;
                    selectedProductsList.appendChild(listItem);
                }

                // Reset fields
                productSearchInput.value = '';
                quantityInput.value = '';
            });

            document.getElementById('clientForm').addEventListener('keydown', function(event) {
                // Check if the pressed key is Enter
                if (event.key === 'Enter') {
                    // Prevent the default form submission
                    event.preventDefault();
                }
            });
        });
    </script>

</body>

</html>
