<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Register</title>
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

  <main>
    <div class="container">
      <div class="position-relative">
        <a href="{{route('dashboard')}}" class="btn btn-dark-light" style="position: absolute; top: 50px; left: 10px;">
          <i class="bi bi-arrow-left text-primary" style="font-size: 1.5rem;">
          </i>
        </a>
      </div>



      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Create an Account</h5>
                    <p class="text-center small">Enter your personal details to create account</p>
                  </div>

                  <form class="row g-4 needs-validation" method="POST" action="/register">
                    @csrf
                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Username</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="text" name="username" class="form-control" id="yourUsername" required>
                        <div class="invalid-feedback">Please choose a username.</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">Please enter your password!</div>
                    </div>
                    <div class="col-12">
                      <label for="privilege" class="form-label">Privilege</label>
                      <select class="form-control" id="privilege" name="privilege">
                        <option value="user">User</option>
                        <option value="superuser">Super User</option>
                      </select>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Create Account</button>
                    </div>
                  </form>

                </div>
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>


  <!-- Template Main JS File -->
  <script src="{{ asset('jquery/jquery-3.7.1.min.js') }}"></script>
  <script src="assets/js/main.js"></script>
  <script src="{{ asset('js/notifications.js') }}"></script>

</body>

</html>