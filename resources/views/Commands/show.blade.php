<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Info Commnade</title>
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
            <h1>Commande</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item">Gestion des commande</li>
                    <li class="breadcrumb-item active">Commande {{ $command->id }}</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="card p-3">
            <div class="row">
                {{-- command details --}}
                <div class="col-md-6">
                    <h4>Details de la commande</h4>
                    <hr>
                    <p>N° commande : {{ $command->id }}</p>
                    <p>Date de commande : {{ $command->created_at->format('d/m/Y \à H:i') }}</p>
                    <p>Méthode de paiement : {{$command->payment_method}} </p>
                    @if ($command->type == 'pending')
                        <p>Etat de la commande : <span class="text-warning">En attente</span></p>
                    @elseif($command->type == 'done')
                        <p>Etat de la commande : <span class=" text-success">Confirmé</span></p>
                    @else
                        <p>Etat de la commande : <span class="text-danger">Annulé</span></p>
                    @endif
                </div>
                {{-- client details --}}
                <div class="col-md-6">
                    <h4>Details du client</h4>
                    <hr>
                    <p>Nom complet : {{ $command->client->last_name }} {{ $command->client->first_name }} </p>
                    <p>Email : {{ $command->client->email }}</p>
                    <p>Téléphone : {{ $command->client->phone_number }}</p>
                    <p>Adresse : {{ $command->client->address }}</p>
                </div>
            </div>
            {{-- invoice div --}}
            @if ($command->type == 'done')
            <div class="row">
                <div class="col-md-6">
                    <p>Date de confirmation: {{ $sale->created_at->format('d/m/Y \à H:i') }}</p>
                </div>
                <div class="col-md-6">
                    <a href="/sales/{{$sale->id}}" target="_blank" class="btn btn-warning me-2">Afficher la facture</a>
                    <a href="/sales/{{$sale->id}}/facture" class="btn btn-primary">Télécharger la facture</a>
                </div>
            </div>
            @endif
            {{-- product list --}}
            <div class="row mt-3">
                <div class="col-md-12">
                    <h4>Liste des produits</h4>
                    <hr>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nom</th>
                                <th scope="col">Prix unitaire</th>
                                <th scope="col">Quantité</th>
                                <th scope="col">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($productsWithQuantities as $productWithQuantity)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $productWithQuantity['product']->name }}</td>
                                    <td>{{ $productWithQuantity['product']->price }} DA</td>
                                    <td>{{ $productWithQuantity['quantity'] }}</td>
                                    <td>{{ $productWithQuantity['product']->price * $productWithQuantity['quantity'] }}
                                        DA</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-6 ms-2 mt-3">
                            <p class><b>Prix total :</b> {{ $command->total_price }} DA</p>
                        </div>
                    </div>
                    @if ($command->type == 'pending')
                        <div class="row">
                            <div class="col-3">
                                <form action="/commands/{{$command->id}}/confirm" method="POST">
                                    @csrf
                                    @method('put')
                                    <button type="submit" class="btn btn-primary">Confirmer la commande</button>
                                </form>
                            </div>
                            <div class="col-3">
                                <form action="/commands/{{$command->id}}/cancel" method="POST">
                                    @csrf
                                    @method('put')
                                    <button type="submit" class="btn btn-danger">Annuler la commande</button>
                                </form>
                            </div>
                            <div class="col text-end"> <!-- Align the form to the right -->
                                <form action="/commands/{{$command->id}}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>

    </main><!-- End #main -->


    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>


    <!-- Template Main JS File -->
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>

</body>

</html>
