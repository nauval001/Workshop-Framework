<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item nav-profile">
      <a href="#" class="nav-link">
        <div class="nav-profile-image">
          <img src="{{ asset('assets/images/faces/face1.jpg') }}" alt="image">
          <span class="login-status online"></span>
        </div>
        <div class="nav-profile-text d-flex flex-column">
          <span class="font-weight-bold mb-2">{{ Auth::user()->name ?? 'Admin' }}</span>
          <span class="text-secondary text-small">Administrator</span>
        </div>
        <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
      </a>
    </li>
    
    <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
      <a class="nav-link" href="{{ url('/') }}">
        <span class="menu-title">Dashboard</span>
        <i class="mdi mdi-home menu-icon"></i>
      </a>
    </li>

    <li class="nav-item {{ request()->is('kategori*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ url('/kategori') }}">
        <span class="menu-title">Kategori Buku</span>
        <i class="mdi mdi-format-list-bulleted menu-icon"></i>
      </a>
    </li>

    <li class="nav-item {{ request()->is('buku*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ url('/buku') }}">
        <span class="menu-title">Buku</span>
        <i class="mdi mdi-book-open-page-variant menu-icon"></i>
      </a>
    </li>

    <li class="nav-item {{ request()->is('barang*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ url('/barang') }}">
        <span class="menu-title">Barang</span>
        <i class="mdi mdi-package-variant menu-icon"></i>
      </a>
    </li>

    <li class="nav-item">
    <a class="nav-link" data-bs-toggle="collapse" href="#modul-js" aria-expanded="false" aria-controls="modul-js">
      <span class="menu-title">JQuery</span>
      <i class="menu-arrow"></i>
      <i class="mdi mdi-language-javascript menu-icon"></i>
    </a>
      <div class="collapse" id="modul-js">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="{{ route('js.html') }}">HTML Table</a></li>
          <li class="nav-item"> <a class="nav-link" href="{{ route('js.dt') }}">DataTables</a></li>
          <li class="nav-item"> <a class="nav-link" href="{{ route('js.select') }}">Select & Select2</a></li>
        </ul>
      </div>
    </li>

    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#modul-ajax" aria-expanded="false" aria-controls="modul-ajax">
        <span class="menu-title">AJAX & Axios</span>
        <i class="menu-arrow"></i>
        <i class="mdi mdi-swap-horizontal menu-icon"></i>
      </a>
      <div class="collapse" id="modul-ajax">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="{{ route('ajax.wilayah') }}">Wilayah Administrasi</a></li>
          <li class="nav-item"> <a class="nav-link" href="{{ route('ajax.pos') }}">Kasir (POS)</a></li>
          </ul>
      </div>
    </li>

    <li class="nav-item">
  <a class="nav-link" href="{{ route('vendor.index') }}">
    <span class="menu-title">Panel Vendor Kantin</span>
    <i class="mdi mdi-store menu-icon"></i>
  </a>
</li>

<li class="nav-item">
  <a class="nav-link" href="{{ route('customer.index') }}">
    <span class="menu-title">Pesan Makan (Customer)</span>
    <i class="mdi mdi-food menu-icon"></i>
  </a>
</li>

  </ul>
</nav>