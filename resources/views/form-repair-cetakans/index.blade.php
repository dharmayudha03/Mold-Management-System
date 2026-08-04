<x-app-layout>
    <x-slot name="header">
        Form PEJO (Repair Cetakan)
    </x-slot>

    <!-- Header Actions & Search Filter Card -->
    <div class="card shadow-sm border-0 mb-4" style="border-radius: 1rem;">
        <div class="card-body p-3.5">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                
                <!-- Search Form -->
                <form method="GET" action="{{ route('form-repair-cetakans.index') }}" class="d-flex align-items-center gap-2">
                    <div class="position-relative" style="width: 280px;">
                        <i class="fas fa-search position-absolute text-gray-400" style="left: 12px; top: 50%; transform: translateY(-50%); font-size: 0.8rem;"></i>
                        <input type="text" name="search" value="{{ $search }}" placeholder="Cari No Doc / Code Item / Masalah..." 
                            class="form-control text-xs py-2" style="border-radius: 0.75rem; padding-left: 32px !important;">
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary font-weight-bold px-3.5 py-2" style="border-radius: 0.75rem; background-color: #2563eb; border: none;">
                        <i class="fas fa-filter mr-1"></i> Filter
                    </button>
                    @if($search)
                        <a href="{{ route('form-repair-cetakans.index') }}" class="btn btn-sm btn-outline-secondary font-weight-bold px-3 py-2" style="border-radius: 0.75rem;">Reset</a>
                    @endif
                </form>

                <!-- Create Button -->
                @if(!auth()->user()->hasRole('User') && !auth()->user()->hasRole('Pe') && !auth()->user()->hasRole('pe'))
                <div class="shrink-0">
                    <a href="{{ route('form-repair-cetakans.create') }}" class="btn btn-sm btn-primary font-weight-bold px-3.5 py-2" style="background-color: #2563eb; border: none; border-radius: 0.75rem;">
                        <i class="fas fa-plus mr-1.5"></i> Tambah Form PEJO
                    </a>
                </div>
                @endif

            </div>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="card shadow-sm border-0 mb-4" style="border-radius: 1rem;">
        <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-extrabold text-gray-900"><i class="fas fa-wrench text-gray-700 mr-2"></i>Daftar Form PEJO (Pengajuan Repair Cetakan)</h6>
            <span class="badge bg-light text-gray-700 border px-3 py-1.5 font-weight-bold" style="border-radius: 50rem;">Total: {{ $formRepairCetakans->total() }} Records</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 text-xs">
                    <thead class="bg-light text-gray-900 font-weight-extrabold border-bottom">
                        <tr>
                            <th>No Doc</th>
                            <th>Tanggal</th>
                            <th>PIC</th>
                            <th>Code Item</th>
                            <th>Mold Set</th>
                            <th>Mold Cav</th>
                            <th>Masalah</th>
                            <th>Foto</th>
                            <th>Status MJO</th>
                            <th class="text-right pr-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($formRepairCetakans as $item)
                            <tr>
                                <td class="font-weight-extrabold text-gray-900">{{ $item->nodoc }}</td>
                                <td class="text-gray-700 font-weight-bold">{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                                <td class="font-weight-bold text-gray-800">{{ $item->detailUser->name ?? '-' }}</td>
                                <td class="font-weight-extrabold text-gray-900 text-sm">{{ $item->listCodeItem->name ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-light text-gray-800 border px-2.5 py-1 font-weight-bold" style="border-radius: 0.5rem;">
                                        {{ $item->setCodeItem->moldset ?? '-' }}
                                    </span>
                                </td>
                                <td class="font-weight-bold text-gray-800">{{ $item->cavCodeItem->moldcav ?? '-' }}</td>
                                <td class="text-gray-700 font-weight-semibold text-truncate" style="max-width: 180px;">{{ $item->masalah }}</td>
                                <td class="align-middle">
                                    @php
                                        $rawGambar = $item->gambar;
                                        $imgs = [];
                                        if (is_string($rawGambar)) {
                                            $decoded = json_decode($rawGambar, true);
                                            if (is_array($decoded)) {
                                                $imgs = $decoded;
                                            } elseif (!empty($rawGambar)) {
                                                $imgs = [$rawGambar];
                                            }
                                        } elseif (is_array($rawGambar)) {
                                            $imgs = $rawGambar;
                                        }
                                    @endphp

                                    @if(count($imgs) > 0)
                                        <div class="d-flex align-items-center gap-1.5 flex-wrap">
                                            @foreach(array_slice($imgs, 0, 3) as $imgPath)
                                                @php $cleanUrl = asset(ltrim(str_replace('\\', '/', $imgPath), '/')); @endphp
                                                <a href="{{ $cleanUrl }}" target="_blank" class="d-inline-block border rounded p-1 bg-white shadow-xs hover:shadow-sm transition-all" title="Klik untuk lihat foto jelas">
                                                    <img src="{{ $cleanUrl }}" class="rounded" style="width: 52px; height: 52px; object-fit: cover;">
                                                </a>
                                            @endforeach
                                            @if(count($imgs) > 3)
                                                <span class="badge bg-secondary text-white font-weight-bold text-xs" style="border-radius: 50rem; padding: 0.35rem 0.5rem;">+{{ count($imgs) - 3 }}</span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-gray-400 font-weight-bold text-xs">-</span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    @if($item->latestMjo)
                                        <span class="badge border px-2.5 py-1 font-weight-bold" style="border-radius: 50rem; background-color: #ecfdf5; color: #047857; border-color: #a7f3d0 !important; font-size: 0.72rem;">
                                            <i class="fas fa-check-circle mr-1" style="color: #10b981;"></i> {{ $item->latestMjo->nodoc }}
                                        </span>
                                    @else
                                        <div class="d-flex flex-column align-items-start gap-1">
                                            <span class="badge border px-2.5 py-1 font-weight-bold" style="border-radius: 50rem; background-color: #fffbe6; color: #b45309; border-color: #fde68a !important; font-size: 0.72rem;">
                                                <i class="fas fa-clock mr-1" style="color: #f59e0b;"></i> Belum MJO
                                            </span>
                                            @if(auth()->user()->hasRole('Pe') || auth()->user()->hasRole('Msd') || auth()->user()->hasRole('super_admin'))
                                            <a href="{{ route('form-mjos.create', ['pejo_id' => $item->id]) }}" class="btn btn-xs btn-outline-primary font-weight-bold px-2 py-0.5 shadow-2xs mt-0.5" style="border-radius: 0.375rem; font-size: 0.68rem;" title="Proses PEJO ini ke Form MJO">
                                                <i class="fas fa-plus mr-1 text-xxs"></i>Buat MJO
                                            </a>
                                            @endif
                                        </div>
                                    @endif
                                </td>
                                <td class="text-right pr-4 align-middle">
                                    @if(!auth()->user()->hasRole('User') && !auth()->user()->hasRole('Leader') && !auth()->user()->hasRole('leader') && !auth()->user()->hasRole('Supervisor') && !auth()->user()->hasRole('supervisor') && !auth()->user()->hasRole('Svp') && !auth()->user()->hasRole('spv') && !auth()->user()->hasRole('Pe') && !auth()->user()->hasRole('pe'))
                                    <div class="dropdown {{ ($loop->last || $loop->count <= 2) ? 'dropup' : '' }} d-inline-block">
                                        <button class="btn btn-xs btn-light text-gray-600 border shadow-xs p-1" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 28px; height: 28px; border-radius: 0.5rem;">
                                            <i class="fas fa-ellipsis-v text-xs"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 py-1" style="border-radius: 0.75rem; font-size: 0.8rem;">
                                            @if(!$item->latestMjo && (auth()->user()->hasRole('Pe') || auth()->user()->hasRole('Msd') || auth()->user()->hasRole('super_admin')))
                                                <li>
                                                    <a href="{{ route('form-mjos.create', ['pejo_id' => $item->id]) }}" class="dropdown-item py-1.5 px-3 text-primary font-weight-bold">
                                                        <i class="fas fa-plus-circle text-primary mr-2"></i> Buat Form MJO
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider my-1"></li>
                                            @endif
                                            <li>
                                                <a href="{{ route('form-repair-cetakans.edit', $item->id) }}" class="dropdown-item py-1.5 px-3 text-gray-700 font-weight-bold">
                                                    <i class="fas fa-edit text-primary mr-2"></i> Edit
                                                </a>
                                            </li>
                                            @if(auth()->user()->hasRole('super_admin'))
                                            <li><hr class="dropdown-divider my-1"></li>
                                            <li>
                                                <form action="{{ route('form-repair-cetakans.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus Form Repair ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item py-1.5 px-3 text-danger font-weight-bold">
                                                        <i class="fas fa-trash-alt text-danger mr-2"></i> Hapus
                                                    </button>
                                                </form>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                    @else
                                        <span class="text-gray-400 font-weight-bold">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-gray-500 py-4 font-weight-bold">
                                    Tidak ada data Form PEJO (Repair Cetakan).
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="p-3 border-top bg-white">
                {{ $formRepairCetakans->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
