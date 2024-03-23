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

        <div>
            {{-- client --}}
            <h5>Client</h5>
            <div class="row align-items-center">
                <!-- client search input -->
                <div class="col-md-4">
                    <input list="clients" type="text" class="form-control" id="client-search"
                        placeholder="Chercher un client">
                    <!-- Dropdown list of clients (or search results) -->
                    <datalist id="clients">
                        @foreach ($clients as $client)
                            <option value="{{ $client->phone_number }}">{{ $client->last_name }}
                                {{ $client->first_name }}</option>
                        @endforeach
                    </datalist>
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
                            <option value="{{ $product->name }}">Stock actuel: {{ $product->current_stock }}</option>
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
            <h5 class="mt-3">Produits selectionnes</h5>
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
                    alert('Veuillez sélectionner un produit et entrer une quantité valide.');
                    return;
                }

                // Check if the product is already selected
                const existingProduct = document.querySelector(
                    `#selected-products-list li[data-name="${productName}"]`);
                if (existingProduct) {
                    const existingQuantity = parseInt(existingProduct.dataset.quantity);
                    existingProduct.dataset.quantity = existingQuantity + quantity;
                    existingProduct.textContent =
                        `${productName} - Quantité: ${existingProduct.dataset.quantity}`;
                    // Create delete button
                    const deleteButton = document.createElement('button');
                    deleteButton.textContent = 'Supprimer';
                    deleteButton.classList.add('btn', 'btn-danger','btn-sm', 'mx-5',);
                    deleteButton.addEventListener('click', function() {
                        existingProduct.remove();
                    });

                    // Append delete button to list item
                    existingProduct.appendChild(deleteButton);

                    // Append list item to selected products list
                    // selectedProductsList.appendChild(listItem);
                    
                        
                } else {
                    const listItem = document.createElement('li');
                    listItem.dataset.name = productName;
                    listItem.dataset.quantity = quantity;
                    listItem.textContent = `${productName} - Quantité: ${quantity}`;
                    selectedProductsList.appendChild(listItem);
                    // Create delete button
                    const deleteButton = document.createElement('button');
                    deleteButton.textContent = 'Supprimer';
                    deleteButton.classList.add('btn', 'btn-danger','btn-sm', 'mx-5',);
                    deleteButton.addEventListener('click', function() {
                        listItem.remove();
                    });

                    // Append delete button to list item
                    listItem.appendChild(deleteButton);

                    // Append list item to selected products list
                    selectedProductsList.appendChild(listItem);
                }

                // Reset fields
                productSearchInput.value = '';
                quantityInput.value = '';
            });
        });
    </script>

</body>

</html>
