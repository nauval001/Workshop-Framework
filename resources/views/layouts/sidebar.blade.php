<li class="nav-item {{ request()->is('kategori*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('kategori.index') }}">
        <span class="menu-title">Kategori</span>
        <i class="mdi mdi-format-list-bulleted menu-icon"></i>
    </a>
</li>