<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
      <a href="{{ url('') }}" class="app-brand-link">
        <span class="app-brand-text demo menu-text fw-bolder ms-2">{{ env("APP_NAME") }}</span>
      </a>

      <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
        {{-- <i class="bx bx-chevron-left bx-sm align-middle"></i> --}}
      </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
      <!-- Dashboard -->
      <li class="menu-item {{ Request::segment(2) == 'dashboard'? 'active' : '' }}">
        <a href="{{ route('admin.dashboard.index') }}" class="menu-link">
          <div data-i18n="Analytics">Dashboard</div>
        </a>
      </li>
      <li class="menu-item {{ Request::segment(2) == 'treatment'? 'active' : '' }}">
        <a href="{{ route('admin.treatment.index') }}" class="menu-link">
          <div data-i18n="Analytics">Treatment</div>
        </a>
      </li>
      <li class="menu-item {{ Request::segment(2) == 'product'? 'active' : '' }}">
        <a href="{{ route('admin.product.index') }}" class="menu-link">
          <div data-i18n="Analytics">Produk</div>
        </a>
      </li>
      <li class="menu-item {{ Request::segment(2) == 'transaction'? 'active' : '' }}">
        <a href="{{ route('admin.transaction.index') }}" class="menu-link">
          <div data-i18n="Analytics">Transaksi</div>
        </a>
      </li>
      <li class="menu-item {{ Request::segment(2) == 'schedule'? 'active' : '' }}">
        <a href="{{ route('admin.schedule.index') }}" class="menu-link">
          <div data-i18n="Analytics">Jadwal Praktek</div>
        </a>
      </li>      
      <li class="menu-item {{ Request::segment(2) == 'schedule-booked'? 'active' : '' }}">
        <a href="{{ route('admin.schedule-booked.index') }}" class="menu-link">
          <div data-i18n="Analytics">Perjanjian Jadwal</div>
        </a>
      </li>      
      <li class="menu-item {{ Request::segment(2) == 'profile'? 'active' : '' }}">
        <a href="{{ route('admin.profile.index') }}" class="menu-link">
          <div data-i18n="Analytics">Profil</div>
        </a>
      </li>      
    </ul>
  </aside>