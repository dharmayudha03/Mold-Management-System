<x-app-layout>
    <x-slot name="header">
        Dashboard
    </x-slot>

@php
    $authUser = auth()->user();
    $isSuperAdmin = $authUser && ($authUser->hasRole('super_admin') || $authUser->email === 'admin@admin.com');

    $isSetupMaint = $authUser && ($authUser->hasRole('Setup & Maintenance') || $authUser->hasRole('Setup') || $authUser->hasRole('Maintenance'));
    $isPE = $authUser && ($authUser->hasRole('PE') || $authUser->hasRole('pe') || $authUser->hasRole('Pe'));
    $isMSD = $authUser && ($authUser->hasRole('Msd') || $authUser->hasRole('msd') || $authUser->hasRole('MSD'));
    $isPPIC = $authUser && ($authUser->hasRole('PPIC') || $authUser->hasRole('Ppic') || $authUser->hasRole('ppic') || $authUser->hasRole('Hatsumono'));
    $isUserRole = $authUser && ($authUser->hasRole('User') || $authUser->hasRole('user') || $authUser->hasRole('Leader') || $authUser->hasRole('Supervisor') || $authUser->hasRole('leader') || $authUser->hasRole('supervisor'));

    // ATURAN PRESISI ROLE:
    // 1. Setup & Maintenance: HANYA Form Setup, Sandblasting, PEJO Repair
    // 2. PE: HANYA PEJO Repair, Form MJO
    // 3. MSD: HANYA Form MJO
    // 4. PPIC & Hatsumono: HANYA Schedule
    // 5. User (Operator/Leader): HANYA Cetakan Naik
    // 6. Super Admin: SEMUA KARTU

    $canAccessCodeItem = $isSuperAdmin;
    $canAccessMesin = $isSuperAdmin;

    $canAccessSetup = $isSuperAdmin || $isSetupMaint;
    $canAccessSandblasting = $isSuperAdmin || $isSetupMaint;
    $canAccessPejo = $isSuperAdmin || $isSetupMaint || $isPE;
    $canAccessMjo = $isSuperAdmin || $isPE || $isMSD;
    $canAccessSchedule = $isSuperAdmin || $isPPIC;
    $canAccessCetakanNaik = $isSuperAdmin || $isUserRole;
    $canAccessUsers = $isSuperAdmin;
