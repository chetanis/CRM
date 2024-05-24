<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Dashboard</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('imgs/icons/djezzy.png') }}" rel="icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

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

        <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">

                <!-- Left side columns -->
                <div class="col-lg-8">
                    <div class="row">

                        <!-- Sales Card -->
                        <div class="col-xxl-4 col-md-6">
                            <div class="card info-card sales-card">

                                <div class="filter">
                                    <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                            class="bi bi-three-dots"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                        <li class="dropdown-header text-start">
                                            <h6>Filter</h6>
                                        </li>
                                        <li><a class="dropdown-item sale-filter-option" href="#"
                                                data-filter="today">Today</a></li>
                                        <li><a class="dropdown-item sale-filter-option" href="#"
                                                data-filter="month">This Month</a></li>
                                        <li><a class="dropdown-item sale-filter-option" href="#"
                                                data-filter="year">This Year</a></li>
                                    </ul>
                                </div>

                                <div class="card-body">
                                    <h5 class="card-title sale-card-title">Vantes <span class="sale-card-title-span">| Today</span></h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-cart"></i>
                                        </div>
                                        <div class="ps-3 ">
                                            <h6 class="sale-card-body">{{ $nbSales }}</h6>
                                            <span class="sale-card-body-diff-side text-success medium pt-2 ps-1">+</span>
                                            <span class="sale-card-body-diff text-success small pt-1 fw-bold">{{$salesPercentageDiff}}%</span> 
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div><!-- End Sales Card -->

                        <!-- Revenue Card -->
                        <div class="col-xxl-4 col-md-6">
                            <div class="card info-card revenue-card">

                                <div class="filter">
                                    <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                            class="bi bi-three-dots"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                        <li class="dropdown-header text-start">
                                            <h6>Filter</h6>
                                        </li>
                                        <li><a class="dropdown-item revenue-filter-option" href="#"
                                                data-filter="today">Today</a></li>
                                        <li><a class="dropdown-item revenue-filter-option" href="#"
                                                data-filter="month">This Month</a></li>
                                        <li><a class="dropdown-item revenue-filter-option" href="#"
                                                data-filter="year">This Year</a></li>
                                    </ul>
                                </div>

                                <div class="card-body">
                                    <h5 class="card-title  revenue-card-title">Revenu <span class="revenue-card-title-span">| This Month</span></h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-currency-dollar"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6 class=" revenue-card-body">{{$totalRevenue }}</h6>
                                            <span class="revenue-card-body-diff-side text-success medium pt-2 ps-1">+</span>
                                            <span class="revenue-card-body-diff text-success small pt-1 fw-bold">{{$RevenuePercentageDiff}}%</span> 
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div><!-- End Revenue Card -->

                        <!-- Customers Card -->
                        <div class="col-xxl-4 col-xl-12">

                            <div class="card info-card customers-card">

                                <div class="filter">
                                    <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                            class="bi bi-three-dots"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                        <li class="dropdown-header text-start">
                                            <h6>Filter</h6>
                                        </li>
                                        <li><a class="dropdown-item client-filter-option" href="#"
                                                data-filter="today">Today</a></li>
                                        <li><a class="dropdown-item client-filter-option" href="#"
                                                data-filter="month">This Month</a></li>
                                        <li><a class="dropdown-item client-filter-option" href="#"
                                                data-filter="year">This Year</a></li>
                                    </ul>
                                </div>

                                <div class="card-body">
                                    <h5 class="card-title">Clients <span class="client-card-title-span">| This Year</span></h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-people"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6 class="client-card-body">{{ $nbclients }}</h6>
                                            <span class="client-card-body-diff-side text-success medium pt-2 ps-1">+</span>
                                            <span class="client-card-body-diff text-success small pt-1 fw-bold">{{$clientsPercentageDiff}}%</span> 

                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div><!-- End Customers Card -->

                        <!-- Recent Sales -->
                        <div class="col-12">
                            <div class="card recent-sales overflow-auto">

                                <div class="card-body">
                                    <h5 class="card-title">Ventes récentes</h5>
                                    @if ($sales->count() > 0)
                                        <table class="table table-borderless datatable">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Customer</th>
                                                    <th scope="col">Date de vente</th>
                                                    <th scope="col">Price</th>
                                                    <th scope="col">Détails</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($sales as $sale)
                                                    <tr>
                                                        <th scope="row" class="text-primary">{{ $sale->id }}
                                                        </th>
                                                        <td> {{ $sale->command->client->last_name }}
                                                            {{ $sale->command->client->first_name }}</td>
                                                        <td>{{ $sale->created_at->format('d/m/Y') }}</td>
                                                        <td>{{ $sale->command->total_price }} DA</td>
                                                        <td>
                                                            <button
                                                                onclick="window.location.href='/commands/{{ $sale->command->id }}'"
                                                                type="button"
                                                                class="btn btn-outline-primary btn-sm">Consulter</button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <h4>pas de ventes</h4>
                                    @endif

                                </div>

                            </div>
                        </div><!-- End Recent Sales -->

                    </div>
                </div><!-- End Left side columns -->

                <!-- Right side columns -->
                <div class="col-lg-4">

                    <!-- Appointments -->
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Rendez-vous d'aujourd'hui</h5>
                            <div class="activity">
                                @if ($appointments->count() == 0)
                                    <h4>pas de rendez vous</h4>
                                @else
                                    @foreach ($appointments as $appointment)
                                        <div class="activity-item d-flex">
                                            <div class="activite-label">{{ $appointment->getHour() }}</div>
                                            @if ($appointment->status == 'done')
                                                <i
                                                    class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                                            @elseif ($appointment->status == 'pending')
                                                <i
                                                    class='bi bi-circle-fill activity-badge text-warning align-self-start'></i>
                                            @else
                                                <i
                                                    class='bi bi-circle-fill activity-badge text-danger align-self-start'></i>
                                            @endif
                                            <div class="activity-content">
                                                <a href="/appointments/{{ $appointment->id }}" class="text-dark">
                                                    Rendez-vous avec <span
                                                        class="fw-bold text-primary">{{ $appointment->client->first_name . $appointment->client->last_name }}</span></a>
                                            </div>
                                        </div><!-- End activity item-->
                                    @endforeach
                                @endif

                            </div>

                        </div>
                    </div><!-- End Recent Activity -->
                    <!-- if admin -->
                    @if (Auth::user()->privilege == 'admin')
                        <!-- Top Selling -->
                        <div class="col-12">
                            <div class="card top-selling overflow-auto">

                                <div class="card-body pb-0">
                                    <h5 class="card-title">Produits les plus vendus </h5>

                                    <table class="table table-borderless">
                                        <thead>
                                            <tr>
                                                <th scope="col">Product</th>
                                                <th scope="col">Sold</th>
                                                <th scope="col">Revenue</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($topProducts as $product)
                                                <tr>
                                                    <td><a href='/products/{{ $product->id }}'
                                                            class="text-primary fw-bold">{{ $product->name }}</a></td>
                                                    <td class="fw-bold">{{ $product->sold }}</td>
                                                    <td>{{ $product->getTotalRevenueFromConfirmedCommands() }} DA</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                </div>

                            </div>
                        </div><!-- End Top Selling -->
                    @endif

                </div><!-- End Right side columns -->

            </div>
        </section>

    </main><!-- End #main -->


    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>


    <!-- Template Main JS File -->
    <script src="{{ asset('jquery/jquery-3.7.1.min.js') }}"></script>
    {{-- <script src="{{ asset('js/script.js') }}"></script> --}}
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/notifications.js') }}"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
</body>

</html>
