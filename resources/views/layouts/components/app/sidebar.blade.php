<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="{{ url('/') }}" class="text-nowrap logo-img">
                {{-- <img src="../assets/images/logos/dark-logo.svg" width="180" alt="" /> --}}
                <img src="{{ asset('assets/images/logos/new_logo.png') }}" width="180" alt="lgo">
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8"></i>
            </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">

                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Home</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('beranda') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-layout-dashboard"></i>
                        </span>
                        <span class="hide-menu">Beranda</span>
                    </a>
                </li>
                @hasanyrole('Admin|Pengembang')
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Manajemen</span>
                    </li>
                @endhasanyrole
                @hasanyrole('Admin')
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('page.verifikasi.index') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-check"></i>
                            </span>
                            <span class="hide-menu">Verifikasi</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('page.user.index') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-users"></i>
                            </span>
                            <span class="hide-menu">Pengguna</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('page.pengembang.index') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-users"></i>
                            </span>
                            <span class="hide-menu">Pengembang</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('page.kriteria.index') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-database"></i>
                            </span>
                            <span class="hide-menu">Kriteria dan Sub Kriteria</span>
                        </a>
                    </li>
                @endhasanyrole
                @hasanyrole('Admin|Pengembang')
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('page.uji.perhitungan') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-math"></i>
                            </span>
                            <span class="hide-menu">Perhitungan</span>
                        </a>
                    </li>
                @endhasanyrole
                @hasanyrole('Pengembang')
                    @if (auth()->user()->hasRole('Pengembang') && auth()->user()->dataPengembang->is_verified == 1)
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('page.perumahan.proyek') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-home-cog"></i>
                                </span>
                                <span class="hide-menu">Proyek</span>
                            </a>
                        </li>
                    @endif
                @endhasanyrole
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Umum</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('page.perumahan.list') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-home"></i>
                        </span>
                        <span class="hide-menu">List Perumahan</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    {{-- @php
                        $urlRekomendasi = `{{ route('page.uji.rekomendasi') }}`;
                        $loginRole = auth()->user()->roles[0]->name;
                        if ($loginRole == 'Umum') {
                            $urlRekomendasi = `{{ route('page.uji.rekomendasi_preferensi') }}`;
                        }

                    @endphp --}}
                    <a class="sidebar-link" href="{{ route('page.uji.rekomendasi') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-crown"></i>
                        </span>
                        <span class="hide-menu">Hasil Rekomendasi</span>
                    </a>
                </li>

            </ul>
            {{-- <div class="unlimited-access hide-menu bg-light-primary position-relative mb-7 mt-5 rounded">
                <div class="d-flex">
                    <div class="unlimited-access-title me-3">
                        <h6 class="fw-semibold fs-4 mb-6 text-dark w-85">Upgrade to pro</h6>
                        <a href="https://adminmart.com/product/modernize-bootstrap-5-admin-template/" target="_blank"
                            class="btn btn-primary fs-2 fw-semibold lh-sm">Buy Pro</a>
                    </div>
                    <div class="unlimited-access-img">
                        <img src="../assets/images/backgrounds/rocket.png" alt="" class="img-fluid">
                    </div>
                </div>
            </div> --}}
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
