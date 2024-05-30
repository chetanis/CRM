<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Info Client</title>
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
            <h1>Profil du client</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item">Gestion des clients</li>
                    <li class="breadcrumb-item active">Client {{ $client->id }}</li>
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
                                        data-bs-target="#profile-overview">Aperçu
                                    </button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link " data-bs-toggle="tab"
                                        data-bs-target="#profile-edit">Modifier profil</button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link " data-bs-toggle="tab"
                                        data-bs-target="#profile-historique">Historique</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link " data-bs-toggle="tab"
                                        data-bs-target="#profile-rdv">RDVs</button>
                                </li>

                            </ul>
                            <div class="tab-content pt-2">
                                {{-- Show client details --}}
                                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                    <h5 class="card-title">Détails du profil</h5>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label ">Nom complet</div>
                                        <div class="col-lg-9 col-md-8">{{ $client->last_name }}
                                            {{ $client->first_name }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Email</div>
                                        <div class="col-lg-9 col-md-8">{{ $client->email }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Numéro de téléphone</div>
                                        <div class="col-lg-9 col-md-8">
                                            {{ empty($client->phone_number) ? '...' : $client->phone_number }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Nom de l'entreprise</div>
                                        <div class="col-lg-9 col-md-8">
                                            {{ empty($client->company_name) ? '...' : $client->company_name }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Profession</div>
                                        <div class="col-lg-9 col-md-8">
                                            {{ empty($client->job_title) ? '...' : $client->job_title }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Secteur d'activité</div>
                                        <div class="col-lg-9 col-md-8">
                                            {{ empty($client->industry) ? '...' : $client->industry }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Address</div>
                                        <div class="col-lg-9 col-md-8">
                                            {{ empty($client->address) ? '...' : $client->address }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Facebook</div>
                                        <div class="col-lg-9 col-md-8">
                                            {{ empty($client->social_media_profiles['facebook']) ? '...' : $client->social_media_profiles['facebook'] }}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Linkedin</div>
                                        <div class="col-lg-9 col-md-8">
                                            {{ empty($client->social_media_profiles['linkedin']) ? '...' : $client->social_media_profiles['linkedin'] }}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">X</div>
                                        <div class="col-lg-9 col-md-8">
                                            {{ empty($client->social_media_profiles['x']) ? '...' : $client->social_media_profiles['x'] }}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Autre</div>
                                        <div class="col-lg-9 col-md-8">
                                            {{ empty($client->social_media_profiles['other']) ? '...' : $client->social_media_profiles['other'] }}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Code fiscal</div>
                                        <div class="col-lg-9 col-md-8">
                                            {{ empty($client->code_fiscal) ? '...' : $client->code_fiscal }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Source de prospect</div>
                                        <div class="col-lg-9 col-md-8">
                                            {{ empty($client->lead_source) ? '...' : $client->lead_source }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Client depuis</div>
                                        <div class="col-lg-9 col-md-8">{{ $client->created_at->format('d-m-Y') }}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Notes</div>
                                        <div class="col-md-8 col-lg-9">
                                            <textarea name="notes" id="notes" class="form-control" style="height: 100px"readonly>{{ $client->notes }}</textarea>
                                        </div>
                                    </div>
                                    {{-- if the user is an admin --}}
                                    @if (Auth::user()->privilege == 'admin')
                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">assigné à</div>
                                            <div class="col-lg-9 col-md-8">
                                                {{ $client->assignedTo->id . '. ' . $client->assignedTo->full_name }}
                                            </div>
                                        </div>
                                        <div class="col-lg-9 mt-5 col-md-8 d-flex justify-content-center">
                                            <button data-bs-toggle="modal" data-bs-target="#changeAssignedUser"
                                                type="button" class="btn btn-primary me-3">Changer l'utilisateur
                                                assigné</button>
                                            <form id="delete-client-form" method="POST"
                                                action="/clients/{{ $client->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Supprimer le
                                                    client</button>
                                            </form>
                                        </div>
                                        <!-- change the user assigned to the client -->
                                        <div class="modal fade" id="changeAssignedUser" tabindex="-1"
                                            aria-labelledby="changeAssignedUserLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="changeAssignedUserLabel">Changer
                                                            l'utilisateur assigné à
                                                            {{ $client->last_name . ' ' . $client->first_name }}</h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="/clients/{{ $client->id }}/change-user"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="mb-3">
                                                                <div>
                                                                    <input list="users" type="text" required
                                                                        class="form-control"
                                                                        placeholder="Chercher un utilisateur"
                                                                        name="assigned_to">
                                                                    <!-- Dropdown list of users (or search user) -->
                                                                    <datalist id="users">
                                                                        @foreach ($users as $user)
                                                                            <option value="{{ $user->id }}">
                                                                                {{ $user->username . ': ' . $user->full_name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </datalist>
                                                                </div>
                                                            </div>
                                                            <button type="submit" class="btn btn-primary">Mettre à
                                                                jour</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                </div>
                                {{-- client details ends --}}

                                {{-- Edit client --}}
                                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                                    <!-- Profile Edit Form -->
                                    <form method="POST" action="/clients/{{ $client->id }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="row mb-3">
                                            <label for="lastName" class="col-md-4 col-lg-3 col-form-label">Nom</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="lastName" type="text"
                                                    value="{{ $client->last_name }}" class="form-control"
                                                    id="lastName">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="name"
                                                class="col-md-4 col-lg-3 col-form-label">Prenom</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="name" type="text"
                                                    value="{{ $client->first_name }}" class="form-control"
                                                    id="name">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="email"
                                                class="col-md-4 col-lg-3 col-form-label">Email</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="email" type="email" value="{{ $client->email }}"
                                                    class="form-control" id="email">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="phone" class="col-md-4 col-lg-3 col-form-label">Numéro de
                                                téléphone</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="phone" type="tel"
                                                    value="{{ $client->phone_number }}" class="form-control"
                                                    id="phone">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="sName" class="col-md-4 col-lg-3 col-form-label">Nom de
                                                l'entreprise</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="company" type="text"
                                                    value="{{ $client->company_name }}" class="form-control"
                                                    id="sName">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="job"
                                                class="col-md-4 col-lg-3 col-form-label">Profession</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="job" type="text"
                                                    value="{{ $client->job_title }}" class="form-control"
                                                    id="job">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="industry" class="col-md-4 col-lg-3 col-form-label">Secteur
                                                d'activité</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="industry" type="text"
                                                    value="{{ $client->industry }}" class="form-control"
                                                    id="industry">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="inputAddress"
                                                class="col-md-4 col-lg-3 col-form-label">Address</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="address" type="text" value="{{ $client->address }}"
                                                    class="form-control" id="inputAddress">
                                            </div>
                                        </div>



                                        <div class="row mb-3">
                                            <label for="facebook"
                                                class="col-md-4 col-lg-3 col-form-label">Facebook</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="facebook" type="text"
                                                    value="{{ $client->social_media_profiles['facebook'] }}"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="linkedin"
                                                class="col-md-4 col-lg-3 col-form-label">Linkedin</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="linkedin" type="text"
                                                    value="{{ $client->social_media_profiles['linkedin'] }}"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="x" class="col-md-4 col-lg-3 col-form-label">X</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="x" type="text"
                                                    value="{{ $client->social_media_profiles['x'] }}"
                                                    class="form-control">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="other"
                                                class="col-md-4 col-lg-3 col-form-label">Autre</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="other" type="text"
                                                    value="{{ $client->social_media_profiles['other'] }}"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="lead" class="col-md-4 col-lg-3 col-form-label">Source de
                                                prospect</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="lead" type="text"
                                                    value="{{ $client->lead_source }}" class="form-control"
                                                    id="leads">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="notes"
                                                class="col-md-4 col-lg-3 col-form-label">Notes</label>
                                            <div class="col-md-8 col-lg-9">
                                                <textarea name="notes" id="notes" class="form-control" style="height: 100px">{{ $client->notes }}</textarea>
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </form><!-- End Profile Edit Form -->

                                </div>

                                <div class="tab-pane fade profile-historique pt-3" id="profile-historique">
                                    {{-- check if the there are commands or no --}}
                                    @if ($commands->count() == 0)
                                        <h2>Pas de commande pour le moment</h2>
                                    @else
                                        <div class="row">
                                            <div class="col">
                                                <p>N° des commandes: <span
                                                        class="text-primary">{{ $commands->count() }}</span></p>
                                            </div>
                                            <div class="col">
                                                <p>en attente: <span class="text-warning">{{ $countPending }}</span>
                                                </p>
                                            </div>
                                            <div class="col">
                                                <p>annulées: <span class="text-danger">{{ $countCancelled }}</span>
                                                </p>
                                            </div>
                                            <div class="col">
                                                <p>confirmées: <span class="text-success">{{ $countConfirmed }}</span>
                                                </p>
                                            </div>
                                        </div>

                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th scope="col">ID</th>
                                                    <th scope="col">Date de commande</th>
                                                    <th scope="col">Montant</th>
                                                    <th scope="col">Statut</th>
                                                    <th scope="col">Détails</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($commands as $command)
                                                    <tr>
                                                        <th scope="row">{{ $command->id }}</th>
                                                        <td>{{ $command->created_at->format('d-m-Y H:i') }}</td>
                                                        <td>{{ $command->total_price }} DA</td>
                                                        @if ($command->type == 'pending')
                                                            <td><span class="badge bg-warning">En attente</span></td>
                                                        @elseif($command->type == 'done')
                                                            <td><span class="badge bg-success">Confirmé</span></td>
                                                        @else
                                                            <td><span class="badge bg-danger">Annulé</span></td>
                                                        @endif
                                                        <td><button
                                                                onclick="window.location.href='/commands/{{ $command->id }}'"
                                                                type="button"
                                                                class="btn btn-outline-primary btn-sm">Consulter</button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                </div>
                                <div class="tab-pane fade profile-rdv pt-3" id="profile-rdv">
                                    {{-- check if the there are appointments or no --}}
                                    @if ($appointments->count() == 0)
                                        <h2>Pas de rendez-vous pour le moment</h2>
                                    @else
                                        <div class="row">
                                            <div class="col">
                                                <p>N° des rendez-vous: <span
                                                        class="text-primary">{{ $appointments->count() }}</span></p>
                                            </div>
                                        </div>

                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th scope="col">ID</th>
                                                    <th scope="col">Date de rendez-vous</th>
                                                    <th scope="col">Statut</th>
                                                    <th scope="col">Détails</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($appointments as $appointment)
                                                    <tr>
                                                        <th scope="row">{{ $appointment->id }}</th>
                                                        <td>{{ $appointment->date_and_time }}</td>
                                                        @if ($appointment->status == 'pending')
                                                            <td><span class="badge bg-warning">En attente</span></td>
                                                        @elseif($appointment->status == 'done')
                                                            <td><span class="badge bg-success">Termine</span></td>
                                                        @else
                                                            <td><span class="badge bg-danger">Annulé</span></td>
                                                        @endif
                                                        <td><button
                                                                onclick="window.location.href='/appointments/{{ $appointment->id }}'"
                                                                type="button"
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
    <script src="{{ asset('jquery/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/notifications.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#delete-client-form').on('submit', function(e) {
                e.preventDefault(); // Prevent the form from submitting immediately

                if (confirm('Êtes-vous sûr de vouloir supprimer ce client ?')) {
                    this.submit(); // Submit the form if the user confirms
                }
            });
        });
    </script>

</body>

</html>
