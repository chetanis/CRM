<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

<ul class="sidebar-nav" id="sidebar-nav">
  <div class="top-nav">
    <li class="nav-item">
      <a class="nav-link " href="{{route('dashboard')}}">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li><!-- End Dashboard Nav -->
    @auth
    @if(auth()->user()->privilege === 'admin')
    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#users-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-person"></i><span>Gestion d'utilisateur</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="users-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a href="{{route('register')}}">
            <i class="bi bi-circle"></i><span>Ajouter utilisateur</span>
          </a>
        </li>
        <li>
          <a href="{{route('users.index')}}">
            <i class="bi bi-circle"></i><span>Afficher les utilisateurs</span>
          </a>
        </li>
      </ul>
    </li><!-- End audit Nav -->
    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#audit-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-card-list"></i><span>Audit</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="audit-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a href="{{route('logs')}}">
            <i class="bi bi-circle"></i><span>Afficher le journal d'activité</span>
          </a>
        </li>
      </ul>
    </li><!-- End audit Nav -->
    @endif

    @if(auth()->user()->privilege === 'admin' || auth()->user()->privilege === 'superuser')
    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#products-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-bag"></i><span>Gestion des poduits</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="products-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a href="{{route('products.create')}}">
            <i class="bi bi-circle"></i><span>Ajouter produit</span>
          </a>
        </li>
        <li>
          <a href="{{route('products.index')}}">
            <i class="bi bi-circle"></i><span>Afficher les produits</span>
          </a>
        </li>
      </ul>
    </li><!-- End Produits Nav -->
    @endif
    @endauth
    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#clients-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-layout-text-window-reverse"></i><span>Gestion des clients</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="clients-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a href="{{route('clients.create')}}">
            <i class="bi bi-circle"></i><span>Ajouter un client</span>
          </a>
        </li>
        <li>
          <a href="{{route('clients.index')}}">
            <i class="bi bi-circle"></i><span>Afficher les clients</span>
          </a>
        </li>
      </ul>
    </li><!-- End Clients Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#commands-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-bar-chart"></i><span>Gestion des commandes</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="commands-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a href="{{route('commands.create')}}">
            <i class="bi bi-circle"></i><span>Ajouter commande</span>
          </a>
        </li>
        <li>
          <a href="{{route('commands.index')}}">
            <i class="bi bi-circle"></i><span>Afficher les commandes</span>
          </a>
        </li>
      </ul>
    </li><!-- End Commandes Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#appointments-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-calendar-week"></i><span>Gestion des rendez-vous</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="appointments-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a href="{{route('appointments.create')}}">
            <i class="bi bi-circle"></i><span>Ajouter rendez-vous</span>
          </a>
        </li>
        <li>
          <a href="{{route('appointments.index')}}">
            <i class="bi bi-circle"></i><span>Afficher les rendez-vous</span>
          </a>
        </li>
      </ul>
    </li><!-- End Appointments Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-gem"></i><span>Reporting</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="icons-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a href="{{route('clients-report')}}">
            <i class="bi bi-circle"></i><span>Clients</span>
          </a>
        </li>
        @if(auth()->user()->privilege === 'admin')
        <li>
          <a href="{{route('users-report')}}">
            <i class="bi bi-circle"></i><span>Users</span>
          </a>
        </li>
        @endif
        <li>
          <a href="{{route('commands-report')}}">
            <i class="bi bi-circle"></i><span>commande et produit</span>
          </a>
        </li>
      </ul>
    </li><!-- End Reporting Nav -->
  </div>
  <div class="bot-nav">
    <li class="nav-item">

      <!-- form to logout -->
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
      </form>

      <a class="nav-link collapsed" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="bi bi-box-arrow-in-right"></i>
        <span>Log out</span>
      </a>
    </li><!-- End logout Page Nav -->
  </div>
</ul>

</aside><!-- End Sidebar-->