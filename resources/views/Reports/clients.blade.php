<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Journal d'activité</title>
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

        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="pagetitle">
                        <h1>Rapport client</h1>
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                                <li class="breadcrumb-item active">Reporting</li>
                            </ol>
                        </nav>
                    </div><!-- End Page Title -->
                </div>
            </div>
        </div>
        <section class="card">
            <div class="card-body pt-3 report">
                <h4 class="mb-0 mt-1 ms-1 ">Sélectionnez ce que vous souhaitez inclure dans le rapport.</h4>
                <hr>
                <form id="date-form" action="{{route("generate-clients-report")}}" method="POST">
                    @csrf
                    <div class="col mt-4">
                        <div class="row">
                            <div class="col-md-3 label">Sélectionnez une période:</div>
                            <div class="col-md-2">
                                <input class="form-check-input" type="radio" name="time_period" id="all_time"
                                    value="all_time" checked>
                                <label class="form-check-label" for="all_time">Tout le temps</label>
                            </div>
                            <div class="col-md-2">
                                <input class="form-check-input" type="radio" name="time_period" id="last_year"
                                    value="last_year">
                                <label class="form-check-label" for="last_year">L'année dernière</label>
                            </div>
                            <div class="col-md-2">
                                <input class="form-check-input" type="radio" name="time_period" id="last_month"
                                    value="last_month">
                                <label class="form-check-label" for="last_month">Le mois dernier</label>
                            </div>
                            <div class="col-md-2">
                                <input class="form-check-input" type="radio" name="time_period" id="custom"
                                    value="custom">
                                <label class="form-check-label" for="custom">Personnalisé</label>
                            </div>
                        </div>
                        <!-- Custom Dates -->
                        <div id="custom_dates" class="mt-3 d-none">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="mb-2" for="start_date">Date de début</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date">
                                </div>
                                <div class="col-md-6">
                                    <label class="mb-2" for="end_date">Date de fin</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date">
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <label class="col-md-3  label">Statistiques sur le nombre de clients</label>
                            <div class="col-md-2">
                                <input checked class="form-check-input" type="checkbox" name="report_options[]"value="client_stat"> 
                                <label class="ms-2">inclue</label>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 label">Graphiques en ligne : nombre de clients / temps</label>
                            <div class="col-md-2">
                                <input class="form-check-input" type="checkbox" name="report_options[]"value="client_graph"> 
                                <label class="ms-2">inclue</label>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3  label">graphique à barres: Source des nouveaux clients</label>
                            <div class="col-md-2">
                                <input class="form-check-input" type="checkbox" name="report_options[]"value="lead_source"> 
                                <label class="ms-2">inclue</label>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 label">Tableau des clients et leurs activités</label>
                            <div class="col-md-2">
                                <input class="form-check-input" type="checkbox" name="report_options[]" id="client_activities" value="client_activities"> 
                                <label class="ms-2">inclue</label>
                            </div>
                        </div>
                        <div id="additional-activities" class="d-none">
                            <div class="form-group row">
                                <div class="form-check col-md-2">
                                    <input type="checkbox" class="form-check-input" name="activity_options[]" value="nb_of_commands" checked>
                                    <label class="form-check-label">Nb de commandes</label>
                                </div>
                                <div class="form-check col-md-3">
                                    <input type="checkbox" class="form-check-input" name="activity_options[]" value="nb_of_confirmed_sales"checked>
                                    <label class="form-check-label">Nb de ventes confirmées</label>
                                </div>
                                <div class="form-check col-md-3">
                                    <input type="checkbox" class="form-check-input" name="activity_options[]" value="nb_of_cancelled_commands"checked>
                                    <label class="form-check-label">Nb de commandes annulées</label>
                                </div>
                                <div class="form-check col-md-2">
                                    <input type="checkbox" class="form-check-input" name="activity_options[]" value="nb_of_appointments"checked>
                                    <label class="form-check-label">Nb de rendez-vous</label>
                                </div>
                                <div class="form-check col-md-2">
                                    <input type="checkbox" class="form-check-input" name="activity_options[]" value="amount_earned"checked>
                                    <label class="form-check-label">Gains</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Submit</button>
                </form>
            </div>


        </section>

    </main><!-- End #main -->


    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>


    <!-- Template Main JS File -->
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('jquery/jquery-3.7.1.min.js') }}"></script>
    <script>
        // Toggle custom dates visibility based on radio button selection
        $('input[name="time_period"]').change(function() {
            if ($(this).val() === 'custom') {
                $('#custom_dates').removeClass('d-none'); // Show custom date inputs
            } else {
                $('#custom_dates').addClass('d-none'); // Hide custom date inputs
            }
        });
        // Toggle activities visibility based on checkbox selection
        $('#client_activities').change(function() {
            if ($(this).is(':checked')) {
                $('#additional-activities').removeClass('d-none'); // Show additional checkboxes
            } else {
                $('#additional-activities').addClass('d-none'); // Hide additional checkboxes
            }
        });

        $('#date-form').submit(function(event) {
            // Check if custom dates are filled in before form submission
            if ($('input[name="time_period"]:checked').val() === 'custom') {
                var startDate = $('#start_date').val();
                var endDate = $('#end_date').val();

                if (!startDate || !endDate) {
                    alert('Veuillez remplir la date de début et la date de fin.');
                    event.preventDefault(); // Prevent form submission
                    return;
                }
            }
            // Check if at least one report option is selected before form submission
            if ($('input[name="report_options[]"]:checked').length === 0) {
                alert('Veuillez sélectionner au moins une option de rapport.');
                event.preventDefault(); // Prevent form submission
                return;
            }

            // Check if at least one activity option is selected if activity tables is checked before form submission
            if ($('#client_activities').is(':checked') && $('input[name="activity_options[]"]:checked').length === 0) {
                alert('Veuillez sélectionner au moins une option d\'activité.');
                event.preventDefault(); // Prevent form submission
                return;
            }

            //check if the end date is in the past and if the start date is earlier than the end date
            var startDate = new Date($('#start_date').val());
            var endDate = new Date($('#end_date').val());
            var now = new Date();

            if (endDate >= now) {
                alert(' La date de fin doit être dans le passé');
                event.preventDefault(); // Prevent form submission
                return;
            }

            if (startDate >= endDate) {
                alert('La date de début doit être antérieure à la date de fin.');
                event.preventDefault(); // Prevent form submission
                return;
            }
        });
    </script>
</body>

</html>
