<x-app-layout>
    <x-slot name="header">
        Form Setup Cetakan
    </x-slot>

    <!-- Header Actions & Search Card -->
    <div class="card shadow-sm border-0 mb-4" style="border-radius: 1rem;">
        <div class="card-body p-3.5">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                
                <!-- Search Form -->
                <form method="GET" action="{{ route('form-setup-cetakans.index') }}" class="d-flex align-items-center gap-2">
                    <div class="position-relative" style="width: 280px;">
                        <i class="fas fa-search position-absolute text-gray-400" style="left: 12px; top: 50%; transform: translateY(-50%); font-size: 0.8rem;"></i>
                        <input type="text" name="search" value="{{ $search }}" placeholder="Cari No Doc / Code Item / Mesin..." 
                            class="form-control text-xs py-2" style="border-radius: 0.75rem; padding-left: 32px !important;">
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary font-weight-bold px-3.5 py-2" style="border-radius: 0.75rem; background-color: #2563eb; border: none;">
                        <i class="fas fa-filter mr-1"></i> Filter
                    </button>
                    @if($search)
                        <a href="{{ route('form-setup-cetakans.index') }}" class="btn btn-sm btn-outline-secondary font-weight-bold px-3 py-2" style="border-radius: 0.75rem;">Reset</a>
                    @endif
                </form>

                <!-- Action Buttons -->
                <div class="d-flex align-items-center gap-2 shrink-0">
                    <button type="button" class="btn btn-sm btn-outline-primary font-weight-bold px-3 py-2" data-bs-toggle="modal" data-bs-target="#exportFilterModal" data-toggle="modal" data-target="#exportFilterModal" onclick="openSetupExportModal()" style="border-radius: 0.75rem;">
                        <i class="fas fa-download mr-1.5"></i> Download Laporan
                    </button>
                    @if(!auth()->user()->hasRole('User'))
                    <a href="{{ route('form-setup-cetakans.create') }}" class="btn btn-sm btn-primary font-weight-bold px-3.5 py-2" style="background-color: #2563eb; border: none; border-radius: 0.75rem;">
                        <i class="fas fa-plus mr-1.5"></i> Tambah Setup
                    </a>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <!-- Modal Filter Download Laporan -->
    <div class="modal fade" id="exportFilterModal" tabindex="-1" role="dialog" aria-labelledby="exportFilterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 1.25rem;">
                <div class="modal-header bg-white border-bottom-0 pb-0 pt-4 px-4">
                    <h5 class="modal-title font-weight-black text-gray-900 text-base" id="exportFilterModalLabel">
                        <i class="fas fa-filter text-primary mr-2"></i>Filter Download Form Setup Cetakan
                    </h5>
                    <button type="button" class="close text-gray-400" data-bs-dismiss="modal" data-dismiss="modal" onclick="closeSetupExportModal()" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="exportFilterSetupForm" method="GET" action="{{ route('form-setup-cetakans.export-csv') }}">
                    <div class="modal-body p-4 text-xs">
                        <p class="text-gray-500 font-weight-bold mb-3">Pilih rentang tanggal dan rentang Code Item yang ingin di-download (biarkan kosong jika ingin mendownload semua data):</p>
                        
                        <!-- Filter Tanggal -->
                        <div class="form-group mb-3">
                            <label class="font-weight-extrabold text-gray-800 uppercase text-[10px] mb-1 d-block">Rentang Tanggal</label>
                            <div class="row no-gutters gap-2">
                                <div class="col">
                                    <label class="text-[10px] text-gray-500 font-weight-bold mb-1">Mulai Tanggal:</label>
                                    <input type="date" name="start_date" class="form-control text-xs" style="border-radius: 0.65rem;">
                                </div>
                                <div class="col">
                                    <label class="text-[10px] text-gray-500 font-weight-bold mb-1">Sampai Tanggal:</label>
                                    <input type="date" name="end_date" class="form-control text-xs" style="border-radius: 0.65rem;">
                                </div>
                            </div>
                        </div>

                        <!-- Filter Code Item Range -->
                        <div class="form-group mb-3">
                            <label class="font-weight-extrabold text-gray-800 uppercase text-[10px] mb-1 d-block">Rentang Code Item</label>
                            <div class="row no-gutters gap-2">
                                <div class="col">
                                    <label class="text-[10px] text-gray-500 font-weight-bold mb-1">Dari Code Item:</label>
                                    <select name="start_code_item_id" class="form-control text-xs custom-select" style="border-radius: 0.65rem;">
                                        <option value="">-- Semua Code Item --</option>
                                        @foreach($listCodeItems as $codeItem)
                                            <option value="{{ $codeItem->id }}">{{ $codeItem->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="text-[10px] text-gray-500 font-weight-bold mb-1">Sampai Code Item:</label>
                                    <select name="end_code_item_id" class="form-control text-xs custom-select" style="border-radius: 0.65rem;">
                                        <option value="">-- Semua Code Item --</option>
                                        @foreach($listCodeItems as $codeItem)
                                            <option value="{{ $codeItem->id }}">{{ $codeItem->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-top-0 px-4 py-3 d-flex align-items-center justify-content-end gap-2" style="border-radius: 0 0 1.25rem 1.25rem;">
                        <button type="button" class="btn btn-sm btn-secondary font-weight-bold px-3 py-2" data-bs-dismiss="modal" data-dismiss="modal" onclick="closeSetupExportModal()" style="border-radius: 0.75rem;">
                            Batal
                        </button>
                        <button type="submit" onclick="submitSetupExport('csv')" class="btn btn-sm btn-success font-weight-bold px-3.5 py-2" style="background-color: #059669; border: none; border-radius: 0.75rem;">
                            <i class="fas fa-file-csv mr-1.5"></i> Export CSV
                        </button>
                        <button type="submit" onclick="submitSetupExport('pdf')" class="btn btn-sm btn-warning font-weight-bold px-3.5 py-2 text-dark" style="background-color: #f59e0b; border: none; border-radius: 0.75rem; color: #1e293b !important;">
                            <i class="fas fa-print mr-1.5"></i> Print PDF
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openSetupExportModal() {
            const modalEl = document.getElementById('exportFilterModal');
            if (!modalEl) return;
            if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                let modalInstance = bootstrap.Modal.getInstance(modalEl);
                if (!modalInstance) {
                    modalInstance = new bootstrap.Modal(modalEl);
                }
                modalInstance.show();
            } else if (typeof $ !== 'undefined' && $.fn.modal) {
                $('#exportFilterModal').modal('show');
            } else {
                modalEl.classList.add('show');
                modalEl.style.display = 'block';
            }
        }

        function closeSetupExportModal() {
            const modalEl = document.getElementById('exportFilterModal');
            if (!modalEl) return;
            if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                let modalInstance = bootstrap.Modal.getInstance(modalEl);
                if (modalInstance) {
                    modalInstance.hide();
                }
            } else if (typeof $ !== 'undefined' && $.fn.modal) {
                $('#exportFilterModal').modal('hide');
            } else {
                modalEl.classList.remove('show');
                modalEl.style.display = 'none';
            }
        }

        function submitSetupExport(type) {
            const form = document.getElementById('exportFilterSetupForm');
            if (type === 'csv') {
                form.action = "{{ route('form-setup-cetakans.export-csv') }}";
                form.target = "_self";
            } else {
                form.action = "{{ route('form-setup-cetakans.print-pdf') }}";
                form.target = "_blank";
            }
        }
    </script>

    <!-- Table Card -->
    <div class="card shadow-sm border-0 mb-4" id="data-table-card" style="border-radius: 1rem;">
        <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-extrabold text-gray-900"><i class="fas fa-file-invoice text-gray-700 mr-2"></i>Daftar Form Setup Cetakan</h6>
            <span class="badge bg-light text-gray-700 border px-3 py-1.5 font-weight-bold" style="border-radius: 50rem;">Total: {{ $formSetupCetakans->total() }} Records</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 text-xs">
                    <thead class="bg-light text-gray-900 font-weight-extrabold border-bottom">
                        <tr>
                            <th class="py-3 pl-4">No Doc</th>
                            <th class="py-3">Tanggal</th>
                            <th class="py-3">Kategori</th>
                            <th class="py-3">Shift</th>
                            <th class="py-3">Code Item</th>
                            <th class="py-3">Mold Set</th>
                            <th class="py-3">Mold Cav</th>
                            <th class="py-3">Mesin</th>
                            <th class="py-3 text-center">Guide Pen</th>
                            <th class="py-3 text-center">Busing</th>
                            <th class="py-3 text-center">Baut</th>
                            <th class="py-3 text-center">Core</th>
                            <th class="py-3 text-center">Piston</th>
                            <th class="py-3 text-center">Pot</th>
                            <th class="py-3 text-center">PL</th>
                            <th class="py-3 text-center">Cav NG</th>
                            <th class="py-3 text-right pr-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($formSetupCetakans as $item)
                            <tr>
                                <td class="font-weight-extrabold text-gray-900 pl-4">{{ $item->nodoc }}</td>
                                <td class="text-gray-700 font-weight-bold">{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                                <td>
                                    <span class="badge bg-light text-gray-800 border px-2.5 py-1 font-weight-bold" style="border-radius: 0.5rem;">
                                        {{ $item->kategori->name ?? '-' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary text-white px-2 py-0.5 font-weight-bold" style="border-radius: 50rem;">
                                        Shift {{ $item->shift }}
                                    </span>
                                </td>
                                <td class="font-weight-extrabold text-gray-900 text-sm">{{ $item->listCodeItem->name ?? '-' }}</td>
                                <td class="font-weight-bold text-gray-800">{{ $item->setCodeItem->moldset ?? '-' }}</td>
                                <td class="font-weight-bold text-gray-800">{{ $item->cavCodeItem->moldcav ?? '-' }}</td>
                                <td class="font-weight-extrabold text-gray-900">{{ $item->listMesin->code ?? '-' }}</td>

                                {{-- Guide Pen --}}
                                <td class="text-center">
                                    @if($item->guidepen === '√')
                                        <span class="badge font-weight-extrabold px-2 py-1" style="background-color: #ecfdf5; color: #065f46; border: 1px solid #6ee7b7; border-radius: 0.5rem; font-size: 0.75rem;">√</span>
                                    @else
                                        <span class="badge font-weight-extrabold px-2 py-1" style="background-color: #fef2f2; color: #991b1b; border: 1px solid #fca5a5; border-radius: 0.5rem; font-size: 0.75rem;">–</span>
                                    @endif
                                </td>

                                {{-- Busing --}}
                                <td class="text-center">
                                    @if($item->busing === '√')
                                        <span class="badge font-weight-extrabold px-2 py-1" style="background-color: #ecfdf5; color: #065f46; border: 1px solid #6ee7b7; border-radius: 0.5rem; font-size: 0.75rem;">√</span>
                                    @else
                                        <span class="badge font-weight-extrabold px-2 py-1" style="background-color: #fef2f2; color: #991b1b; border: 1px solid #fca5a5; border-radius: 0.5rem; font-size: 0.75rem;">–</span>
                                    @endif
                                </td>

                                {{-- Baut --}}
                                <td class="text-center">
                                    @if($item->baut === '√')
                                        <span class="badge font-weight-extrabold px-2 py-1" style="background-color: #ecfdf5; color: #065f46; border: 1px solid #6ee7b7; border-radius: 0.5rem; font-size: 0.75rem;">√</span>
                                    @else
                                        <span class="badge font-weight-extrabold px-2 py-1" style="background-color: #fef2f2; color: #991b1b; border: 1px solid #fca5a5; border-radius: 0.5rem; font-size: 0.75rem;">–</span>
                                    @endif
                                </td>

                                {{-- Core --}}
                                <td class="text-center">
                                    @if($item->core === '√')
                                        <span class="badge font-weight-extrabold px-2 py-1" style="background-color: #ecfdf5; color: #065f46; border: 1px solid #6ee7b7; border-radius: 0.5rem; font-size: 0.75rem;">√</span>
                                    @else
                                        <span class="badge font-weight-extrabold px-2 py-1" style="background-color: #fef2f2; color: #991b1b; border: 1px solid #fca5a5; border-radius: 0.5rem; font-size: 0.75rem;">–</span>
                                    @endif
                                </td>

                                {{-- Piston --}}
                                <td class="text-center">
                                    @if($item->piston === '√')
                                        <span class="badge font-weight-extrabold px-2 py-1" style="background-color: #ecfdf5; color: #065f46; border: 1px solid #6ee7b7; border-radius: 0.5rem; font-size: 0.75rem;">√</span>
                                    @else
                                        <span class="badge font-weight-extrabold px-2 py-1" style="background-color: #fef2f2; color: #991b1b; border: 1px solid #fca5a5; border-radius: 0.5rem; font-size: 0.75rem;">–</span>
                                    @endif
                                </td>

                                {{-- Pot --}}
                                <td class="text-center">
                                    @if($item->pot === '√')
                                        <span class="badge font-weight-extrabold px-2 py-1" style="background-color: #ecfdf5; color: #065f46; border: 1px solid #6ee7b7; border-radius: 0.5rem; font-size: 0.75rem;">√</span>
                                    @else
                                        <span class="badge font-weight-extrabold px-2 py-1" style="background-color: #fef2f2; color: #991b1b; border: 1px solid #fca5a5; border-radius: 0.5rem; font-size: 0.75rem;">–</span>
                                    @endif
                                </td>

                                {{-- PL --}}
                                <td class="text-center">
                                    @if($item->pl === '√')
                                        <span class="badge font-weight-extrabold px-2 py-1" style="background-color: #ecfdf5; color: #065f46; border: 1px solid #6ee7b7; border-radius: 0.5rem; font-size: 0.75rem;">√</span>
                                    @else
                                        <span class="badge font-weight-extrabold px-2 py-1" style="background-color: #fef2f2; color: #991b1b; border: 1px solid #fca5a5; border-radius: 0.5rem; font-size: 0.75rem;">–</span>
                                    @endif
                                </td>

                                {{-- Cavity NG --}}
                                <td class="text-center" style="min-width: 75px;">
                                    @if($item->cav_ng > 0)
                                        <span class="badge font-weight-extrabold px-2.5 py-1" style="background-color: #fff1f2; color: #9f1239; border: 1px solid #fecdd3; border-radius: 0.5rem; font-size: 0.75rem;">
                                            <i class="fas fa-exclamation-triangle mr-1" style="font-size: 0.6rem;"></i>{{ $item->cav_ng }}
                                        </span>
                                    @else
                                        <span class="badge font-weight-extrabold px-2.5 py-1" style="background-color: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; border-radius: 0.5rem; font-size: 0.75rem;">
                                            0
                                        </span>
                                    @endif
                                </td>

                                <td class="text-right pr-4">
                                    @if((!auth()->user()->hasRole('Setup & Maintenance') && !auth()->user()->hasRole('User')) || auth()->user()->hasRole('super_admin'))
                                    <div class="dropdown d-inline-block">
                                        <button class="btn btn-xs btn-light text-gray-600 border shadow-xs p-1" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 28px; height: 28px; border-radius: 0.5rem;">
                                            <i class="fas fa-ellipsis-v text-xs"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 py-1" style="border-radius: 0.75rem; font-size: 0.8rem;">
                                            <li>
                                                <a href="{{ route('form-setup-cetakans.edit', $item->id) }}" class="dropdown-item py-1.5 px-3 text-gray-700 font-weight-bold">
                                                    <i class="fas fa-edit text-primary mr-2"></i> Edit
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider my-1"></li>
                                            <li>
                                                <form action="{{ route('form-setup-cetakans.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus Form Setup ini?')">
                                                    @csrf
                                                    @method('DELETE')
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
                            <tr>
                                <td colspan="17" class="text-center text-gray-500 py-4 font-weight-bold">
                                    Tidak ada data Form Setup Cetakan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="p-3 border-top bg-white">
                {{ $formSetupCetakans->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
