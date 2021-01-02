<div class="left-side-bar">
  <div class="brand-logo">
    <a href="index.html">
      <img src="{{ asset('deskapp/vendors/images/deskapp-logo.svg') }}" alt="" class="dark-logo">
      <img src="{{ asset('deskapp/vendors/images/deskapp-logo-white.svg') }}" alt="" class="light-logo">
    </a>
    <div class="close-sidebar" data-toggle="left-sidebar-close">
      <i class="ion-close-round"></i>
    </div>
  </div>
  <div class="menu-block customscroll">
    <div class="sidebar-menu">
      <ul id="accordion-menu">
        <li class="{{ request()->routeIs('admin.dashboard*') ? 'show' : '' }}">
          <a href="{{ route('admin.dashboard') }}" class="dropdown-toggle no-arrow">
            <span class="micon dw dw-house1"></span><span class="mtext">Dashboard</span>
          </a>
        </li>
        <li class="dropdown {{ request()->routeIs('admin.projects*') ? 'show' : '' }}">
          <a href="javascript:;" class="dropdown-toggle">
            <span class="micon dw dw-city"></span><span class="mtext">Project</span>
          </a>
          <ul class="submenu"  style="display: {{ request()->routeIs('admin.projects*') ? 'block' : 'none' }}">
            <li><a class="{{ request()->routeIs('admin.projects.create') ? 'active' :'' }}" href="{{ route('admin.projects.create') }}">Tambah Project</a></li>
            <li><a class="{{ request()->routeIs('admin.projects.onProcess') ? 'active' :'' }}" href="{{ route('admin.projects.onProcess') }}">Project On-Process</a></li>
            <li><a class="{{ request()->routeIs('admin.projects.onProgress') ? 'active' :'' }}" href="{{ route('admin.projects.onProgress') }}">Project On-Progress</a></li>
            <li><a class="{{ request()->routeIs('admin.projects.finished') ? 'active' :'' }}" href="{{ route('admin.projects.finished') }}">Project Finished</a></li>
          </ul>
        </li>
        <li class="dropdown {{ request()->routeIs('admin.clients*') ? 'show' : '' }}">
          <a href="javascript:;" class="dropdown-toggle">
            <span class="micon dw dw-deal"></span><span class="mtext">Klien</span>
          </a>
          <ul class="submenu" style="display: {{ request()->routeIs('admin.clients*') ? 'block' : 'none' }}">
            <li><a class="{{ request()->routeIs('admin.clients.index') ? 'active' :'' }}" href="{{ Route('admin.clients.index') }}">List Klien</a></li>
            <li><a class="{{ request()->routeIs('admin.clients.create') ? 'active' :'' }}" href="{{ Route('admin.clients.create') }}">Tambah Klien</a></li>
          </ul>
        </li>
        <li class="dropdown {{ request()->routeIs('admin.workers*') ? 'show' : '' }}">
          <a href="javascript:;" class="dropdown-toggle">
            <span class="micon dw dw-group"></span><span class="mtext">Tukang</span>
          </a>
          <ul class="submenu" style="display: {{ request()->routeIs('admin.workers*') ? 'block' : 'none' }}">
            <li><a class="{{ request()->routeIs('admin.workers.index') ? 'active' :'' }}" href="{{ Route('admin.workers.index') }}">List Tukang</a></li>
            <li><a class="{{ request()->routeIs('admin.workers.create') ? 'active' :'' }}" href="{{ Route('admin.workers.create') }}">Tambah Tukang</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="javascript:;" class="dropdown-toggle {{ request()->routeIs('admin.cashes*') ? 'show' : '' }}">
            <span class="micon dw dw-newspaper"></span><span class="mtext">Kas</span>
          </a>
          <ul class="submenu" style="display: {{ request()->routeIs('admin.cashes*') ? 'block' : 'none' }}">
            <li><a class="{{ request()->routeIs('admin.cashes.index') ? 'active' :'' }}" href="{{ Route('admin.cashes.index') }}">Data Kas</a></li>
            <li><a class="{{ request()->routeIs('admin.cashes.debt*') ? 'active' :'' }}" href="{{ Route('admin.cashes.debt') }}">Data Hutang</a></li>
            <li><a class="{{ request()->routeIs('admin.cashes.createOut') ? 'active' :'' }}" href="{{ Route('admin.cashes.createOut') }}">Tambah Pengeluaran</a></li>
          </ul>
        </li>
        <li class="{{ request()->routeIs('admin.report') ? 'show' : '' }}">
          <a href="{{ route('admin.report') }}" class="dropdown-toggle no-arrow">
            <span class="micon dw dw-analytics-10"></span><span class="mtext">Laporan</span>
          </a>
        </li>
        <li class="dropdown {{ request()->routeIs('admin.users*') ? 'show' : '' }}">
          <a href="javascript:;" class="dropdown-toggle">
            <span class="micon dw dw-user2"></span><span class="mtext">User</span>
          </a>
          <ul class="submenu" style="display: {{ request()->routeIs('admin.users*') ? 'block' : 'none' }}">
            <li><a class="{{ request()->routeIs('admin.users.index') ? 'active' :'' }}" href="{{ Route('admin.users.index') }}">List User</a></li>
            <li><a class="{{ request()->routeIs('admin.users.create') ? 'active' :'' }}" href="{{ Route('admin.users.create') }}">Tambah User</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</div>