<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Clients</title>
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

      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <div class="pagetitle">
              <h1>Liste des clients</h1>
              <nav>
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                  <li class="breadcrumb-item active">Gestion des clients</li>
                </ol>
              </nav>
            </div><!-- End Page Title -->
          </div>
          <div class="col-md-6">
            <div class="search-bar">
              <form class="d-flex align-items-center" action="{{ route('search-client') }}" method="GET">
                <input type="text" name="search" class="form-control me-1" placeholder="Chercher client">
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
                <th scope="col">Email</th>
                <th scope="col">Telephone</th>
                <th scope="col">Client depuis</th>
                <th scope="col">Détails</th>
              </tr>
            </thead>
            <tbody>
            @foreach($clients as $client)
              <tr>
                <th scope="row">{{$client->id}}</th>
                <td>{{$client->last_name}} {{$client->first_name}}</td>
                <td>{{$client->email}}</td>
                <td>{{$client->phone_number}}</td>
                <td>{{$client->created_at->format('d/m/Y')}}</td>
                <td>
                    <button onclick="window.location.href='/clients/{{$client->id}}'" type="button" class="btn btn-outline-primary btn-sm">Consulter</button>
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
          {{ $clients->links('vendor.pagination.bootstrap-5') }}
    </main><!-- End #main -->


    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>


    <!-- Template Main JS File -->
    <script src="{{ asset('jquery/jquery-3.7.1.min.js') }}"></script>
    <script src="{{asset('js/script.js')}}"></script>
    <script src="{{asset('bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('js/notifications.js') }}"></script>
</body>

</html>