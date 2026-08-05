<x-app-layout>
    <x-slot name="header">
        Form MJO
    </x-slot>

    <!-- Header Actions & Search Filter Card -->
    <div class="card shadow-sm border-0 mb-4" style="border-radius: 1rem;">
        <div class="card-body p-3.5">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                
                <!-- Search Form -->
                <form method="GET" action="{{ route('form-mjos.index') }}" class="d-flex align-items-center gap-2">
                    <div class="position-relative" style="width: 280px;">
                        <i class="fas fa-search position-absolute text-gray-400" style="left: 12px; top: 50%; transform: translateY(-50%); font-size: 0.8rem;"></i>
                        <input type="text" name="search" value="{{ $search }}" placeholder="Cari No Doc / Code Item..." 
                            class="form-control text-xs py-2" style="border-radius: 0.75rem; padding-left: 32px !important;">
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary font-weight-bold px-3.5 py-2" style="border-radius: 0.75rem; background-color: #2563eb; border: none;">
                        <i class="fas fa-filter mr-1"></i> Filter
                    </button>
                    @if($search)
                        <a href="{{ route('form-mjos.index') }}" class="btn btn-sm btn-outline-secondary font-weight-bold px-3 py-2" style="border-radius: 0.75rem;">Reset</a>
                    @endif
                </form>

                <!-- Create Button -->
                @if((auth()->user()->hasRole('Pe') || auth()->user()->hasRole('pe') || auth()->user()->hasRole('PE') || auth()->user()->hasRole('super_admin')) && !auth()->user()->hasRole('Msd') && !auth()->user()->hasRole('msd') && !auth()->user()->hasRole('MSD'))
                <div class="shrink-0">
                    <a href="{{ route('form-mjos.create') }}" class="btn btn-sm btn-primary font-weight-bold px-3.5 py-2" style="background-color: #2563eb; border: none; border-radius: 0.75rem;">
                        <i class="fas fa-plus mr-1.5"></i> Tambah Form MJO
                    </a>
                </div>
                @endif

            </div>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="card shadow-sm border-0 mb-4" id="data-table-card" style="border-radius: 1rem;">
        <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-extrabold text-gray-900"><i class="fas fa-tools text-gray-700 mr-2"></i>Daftar Form MJO</h6>
            <span class="badge bg-light text-gray-700 border px-3 py-1.5 font-weight-bold" style="border-radius: 50rem;">Total: {{ $formMjos->total() }} Records</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 text-xs">
                    <thead class="bg-light text-gray-900 font-weight-extrabold border-bottom">
                        <tr>
                            <th>No Doc</th>
                            <th>Ref. PEJO</th>
                            <th>Tanggal</th>
                            <th>PIC</th>
                            <th>Code Item</th>
                            <th>Masalah</th>
                            <th>Status Repair</th>
                            <th>Foto</th>
                            <th class="text-right pr-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($formMjos as $item)
                            <tr>
                                <td class="font-weight-extrabold text-gray-900">{{ $item->nodoc }}</td>
                                <td class="align-middle">
                                    @if($item->formRepairCetakan)
                                        <span class="badge border px-2.5 py-1 font-weight-bold" style="border-radius: 50rem; background-color: #ecfeff; color: #0e7490; border-color: #a5f3fc !important; font-size: 0.72rem;">
                                            <i class="fas fa-file-alt mr-1" style="color: #06b6d4;"></i> {{ $item->formRepairCetakan->nodoc }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 font-weight-semibold text-xs">-</span>
                                    @endif
                                </td>
                                <td class="text-gray-700 font-weight-bold">{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                                <td class="font-weight-bold text-gray-800">{{ $item->detailUser->name ?? '-' }}</td>
                                <td class="font-weight-extrabold text-gray-900 text-sm">{{ $item->listCodeItem->name ?? '-' }}</td>
                                <td class="text-gray-700 font-weight-semibold text-truncate" style="max-width: 180px;">{{ $item->masalah }}</td>
                                <td class="align-middle">
                                    @if($item->status == 'Selesai')
                                        <div class="d-flex flex-column align-items-start gap-1">
                                            <span class="badge border px-2.5 py-1 font-weight-bold" style="border-radius: 50rem; background-color: #ecfdf5; color: #047857; border-color: #a7f3d0 !important; font-size: 0.72rem;">
                                                <i class="fas fa-check-circle mr-1" style="color: #10b981;"></i> Selesai
                                            </span>
                                            @if($item->tglselesai)
                                                <span class="text-gray-500 font-weight-semibold" style="font-size: 0.68rem;"><i class="fas fa-calendar-check mr-1 text-emerald-600"></i>{{ \Carbon\Carbon::parse($item->tglselesai)->format('d/m/Y') }}</span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="badge border px-2.5 py-1 font-weight-bold" style="border-radius: 50rem; background-color: #fffbe6; color: #b45309; border-color: #fde68a !important; font-size: 0.72rem;">
                                            <i class="fas fa-clock mr-1" style="color: #f59e0b;"></i> Dalam Proses
                                        </span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    @php
                                        $rawGambar = $item->gambar;
                                        $imgs = [];
                                        if (is_string($rawGambar)) {
                                            $decoded = json_decode($rawGambar, true);
                                            if (is_array($decoded)) $imgs = $decoded;
                                            elseif (!empty($rawGambar)) $imgs = [$rawGambar];
                                        } elseif (is_array($rawGambar)) {
                                            $imgs = $rawGambar;
                                        }

                                        $rawSelesai = $item->gambar_selesai;
                                        $imgsSelesai = [];
                                        if (is_string($rawSelesai)) {
                                            $decodedS = json_decode($rawSelesai, true);
                                            if (is_array($decodedS)) $imgsSelesai = $decodedS;
                                            elseif (!empty($rawSelesai)) $imgsSelesai = [$rawSelesai];
                                        } elseif (is_array($rawSelesai)) {
                                            $imgsSelesai = $rawSelesai;
                                        }
                                    @endphp

                                    <div class="d-flex flex-column gap-1">
                                        @if(count($imgs) > 0)
                                            <div class="d-flex align-items-center gap-1 flex-wrap">
                                                <span class="text-gray-400 font-weight-bold text-xxs block w-100">Laporan:</span>
                                                @foreach(array_slice($imgs, 0, 2) as $imgPath)
                                                    @php $cleanUrl = asset(ltrim(str_replace('\\', '/', $imgPath), '/')); @endphp
                                                    <a href="{{ $cleanUrl }}" target="_blank" class="d-inline-block border rounded p-0.5 bg-white shadow-xs hover:shadow-sm" title="Foto Masalah">
                                                        <img src="{{ $cleanUrl }}" class="rounded" style="width: 42px; height: 42px; object-fit: cover;">
                                                    </a>
                                                @endforeach
                                                @if(count($imgs) > 2)
                                                    <span class="badge bg-light text-gray-600 border font-weight-bold text-xxs" style="border-radius: 50rem; padding: 0.2rem 0.4rem;">+{{ count($imgs) - 2 }}</span>
                                                @endif
                                            </div>
                                        @endif

                                        @if(count($imgsSelesai) > 0)
                                            <div class="d-flex align-items-center gap-1 flex-wrap mt-1">
                                                <span class="text-emerald-600 font-weight-bold text-xxs block w-100"><i class="fas fa-check-double mr-0.5"></i>Hasil Repair:</span>
                                                @foreach(array_slice($imgsSelesai, 0, 2) as $imgPathS)
                                                    @php $cleanUrlS = asset(ltrim(str_replace('\\', '/', $imgPathS), '/')); @endphp
                                                    <a href="{{ $cleanUrlS }}" target="_blank" class="d-inline-block border border-emerald-300 rounded p-0.5 bg-emerald-50 shadow-xs hover:shadow-sm" title="Foto Hasil Perbaikan Mold Shop">
                                                        <img src="{{ $cleanUrlS }}" class="rounded" style="width: 42px; height: 42px; object-fit: cover;">
                                                    </a>
                                                @endforeach
                                                @if(count($imgsSelesai) > 2)
                                                    <span class="badge bg-emerald-100 text-emerald-700 border border-emerald-200 font-weight-bold text-xxs" style="border-radius: 50rem; padding: 0.2rem 0.4rem;">+{{ count($imgsSelesai) - 2 }}</span>
                                                @endif
                                            </div>
                                        @endif

                                        @if(count($imgs) == 0 && count($imgsSelesai) == 0)
                                            <span class="text-gray-400 font-weight-bold text-xs">-</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="text-right pr-4 align-middle whitespace-nowrap">
                                    @if(auth()->user()->hasRole('super_admin'))
                                        <div class="d-inline-flex align-items-center gap-1">
                                            <!-- Tombol Edit PE Langsung (Hanya Super Admin) -->
                                            <a href="{{ route('form-mjos.edit', $item->id) }}" class="btn btn-xs font-weight-bold px-2 py-0.5 border shadow-2xs" style="border-radius: 0.375rem; font-size: 0.68rem; color: #3730a3; background-color: #e0e7ff; border-color: #c7d2fe !important;" title="Edit Data MJO (PE)">
                                                <i class="fas fa-edit mr-1" style="font-size: 0.65rem;"></i>Edit PE
                                            </a>

                                            <a href="{{ route('form-mjos.edit', $item->id) }}#moldshop" class="btn btn-xs font-weight-bold px-2.5 py-1 text-white shadow-xs" style="border-radius: 0.5rem; background-color: #0284c7; border: none; font-size: 0.68rem;" title="Update Hasil Mold Shop">
                                                <i class="fas fa-tools mr-1"></i> Update M.Shop
                                            </a>

                                            <form action="{{ route('form-mjos.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus Form MJO ini?')" class="d-inline ml-1">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-xs btn-outline-danger font-weight-bold px-2 py-1" style="border-radius: 0.5rem;" title="Hapus MJO">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @elseif(auth()->user()->hasRole('Msd') || auth()->user()->hasRole('msd') || auth()->user()->hasRole('MSD'))
                                        @if($item->status == 'Selesai')
                                            <span class="text-gray-400 font-weight-bold">-</span>
                                        @else
                                            <a href="{{ route('form-mjos.edit', $item->id) }}#moldshop" class="btn btn-xs font-weight-bold px-2.5 py-1 text-white shadow-xs" style="border-radius: 0.5rem; background-color: #0284c7; border: none; font-size: 0.68rem;" title="Update Hasil Mold Shop">
                                                <i class="fas fa-tools mr-1"></i> Update M.Shop
                                            </a>
                                        @endif
                                    @else
                                        <span class="text-gray-400 font-weight-bold">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-gray-500 py-4 font-weight-bold">
                                    Tidak ada data Form MJO.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="p-3 border-top bg-white">
                {{ $formMjos->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