@endphp

    <!-- 5 Top Metric Cards (Role-Based Clickable Access) -->
    <div class="row mb-4">

        <!-- Card 1: Total Code Item -->
        <div class="col-xl col-md-6 mb-3">
            @if($canAccessCodeItem)
            <a href="{{ route('code-items.index') }}" class="card border-0 shadow-xs h-100 bg-white text-decoration-none hover:shadow-md transition-all cursor-pointer" style="border-radius: 0.85rem; border: 1px solid #f1f5f9 !important;">
            @else
            <div class="card border-0 shadow-xs h-100 bg-white opacity-70" style="border-radius: 0.85rem; border: 1px solid #e2e8f0 !important; cursor: not-allowed;" title="Akses Terkunci untuk Role {{ Auth::user()->roles->pluck('name')->first() ?? 'User' }}">
            @endif
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="rounded-xl text-white d-flex align-items-center justify-content-center shrink-0" style="width: 44px; height: 44px; border-radius: 0.75rem; background-color: {{ $canAccessCodeItem ? '#2563eb' : '#94a3b8' }} !important;">
                        <i class="fas {{ $canAccessCodeItem ? 'fa-cubes' : 'fa-lock' }} fa-lg text-white"></i>
                    </div>
                    <div>
                        <div class="text-[10px] font-weight-black uppercase tracking-wider d-flex align-items-center" style="color: #64748b;">
                            TOTAL CODE ITEM
                            @if(!$canAccessCodeItem)<i class="fas fa-lock text-danger text-[9px] ml-1" title="Akses Terkunci"></i>@endif
                        </div>
                        <div class="h4 mb-0 font-weight-black" id="totalCodeItem" style="color: #0f172a; font-size: 1.3rem; line-height: 1.2;">{{ number_format($totalCodeItem) }}</div>
                        <div class="text-[10px] font-weight-bold" style="color: #94a3b8;">{{ $canAccessCodeItem ? 'Data Mold Master' : 'Akses Terkunci' }}</div>
                    </div>
                </div>
            @if($canAccessCodeItem)
            </a>
            @else
            </div>
            @endif
        </div>

        <!-- Card 2: Mesin Aktif -->
        <div class="col-xl col-md-6 mb-3">
            @if($canAccessMesin)
            <a href="{{ route('list-mesins.index') }}" class="card border-0 shadow-xs h-100 bg-white text-decoration-none hover:shadow-md transition-all cursor-pointer" style="border-radius: 0.85rem; border: 1px solid #f1f5f9 !important;">
            @else
            <div class="card border-0 shadow-xs h-100 bg-white opacity-70" style="border-radius: 0.85rem; border: 1px solid #e2e8f0 !important; cursor: not-allowed;" title="Akses Terkunci untuk Role {{ Auth::user()->roles->pluck('name')->first() ?? 'User' }}">
            @endif
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="rounded-xl text-white d-flex align-items-center justify-content-center shrink-0" style="width: 44px; height: 44px; border-radius: 0.75rem; background-color: {{ $canAccessMesin ? '#16a34a' : '#94a3b8' }} !important;">
                        <i class="fas {{ $canAccessMesin ? 'fa-check-circle' : 'fa-lock' }} fa-lg text-white"></i>
                    </div>
                    <div>
                        <div class="text-[10px] font-weight-black uppercase tracking-wider d-flex align-items-center" style="color: #64748b;">
                            MESIN AKTIF
                            @if(!$canAccessMesin)<i class="fas fa-lock text-danger text-[9px] ml-1" title="Akses Terkunci"></i>@endif
                        </div>
                        <div class="h4 mb-0 font-weight-black" id="totalMesin" style="color: #0f172a; font-size: 1.3rem; line-height: 1.2;">{{ number_format($totalMesin) }}</div>
                        <div class="text-[10px] font-weight-bold" style="color: #94a3b8;">{{ $canAccessMesin ? 'Status Aktif Produksi' : 'Akses Terkunci' }}</div>
                    </div>
                </div>
            @if($canAccessMesin)
            </a>
            @else
            </div>
            @endif
        </div>

        <!-- Card 3: Form Setup -->
        <div class="col-xl col-md-6 mb-3">
            @if($canAccessSetup)
            <a href="{{ route('form-setup-cetakans.index') }}" class="card border-0 shadow-xs h-100 bg-white text-decoration-none hover:shadow-md transition-all cursor-pointer" style="border-radius: 0.85rem; border: 1px solid #f1f5f9 !important;">
            @else
            <div class="card border-0 shadow-xs h-100 bg-white opacity-70" style="border-radius: 0.85rem; border: 1px solid #e2e8f0 !important; cursor: not-allowed;" title="Akses Terkunci untuk Role {{ Auth::user()->roles->pluck('name')->first() ?? 'User' }}">
            @endif
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="rounded-xl text-white d-flex align-items-center justify-content-center shrink-0" style="width: 44px; height: 44px; border-radius: 0.75rem; background-color: {{ $canAccessSetup ? '#0284c7' : '#94a3b8' }} !important;">
                        <i class="fas {{ $canAccessSetup ? 'fa-file-invoice' : 'fa-lock' }} fa-lg text-white"></i>
                    </div>
                    <div>
                        <div class="text-[10px] font-weight-black uppercase tracking-wider d-flex align-items-center" style="color: #64748b;">
                            FORM SETUP
                            @if(!$canAccessSetup)<i class="fas fa-lock text-danger text-[9px] ml-1" title="Akses Terkunci"></i>@endif
                        </div>
                        <div class="h4 mb-0 font-weight-black" id="totalSetup" style="color: #0f172a; font-size: 1.3rem; line-height: 1.2;">{{ number_format($totalSetup) }}</div>
                        <div class="text-[10px] font-weight-bold" style="color: #94a3b8;">{{ $canAccessSetup ? 'Form Setup Terdaftar' : 'Akses Terkunci' }}</div>
                    </div>
                </div>
            @if($canAccessSetup)
            </a>
            @else
            </div>
            @endif
        </div>

        <!-- Card 4: Cetakan Naik -->
        <div class="col-xl col-md-6 mb-3">
            @if($canAccessCetakanNaik)
            <a href="{{ route('cetakan-naiks.index') }}" class="card border-0 shadow-xs h-100 bg-white text-decoration-none hover:shadow-md transition-all cursor-pointer" style="border-radius: 0.85rem; border: 1px solid #f1f5f9 !important;">
            @else
            <div class="card border-0 shadow-xs h-100 bg-white opacity-70" style="border-radius: 0.85rem; border: 1px solid #e2e8f0 !important; cursor: not-allowed;" title="Akses Terkunci untuk Role {{ Auth::user()->roles->pluck('name')->first() ?? 'User' }}">
            @endif
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="rounded-xl text-white d-flex align-items-center justify-content-center shrink-0" style="width: 44px; height: 44px; border-radius: 0.75rem; background-color: {{ $canAccessCetakanNaik ? '#ea580c' : '#94a3b8' }} !important;">
                        <i class="fas {{ $canAccessCetakanNaik ? 'fa-fire' : 'fa-lock' }} fa-lg text-white"></i>
                    </div>
                    <div>
                        <div class="text-[10px] font-weight-black uppercase tracking-wider d-flex align-items-center" style="color: #64748b;">
                            CETAKAN NAIK
                            @if(!$canAccessCetakanNaik)<i class="fas fa-lock text-danger text-[9px] ml-1" title="Akses Terkunci"></i>@endif
                        </div>
                        <div class="h4 mb-0 font-weight-black" id="totalCetakanNaik" style="color: #0f172a; font-size: 1.3rem; line-height: 1.2;">{{ number_format($totalCetakanNaik) }}</div>
                        <div class="text-[10px] font-weight-bold" style="color: #94a3b8;">{{ $canAccessCetakanNaik ? 'Sedang Produksi' : 'Akses Terkunci' }}</div>
                    </div>
                </div>
            @if($canAccessCetakanNaik)
            </a>
            @else
            </div>
            @endif
        </div>

        <!-- Card 5: Sandblasting -->
        <div class="col-xl col-md-6 mb-3">
            @if($canAccessSandblasting)
            <a href="{{ route('form-sandblastings.index') }}" class="card border-0 shadow-xs h-100 bg-white text-decoration-none hover:shadow-md transition-all cursor-pointer" style="border-radius: 0.85rem; border: 1px solid #f1f5f9 !important;">
            @else
            <div class="card border-0 shadow-xs h-100 bg-white opacity-70" style="border-radius: 0.85rem; border: 1px solid #e2e8f0 !important; cursor: not-allowed;" title="Akses Terkunci untuk Role {{ Auth::user()->roles->pluck('name')->first() ?? 'User' }}">
            @endif
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="rounded-xl text-white d-flex align-items-center justify-content-center shrink-0" style="width: 44px; height: 44px; border-radius: 0.75rem; background-color: {{ $canAccessSandblasting ? '#f59e0b' : '#94a3b8' }} !important;">
                        <i class="fas {{ $canAccessSandblasting ? 'fa-bolt' : 'fa-lock' }} fa-lg text-white"></i>
                    </div>
                    <div>
                        <div class="text-[10px] font-weight-black uppercase tracking-wider d-flex align-items-center" style="color: #64748b;">
                            SANDBLASTING
                            @if(!$canAccessSandblasting)<i class="fas fa-lock text-danger text-[9px] ml-1" title="Akses Terkunci"></i>@endif
                        </div>
                        <div class="h4 mb-0 font-weight-black" id="totalSandblasting" style="color: #0f172a; font-size: 1.3rem; line-height: 1.2;">{{ number_format($totalSandblasting) }}</div>
                        <div class="text-[10px] font-weight-bold" style="color: #94a3b8;">{{ $canAccessSandblasting ? 'Proses Sandblasting' : 'Akses Terkunci' }}</div>
                    </div>
                </div>
            @if($canAccessSandblasting)
            </a>
            @else
            </div>
            @endif
        </div>

    </div>

    <!-- Secondary Clean Metrics Row -->
    <div class="row mb-4">
        <!-- PEJO REPAIR -->
        <div class="col-6 col-md">
            @if($canAccessPejo)
            <a href="{{ route('form-repair-cetakans.index') }}" class="card border-0 shadow-xs text-decoration-none bg-white hover:bg-slate-50 transition-all cursor-pointer" style="border-radius: 0.75rem; border: 1px solid #f1f5f9 !important;">
            @else
            <div class="card border-0 shadow-xs bg-white opacity-70" style="border-radius: 0.75rem; border: 1px solid #e2e8f0 !important; cursor: not-allowed;" title="Akses Terkunci untuk Role {{ Auth::user()->roles->pluck('name')->first() ?? 'User' }}">
            @endif
                <div class="card-body p-2.5 d-flex align-items-center justify-content-between">
                    <div>
                        <div class="uppercase text-[10px] font-weight-black d-flex align-items-center" style="color: #64748b;">
                            PEJO REPAIR
                            @if(!$canAccessPejo)<i class="fas fa-lock text-danger text-[9px] ml-1" title="Akses Terkunci"></i>@endif
                        </div>
                        <div class="h5 mb-0 font-weight-black" id="totalRepair" style="color: #0f172a;">{{ number_format($totalRepair) }}</div>
                    </div>
                    <span class="rounded-circle text-white p-1 d-inline-flex align-items-center justify-content-center" style="width: 28px; height: 28px; background-color: {{ $canAccessPejo ? '#f43f5e' : '#94a3b8' }};">
                        <i class="fas {{ $canAccessPejo ? 'fa-wrench' : 'fa-lock' }} text-xs"></i>
                    </span>
                </div>
            @if($canAccessPejo)
            </a>
            @else
            </div>
            @endif
        </div>

        <!-- FORM MJO -->
        <div class="col-6 col-md">
            @if($canAccessMjo)
            <a href="{{ route('form-mjos.index') }}" class="card border-0 shadow-xs text-decoration-none bg-white hover:bg-slate-50 transition-all cursor-pointer" style="border-radius: 0.75rem; border: 1px solid #f1f5f9 !important;">
            @else
            <div class="card border-0 shadow-xs bg-white opacity-70" style="border-radius: 0.75rem; border: 1px solid #e2e8f0 !important; cursor: not-allowed;" title="Akses Terkunci untuk Role {{ Auth::user()->roles->pluck('name')->first() ?? 'User' }}">
            @endif
                <div class="card-body p-2.5 d-flex align-items-center justify-content-between">
                    <div>
                        <div class="uppercase text-[10px] font-weight-black d-flex align-items-center" style="color: #64748b;">
                            FORM MJO
                            @if(!$canAccessMjo)<i class="fas fa-lock text-danger text-[9px] ml-1" title="Akses Terkunci"></i>@endif
                        </div>
                        <div class="h5 mb-0 font-weight-black" id="totalMjo" style="color: #0f172a;">{{ number_format($totalMjo) }}</div>
                    </div>
                    <span class="rounded-circle text-white p-1 d-inline-flex align-items-center justify-content-center" style="width: 28px; height: 28px; background-color: {{ $canAccessMjo ? '#0284c7' : '#94a3b8' }};">
                        <i class="fas {{ $canAccessMjo ? 'fa-tools' : 'fa-lock' }} text-xs"></i>
                    </span>
                </div>
            @if($canAccessMjo)
            </a>
            @else
            </div>
            @endif
        </div>

        <!-- SCHEDULE -->
        <div class="col-6 col-md">
            @if($canAccessSchedule)
            <a href="{{ route('form-schedules.index') }}" class="card border-0 shadow-xs text-decoration-none bg-white hover:bg-slate-50 transition-all cursor-pointer" style="border-radius: 0.75rem; border: 1px solid #f1f5f9 !important;">
            @else
            <div class="card border-0 shadow-xs bg-white opacity-70" style="border-radius: 0.75rem; border: 1px solid #e2e8f0 !important; cursor: not-allowed;" title="Akses Terkunci untuk Role {{ Auth::user()->roles->pluck('name')->first() ?? 'User' }}">
            @endif
                <div class="card-body p-2.5 d-flex align-items-center justify-content-between">
                    <div>
                        <div class="uppercase text-[10px] font-weight-black d-flex align-items-center" style="color: #64748b;">
                            SCHEDULE
                            @if(!$canAccessSchedule)<i class="fas fa-lock text-danger text-[9px] ml-1" title="Akses Terkunci"></i>@endif
                        </div>
                        <div class="h5 mb-0 font-weight-black" id="totalSchedule" style="color: #0f172a;">{{ number_format($totalSchedule) }}</div>
                    </div>
                    <span class="rounded-circle text-white p-1 d-inline-flex align-items-center justify-content-center" style="width: 28px; height: 28px; background-color: {{ $canAccessSchedule ? '#10b981' : '#94a3b8' }};">
                        <i class="fas {{ $canAccessSchedule ? 'fa-calendar-check' : 'fa-lock' }} text-xs"></i>
                    </span>
                </div>
            @if($canAccessSchedule)
            </a>
            @else
            </div>
            @endif
        </div>

        <!-- USERS SYSTEM -->
        @if($canAccessUsers)
        <div class="col-6 col-md">
            <a href="{{ route('users.index') }}" class="card border-0 shadow-xs text-decoration-none bg-white hover:bg-slate-50 transition-all cursor-pointer" style="border-radius: 0.75rem; border: 1px solid #f1f5f9 !important;">
                <div class="card-body p-2.5 d-flex align-items-center justify-content-between">
                    <div>
                        <div class="uppercase text-[10px] font-weight-black" style="color: #64748b;">USERS SYSTEM</div>
                        <div class="h5 mb-0 font-weight-black" id="totalUser" style="color: #0f172a;">{{ number_format($totalUser) }}</div>
                    </div>
                    <span class="rounded-circle text-white p-1 d-inline-flex align-items-center justify-content-center" style="width: 28px; height: 28px; background-color: #8b5cf6;">
                        <i class="fas fa-users text-xs"></i>
                    </span>
                </div>
            </a>
        </div>
        @endif
    </div>

    <!-- Main Table 1: Status Cetakan Naik Terbaru (Matching Heater Project Table Style) -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-xs bg-white" style="border-radius: 0.85rem; border: 1px solid #f1f5f9 !important; overflow: hidden;">
                <div class="card-header py-3 px-4 d-flex align-items-center justify-content-between bg-white border-bottom-0">
                    <h5 class="m-0 font-weight-extrabold text-gray-900" style="font-size: 1.05rem; color: #0f172a;">Status Cetakan Naik Terbaru</h5>
                    <div class="d-flex align-items-center gap-2">
                        @if(auth()->user()->hasRole('User') || auth()->user()->hasRole('Leader') || auth()->user()->hasRole('Supervisor') || auth()->user()->hasRole('leader') || auth()->user()->hasRole('supervisor') || auth()->user()->hasRole('super_admin'))
                        <a href="{{ route('cetakan-naiks.index') }}" class="btn btn-sm btn-primary font-weight-bold px-3 py-1.5 text-xs text-white" style="border-radius: 0.6rem; background-color: #2563eb; border: none;">
                            {{ auth()->user()->hasRole('User') ? 'Lihat Cetakan Naik →' : 'Kelola Cetakan Naik →' }}
                        </a>
                        @endif
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive custom-scrollbar" style="max-height: 320px; overflow-y: auto;">
                        <table class="table table-hover mb-0 text-xs w-100">
                            <thead class="bg-light" style="background-color: #f8fafc !important;">
                                <tr style="border-bottom: 1px solid #e2e8f0;">
                                    <th class="py-3 px-4 font-weight-extrabold text-gray-800" style="color: #334155 !important;">NO MESIN</th>
                                    <th class="py-3 px-4 font-weight-extrabold text-gray-800" style="color: #334155 !important;">CODE ITEM</th>
                                    <th class="py-3 px-4 font-weight-extrabold text-gray-800" style="color: #334155 !important;">MOLD SET</th>
                                    <th class="py-3 px-4 font-weight-extrabold text-gray-800" style="color: #334155 !important;">MOLD CAVITY</th>
                                    <th class="py-3 px-4 font-weight-extrabold text-gray-800" style="color: #334155 !important;">TANGGAL NAIK</th>
                                    <th class="py-3 px-4 font-weight-extrabold text-gray-800 text-center" style="color: #334155 !important;">STATUS</th>
                                </tr>
                            </thead>
                            <tbody id="recentCetakanNaikTbody">
                                @forelse($recentCetakanNaik as $item)
                                    <tr style="border-bottom: 1px solid #f1f5f9;">
                                        <td class="py-3 px-4 font-weight-black text-gray-900">
                                            <span class="font-weight-black text-gray-900" style="color: #0f172a;">{{ $item->listMesin->code ?? '-' }}</span>
                                        </td>
                                        <td class="py-3 px-4 font-weight-extrabold" style="color: #0f172a;">{{ $item->listCodeItem->name ?? '-' }}</td>
                                        <td class="py-3 px-4 font-weight-bold" style="color: #475569;">{{ $item->setCodeItem->moldset ?? '-' }}</td>
                                        <td class="py-3 px-4 font-weight-bold" style="color: #475569;">{{ $item->cavCodeItem->moldcav ?? '-' }}</td>
                                        <td class="py-3 px-4 font-weight-bold" style="color: #64748b;">{{ \Carbon\Carbon::parse($item->tanggalnaik)->format('d/m/Y') }}</td>
                                        <td class="py-3 px-4 text-center">
                                            <span class="badge rounded-circle bg-secondary text-white d-inline-flex align-items-center justify-content-center font-weight-bold" style="width: 28px; height: 28px; background-color: #64748b !important;">
                                                <i class="fas fa-check text-xs"></i>
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-gray-500 py-4 italic">Belum ada cetakan sedang aktif produksi saat ini</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Secondary Table Row: 3 Clean Grid Tables (Setup, Sandblasting, History) -->
    <div class="row align-items-stretch mb-4">

        <!-- 1. Setup Cetakan Terbaru -->
        <div class="col-lg-4 mb-4 d-flex">
            <div class="card border-0 shadow-xs w-100 h-100 d-flex flex-column justify-content-between bg-white" style="border-radius: 0.85rem; border: 1px solid #f1f5f9 !important; overflow: hidden;">
                <div class="card-header py-3 px-3 d-flex align-items-center justify-content-between bg-white border-bottom-0">
                    <h6 class="m-0 font-weight-extrabold text-gray-900 text-xs uppercase" style="color: #0f172a;"><i class="fas fa-file-invoice text-primary mr-1.5"></i>Setup Cetakan Terbaru</h6>
                    @if(auth()->user()->hasRole('Setup & Maintenance') || auth()->user()->hasRole('User') || auth()->user()->hasRole('super_admin'))
                    <a href="{{ route('form-setup-cetakans.index') }}" class="text-[11px] text-primary font-weight-bold text-decoration-none">View All &rarr;</a>
                    @endif
                </div>
                <div class="card-body p-0 d-flex flex-column flex-grow-1">
                    <div class="table-responsive flex-grow-1 custom-scrollbar" style="max-height: 240px; overflow-y: auto;">
                        <table class="table table-hover mb-0 text-xs w-100">
                            <thead class="bg-light" style="background-color: #f8fafc !important;">
                                <tr>
                                    <th style="width: 45%; color: #334155; font-weight: 800;">CODE ITEM</th>
                                    <th style="width: 30%; color: #334155; font-weight: 800;">MOLD SET</th>
                                    <th style="width: 25%; color: #334155; font-weight: 800;">TANGGAL</th>
                                </tr>
                            </thead>
                            <tbody id="recentSetupTbody">
                                @forelse($recentSetup as $item)
                                    <tr style="border-bottom: 1px solid #f1f5f9;">
                                        <td style="color: #0f172a; font-weight: 800;">{{ $item->listCodeItem->name ?? '-' }}</td>
                                        <td style="color: #475569; font-weight: 700;">{{ $item->setCodeItem->moldset ?? '-' }}</td>
                                        <td style="color: #64748b; font-weight: 700;">{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-gray-500 py-3 italic">Belum ada data setup</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Sandblasting Terbaru -->
        <div class="col-lg-4 mb-4 d-flex">
            <div class="card border-0 shadow-xs w-100 h-100 d-flex flex-column justify-content-between bg-white" style="border-radius: 0.85rem; border: 1px solid #f1f5f9 !important; overflow: hidden;">
                <div class="card-header py-3 px-3 d-flex align-items-center justify-content-between bg-white border-bottom-0">
                    <h6 class="m-0 font-weight-extrabold text-gray-900 text-xs uppercase" style="color: #0f172a;"><i class="fas fa-bolt text-amber-500 mr-1.5"></i>Sandblasting Terbaru</h6>
                    @if(auth()->user()->hasRole('Setup & Maintenance') || auth()->user()->hasRole('User') || auth()->user()->hasRole('super_admin'))
                    <a href="{{ route('form-sandblastings.index') }}" class="text-[11px] text-amber-600 font-weight-bold text-decoration-none">View All &rarr;</a>
                    @endif
                </div>
                <div class="card-body p-0 d-flex flex-column flex-grow-1">
                    <div class="table-responsive flex-grow-1 custom-scrollbar" style="max-height: 240px; overflow-y: auto;">
                        <table class="table table-hover mb-0 text-xs w-100">
                            <thead class="bg-light" style="background-color: #f8fafc !important;">
                                <tr>
                                    <th style="width: 45%; color: #334155; font-weight: 800;">CODE ITEM</th>
                                    <th style="width: 30%; color: #334155; font-weight: 800;">MOLD SET</th>
                                    <th style="width: 25%; color: #334155; font-weight: 800;">TANGGAL</th>
                                </tr>
                            </thead>
                            <tbody id="recentSandblastingTbody">
                                @forelse($recentSandblasting as $item)
                                    <tr style="border-bottom: 1px solid #f1f5f9;">
                                        <td style="color: #0f172a; font-weight: 800;">{{ $item->listCodeItem->name ?? '-' }}</td>
                                        <td style="color: #475569; font-weight: 700;">{{ $item->setCodeItem->moldset ?? '-' }}</td>
                                        <td style="color: #64748b; font-weight: 700;">{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-gray-500 py-3 italic">Belum ada data sandblasting</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. History Cetakan Terbaru -->
        <div class="col-lg-4 mb-4 d-flex">
            <div class="card border-0 shadow-xs w-100 h-100 d-flex flex-column justify-content-between bg-white" style="border-radius: 0.85rem; border: 1px solid #f1f5f9 !important; overflow: hidden;">
                <div class="card-header py-3 px-3 d-flex align-items-center justify-content-between bg-white border-bottom-0">
                    <h6 class="m-0 font-weight-extrabold text-gray-900 text-xs uppercase" style="color: #0f172a;"><i class="fas fa-history text-info mr-1.5"></i>History Cetakan Terbaru</h6>
                    @if(auth()->user()->hasRole('super_admin'))
                    <a href="{{ route('history-cetakans.index') }}" class="text-[11px] text-info font-weight-bold text-decoration-none">View All &rarr;</a>
                    @endif
                </div>
                <div class="card-body p-0 d-flex flex-column flex-grow-1">
                    <div class="table-responsive flex-grow-1 custom-scrollbar" style="max-height: 240px; overflow-y: auto;">
                        <table class="table table-hover mb-0 text-xs w-100">
                            <thead class="bg-light" style="background-color: #f8fafc !important;">
                                <tr>
                                    <th style="width: 35%; color: #334155; font-weight: 800;">CODE ITEM</th>
                                    <th style="width: 30%; color: #334155; font-weight: 800;">MOLD SET</th>
                                    <th style="width: 35%; color: #334155; font-weight: 800;">DESKRIPSI</th>
                                </tr>
                            </thead>
                            <tbody id="recentHistoryTbody">
                                @forelse($recentHistory as $item)
                                    <tr style="border-bottom: 1px solid #f1f5f9;">
                                        <td style="color: #0f172a; font-weight: 800;">{{ $item->listCodeItem->name ?? '-' }}</td>
                                        <td style="color: #475569; font-weight: 700;">{{ $item->setCodeItem->moldset ?? '-' }}</td>
                                        <td style="color: #64748b; font-weight: 700;" class="text-truncate" style="max-width: 120px;" title="{{ $item->deskripsi }}">{{ $item->deskripsi }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-gray-500 py-3 italic">Belum ada history cetakan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Script for Live Auto-Refresh (Polling 3 Seconds) -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function escapeHtml(text) {
                if (!text) return '-';
                return String(text)
                    .replace(/&/g, "&amp;")
                    .replace(/</g, "&lt;")
                    .replace(/>/g, "&gt;")
                    .replace(/"/g, "&quot;")
                    .replace(/'/g, "&#039;");
            }

            function fetchDashboardData() {
                fetch("{{ route('dashboard.api-data') }}", {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) throw new Error('Network error');
                    return response.json();
                })
                .then(data => {
                    // 1. Update Metrics Cards
                    const codeItemEl = document.getElementById('totalCodeItem');
                    if (codeItemEl && data.totalCodeItem !== undefined) codeItemEl.textContent = data.totalCodeItem;

                    const mesinEl = document.getElementById('totalMesin');
                    if (mesinEl && data.totalMesin !== undefined) mesinEl.textContent = data.totalMesin;

                    const setupEl = document.getElementById('totalSetup');
                    if (setupEl && data.totalSetup !== undefined) setupEl.textContent = data.totalSetup;

                    const cetakanNaikEl = document.getElementById('totalCetakanNaik');
                    if (cetakanNaikEl && data.totalCetakanNaik !== undefined) cetakanNaikEl.textContent = data.totalCetakanNaik;

                    const sandblastingEl = document.getElementById('totalSandblasting');
                    if (sandblastingEl && data.totalSandblasting !== undefined) sandblastingEl.textContent = data.totalSandblasting;

                    const repairEl = document.getElementById('totalRepair');
                    if (repairEl && data.totalRepair !== undefined) repairEl.textContent = data.totalRepair;

                    const mjoEl = document.getElementById('totalMjo');
                    if (mjoEl && data.totalMjo !== undefined) mjoEl.textContent = data.totalMjo;

                    const scheduleEl = document.getElementById('totalSchedule');
                    if (scheduleEl && data.totalSchedule !== undefined) scheduleEl.textContent = data.totalSchedule;

                    const userEl = document.getElementById('totalUser');
                    if (userEl && data.totalUser !== undefined) userEl.textContent = data.totalUser;

                    // 2. Update Table Cetakan Naik Terbaru
                    const cetakanNaikTbody = document.getElementById('recentCetakanNaikTbody');
                    if (cetakanNaikTbody && Array.isArray(data.recentCetakanNaik)) {
                        if (data.recentCetakanNaik.length === 0) {
                            cetakanNaikTbody.innerHTML = '<tr><td colspan="6" class="text-center text-gray-500 py-4 italic">Belum ada cetakan sedang aktif produksi saat ini</td></tr>';
                        } else {
                            cetakanNaikTbody.innerHTML = data.recentCetakanNaik.map(item => `
                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                    <td class="py-3 px-4 font-weight-black text-gray-900">
                                        <span class="font-weight-black text-gray-900" style="color: #0f172a;">${escapeHtml(item.mesin)}</span>
                                    </td>
                                    <td class="py-3 px-4 font-weight-extrabold" style="color: #0f172a;">${escapeHtml(item.code_item)}</td>
                                    <td class="py-3 px-4 font-weight-bold" style="color: #475569;">${escapeHtml(item.mold_set)}</td>
                                    <td class="py-3 px-4 font-weight-bold" style="color: #475569;">${escapeHtml(item.mold_cavity)}</td>
                                    <td class="py-3 px-4 font-weight-bold" style="color: #64748b;">${escapeHtml(item.tanggal_naik)}</td>
                                    <td class="py-3 px-4 text-center">
                                        <span class="badge rounded-circle bg-secondary text-white d-inline-flex align-items-center justify-content-center font-weight-bold" style="width: 28px; height: 28px; background-color: #64748b !important;">
                                            <i class="fas fa-check text-xs"></i>
                                        </span>
                                    </td>
                                </tr>
                            `).join('');
                        }
                    }

                    // 3. Update Table Setup Cetakan Terbaru
                    const setupTbody = document.getElementById('recentSetupTbody');
                    if (setupTbody && Array.isArray(data.recentSetup)) {
                        if (data.recentSetup.length === 0) {
                            setupTbody.innerHTML = '<tr><td colspan="3" class="text-center text-gray-500 py-3 italic">Belum ada data setup</td></tr>';
                        } else {
                            setupTbody.innerHTML = data.recentSetup.map(item => `
                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                    <td style="color: #0f172a; font-weight: 800;">${escapeHtml(item.code_item)}</td>
                                    <td style="color: #475569; font-weight: 700;">${escapeHtml(item.mold_set)}</td>
                                    <td style="color: #64748b; font-weight: 700;">${escapeHtml(item.tanggal)}</td>
                                </tr>
                            `).join('');
                        }
                    }

                    // 4. Update Table Sandblasting Terbaru
                    const sandblastingTbody = document.getElementById('recentSandblastingTbody');
                    if (sandblastingTbody && Array.isArray(data.recentSandblasting)) {
                        if (data.recentSandblasting.length === 0) {
                            sandblastingTbody.innerHTML = '<tr><td colspan="3" class="text-center text-gray-500 py-3 italic">Belum ada data sandblasting</td></tr>';
                        } else {
                            sandblastingTbody.innerHTML = data.recentSandblasting.map(item => `
                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                    <td style="color: #0f172a; font-weight: 800;">${escapeHtml(item.code_item)}</td>
                                    <td style="color: #475569; font-weight: 700;">${escapeHtml(item.mold_set)}</td>
                                    <td style="color: #64748b; font-weight: 700;">${escapeHtml(item.tanggal)}</td>
                                </tr>
                            `).join('');
                        }
                    }

                    // 5. Update Table History Cetakan Terbaru
                    const historyTbody = document.getElementById('recentHistoryTbody');
                    if (historyTbody && Array.isArray(data.recentHistory)) {
                        if (data.recentHistory.length === 0) {
                            historyTbody.innerHTML = '<tr><td colspan="3" class="text-center text-gray-500 py-3 italic">Belum ada history cetakan</td></tr>';
                        } else {
                            historyTbody.innerHTML = data.recentHistory.map(item => `
                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                    <td style="color: #0f172a; font-weight: 800;">${escapeHtml(item.code_item)}</td>
                                    <td style="color: #475569; font-weight: 700;">${escapeHtml(item.mold_set)}</td>
                                    <td style="color: #64748b; font-weight: 700;" class="text-truncate" style="max-width: 120px;" title="${escapeHtml(item.deskripsi)}">${escapeHtml(item.deskripsi)}</td>
                                </tr>
                            `).join('');
                        }
                    }
                })
                .catch(err => {
                    // Quietly handle fetch errors (e.g. temporary network hiccups)
                });
            }

            // Start auto-refresh interval (every 3000ms = 3 seconds)
            setInterval(fetchDashboardData, 3000);
        });
    </script>
</x-app-layout>
