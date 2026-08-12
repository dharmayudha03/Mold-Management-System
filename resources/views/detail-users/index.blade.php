<x-app-layout>
    <x-slot name="header">
        Detail Users (Karyawan PIC)
    </x-slot>

    <!-- Top Header Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-4">
            <div class="card shadow-sm border-0 p-3" style="border-radius: 1rem; background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-xs font-weight-bold text-gray-500 uppercase tracking-wider mb-1">Total Karyawan PIC</div>
                        <div class="h4 mb-0 font-weight-extrabold text-gray-900">{{ $detailUsers->total() }}</div>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-primary" style="width: 48px; height: 48px; background-color: #eff6ff;">
                        <i class="fas fa-users text-lg"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card shadow-sm border-0 p-3" style="border-radius: 1rem; background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-xs font-weight-bold text-gray-500 uppercase tracking-wider mb-1">Role / Penugasan</div>
                        <div class="h4 mb-0 font-weight-extrabold text-indigo-600">
                            {{ \App\Models\DetailUser::distinct('role_id')->count() }} Role
                        </div>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-indigo-600" style="width: 48px; height: 48px; background-color: #eef2ff;">
                        <i class="fas fa-user-shield text-lg"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card shadow-sm border-0 p-3" style="border-radius: 1rem; background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-xs font-weight-bold text-gray-500 uppercase tracking-wider mb-1">Status Operasional</div>
                        <div class="h4 mb-0 font-weight-extrabold text-emerald-600">
                            <i class="fas fa-check-circle text-xs mr-1"></i>Aktif
                        </div>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-emerald-600" style="width: 48px; height: 48px; background-color: #ecfdf5;">
                        <i class="fas fa-id-badge text-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Header Actions & Search Card -->
    <div class="card shadow-sm border-0 mb-4" style="border-radius: 1rem;">
        <div class="card-body p-3.5">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                
                <!-- Search Form -->
                <form method="GET" action="{{ url()->current() }}" class="d-flex align-items-center gap-2">
                    <div class="position-relative" style="width: 300px;">
                        <i class="fas fa-search position-absolute text-gray-400" style="left: 12px; top: 50%; transform: translateY(-50%); font-size: 0.8rem;"></i>
                        <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama karyawan..." 
                            class="form-control text-xs py-2" style="border-radius: 0.75rem; padding-left: 34px !important;">
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary font-weight-bold px-3.5 py-2" style="border-radius: 0.75rem; background-color: #2563eb; border: none;">
                        <i class="fas fa-filter mr-1"></i> Cari
                    </button>
                    @if($search)
                        <a href="{{ route('detail-users.index') }}" class="btn btn-sm btn-outline-secondary font-weight-bold px-3 py-2" style="border-radius: 0.75rem;">Reset</a>
                    @endif
                </form>

                <!-- Action Buttons -->
                <div class="d-flex align-items-center gap-2 shrink-0">
                    <a href="{{ route('detail-users.create') }}" class="btn btn-sm btn-primary font-weight-bold px-3.5 py-2" style="background-color: #2563eb; border: none; border-radius: 0.75rem;">
                        <i class="fas fa-plus mr-1.5"></i> Tambah Detail User
                    </a>
                </div>

            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card shadow-sm border-0 mb-4" style="border-radius: 1rem;">
        <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-extrabold text-gray-900">
                <i class="fas fa-id-card text-primary mr-2"></i>Daftar Detail Users (Karyawan PIC)
            </h6>
            <span class="badge bg-light text-gray-700 border px-3 py-1.5 font-weight-bold" style="border-radius: 50rem;">Total: {{ $detailUsers->total() }} Record</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 text-xs">
                    <thead class="bg-light text-gray-900 font-weight-extrabold border-bottom">
                        <tr>
                            <th class="py-3 pl-4" style="width: 70px;">NO</th>
                            <th class="py-3">NAMA KARYAWAN PIC</th>
                            <th class="py-3">GROUP / ROLE TUGAS</th>
                            <th class="py-3 text-right pr-4" style="width: 100px;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($detailUsers as $index => $item)
                            <tr>
                                <td class="font-weight-extrabold text-gray-500 pl-4 align-middle">
                                    {{ $detailUsers->firstItem() + $index }}
                                </td>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center text-primary font-weight-extrabold shadow-xs shrink-0" style="width: 34px; height: 34px; background-color: #eff6ff; border: 1px solid #bfdbfe; font-size: 0.75rem;">
                                            {{ strtoupper(substr($item->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="font-weight-extrabold text-gray-900 text-sm">{{ $item->name }}</div>
                                            <div class="text-[11px] text-gray-500 font-weight-bold">Petugas / Operator PIC</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    @php
                                        $roleName = $item->role->name ?? '-';
                                        $bg = '#f1f5f9';
                                        $color = '#475569';
                                        $border = '#cbd5e1';

                                        if (str_contains($roleName, 'Setup') && str_contains($roleName, 'Maintenance')) {
                                            $bg = '#eff6ff'; $color = '#1d4ed8'; $border = '#bfdbfe';
                                        } elseif (str_contains($roleName, 'Setup')) {
                                            $bg = '#eef2ff'; $color = '#4338ca'; $border = '#c7d2fe';
                                        } elseif (str_contains($roleName, 'Maintenance')) {
                                            $bg = '#ecfdf5'; $color = '#047857'; $border = '#a7f3d0';
                                        } elseif (str_contains($roleName, 'Leader') || str_contains($roleName, 'Supervisor')) {
                                            $bg = '#faf5ff'; $color = '#7e22ce'; $border = '#e9d5ff';
                                        }
                                    @endphp
                                    <span class="badge px-3 py-1.5 font-weight-bold" style="background-color: {{ $bg }}; color: {{ $color }}; border: 1px solid {{ $border }}; border-radius: 0.5rem; font-size: 0.75rem;">
                                        <i class="fas fa-shield-alt mr-1" style="font-size: 0.65rem;"></i>{{ $roleName }}
                                    </span>
                                </td>
                                <td class="text-right pr-4 align-middle">
                                    <div class="d-flex align-items-center justify-content-end gap-1.5">
                                        <a href="{{ route('detail-users.edit', $item->id) }}" class="btn btn-xs btn-light text-primary border p-0 d-inline-flex align-items-center justify-content-center shadow-2xs" style="width: 28px; height: 28px; border-radius: 0.45rem; background-color: #f0f9ff; border-color: #bae6fd !important;" title="Edit Karyawan">
                                            <i class="fas fa-pen" style="font-size: 0.65rem;"></i>
                                        </a>
                                        <form action="{{ route('detail-users.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus karyawan {{ $item->name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-xs btn-light text-danger border p-0 d-inline-flex align-items-center justify-content-center shadow-2xs" style="width: 28px; height: 28px; border-radius: 0.45rem; background-color: #fff1f2; border-color: #fecdd3 !important;" title="Hapus Karyawan">
                                                <i class="fas fa-trash-alt" style="font-size: 0.65rem;"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-gray-500 py-5 font-weight-bold">
                                    <div class="py-3">
                                        <i class="fas fa-users-slash text-gray-300 mb-2" style="font-size: 2rem;"></i>
                                        <div>Tidak ada data karyawan PIC.</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="p-3 border-top bg-white">
                {{ $detailUsers->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
