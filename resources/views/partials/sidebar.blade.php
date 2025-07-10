<aside class="left-sidebar with-vertical">
    <div class="sidebar-container d-flex flex-column" style="height: 100%;">
        <!-- Brand Logo -->
        <div class="brand-logo d-flex align-items-center justify-content-between ">
            <a href="{{ route('dashboard') }}" class="text-nowrap logo-img">
            </a>
            <a href="javascript:void(0)" class="sidebartoggler ms-auto text-decoration-none fs-5 d-block d-xl-none" onclick="toggleSidebar()">
                {{-- <i class="ti ti-x text-white opacity-75 hover-opacity-100 transition-opacity"></i> --}}
                <i class="ti ti-x"></i>
            </a>
        </div>

        <!-- Logo di Atas Sidebar -->
        <div class="logo-top text-center my-4">
            <img src="{{ asset('assets/images/logos/bank_kerta.svg') }}" alt="Additional Logo" class="extra-logo" style="max-width: 160px; height: auto;" />
        </div>

        <!-- Sidebar Navigation -->
        <nav class="sidebar-nav scroll-sidebar flex-grow-1" data-simplebar>
            <ul id="sidebarnav">
                <li class="sidebar-item {{ Route::is('dashboard') ? 'active' : '' }}">
                    <a class="sidebar-link d-flex align-items-center gap-3 py-3 px-4" href="{{ route('dashboard') }}" aria-expanded="false">
                        <span><i class="ti ti-aperture"></i></span>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item {{ Route::is('products.dashboard') ? 'active' : '' }}">
                    <a class="sidebar-link d-flex align-items-center gap-3 py-3 px-4" href="{{ route('products.dashboard') }}" aria-expanded="false">
                        <span><i class="ti ti-file-text"></i></span>
                        <span class="hide-menu">Product</span>
                    </a>
                </li>
                <li class="sidebar-item {{ Route::is('nasabah.dashboard') ? 'active' : '' }}">
                    <a class="sidebar-link d-flex align-items-center gap-3 py-3 px-4" href="{{ route('nasabah.dashboard') }}" aria-expanded="false">
                        <span><i class="ti ti-list-details"></i></span>
                        <span class="hide-menu">Nasabah</span>
                    </a>
                </li>
                <li class="sidebar-item {{ Route::is('pengajuan.dashboard') ? 'active' : '' }}">
                    <a class="sidebar-link d-flex align-items-center gap-3 py-3 px-4" href="{{ route('pengajuan.dashboard') }}" aria-expanded="false">
                        <span><i class="ti ti-currency-dollar"></i></span>
                        <span class="hide-menu">Pengajuan Kredit</span>
                    </a>
                </li>
                <li class="sidebar-item {{ Route::is('laporan.nasabah') ? 'active' : '' }}">
                    <a class="sidebar-link d-flex align-items-center gap-3 py-3 px-4" href="{{ route('laporan.nasabah') }}" aria-expanded="false">
                        <span><i class="ti ti-notebook"></i></span>
                        <span class="hide-menu">Laporan</span>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Sidebar Footer -->
        <div class="sidebar-footer text-center py-4">
            <p class="mb-0 text-white-50">&copy; design by dhea</p>
        </div>
    </div>
    <style>
        .sidebar-footer{
            background: linear-gradient(135deg, #0d6efd, #0099ff) !important;
        }
        .left-sidebar {
            background: linear-gradient(135deg, #0d6efd, #0099ff) !important;
            color: white;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .sidebar-link {
            color: rgba(255, 255, 255, 0.9) !important;
            transition: all 0.3s ease;
            border-radius: 8px;
            margin: 4px 12px;
        }

        .sidebar-link:hover {
            background-color: rgba(255, 255, 255, 0.15);
            color: white !important;
            transform: translateX(5px);
        }

        .sidebar-item.active .sidebar-link {
            background-color: rgba(255, 255, 255, 0.2);
            color: white !important;
            font-weight: 500;
        }

        .ti {
            font-size: 1.25rem;
        }

        .hover-opacity-100:hover {
            opacity: 1 !important;
        }

        .transition-opacity {
            transition: opacity 0.3s ease;
        }

        /* Custom scrollbar for webkit browsers */
        .scroll-sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .scroll-sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        .scroll-sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 3px;
        }

        .scroll-sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }
    </style>
</aside>
