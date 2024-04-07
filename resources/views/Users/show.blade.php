<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Info User</title>
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
        @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ Session::get('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="pagetitle">
            <h1>Profile</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item">Gestion des utilisateurs</li>
                    <li class="breadcrumb-item active">User {{ $user->id }}</li>
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
                                        data-bs-target="#profile-overview">Overview</button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link " data-bs-toggle="tab"
                                        data-bs-target="#profile-edit">Modifier profile</button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link " data-bs-toggle="tab"
                                        data-bs-target="#Clients-historique">Clients</button>
                                </li>
                                
                                <li class="nav-item">
                                    <button class="nav-link " data-bs-toggle="tab"
                                        data-bs-target="#Commands-historique">Commandes</button>
                                </li>
                            </ul>
                            <div class="tab-content pt-2">
                                {{-- Show client details --}}
                                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                    <h5 class="card-title">Profile Details</h5>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Nom d'utilisateur</div>
                                        <div class="col-lg-9 col-md-8">{{ $user->username }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Nom complet</div>
                                        <div class="col-lg-9 col-md-8">{{ $user->full_name }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label ">Privilege</div>
                                        <div class="col-lg-9 col-md-8">{{ $user->privilege }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">User depuis</div>
                                        <div class="col-lg-9 col-md-8">{{ $user->created_at->format('d-m-Y') }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Notes</div>
                                        <div class="col-md-8 col-lg-9">
                                            <textarea name="notes" id="notes" class="form-control" style="height: 50"readonly></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <p>N° des clients: <span
                                                    class="text-primary">{{ $clients->count() }}</span></p>
                                        </div>
                                        <div class="col">
                                            <p>N° des commandes: <span
                                                    class="text-warning">{{ $commands->count() }}</span></p>
                                        </div>
                                        <div class="col">
                                            <p>N° des vents: <span class="text-success">{{ $nbSales }}</span></p>
                                        </div>
                                    </div>
                                    {{-- <div class="col-lg-9 mt-5 col-md-8 d-flex justify-content-center">
                                        <form method="POST" action="/clients/{{ $client->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Supprimer le client</button>
                                        </form>
                                    </div> --}}

                                </div>
                                {{-- client details ends --}}

                                {{-- Edit client --}}
                                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                                    <!-- Profile Edit Form -->
                                    <form method="POST" action="/users/{{ $user->id }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="row mb-3">
                                            <label for="full_name" class="col-md-4 col-lg-3 col-form-label">Nom
                                                complet</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="full_name" type="text" value="{{ $user->full_name }}"
                                                    class="form-control" id="full_name">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="username" class="col-md-4 col-lg-3 col-form-label">Nom
                                                d'utilisateur</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="username" type="text" value="{{ $user->username }}"
                                                    class="form-control" id="username">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="privilege"
                                                class="col-md-4 col-lg-3 col-form-label">Privilege</label>
                                            <div class="col-md-8 col-lg-9">
                                                <select name="privilege" id="privilege" class="form-select">
                                                    <option value="admin"
                                                        @if ($user->privilege == 'admin') selected @endif>Admin</option>
                                                    <option value="superuser"
                                                        @if ($user->privilege == 'superuser') selected @endif>Superuser
                                                    </option>
                                                    <option value="user"
                                                        @if ($user->privilege == 'user') selected @endif>User</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="password" class="col-md-4 col-lg-3 col-form-label">Nouveau mot
                                                de passe</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="password" type="text" value=""
                                                    class="form-control" id="password">
                                            </div>
                                        </div>

                                        {{-- <div class="row mb-3">
                                            <label for="notes"
                                                class="col-md-4 col-lg-3 col-form-label">Notes</label>
                                            <div class="col-md-8 col-lg-9">
                                                <textarea name="notes" id="notes" class="form-control" style="height: 100px">{{ $client->notes }}</textarea>
                                            </div>
                                        </div> --}}

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </form>

                                </div>
                                {{-- Edit client ends --}}

                                {{-- Show user's clietns --}}

                                <div class="tab-pane fade profile-historique pt-3"
                                    id="Clients-historique">
                                    <!-- check if the there are clients or no -->
                                    @if ($clients->count() == 0)
                                        <h4 class="ms-3">Pas de clients pour le moment</h4>
                                    @else
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Nom</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Telephone</th>
                                                <th scope="col">Start Date</th>
                                                <th scope="col">Détails</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($clients as $client)
                                                <tr>
                                                    <th scope="row">{{ $client->id }}</th>
                                                    <td>{{ $client->last_name }} {{ $client->first_name }}</td>
                                                    <td>{{ $client->email }}</td>
                                                    <td>{{ $client->phone_number }}</td>
                                                    <td>{{ $client->created_at->format('d/m/Y') }}</td>
                                                    <td>
                                                        <button onclick="window.location.href='/clients/{{ $client->id }}'" type="button"
                                                            class="btn btn-outline-primary btn-sm">Consulter</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @endif
                                </div>

                                {{-- Show user's commands --}}

                                <div class="tab-pane fade profile-historique pt-3"
                                    id="Commands-historique">
                                    <!-- check if the there are clients or no -->
                                    @if ($commands->count() == 0)
                                        <h4 class="ms-3">Pas de commandes pour le moment</h4>
                                    @else
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
                                    @endif
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
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>

</body>

</html>
