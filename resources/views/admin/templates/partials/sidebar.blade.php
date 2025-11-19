  <!--- Sidemenu -->
  <div id="sidebar-menu">

      <div class="logo-box">
          <a class='logo logo-light' href='index.htm'>
              <span class="logo-sm">
                  <img src="{{ url('templates/assets/images/logo-sm.png') }}" alt="" height="22">
              </span>
              <span class="logo-lg">
                  <img src="{{ url('templates/assets/images/logo-light.png') }}" alt="" height="24">
              </span>
          </a>
          <a class='logo logo-dark' href='index.htm'>
              <span class="logo-sm">
                  <img src="{{ url('templates/assets/images/logo-sm.png') }}" alt="" height="22">
              </span>
              <span class="logo-lg">
                  <img src="{{ url('templates/assets/images/logo-dark.png') }}" alt="" height="24">
              </span>
          </a>
      </div>

      <ul id="side-menu">

          <li class="menu-title">Menu</li>

          <li {{ Request::is('dashboard/*') ? 'class="menuitem-active"' : '' }}>
              <a class='tp-link {{ Request::is('dashboard/*') ? 'class="active"' : '' }}'
                  href='{{ url('/dashboard') }}'>
                  <i data-feather="pie-chart"></i>
                  <span> Dashboard </span>
              </a>
          </li>

          <li {{ Request::is('brands/*') ? 'class="menuitem-active"' : '' }}>
              <a class='tp-link {{ Request::is('brands/*') ? 'class="active"' : '' }}' href='{{ url('brands') }}'>
                  <i data-feather="server"></i>
                  <span> Brands </span>
              </a>
          </li>

          <li {{ Request::is('campaign/*') ? 'class="menuitem-active"' : '' }}>
              <a class='tp-link {{ Request::is('campaign/*') ? 'class="active"' : '' }}' href='{{ url('campaign') }}'>
                  <i data-feather="shuffle"></i>
                  <span> Campaign </span>
              </a>
          </li>

          <li {{ Request::is('perbandingan/*') ? 'class="menuitem-active"' : '' }}>
              <a class='tp-link {{ Request::is('perbandingan/*') ? 'class="active"' : '' }}'
                  href='{{ url('perbandingan') }}'>
                  <i data-feather="shuffle"></i>
                  <span> Perbandingan </span>
              </a>
          </li>

      </ul>

  </div>
  <!-- End Sidebar -->

  <div class="clearfix"></div>
