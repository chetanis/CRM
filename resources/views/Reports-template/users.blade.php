<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Users Statistics</title>
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
    <center>
        @if (isset($all_time))
            <h2 class="mt-4">Rapport utilisateur de Tout le Temps</h2>
        @else
            <h2 class="mt-4">Rapport utilisateur</h2>
            <p>Période de Référence : {{ $startDate->format('d/m/Y') }} - {{ $endDate->format('d/m/Y') }}</p>
        @endif
    </center>

    @if ($user_stat_checked)
        @if (isset($all_time))
            <div class=" text-center mt-5">
                <h5>Nb d'utilisateurs pendant la Période</h5>
                <p>{{ $nb_users }} </p>
            </div>
        @else
            <div class="row mt-5">
                <div class="col-md-4 text-center">
                    <h5>Nb d'utilisateurs Avant la Période</h5>
                    <p>{{ $nb_users - $nb_users_in_period }}</p>
                </div>
                <div class="col-md-4 text-center">
                    <h5>Nb d'utilisateurs Acquis Pendant la Période</h5>
                    <p>{{ $nb_users_in_period }} </p>
                </div>
                <div class="col-md-4 text-center">
                    <h5>Nb d'utilisateurss à la fin de la période</h5>
                    <p> {{ $nb_users }}</p>
                </div>
            </div>
        @endif
    @endif

    @if ($user_client_graph_checked)
        <div class="row justify-content-center my-3"> <!-- Center content horizontally and add spacing -->
            <div class="col-md-8 text-center"> <!-- Center the content within the column -->
                <canvas id="clientsPerUserChart"></canvas>
            </div>
        </div>
    @endif

    @if ($user_sales_checked)
        <!-- Second Canvas Row -->
        <div class="row justify-content-center my-3"> <!-- Center content horizontally and add spacing -->
            <div class="col-md-8 text-center"> <!-- Center the content within the column -->
                <canvas id="salesPerUserChart"></canvas>
            </div>
        </div>
    @endif

    @if ($user_activities_checked)
        <center>
            <div class="m-5">
                <h4 class="mb-3">Tableau des clients et leurs activités</h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>User Name</th>
                            <th>Total Commands</th>
                            <th>Confirmed Commands</th>
                            <th>Cancelled Commands</th>
                            <th>Total Appointments</th>
                            <th>Gains</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($userActivity as $activity)
                            <tr>
                                <td>{{ $activity['user_name'] }}</td>
                                <td>{{ $activity['total_commands'] }}</td>
                                <td>{{ $activity['confirmed_commands'] }}</td>
                                <td>{{ $activity['cancelled_commands'] }}</td>
                                <td>{{ $activity['total_appointments'] }}</td>
                                <td>{{ $activity['gains'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </center>
    @endif
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('jquery/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('chart/chart.js') }}"></script>

    <script>
        $(document).ready(function() {
            var userActivity = @json($userActivity);

            var userNames = userActivity.map(function(activity) {
                return activity.user_name;
            });

            var totalClients = userActivity.map(function(activity) {
                return activity.total_appointments;
            });

            var totalSales = userActivity.map(function(activity) {
                return activity.total_commands;
            });

            // Graphique en ligne : Nombre de clients par utilisateur
            var ctxClientsPerUser = document.getElementById('clientsPerUserChart').getContext('2d');
            new Chart(ctxClientsPerUser, {
                type: 'line',
                data: {
                    labels: userNames,
                    datasets: [{
                        label: 'Nombre de Clients',
                        data: totalClients,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: true,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Nombre de clients par utilisateur',
                            font: {
                                size: 20, // Increase the font size
                                weight: 'bold', // Optional: Make the font bold
                            },
                        },
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Graphique à barres : Nombre de ventes par utilisateur
            var ctxSalesPerUser = document.getElementById('salesPerUserChart').getContext('2d');
            new Chart(ctxSalesPerUser, {
                type: 'bar',
                data: {
                    labels: userNames,
                    datasets: [{
                        label: 'Nombre de Ventes',
                        data: totalSales,
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Nombre de ventes par utilisateur',
                            font: {
                                size: 20, // Increase the font size
                                weight: 'bold', // Optional: Make the font bold
                            },

                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>


</body>

</html>
