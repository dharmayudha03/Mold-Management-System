<x-app-layout>
    <x-slot name="header">
        Penomoran Rak Cetakan
    </x-slot>

    <!-- Filter & Action Card -->
    <div class="card shadow-sm border-0 mb-4" style="border-radius: 1rem;">
        <div class="card-body p-3.5">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                <form method="GET" action="{{ route('penomoran-raks.index') }}" class="d-flex align-items-center gap-2">
                    <div class="position-relative" style="width: 280px;">
                        <i class="fas fa-search position-absolute text-gray-400" style="left: 12px; top: 50%; transform: translateY(-50%); font-size: 0.8rem;"></i>
                        <input type="text" name="search" value="{{ $search }}" placeholder="Cari Code Item / Rak..." 
                            class="form-control text-xs py-2" style="border-radius: 0.75rem; padding-left: 32px !important;">
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary font-weight-bold px-3.5 py-2" style="border-radius: 0.75rem; background-color: #2563eb; border: none;">
                        <i class="fas fa-filter mr-1"></i> Filter
                    </button>
                    @if($search)
                        <a href="{{ route('penomoran-raks.index') }}" class="btn btn-sm btn-outline-secondary font-weight-bold px-3 py-2" style="border-radius: 0.75rem;">Reset</a>
                    @endif
                </form>

                @if(!auth()->user()->hasRole('User'))
                <div class="shrink-0">
                    <a href="{{ route('penomoran-raks.create') }}" class="btn btn-sm btn-primary font-weight-bold px-3.5 py-2" style="background-color: #2563eb; border: none; border-radius: 0.75rem;">
                        <i class="fas fa-plus mr-1.5"></i> Tambah Penomoran Rak
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="card shadow-sm border-0 mb-4" style="border-radius: 1rem;">
        <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-extrabold text-gray-900"><i class="fas fa-boxes text-gray-700 mr-2"></i>Daftar Penomoran Rak Cetakan</h6>
            <span class="badge bg-light text-gray-700 border px-3 py-1.5 font-weight-bold" style="border-radius: 50rem;">Total: {{ $penomoranRaks->total() }} Records</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 text-xs">
                    <thead class="bg-light text-gray-900 font-weight-extrabold border-bottom">
                        <tr>
                            <th>Code Item</th>
                            <th>Mold Set</th>
                            <th>Mold Cav</th>
                            <th>Rak</th>
                            <th>No Rak</th>
                            <th class="text-right pr-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($penomoranRaks as $item)
                            <tr>
                                <td class="font-weight-extrabold text-gray-900 text-sm">{{ $item->listCodeItem->name ?? '-' }}</td>
                                <td class="font-weight-bold text-gray-800">{{ $item->setCodeItem->moldset ?? '-' }}</td>
                                <td class="font-weight-bold text-gray-800">{{ $item->cavCodeItem->moldcav ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-light text-gray-800 border px-2.5 py-1 font-weight-bold" style="border-radius: 0.5rem;">
                                        {{ $item->listRak->rak ?? $item->rak ?? '-' }}
                                    </span>
                                </td>
                                <td class="font-weight-extrabold text-gray-900">
                                    <span class="badge bg-light text-gray-800 border px-2.5 py-1 font-weight-bold" style="border-radius: 0.5rem;">
                                        {{ $item->listNoRak->norak ?? $item->norak ?? '-' }}
                                    </span>
                                </td>
                                <td class="text-right pr-4">
                                    @if((!auth()->user()->hasRole('Setup & Maintenance') && !auth()->user()->hasRole('User')) || auth()->user()->hasRole('super_admin'))
                                    <div class="dropdown d-inline-block">
                                        <button class="btn btn-xs btn-light text-gray-600 border shadow-xs p-1" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 28px; height: 28px; border-radius: 0.5rem;">
                                            <i class="fas fa-ellipsis-v text-xs"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 py-1" style="border-radius: 0.75rem; font-size: 0.8rem;">
                                            <li>
                                                <a href="{{ route('penomoran-raks.edit', $item->id) }}" class="dropdown-item py-1.5 px-3 text-gray-700 font-weight-bold">
                                                    <i class="fas fa-edit text-primary mr-2"></i> Edit
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider my-1"></li>
                                            <li>
                                                <form action="{{ route('penomoran-raks.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus Penomoran Rak ini?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="dropdown-item py-1.5 px-3 text-danger font-weight-bold">
                                                        <i class="fas fa-trash-alt text-danger mr-2"></i> Hapus
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                    @else
                                    <span class="text-gray-400 font-weight-bold">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center text-gray-500 py-4 font-weight-bold">Tidak ada data.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-3 border-top bg-white">{{ $penomoranRaks->links() }}</div>
        </div>
    </div>
</x-app-layout>
