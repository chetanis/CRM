<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Ajouter Client</title>
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
            <h1>Ajouter un client</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">Gestion des clients</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <!-- add client form -->
        <form id="clientForm" action="{{ route('clients.store') }}" method="POST">
            @csrf
            <p >Informations Personnelles :</p>
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="lastName" class="form-label">Nom <span style="color: red;">*</span></label>
                    <input name="lastName" type="text" class="form-control" id="lastName">
                </div>
                <div class="col-md-6">
                    <label for="name" class="form-label">Prenom <span style="color: red;">*</span></label>
                    <input name="name" type="text" class="form-control" id="name">
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Email <span style="color: red;">*</span></label>
                    <input name="email" type="email" class="form-control" id="email">
                </div>
                <div class="col-md-6">
                    <label for="phone" class="form-label">Numéro de téléphone <span style="color: red;">*</span></label>
                    <input name="phone" type="tel" class="form-control" id="phone">
                </div>
            </div>
            <hr>
            <p >Informations Professionnelles :</p>
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="sName" class="form-label">Nom de l'entreprise</label>
                    <input name="company" type="text" class="form-control" id="sName">
                </div>
                <div class="col-md-6">
                    <label for="job" class="form-label">Profession</label>
                    <input name="job" type="text" class="form-control" id="job">
                </div>
                <div class="col-md-6">
                    <label for="industry" class="form-label">Secteur d'activité</label>
                    <input name="industry" type="text" class="form-control" id="industry">
                </div>
            </div>
            <hr>
            <p >Informations supplémentaires :</p>
            <div class="row g-3">
                <div class="col-12">
                    <label for="inputAddress" class="form-label">Adresse</label>
                    <input name="address" type="text" class="form-control" id="inputAddress">
                </div>
                <label  class="form-label">Profils sur les réseaux sociaux</label>
                <div class="col-md-3">
                    <input name="facebook" type="text" placeholder="facebook" class="form-control" >
                </div>
                <div class="col-md-3">
                    <input name="linkedin" type="text" placeholder="LinkedIn" class="form-control" >
                </div>
                <div class="col-md-3">
                    <input name="x" type="text" placeholder="X" class="form-control" >
                </div>
                <div class="col-md-3">
                    <input name="other" type="text" placeholder="Other" class="form-control" >
                </div>
            </div>
            <hr>
            <p >Détails supplémentaires :</p>
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="leads" class="form-label">Source de prospect</label>
                    <input name="lead" type="text" class="form-control" id="leads">
                </div>
                <div class="col-md-6">
                    <label for="code_fiscal" class="form-label">Code fiscal</label>
                    <input name="code_fiscal" type="text" class="form-control" id="code_fiscal">
                </div>
                <div class="col-md-12">
                    <label for="notes" class="col-sm-2 col-form-label">Notes</label>
                    <div class="col-sm-10">
                        <textarea name="notes" id="notes" class="form-control" style="height: 100px"></textarea>
                    </div>
                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
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
                // Prevent the default form submission
                event.preventDefault();
            }
        });
    </script>

</body>

</html>