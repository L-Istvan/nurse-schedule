<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4 ">

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-4 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/profileLogo.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->name }}</a>
        </div>
      </div>

      {{-------------EMPLOYEE(nurse) && HEADNURSE idebar menu------------------}}
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="/" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Kezdőlap
              </p>
            </a>
          </li>
          {{-------------EMPLOYEE(nurse) idebar menu------------------}}
          @if (Auth::user()->role === "nurse")
            <li class="nav-item">
                <a href="exchange" class="nav-link">
                    <i class="nav-icon fas fa-table"></i>
                    <p>Cserélés</p>
                </a>
            </li>
          @endif
          {{-------------HEADNURSE idebar menu------------------}}
          @if (Auth::user()->role === "headNurse")
            <li class="nav-item">
                <a href="addEmployer" class="nav-link">
                    <i class="nav-icon fas fa-book"></i>
                    <p>Dolgozók</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="details" class="nav-link">
                    <i class="nav-icon fas fa-book"></i>
                    <p>Részletek</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="setting" class="nav-link">
                    <i class="nav-icon fas fa-book"></i>
                    <p>Beállítások</p>
                </a>
            </li>
          @endif
          <li class="nav-item">
            <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="nav-icon fas fa-table"></i>
                <p>Kijelentkezés</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
  </aside>


