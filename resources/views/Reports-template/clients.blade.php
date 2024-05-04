<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Client Statistics</title>
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
        <h2 class="mt-4">Rapport Client de Tout le Temps</h4>
        <p>Période de Référence : Janvier 2023 - Décembre 2023</p>
    </center>

    <div class="row mt-5">
        <div class="col-md-4 text-center">
            <h5>Nb Clients Avant la Période</h5>
            <p>0</p> <!-- Replace with the actual data -->
        </div>
        <div class="col-md-4 text-center">
            <h5>Nb Clients Acquis Pendant la Période</h5>
            <p>2000 </p> <!-- Replace with the actual data -->
        </div>
        <div class="col-md-4 text-center">
            <h5>Nb Clients Après la Période</h5>
            <p> 2000</p> <!-- Replace with the actual data -->
        </div>
    </div>

    <div class="row justify-content-center my-3"> <!-- Center content horizontally and add spacing -->
        <div class="col-md-8 text-center"> <!-- Center the content within the column -->
            <canvas id="clientsChart"></canvas> <!-- Adjust canvas size -->
        </div>
    </div>

    <!-- Second Canvas Row -->
    <div class="row justify-content-center my-3"> <!-- Center content horizontally and add spacing -->
        <div class="col-md-8 text-center"> <!-- Center the content within the column -->
            <canvas id="clientsByLeadSourceChart"></canvas> <!-- Adjust canvas size -->
        </div>
    </div>


    <center>
        <div class="m-5">
            <h4 class="mb-3">Tableau des clients et leurs activités</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Client Name</th>
                        <th>Total Commands</th>
                        <th>Confirmed Commands</th>
                        <th>Cancelled Commands</th>
                        <th>Total Appointments</th>
                        <th>Gains</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clientActivity as $stats)
                        <tr>
                            <td>{{ $stats['client_name'] }}</td>
                            <td>{{ $stats['total_commands'] }}</td>
                            <td>{{ $stats['confirmed_commands'] }}</td>
                            <td>{{ $stats['cancelled_commands'] }}</td>
                            <td>{{ $stats['total_appointments'] }}</td>
                            <td>{{ number_format($stats['gains'], 2) }} DA</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </center>
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('jquery/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('chart/chart.js') }}"></script>

    <script>
        const ctx = document.getElementById('clientsChart').getContext('2d');

        let labels, data;
        @if (isset($clientsPerYear))
            const clientsPerYear = @json($clientsPerYear);
            labels = clientsPerYear.map(c => c.year);
            data = clientsPerYear.map(c => c.count);
        @endif

        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Nb clients',
                    data: data,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    title: {
                        display: true, // Show title
                        text: 'Nombre de clients / temps', // Title text
                        font: {
                            size: 20, // Increase the font size
                            weight: 'bold', // Optional: Make the font bold
                        },
                    },
                },
                responsive: true,
                layout: {
                    padding: {
                        left: 20,
                        right: 20, // Add more padding to ensure right-side labels aren't cut off
                        top: 10,
                        bottom: 30 // Additional bottom padding for x-axis labels
                    }
                },
                scales: {
                    x: {
                        reverse: true, // Reverse the x-axis
                        ticks: {
                            autoSkip: false, // Ensure all labels are shown
                            maxRotation: 45, // Adjust rotation for better visibility
                        },
                    },
                    y: {
                        beginAtZero: true,
                    },
                },
            },
        });

        const ctx2 = document.getElementById('clientsByLeadSourceChart').getContext('2d');

        // Data from the controller
        const clientsBySource = @json($clientsBySource);

        // Extract labels (lead sources) and data (client counts)
        const labels2 = clientsBySource.map(item => item.lead_source ? item.lead_source : 'Inconnu');
        const data2 = clientsBySource.map(item => item.count);

        // Create the bar chart
        const chart2 = new Chart(ctx2, {
            type: 'bar', // Bar graph
            data: {
                labels: labels2,
                datasets: [{
                    label: 'Nb clients',
                    data: data2,
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    title: {
                        display: true, // Show title
                        text: 'Source des nouveaux clients', // Title text
                        font: {
                            size: 20, // Increase the font size
                            weight: 'bold', // Optional: Make the font bold
                        },
                    },
                },
                responsive: true,
                layout: {
                    padding: {
                        left: 20,
                        right: 20, // Add more padding to ensure right-side labels aren't cut off
                        top: 10,
                        bottom: 30 // Additional bottom padding for x-axis labels
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true // Start the y-axis at zero
                    }
                }
            }
        });
    </script>

</body>

</html>
