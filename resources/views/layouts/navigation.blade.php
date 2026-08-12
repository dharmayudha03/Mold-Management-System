<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion shadow-lg" id="accordionSidebar">

    <!-- Sidebar - Brand Header (Clean MOLD SYSTEM Title + Mobile Close Button) -->
    <div class="sidebar-brand d-flex align-items-center justify-content-between px-3.5 py-3 text-decoration-none border-bottom border-gray-800">
        <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-2 text-decoration-none">
            <div class="rounded-lg bg-primary text-white d-flex align-items-center justify-content-center shadow-xs" style="width: 34px; height: 34px;">
                <i class="fas fa-cube" style="font-size: 0.95rem;"></i>
            </div>
            <div class="text-left">
                <div class="text-white font-weight-black text-sm tracking-wider leading-tight" style="letter-spacing: 0.08em;">MOLD SYSTEM</div>
                <div class="text-[10px] text-gray-400 font-weight-bold">PT. IRC INOAC INDONESIA</div>
            </div>
        </a>
        <!-- Close Button (Visible on Mobile only) -->
        <button type="button" class="btn btn-sm text-gray-400 hover:text-white p-1 d-md-none border-0" onclick="document.body.classList.remove('sidebar-mobile-open')" title="Tutup Menu">
            <i class="fas fa-times font-weight-bold" style="font-size: 1.15rem;"></i>
        </button>
    </div>

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }} mt-2">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-th-large text-primary"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    @if(auth()->check() && (auth()->user()->hasRole('PPIC') || auth()->user()->hasRole('Ppic')) && !auth()->user()->hasRole('super_admin'))
        <!-- Heading: FORM REPORT -->
        <div class="sidebar-heading">
            Form Report
        </div>

        <li class="nav-item {{ request()->routeIs('form-schedules.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('form-schedules.index') }}">
                <i class="fas fa-calendar-check text-emerald-400"></i>
                <span>Form Schedule</span>
            </a>
        </li>
    @elseif(auth()->check() && auth()->user()->hasRole('User') && !auth()->user()->hasRole('super_admin'))
        <!-- Heading: FORM REPORT -->
        <div class="sidebar-heading">
            Form Report
        </div>

        <li class="nav-item {{ request()->routeIs('form-setup-cetakans.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('form-setup-cetakans.index') }}">
                <i class="fas fa-file-invoice text-indigo-400"></i>
                <span>Form Setup Cetakan</span>
            </a>
        </li>

        <li class="nav-item {{ request()->routeIs('form-sandblastings.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('form-sandblastings.index') }}">
                <i class="fas fa-bolt text-amber-400"></i>
                <span>Form Sandblasting</span>
            </a>
        </li>

        <li class="nav-item {{ request()->routeIs('form-repair-cetakans.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('form-repair-cetakans.index') }}">
                <i class="fas fa-wrench text-rose-400"></i>
                <span>Form PEJO (Repair)</span>
            </a>
        </li>

        <li class="nav-item {{ request()->routeIs('form-mjos.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('form-mjos.index') }}">
                <i class="fas fa-tools text-sky-400"></i>
                <span>Form MJO</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading: INFO & TRACKING -->
        <div class="sidebar-heading">
            Info & Tracking
        </div>

        <li class="nav-item {{ request()->routeIs('reports.molds*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('reports.molds') }}">
                <i class="fas fa-chart-line text-yellow-300"></i>
                <span class="font-weight-extrabold text-white">Laporan Cetakan</span>
            </a>
        </li>

        <li class="nav-item {{ request()->routeIs('penomoran-raks.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('penomoran-raks.index') }}">
                <i class="fas fa-th-list text-purple-400"></i>
                <span>Penomoran Rak</span>
            </a>
        </li>

        <li class="nav-item {{ request()->routeIs('cetakan-naiks.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('cetakan-naiks.index') }}">
                <i class="fas fa-arrow-circle-up text-emerald-400"></i>
                <span>Cetakan Naik</span>
            </a>
        </li>
    @elseif(auth()->check() && (auth()->user()->hasRole('Leader') || auth()->user()->hasRole('Supervisor') || auth()->user()->hasRole('leader') || auth()->user()->hasRole('supervisor')) && !auth()->user()->hasRole('super_admin'))
        <!-- Heading: FORM REPORT -->
        <div class="sidebar-heading">
            Form Report
        </div>

        <li class="nav-item {{ request()->routeIs('form-repair-cetakans.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('form-repair-cetakans.index') }}">
                <i class="fas fa-wrench text-rose-400"></i>
                <span>Form PEJO (Repair)</span>
            </a>
        </li>

        <li class="nav-item {{ request()->routeIs('form-mjos.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('form-mjos.index') }}">
                <i class="fas fa-tools text-sky-400"></i>
                <span>Form MJO</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading: INFO & TRACKING -->
        <div class="sidebar-heading">
            Info & Tracking
        </div>

        <li class="nav-item {{ request()->routeIs('cetakan-naiks.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('cetakan-naiks.index') }}">
                <i class="fas fa-arrow-circle-up text-emerald-400"></i>
                <span>Cetakan Naik</span>
            </a>
        </li>
    @elseif(auth()->check() && auth()->user()->hasRole('Setup & Maintenance') && !auth()->user()->hasRole('super_admin'))
        <!-- Heading: FORM REPORT -->
        <div class="sidebar-heading">
            Form Report
        </div>

        <li class="nav-item {{ request()->routeIs('form-setup-cetakans.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('form-setup-cetakans.index') }}">
                <i class="fas fa-file-invoice text-indigo-400"></i>
                <span>Form Setup Cetakan</span>
            </a>
        </li>

        <li class="nav-item {{ request()->routeIs('form-sandblastings.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('form-sandblastings.index') }}">
                <i class="fas fa-bolt text-amber-400"></i>
                <span>Form Sandblasting</span>
            </a>
        </li>

        <li class="nav-item {{ request()->routeIs('form-schedules.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('form-schedules.index') }}">
                <i class="fas fa-calendar-check text-emerald-400"></i>
                <span>Form Schedule</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading: INFO & TRACKING -->
        <div class="sidebar-heading">
            Info & Tracking
        </div>

        <li class="nav-item {{ request()->routeIs('penomoran-raks.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('penomoran-raks.index') }}">
                <i class="fas fa-th-list text-purple-400"></i>
                <span>Penomoran Rak</span>
            </a>
        </li>
    @elseif(auth()->check() && (auth()->user()->hasRole('PE') || auth()->user()->hasRole('pe') || auth()->user()->hasRole('Pe')) && !auth()->user()->hasRole('super_admin'))
        <!-- Heading: FORM REPORT -->
        <div class="sidebar-heading">
            Form Report
        </div>

        <li class="nav-item {{ request()->routeIs('form-repair-cetakans.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('form-repair-cetakans.index') }}">
                <i class="fas fa-wrench text-rose-400"></i>
                <span>Form PEJO (Repair)</span>
            </a>
        </li>

        <li class="nav-item {{ request()->routeIs('form-mjos.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('form-mjos.index') }}">
                <i class="fas fa-tools text-sky-400"></i>
                <span>Form MJO</span>
            </a>
        </li>
    @elseif(auth()->check() && (auth()->user()->hasRole('Msd') || auth()->user()->hasRole('msd') || auth()->user()->hasRole('MSD')) && !auth()->user()->hasRole('super_admin'))
        <!-- Heading: FORM REPORT -->
        <div class="sidebar-heading">
            Form Report
        </div>

        <li class="nav-item {{ request()->routeIs('form-mjos.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('form-mjos.index') }}">
                <i class="fas fa-tools text-sky-400"></i>
                <span>Form MJO</span>
            </a>
        </li>
    @else
        <!-- Heading: CETAKAN & MESIN -->
        <div class="sidebar-heading">
            Cetakan & Mesin
        </div>

        <li class="nav-item {{ request()->routeIs('code-items.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('code-items.index') }}">
                <i class="fas fa-cubes text-info"></i>
                <span>Code Item</span>
            </a>
        </li>

        <li class="nav-item {{ request()->routeIs('mesins.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('mesins.index') }}">
                <i class="fas fa-cogs text-warning"></i>
                <span>Mesin</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading: FORM REPORT -->
        <div class="sidebar-heading">
            Form Report
        </div>

        <li class="nav-item {{ request()->routeIs('form-setup-cetakans.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('form-setup-cetakans.index') }}">
                <i class="fas fa-file-invoice text-indigo-400"></i>
                <span>Form Setup Cetakan</span>
            </a>
        </li>

        <li class="nav-item {{ request()->routeIs('form-sandblastings.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('form-sandblastings.index') }}">
                <i class="fas fa-bolt text-amber-400"></i>
                <span>Form Sandblasting</span>
            </a>
        </li>

        <li class="nav-item {{ request()->routeIs('form-repair-cetakans.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('form-repair-cetakans.index') }}">
                <i class="fas fa-wrench text-rose-400"></i>
                <span>Form PEJO (Repair)</span>
            </a>
        </li>

        <li class="nav-item {{ request()->routeIs('form-mjos.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('form-mjos.index') }}">
                <i class="fas fa-tools text-sky-400"></i>
                <span>Form MJO</span>
            </a>
        </li>

        <li class="nav-item {{ request()->routeIs('form-schedules.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('form-schedules.index') }}">
                <i class="fas fa-calendar-check text-emerald-400"></i>
                <span>Form Schedule</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading: INFO & TRACKING -->
        <div class="sidebar-heading">
            Info & Tracking
        </div>

        <li class="nav-item {{ request()->routeIs('reports.molds*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('reports.molds') }}">
                <i class="fas fa-chart-line text-yellow-300"></i>
                <span class="font-weight-extrabold text-white">Laporan Cetakan</span>
            </a>
        </li>

        <li class="nav-item {{ request()->routeIs('penomoran-raks.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('penomoran-raks.index') }}">
                <i class="fas fa-th-list text-purple-400"></i>
                <span>Penomoran Rak</span>
            </a>
        </li>

        <li class="nav-item {{ request()->routeIs('cetakan-naiks.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('cetakan-naiks.index') }}">
                <i class="fas fa-arrow-circle-up text-emerald-400"></i>
                <span>Cetakan Naik</span>
            </a>
        </li>

        <li class="nav-item {{ request()->routeIs('history-cetakans.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('history-cetakans.index') }}">
                <i class="fas fa-history text-cyan-400"></i>
                <span>History Cetakan</span>
            </a>
        </li>

        <li class="nav-item {{ request()->routeIs('kategoris.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('kategoris.index') }}">
                <i class="fas fa-tags text-pink-400"></i>
                <span>Kategori</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading: MASTER DATA -->
        <div class="sidebar-heading">
            Master Data
        </div>

        <li class="nav-item {{ request()->routeIs('list-code-items.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('list-code-items.index') }}">
                <i class="fas fa-list-ol text-blue-300"></i>
                <span>List Code Item</span>
            </a>
        </li>

        <li class="nav-item {{ request()->routeIs('set-code-items.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('set-code-items.index') }}">
                <i class="fas fa-layer-group text-indigo-300"></i>
                <span>Mold Set</span>
            </a>
        </li>

        <li class="nav-item {{ request()->routeIs('cav-code-items.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('cav-code-items.index') }}">
                <i class="fas fa-th text-teal-300"></i>
                <span>Mold Cavity</span>
            </a>
        </li>

        <li class="nav-item {{ request()->routeIs('list-mesins.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('list-mesins.index') }}">
                <i class="fas fa-microchip text-amber-300"></i>
                <span>List Mesin</span>
            </a>
        </li>

        <li class="nav-item {{ request()->routeIs('name-mesins.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('name-mesins.index') }}">
                <i class="fas fa-tag text-orange-300"></i>
                <span>Nama Mesin</span>
            </a>
        </li>

        <li class="nav-item {{ request()->routeIs('class-mesins.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('class-mesins.index') }}">
                <i class="fas fa-sitemap text-yellow-300"></i>
                <span>Class Mesin</span>
            </a>
        </li>

        <li class="nav-item {{ request()->routeIs('list-raks.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('list-raks.index') }}">
                <i class="fas fa-warehouse text-slate-300"></i>
                <span>Master List Rak</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading: ADMINISTRATION -->
        <div class="sidebar-heading">
            Administration
        </div>

        <li class="nav-item {{ request()->routeIs('users.*') || request()->routeIs('detail-users.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('users.index') }}">
                <i class="fas fa-users-cog text-violet-400"></i>
                <span>Kelola User & Password</span>
            </a>
        </li>
    @endif

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block my-3">

    <!-- Sidebar Toggler -->
    <div class="text-center d-none d-md-inline mb-4">
        <button class="rounded-circle border-0 d-inline-flex align-items-center justify-content-center text-gray-300" id="sidebarToggle" style="width: 2.5rem; height: 2.5rem; background-color: rgba(255, 255, 255, 0.15); transition: all 0.2s ease-in-out;" title="Buka/Tutup Sidebar">
            <i class="fas fa-chevron-left" id="sidebarToggleIcon" style="font-size: 0.85rem;"></i>
        </button>
    </div>

</ul>
