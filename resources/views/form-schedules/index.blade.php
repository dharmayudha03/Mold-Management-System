<x-app-layout>
    <x-slot name="header">
        Form Schedule
    </x-slot>

    <!-- Header Actions & Search Filter Card -->
    <div class="card shadow-sm border-0 mb-4" style="border-radius: 1rem;">
        <div class="card-body p-3.5">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                
                <!-- Search Form -->
                <form method="GET" action="{{ route('form-schedules.index') }}" class="d-flex align-items-center gap-2">
                    <div class="position-relative" style="width: 280px;">
                        <i class="fas fa-search position-absolute text-gray-400" style="left: 12px; top: 50%; transform: translateY(-50%); font-size: 0.8rem;"></i>
                        <input type="text" name="search" value="{{ $search }}" placeholder="Cari No Doc / Code Item..." 
                            class="form-control text-xs py-2" style="border-radius: 0.75rem; padding-left: 32px !important;">
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary font-weight-bold px-3.5 py-2" style="border-radius: 0.75rem; background-color: #2563eb; border: none;">
                        <i class="fas fa-filter mr-1"></i> Filter
                    </button>
                    @if($search)
                        <a href="{{ route('form-schedules.index') }}" class="btn btn-sm btn-outline-secondary font-weight-bold px-3 py-2" style="border-radius: 0.75rem;">Reset</a>
                    @endif
                </form>

                <!-- Create Button -->
                @if(!auth()->user()->hasRole('Setup & Maintenance') || auth()->user()->hasRole('super_admin'))
                <div class="shrink-0">
                    <a href="{{ route('form-schedules.create') }}" class="btn btn-sm btn-primary font-weight-bold px-3.5 py-2" style="background-color: #2563eb; border: none; border-radius: 0.75rem;">
                        <i class="fas fa-plus mr-1.5"></i> Tambah Form Schedule
                    </a>
                </div>
                @endif

            </div>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="card shadow-sm border-0 mb-4" style="border-radius: 1rem;">
        <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-extrabold text-gray-900"><i class="fas fa-calendar-check text-gray-700 mr-2"></i>Daftar Form Schedule</h6>
            <span class="badge bg-light text-gray-700 border px-3 py-1.5 font-weight-bold" style="border-radius: 50rem;">Total: {{ $formSchedules->total() }} Records</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive" style="overflow-x: hidden;">
                <table class="table table-hover mb-0 text-xs w-100 align-middle">
                    <thead class="bg-light text-gray-900 font-weight-extrabold border-bottom" style="font-size: 0.75rem;">
                        <tr>
                            <th class="py-2.5 px-2">No Doc</th>
                            <th class="py-2.5 px-2">Tanggal</th>
                            <th class="py-2.5 px-2">PIC</th>
                            <th class="py-2.5 px-2">Code Item</th>
                            <th class="py-2.5 px-2">Mesin</th>
                            <th class="py-2.5 px-2">Kategori</th>
                            <th class="py-2.5 px-2">Shift</th>
                            <th class="py-2.5 px-2">Status</th>
                            <th class="py-2.5 px-2">Dokumen Terkait</th>
                            <th class="py-2.5 px-2 text-right pr-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($formSchedules as $item)
                            <tr>
                                <td class="font-weight-extrabold text-gray-900 py-2 px-2 text-nowrap">{{ $item->nodoc }}</td>
                                <td class="text-gray-700 font-weight-bold py-2 px-2 text-nowrap">{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                                <td class="font-weight-bold text-gray-800 py-2 px-2 text-nowrap">{{ $item->detailUser->name ?? '-' }}</td>
                                <td class="font-weight-extrabold text-gray-900 py-2 px-2 text-nowrap">{{ $item->listCodeItem->name ?? '-' }}</td>
                                <td class="font-weight-extrabold text-gray-900 py-2 px-2 text-nowrap">{{ $item->listMesin->code ?? '-' }}</td>
                                <td class="py-2 px-2 text-nowrap">
                                    <span class="badge bg-light text-gray-800 border px-2 py-0.5 font-weight-bold" style="border-radius: 0.4rem; font-size: 0.68rem;">
                                        {{ $item->kategori->name ?? '-' }}
                                    </span>
                                </td>
                                <td class="py-2 px-2 text-nowrap">
                                    @if($item->shift)
                                        <span class="badge bg-purple-50 text-purple-700 border border-purple-200 px-2 py-0.5 font-weight-bold" style="border-radius: 0.4rem; font-size: 0.68rem;">
                                            <i class="fas fa-clock mr-1"></i> {{ $item->shift }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 font-weight-bold text-xs">-</span>
                                    @endif
                                </td>
                                <td class="py-2 px-2 text-nowrap">
                                    @if(strtoupper($item->status) === 'SELESAI')
                                        <span class="badge bg-success text-white px-2 py-0.5 font-weight-bold" style="border-radius: 0.4rem; font-size: 0.68rem;">
                                            <i class="fas fa-check-circle mr-1"></i> SELESAI
                                        </span>
                                    @else
                                        <span class="badge bg-primary text-white px-2 py-0.5 font-weight-bold" style="border-radius: 0.4rem; font-size: 0.68rem;">
                                            <i class="fas fa-clock mr-1"></i> {{ strtoupper($item->status ?? 'SCHEDULED') }}
                                        </span>
                                    @endif
                                </td>
                                <td class="py-2 px-2 text-nowrap">
                                    @php
                                        $linkedSetup = $item->formSetupCetakans->first();
                                        $linkedSb = $item->formSandblastings->first();
                                    @endphp
                                    @if($linkedSetup)
                                        <span class="badge bg-info-10 text-info border px-2 py-0.5 font-weight-bold d-inline-block" style="border-radius: 0.4rem; font-size: 0.68rem;">
                                            <i class="fas fa-cogs mr-1"></i> {{ $linkedSetup->nodoc }}
                                        </span>
                                    @endif
                                    @if($linkedSb)
                                        <span class="badge bg-warning-10 text-amber-700 border px-2 py-0.5 font-weight-bold d-inline-block" style="border-radius: 0.4rem; font-size: 0.68rem;">
                                            <i class="fas fa-shower mr-1"></i> {{ $linkedSb->nodoc }}
                                        </span>
                                    @endif
                                    @if(!$linkedSetup && !$linkedSb)
                                        <span class="text-gray-400 font-weight-bold text-xs">-</span>
                                    @endif
                                </td>
                                <td class="py-2 pr-3 text-nowrap text-right">
                                    @php
                                        $katName = strtoupper($item->kategori->name ?? '');
                                        $isSandblasting = str_contains($katName, 'SANDBLASTING');
                                        $createParams = ['form_schedule_id' => $item->id];
                                        if ($item->shift) {
                                            $createParams['shift'] = $item->shift;
                                        }
                                        $createUrl = $isSandblasting
                                            ? route('form-sandblastings.create', $createParams)
                                            : route('form-setup-cetakans.create', $createParams);
                                        $createLabel = $isSandblasting ? 'Sandblasting' : 'Setup Cetakan';
                                        $createIcon  = $isSandblasting ? 'fa-shower' : 'fa-cogs';
                                        $createColor = $isSandblasting ? '#f59e0b' : '#0ea5e9';
                                        $alreadyDone = strtoupper($item->status ?? '') === 'SELESAI';
                                    @endphp
                                    <div class="d-flex align-items-center justify-content-end gap-2.5">
                                        @php
                                            $showCreateBtn = !$alreadyDone && !auth()->user()->hasRole('PPIC');
                                            $showEditDelete = (!auth()->user()->hasRole('PPIC') && !auth()->user()->hasRole('Setup & Maintenance')) || auth()->user()->hasRole('super_admin');
                                        @endphp

                                        {{-- Buat Form Button (Setup Cetakan / Sandblasting dari Referensi Schedule) --}}
                                        @if($showCreateBtn)
                                            <a href="{{ $createUrl }}"
                                               class="btn btn-xs font-weight-bold p-1 text-white d-inline-flex align-items-center justify-content-center"
                                               style="border-radius: 0.5rem; width: 26px; height: 26px; background-color: {{ $createColor }}; border: none;"
                                               title="{{ $createLabel }}" data-bs-toggle="tooltip" data-bs-placement="top">
                                                <i class="fas {{ $createIcon }}" style="font-size: 0.65rem;"></i>
                                            </a>
                                        @endif

                                        {{-- Dropdown Edit/Delete --}}
                                        @if($showEditDelete)
                                        <div class="dropdown d-inline-block">
                                            <button class="btn btn-xs btn-light text-gray-600 border shadow-xs p-1"
                                                    type="button" data-bs-toggle="dropdown"
                                                    data-bs-strategy="fixed"
                                                    aria-expanded="false"
                                                    style="width: 26px; height: 26px; border-radius: 0.5rem;">
                                                <i class="fas fa-ellipsis-v" style="font-size: 0.65rem;"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 py-1"
                                                style="border-radius: 0.75rem; font-size: 0.8rem; min-width: 130px; z-index: 9999;">
                                                <li>
                                                    <a href="{{ route('form-schedules.edit', $item->id) }}"
                                                       class="dropdown-item py-1.5 px-3 font-weight-bold text-gray-700">
                                                        <i class="fas fa-edit text-primary mr-2"></i> Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <form action="{{ route('form-schedules.destroy', $item->id) }}"
                                                          method="POST" onsubmit="return confirm('Hapus Form Schedule ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="dropdown-item py-1.5 px-3 font-weight-bold text-danger">
                                                            <i class="fas fa-trash-alt mr-2"></i> Hapus
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                        @endif

                                        @if(!$showCreateBtn && !$showEditDelete)
                                        <span class="text-gray-400 font-weight-bold text-xs">-</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-gray-500 py-4 font-weight-bold">
                                    Tidak ada data Form Schedule.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="p-3 border-top bg-white">
                {{ $formSchedules->links() }}
            </div>
        </div>
    </div>
</x-app-layout>

