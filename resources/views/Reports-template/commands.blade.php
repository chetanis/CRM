<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Commands and products Statistics</title>
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
            <h2 class="mt-4 mb-3">Rapport Commandes et Produits de Tout le Temps</h2>
        @else
            <h2 class="mt-4">Rapport Commandes et Produits</h2>
            <p>Période de Référence : {{ $startDate->format('d/m/Y') }} - {{ $endDate->format('d/m/Y') }}</p>
        @endif
    </center>
    @if ($command_stat_checked)
        <div class="row mt-5">
            <div class="col-md-3 text-center">
                <h5>Nb de commandes total</h5>
                <p class="fw-bold">{{ $nb_commands }}</p>
            </div>
            <div class="col-md-3 text-center">
                <h5>Nb de commandes annulés</h5>
                <p class="text-danger fw-bold">{{ $nb_cancelled_commands }}</p>
            </div>
            <div class="col-md-3 text-center fw-bold">
                <h5>Nb de commandes en attente</h5>
                <p class="text-warning fw-bold">{{ $nb_pending_commands }}</p>
            </div>
            <div class="col-md-3 text-center">
                <h5>Nb de commandes confirmés (Ventes)</h5>
                <p class="text-success fw-bold">{{ $nb_confirmed_commands }}</p>
            </div>
        </div>
    @endif
    @if ($command_percentage_checked)
        <center>
            <div class="row justify-content-center my-3 mt-5"> <!-- Center content horizontally and add spacing -->
                <div class="col-md-4 text-center"> <!-- Adjust column size to better fit the smaller chart -->
                    <canvas id="commandPercentageChart"></canvas> <!-- Set canvas size -->
                </div>
            </div>
        </center>
    @endif

    @if ($command_graph_checked)
        <!-- Second Canvas Row -->
        <center>
            <div class="row justify-content-center my-3 mt-5"> <!-- Center content horizontally and add spacing -->
                <div class="col-md-8 text-center"> <!-- Center the content within the column -->
                    <canvas id="commandChart"></canvas> <!-- Adjust canvas size -->
                </div>
            </div>
        </center>
        <!-- Third Canvas Row -->
        <center>
            <div class="row justify-content-center my-3 mt-5"> <!-- Center content horizontally and add spacing -->
                <div class="col-md-8 text-center"> <!-- Center the content within the column -->
                    <canvas id="commandChart2"></canvas> <!-- Adjust canvas size -->
                </div>
            </div>
        </center>
    @endif

    @if ($product_table_checked)
        <center>
            <div class="m-5">
                <h4 class="mb-3">Tableau des produits</h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nom de produit</th>
                            <th>Unité vendu</th>
                            <th>Revenu</th>
                            <th>bénéfice total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productsTable as $stats)
                            <tr>
                                <td>{{ $stats['product_name'] }}</td>
                                <td>{{ $stats['total_sold'] }}</td>
                                <td>{{ number_format($stats['total_revenue'], 2) }} DA</td>
                                <td>{{ number_format($stats['total_profit'], 2) }} DA</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td><strong>Total</strong></td>
                            <td></td>
                            <td><strong>{{ number_format($totalRevenue, 2) }} DA</strong></td>
                            <td><strong>{{ number_format($totalProfit, 2) }} DA</strong></td>
                        </tr>
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
        @if ($command_percentage_checked)
            var ctx = document.getElementById('commandPercentageChart').getContext('2d');

            // Define the data
            var data = {
                labels: ['Confirmé', 'Annulé', 'En attente'],
                datasets: [{
                    data: [{{ $percentage_confirmed }}, {{ $percentage_cancelled }},
                        {{ $percentage_pending }}
                    ],
                    backgroundColor: ['#55A768', '#BD4651', '#FFD042'], // green, red, yellow
                    hoverBackgroundColor: ['#218838', '#c82333', '#e0a800'] // darker shades
                }]
            };

            // Create the chart
            var commandPercentageChart = new Chart(ctx, {
                type: 'doughnut',
                data: data,
                options: {
                    plugins: {
                        title: {
                            display: true,
                            text: 'Répartition des pourcentages de commande',
                            font: {
                                size: 20, // Increase the font size
                                weight: 'bold', // Optional: Make the font bold
                            },
                        },
                    },
                    responsive: true,
                    legend: {
                        position: 'top',
                    },
                    animation: {
                        animateScale: true,
                        animateRotate: true
                    }
                }
            });
        @endif
        @if ($command_graph_checked)
            var ctx = document.getElementById('commandChart').getContext('2d');
            
            var unit = '{{ $timeUnit }}'; 
            var years = {!! $commandsPerYear->pluck($timeUnit) !!};
            var counts = {!! $commandsPerYear->pluck('count') !!};

            var commandChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: years,
                    datasets: [{
                        label: 'Commandes par année',
                        data: counts,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)', // Adjust background color
                        borderColor: 'rgba(54, 162, 235, 1)', // Adjust border color
                        borderWidth: 2
                    }]
                },
                options: {
                    plugins: {
                        title: {
                            display: true,
                            text: 'Nombre de commandes / ' + unit,
                            font: {
                                size: 20, // Increase the font size
                                weight: 'bold', // Optional: Make the font bold
                            },
                        },
                    },
                    responsive: true,
                    scales: {
                        xAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: unit // Label for X axis
                            }
                        }],
                        yAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'Number of Commands' // Label for Y axis
                            }
                        }]
                    },
                    legend: {
                        display: true,
                        position: 'top'
                    }
                }
            });



            var ctx2 = document.getElementById('commandChart2').getContext('2d');

            // Assuming you passed commandsPerYear as an array of objects with 'year', 'confirmed_count', 'pending_count', and 'cancelled_count' properties

            var years = {!! $commandsPerYear2->pluck($timeUnit) !!};
            var confirmedCounts = {!! $commandsPerYear2->pluck('confirmed_count') !!};
            var pendingCounts = {!! $commandsPerYear2->pluck('pending_count') !!};
            var cancelledCounts = {!! $commandsPerYear2->pluck('cancelled_count') !!};
            var commandChart = new Chart(ctx2, {
                type: 'line',
                data: {
                    labels: years,
                    datasets: [{
                        label: 'Confirmé',
                        data: confirmedCounts,
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 2,
                        fill: false
                    }, {
                        label: 'En attente',
                        data: pendingCounts,
                        borderColor: 'rgba(255, 206, 86, 1)',
                        backgroundColor: 'rgba(255, 206, 86, 1)',
                        borderWidth: 2,
                        fill: false
                    }, {
                        label: 'Annulé',
                        data: cancelledCounts,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 2,
                        fill: false
                    }]
                },
                options: {
                    plugins: {
                        title: {
                            display: true,
                            text: 'Nombre de commandes / ' + unit,
                            font: {
                                size: 20,
                                weight: 'bold'
                            }
                        }
                    },
                    responsive: true,
                    scales: {
                        xAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'Year'
                            }
                        }],
                        yAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'Number of Commands'
                            }
                        }]
                    },
                    legend: {
                        display: true,
                        position: 'top'
                    }
                }
            });
        @endif
    </script>

</body>

</html>
