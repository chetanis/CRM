<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Info Client</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">


    <!-- stylesheets -->
    <link href="{{asset('bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href=" {{asset('css/style.css')}}" rel="stylesheet">
    <link href=" {{asset('bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">

</head>

<body>
    @include('partials._header');
    @include('partials._sideBare');
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Profile</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item">Gestion des clients</li>
                    <li class="breadcrumb-item active">Client</li>
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
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                      </li>
      
                      <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Modifier profile</button>
                      </li>
      
                      <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-historique">Historique</button>
                      </li>
      
                    </ul>
                    <div class="tab-content pt-2">
      
                      <div class="tab-pane fade show active profile-overview" id="profile-overview">
                        <h5 class="card-title">Profile Details</h5>
      
                        <div class="row">
                          <div class="col-lg-3 col-md-4 label ">Full Name</div>
                          <div class="col-lg-9 col-md-8">{{$client->last_name}} {{$client->first_name}}</div>
                        </div>
                        
                        <div class="row">
                          <div class="col-lg-3 col-md-4 label">Email</div>
                          <div class="col-lg-9 col-md-8">{{$client->email}}</div>
                        </div>
                        <div class="row">
                          <div class="col-lg-3 col-md-4 label">Phone</div>
                          <div class="col-lg-9 col-md-8">{{$client->phone_number}}</div>
                        </div>
      
                        <div class="row">
                          <div class="col-lg-3 col-md-4 label">Company</div>
                          <div class="col-lg-9 col-md-8">{{$client->company_name}}</div>
                        </div>
      
                        <div class="row">
                          <div class="col-lg-3 col-md-4 label">Job</div>
                          <div class="col-lg-9 col-md-8">{{$client->job_title}}</div>
                        </div>
      
                        <div class="row">
                          <div class="col-lg-3 col-md-4 label">Secteur d'activité</div>
                          <div class="col-lg-9 col-md-8">{{$client->industry}}</div>
                        </div>
      
                        <div class="row">
                          <div class="col-lg-3 col-md-4 label">Address</div>
                          <div class="col-lg-9 col-md-8">{{$client->address}}</div>
                        </div>
                        <div class="row">
                          <div class="col-lg-3 col-md-4 label">Facebook</div>
                          <div class="col-lg-9 col-md-8">{{empty($client->social_media_profiles['facebook']) ? 'pas de lien' : $client->social_media_profiles['facebook']}}</div>
                        </div>
                        <div class="row">
                          <div class="col-lg-3 col-md-4 label">Linkedin</div>
                          <div class="col-lg-9 col-md-8">{{ empty($client->social_media_profiles['linkedin']) ? 'pas de lien' : $client->social_media_profiles['linkedin'] }}
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-lg-3 col-md-4 label">X</div>
                          <div class="col-lg-9 col-md-8">{{empty($client->social_media_profiles['x']) ? 'pas de lien' : $client->social_media_profiles['x']}}</div>
                        </div>
                        <div class="row">
                          <div class="col-lg-3 col-md-4 label">Autre</div>
                          <div class="col-lg-9 col-md-8">{{empty($client->social_media_profiles['other']) ? 'pas de lien' : $client->social_media_profiles['other']}}</div>
                        </div>
                        <div class="row">
                          <div class="col-lg-3 col-md-4 label">Lead source</div>
                          <div class="col-lg-9 col-md-8">{{$client->lead_source}}</div>
                        </div>
                        <div class="row">
                          <div class="col-lg-3 col-md-4 label">Notes</div>
                          <div class="col-lg-9 col-md-8">{{$client->notes}}</div>
                        </div>
      
                      </div>
      
                      

                      <div class="tab-pane fade profile-historique pt-3" id="profile-historique">
      
                        <h2>bientot disponible</h2>
      
                      </div>
                    </div><!-- End Bordered Tabs -->
      
                  </div>
                </div>
      
              </div>
            </div>
          </section>

    </main><!-- End #main -->


    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>


    <!-- Template Main JS File -->
    <script src="{{asset('js/script.js')}}"></script>
    <script src="{{asset('bootstrap/js/bootstrap.bundle.min.js')}}"></script>

</body>

</html>