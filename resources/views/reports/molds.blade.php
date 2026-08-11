<x-app-layout>
    <x-slot name="header">
        Laporan & History Cetakan (Mold Tracking Report)
    </x-slot>

    <!-- Header & Action Toolbar Card -->
    <div class="card shadow-sm border-0 mb-4" style="border-radius: 1rem;">
        <div class="card-body p-3.5">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                
                <!-- Search Form -->
                <form method="GET" action="{{ route('reports.molds') }}" class="d-flex align-items-center gap-2">
                    <div class="position-relative" style="width: 280px;">
                        <i class="fas fa-search position-absolute text-gray-400" style="left: 12px; top: 50%; transform: translateY(-50%); font-size: 0.8rem;"></i>
                        <input type="text" name="search" value="{{ $search }}" placeholder="Cari Spesifik Nama Code Item..." 
                            class="form-control text-xs py-2" style="border-radius: 0.75rem; padding-left: 32px !important;">
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary font-weight-bold px-3.5 py-2" style="border-radius: 0.75rem; background-color: #2563eb; border: none;">
                        <i class="fas fa-filter mr-1"></i> Filter
                    </button>
                    @if($startDate || $endDate || $startCodeId || $endCodeId || $search)
                        <a href="{{ route('reports.molds') }}" class="btn btn-sm btn-outline-secondary font-weight-bold px-3 py-2" style="border-radius: 0.75rem;">Reset</a>
                    @endif
                </form>

                <!-- Action Buttons -->
                <div class="d-flex align-items-center gap-2 shrink-0">
                    @if($canDownload ?? (auth()->user() && (auth()->user()->hasRole('User') || auth()->user()->hasRole('super_admin'))))
                    <button type="button" class="btn btn-sm btn-outline-primary font-weight-bold px-3 py-2" data-bs-toggle="modal" data-bs-target="#exportFilterModalReport" data-toggle="modal" data-target="#exportFilterModalReport" onclick="openReportExportModal()" style="border-radius: 0.75rem;">
                        <i class="fas fa-download mr-1.5"></i> Download Laporan
                    </button>
                    @endif
                    <button type="button" id="open-preview-btn" data-bs-toggle="modal" data-bs-target="#previewModal" class="btn btn-sm btn-outline-secondary font-weight-bold px-3 py-2" style="border-radius: 0.75rem;">
                        <i class="fas fa-eye mr-1.5"></i> Preview Export
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal Filter Download Laporan Mold Master -->
    <div class="modal fade" id="exportFilterModalReport" tabindex="-1" role="dialog" aria-labelledby="exportFilterModalReportLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 1.25rem;">
                <div class="modal-header bg-white border-bottom-0 pb-0 pt-4 px-4">
                    <h5 class="modal-title font-weight-black text-gray-900 text-base" id="exportFilterModalReportLabel">
                        <i class="fas fa-filter text-primary mr-2"></i>Filter Download Laporan Mold Master
                    </h5>
                    <button type="button" class="close text-gray-400" data-bs-dismiss="modal" data-dismiss="modal" onclick="closeReportExportModal()" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="exportFilterReportForm" method="GET" action="{{ route('reports.molds.export-csv') }}">
                    <div class="modal-body p-4 text-xs">
                        <p class="text-gray-500 font-weight-bold mb-3">Pilih rentang tanggal dan rentang Code Item yang ingin di-download (biarkan kosong jika ingin mendownload semua data):</p>
                        
                        <!-- Filter Tanggal -->
                        <div class="form-group mb-3">
                            <label class="font-weight-extrabold text-gray-800 uppercase text-[10px] mb-1 d-block">Rentang Tanggal</label>
                            <div class="row no-gutters gap-2">
                                <div class="col">
                                    <label class="text-[10px] text-gray-500 font-weight-bold mb-1">Mulai Tanggal:</label>
                                    <input type="date" name="start_date" value="{{ $startDate }}" class="form-control text-xs" style="border-radius: 0.65rem;">
                                </div>
                                <div class="col">
                                    <label class="text-[10px] text-gray-500 font-weight-bold mb-1">Sampai Tanggal:</label>
                                    <input type="date" name="end_date" value="{{ $endDate }}" class="form-control text-xs" style="border-radius: 0.65rem;">
                                </div>
                            </div>
                        </div>

                        <!-- Filter Code Item Range with TomSelect -->
                        <div class="form-group mb-3">
                            <label class="font-weight-extrabold text-gray-800 uppercase text-[10px] mb-1 d-block">Rentang Code Item</label>
                            <div class="row no-gutters gap-2">
                                <div class="col">
                                    <label class="text-[10px] text-gray-500 font-weight-bold mb-1">Dari Code Item:</label>
                                    <select name="start_code_item_id" id="report_modal_start_code_item_id" class="form-control text-xs custom-select" style="border-radius: 0.65rem;">
                                        <option value="">-- Semua Code Item --</option>
                                        @foreach($allCodeItems as $codeItem)
                                            <option value="{{ $codeItem->id }}" {{ $startCodeId == $codeItem->id ? 'selected' : '' }}>{{ $codeItem->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="text-[10px] text-gray-500 font-weight-bold mb-1">Sampai Code Item:</label>
                                    <select name="end_code_item_id" id="report_modal_end_code_item_id" class="form-control text-xs custom-select" style="border-radius: 0.65rem;">
                                        <option value="">-- Semua Code Item --</option>
                                        @foreach($allCodeItems as $codeItem)
                                            <option value="{{ $codeItem->id }}" {{ $endCodeId == $codeItem->id ? 'selected' : '' }}>{{ $codeItem->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-top-0 px-4 py-3 d-flex align-items-center justify-content-end gap-2" style="border-radius: 0 0 1.25rem 1.25rem;">
                        <button type="button" class="btn btn-sm btn-secondary font-weight-bold px-3 py-2" data-bs-dismiss="modal" data-dismiss="modal" onclick="closeReportExportModal()" style="border-radius: 0.75rem;">
                            Batal
                        </button>
                        <button type="submit" onclick="submitReportExport('csv')" class="btn btn-sm btn-success font-weight-bold px-3.5 py-2" style="background-color: #059669; border: none; border-radius: 0.75rem;">
                            <i class="fas fa-file-csv mr-1.5"></i> Export CSV
                        </button>
                        <button type="submit" onclick="submitReportExport('pdf')" class="btn btn-sm btn-warning font-weight-bold px-3.5 py-2 text-dark" style="background-color: #f59e0b; border: none; border-radius: 0.75rem; color: #1e293b !important;">
                            <i class="fas fa-print mr-1.5"></i> Print PDF
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="card shadow-sm border-0 mb-4" style="border-radius: 1rem;">
        <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-extrabold text-gray-900"><i class="fas fa-list-alt text-primary mr-2"></i>Daftar Tracking Mold Master</h6>
            <span class="badge bg-light text-gray-700 border px-3 py-1.5 font-weight-bold" style="border-radius: 50rem;">Total: {{ $codeItems->total() }} Records</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive" style="overflow-x: hidden;">
                <table class="table table-hover mb-0 text-xs w-100" style="table-layout: auto;">
                    <thead class="bg-light text-gray-900 font-weight-extrabold border-bottom">
                        <tr>
                            <th class="py-2.5 px-2" style="width: 12%;">Code Item</th>
                            <th class="py-2.5 px-2" style="width: 21%;">Status & Posisi</th>
                            <th class="py-2.5 px-2" style="width: 23%;">Tanggal Aktivitas</th>
                            <th class="py-2.5 px-1 text-center" style="width: 8%;">Masak</th>
                            <th class="py-2.5 px-1 text-center" style="width: 11%;">Sandblast</th>
                            <th class="py-2.5 px-1 text-center" style="width: 8%;">PEJO</th>
                            <th class="py-2.5 px-1 text-center" style="width: 8%;">MJO</th>
                            <th class="py-2.5 px-1 text-center" style="width: 9%;">Histori</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($codeItems as $item)
                            <tr>
                                <!-- Code Item -->
                                <td class="font-weight-extrabold text-gray-900 text-sm align-middle py-2.5 px-2">
                                    {{ $item->name }}
                                </td>

                                <!-- Status & Location -->
                                <td class="align-middle py-2.5 px-2">
                                    @if($item->status_type === 'produksi')
                                        <span class="badge bg-success text-white px-2 py-0.5 font-weight-bold" style="border-radius: 0.4rem; font-size: 0.68rem;">
                                            <i class="fas fa-play-circle mr-1"></i> Sedang Masak
                                        </span>
                                        <div class="text-xs font-weight-extrabold text-gray-900 mt-1">
                                            <i class="fas fa-microchip text-success mr-1"></i> {{ $item->lokasi }}
                                        </div>
                                    @elseif($item->status_type === 'rak')
                                        <span class="badge bg-info text-white px-2 py-0.5 font-weight-bold" style="border-radius: 0.4rem; font-size: 0.68rem;">
                                            <i class="fas fa-archive mr-1"></i> Di Rak
                                        </span>
                                        <div class="text-xs font-weight-extrabold text-gray-900 mt-1">
                                            <i class="fas fa-warehouse text-info mr-1"></i> {{ $item->lokasi }}
                                        </div>
                                    @else
                                        <span class="badge bg-warning text-dark px-2 py-0.5 font-weight-bold" style="border-radius: 0.4rem; font-size: 0.68rem;">
                                            <i class="fas fa-wrench mr-1"></i> Workshop / Storage
                                        </span>
                                        <div class="text-xs font-weight-extrabold text-gray-900 mt-1">
                                            <i class="fas fa-tools text-warning mr-1"></i> {{ $item->lokasi }}
                                        </div>
                                    @endif
                                </td>

                                <!-- Activity Dates -->
                                <td class="align-middle py-2.5 px-2">
                                    <div class="text-xs">
                                        <div class="mb-0.5"><span class="font-weight-bold text-gray-800">Naik:</span> <span class="font-weight-extrabold text-gray-900 ml-1">{{ $item->tgl_naik_terakhir }}</span></div>
                                        <div class="mb-0.5"><span class="font-weight-bold text-gray-800">Sandblast:</span> <span class="font-weight-extrabold text-gray-900 ml-1">{{ $item->tgl_sandblasting_terakhir }}</span></div>
                                        <div><span class="font-weight-bold text-gray-800">Repair:</span> <span class="font-weight-extrabold text-gray-900 ml-1">{{ $item->tgl_repair_terakhir }}</span></div>
                                    </div>
                                </td>

                                <!-- Metric Counts -->
                                <td class="text-center align-middle py-2.5 px-1">
                                    <span class="font-weight-extrabold text-sm text-gray-900">{{ $item->total_masak }}</span>
                                    <span class="text-xs font-weight-bold text-gray-700 d-block">kali</span>
                                </td>

                                <td class="text-center align-middle py-2.5 px-1">
                                    <span class="font-weight-extrabold text-sm text-gray-900">{{ $item->total_sandblasting }}</span>
                                    <span class="text-xs font-weight-bold text-gray-700 d-block">kali</span>
                                </td>

                                <td class="text-center align-middle py-2.5 px-1">
                                    <span class="font-weight-extrabold text-sm text-gray-900">{{ $item->total_pejo }}</span>
                                    <span class="text-xs font-weight-bold text-gray-700 d-block">kali</span>
                                </td>

                                <td class="text-center align-middle py-2.5 px-1">
                                    <span class="font-weight-extrabold text-sm text-gray-900">{{ $item->total_mjo }}</span>
                                    <span class="text-xs font-weight-bold text-gray-700 d-block">kali</span>
                                </td>

                                <!-- Interactive Timeline Button -->
                                <td class="text-center align-middle py-2.5 px-1">
                                    <button type="button" 
                                            class="btn btn-xs btn-primary font-weight-bold px-2 py-1 view-history-btn" 
                                            style="border-radius: 0.4rem; background-color: #2563eb; border: none; font-size: 0.7rem;"
                                            data-bs-toggle="modal"
                                            data-bs-target="#historyModal"
                                            data-id="{{ $item->id }}" 
                                            data-name="{{ $item->name }}">
                                        <i class="fas fa-history mr-1"></i> Histori
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="p-4 text-center text-gray-500 font-weight-bold">
                                    Tidak ada data cetakan yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Links -->
            <div class="p-3 border-top bg-white">
                {{ $codeItems->links() }}
            </div>
        </div>
    </div>

    <!-- PREVIEW EXPORT MODAL -->
    <div id="previewModal" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content shadow-lg border-0" style="border-radius: 1rem; overflow: hidden;">
                <div class="modal-header text-white py-3 px-4 d-flex align-items-center justify-content-between" style="background-color: #0f172a;">
                    <h5 class="modal-title font-weight-bold text-white mb-0 d-flex align-items-center gap-2">
                        <i class="fas fa-file-invoice text-emerald-400"></i> Preview Laporan Cetakan
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4" style="max-height: 70vh; overflow-y: auto;">
                    <div class="text-center py-3 border-bottom mb-4">
                        <h4 class="font-weight-extrabold text-slate-900 mb-1">PT. IRC INOAC INDONESIA</h4>
                        <h6 class="font-weight-bold text-slate-700 mb-1">LAPORAN TRACKING AKTIVITAS, STATUS & REPAIR CETAKAN</h6>
                        <p class="text-xs text-gray-500 mb-0">Periode Filter: {{ $startDate ?? 'Semua' }} s/d {{ $endDate ?? 'Semua' }}</p>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover text-xs align-middle w-100">
                            <thead class="text-white font-weight-extrabold text-xs" style="background-color: #1e293b;">
                                <tr>
                                    <th class="py-2.5 px-2 text-center">NO</th>
                                    <th class="py-2.5 px-2">CODE ITEM</th>
                                    <th class="py-2.5 px-2">LOKASI POSISI</th>
                                    <th class="py-2.5 px-2 text-center">NAIK TERAKHIR</th>
                                    <th class="py-2.5 px-2 text-center">SANDBLAST TERAKHIR</th>
                                    <th class="py-2.5 px-2 text-center">REPAIR TERAKHIR</th>
                                    <th class="py-2.5 px-2 text-center">MASAK</th>
                                    <th class="py-2.5 px-2 text-center">SANDBLAST</th>
                                    <th class="py-2.5 px-2 text-center">PEJO</th>
                                    <th class="py-2.5 px-2 text-center">MJO</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($codeItems as $index => $item)
                                    <tr>
                                        <td class="text-center font-weight-bold text-slate-700 py-2 px-2">{{ $index + 1 }}</td>
                                        <td class="font-weight-extrabold text-slate-900 py-2 px-2">{{ $item->name }}</td>
                                        <td class="font-weight-bold text-slate-800 py-2 px-2">{{ $item->lokasi }}</td>
                                        <td class="text-center font-weight-bold text-slate-800 py-2 px-2">{{ $item->tgl_naik_terakhir }}</td>
                                        <td class="text-center font-weight-bold text-slate-800 py-2 px-2">{{ $item->tgl_sandblasting_terakhir }}</td>
                                        <td class="text-center font-weight-bold text-slate-800 py-2 px-2">{{ $item->tgl_repair_terakhir }}</td>
                                        <td class="text-center font-weight-extrabold text-blue-700 py-2 px-2">{{ $item->total_masak }}</td>
                                        <td class="text-center font-weight-extrabold text-amber-700 py-2 px-2">{{ $item->total_sandblasting }}</td>
                                        <td class="text-center font-weight-extrabold text-rose-700 py-2 px-2">{{ $item->total_pejo }}</td>
                                        <td class="text-center font-weight-extrabold text-sky-700 py-2 px-2">{{ $item->total_mjo }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer bg-slate-50 py-3 px-4 d-flex align-items-center justify-content-end gap-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary font-weight-bold px-3.5 py-2" data-bs-dismiss="modal" style="border-radius: 0.75rem;">
                        <i class="fas fa-times mr-1.5"></i> Tutup
                    </button>
                    <a href="{{ route('reports.molds.export-csv', $queryParams) }}" class="btn btn-sm btn-success font-weight-bold px-3.5 py-2" style="background-color: #059669; border: none; border-radius: 0.75rem;">
                        <i class="fas fa-file-csv mr-1.5"></i> Export CSV
                    </a>
                    <a href="{{ route('reports.molds.print-pdf', $queryParams) }}" target="_blank" class="btn btn-sm btn-warning font-weight-bold px-3.5 py-2 text-dark" style="background-color: #f59e0b; border: none; border-radius: 0.75rem; color: #1e293b !important;">
                        <i class="fas fa-print mr-1.5"></i> Print PDF
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- TIMELINE LOG HISTORI MODAL -->
    <div id="historyModal" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content shadow-lg border-0" style="border-radius: 1rem; overflow: hidden;">
                <div class="modal-header text-white py-3 px-4 d-flex align-items-center justify-content-between" style="background-color: #0f172a;">
                    <h5 class="modal-title font-weight-bold text-white mb-0 d-flex align-items-center gap-2">
                        <i class="fas fa-history text-amber-400"></i> Histori Log: <span id="modal-code-name" class="text-amber-300"></span>
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4" style="max-height: 70vh; overflow-y: auto;">
                    <div id="timeline-loading" class="text-center py-5">
                        <div class="spinner-border text-primary" role="status"></div>
                        <p class="text-xs text-gray-500 mt-2">Memuat timeline histori...</p>
                    </div>
                    <div id="timeline-content" class="space-y-4" style="display: none;"></div>
                </div>
                <div class="modal-footer bg-slate-50 py-3 px-4">
                    <button type="button" class="btn btn-sm btn-outline-secondary font-weight-bold px-4 py-2" data-bs-dismiss="modal" style="border-radius: 0.75rem;">
                        <i class="fas fa-times mr-1.5"></i> Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function openModalSafely(id) {
                const el = document.getElementById(id);
                if (!el) return;
                if (window.bootstrap && window.bootstrap.Modal) {
                    const inst = window.bootstrap.Modal.getInstance(el) || new window.bootstrap.Modal(el);
                    inst.show();
                } else if (window.jQuery && typeof window.jQuery(el).modal === 'function') {
                    window.jQuery(el).modal('show');
                } else {
                    el.classList.add('show');
                    el.style.display = 'block';
                    document.body.classList.add('modal-open');
                }
            }

            function closeModalSafely(id) {
                const el = document.getElementById(id);
                if (!el) return;
                if (window.bootstrap && window.bootstrap.Modal) {
                    const inst = window.bootstrap.Modal.getInstance(el);
                    if (inst) inst.hide();
                } else if (window.jQuery && typeof window.jQuery(el).modal === 'function') {
                    window.jQuery(el).modal('hide');
                }
                el.classList.remove('show');
                el.style.display = 'none';
                document.body.classList.remove('modal-open');
                const backdrops = document.querySelectorAll('.modal-backdrop');
                backdrops.forEach(b => b.remove());
            }

            // Global click listener for dismiss buttons
            document.addEventListener('click', function(e) {
                const dismissBtn = e.target.closest('[data-bs-dismiss="modal"]');
                if (dismissBtn) {
                    const modal = dismissBtn.closest('.modal');
                    if (modal) {
                        closeModalSafely(modal.id);
                    }
                }
            });

            const openPreviewBtn = document.getElementById('open-preview-btn');
            if (openPreviewBtn) {
                openPreviewBtn.addEventListener('click', function() {
                    openModalSafely('previewModal');
                });
            }

            document.querySelectorAll('.view-history-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const codeId = this.getAttribute('data-id');
                    const codeName = this.getAttribute('data-name');

                    const nameEl = document.getElementById('modal-code-name');
                    if (nameEl) nameEl.innerText = codeName;

                    const loadingEl = document.getElementById('timeline-loading');
                    const contentEl = document.getElementById('timeline-content');

                    if (loadingEl) loadingEl.style.display = 'block';
                    if (contentEl) contentEl.style.display = 'none';

                    openModalSafely('historyModal');

                    fetch("{{ url('/reports/molds') }}/" + codeId + "/history")
                        .then(res => res.json())
                        .then(events => {
                            if (loadingEl) loadingEl.style.display = 'none';
                            if (contentEl) contentEl.style.display = 'block';

                            if (!events || events.length === 0) {
                                contentEl.innerHTML = '<div class="alert alert-secondary text-center text-xs font-weight-bold">Belum ada riwayat aktivitas tercatat.</div>';
                                return;
                            }

                            let html = '<div class="list-group list-group-flush">';
                            events.forEach(ev => {
                                let badgeClass = ev.badge || 'bg-secondary text-white';

                                html += `
                                    <div class="list-group-item p-3 border-left border-4 mb-2 shadow-xs" style="border-left-color: #2563eb !important; border-radius: 0.5rem;">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <span class="badge ${badgeClass} px-2.5 py-1 font-weight-bold text-xs">${ev.type}</span>
                                            <span class="text-xs font-weight-bold text-gray-500"><i class="far fa-calendar-alt mr-1"></i>${ev.date}</span>
                                        </div>
                                        <div class="text-xs font-weight-bold text-gray-900">${ev.title}</div>
                                        <div class="text-xs text-gray-600 mt-1">${ev.detail}</div>
                                    </div>
                                `;
                            });
                            html += '</div>';
                            contentEl.innerHTML = html;
                        })
                        .catch(err => {
                            console.error(err);
                            if (loadingEl) loadingEl.style.display = 'none';
                            if (contentEl) {
                                contentEl.style.display = 'block';
                                contentEl.innerHTML = '<div class="alert alert-danger text-center text-xs">Gagal memuat timeline histori.</div>';
                            }
                        });
                });
            });

            if (typeof TomSelect !== 'undefined') {
                const sEl = document.getElementById('report_modal_start_code_item_id');
                const eEl = document.getElementById('report_modal_end_code_item_id');
                if (sEl && !sEl.tomselect) {
                    new TomSelect(sEl, {
                        plugins: {
                            'dropdown_input': {},
                            'clear_button': { title: 'Hapus pilihan' }
                        },
                        allowEmptyOption: true,
                        create: false,
                        maxItems: 1,
                        closeAfterSelect: true,
                        placeholder: "-- Semua Code Item --",
                        sortField: []
                    });
                }
                if (eEl && !eEl.tomselect) {
                    new TomSelect(eEl, {
                        plugins: {
                            'dropdown_input': {},
                            'clear_button': { title: 'Hapus pilihan' }
                        },
                        allowEmptyOption: true,
                        create: false,
                        maxItems: 1,
                        closeAfterSelect: true,
                        placeholder: "-- Semua Code Item --",
                        sortField: []
                    });
                }
            }
        });

        function openReportExportModal() {
            const modalEl = document.getElementById('exportFilterModalReport');
            if (!modalEl) return;
            if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                let modalInstance = bootstrap.Modal.getInstance(modalEl);
                if (!modalInstance) {
                    modalInstance = new bootstrap.Modal(modalEl);
                }
                modalInstance.show();
            } else if (typeof $ !== 'undefined' && $.fn.modal) {
                $('#exportFilterModalReport').modal('show');
            } else {
                modalEl.classList.add('show');
                modalEl.style.display = 'block';
            }
        }

        function closeReportExportModal() {
            const modalEl = document.getElementById('exportFilterModalReport');
            if (!modalEl) return;
            if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                let modalInstance = bootstrap.Modal.getInstance(modalEl);
                if (modalInstance) {
                    modalInstance.hide();
                }
            } else if (typeof $ !== 'undefined' && $.fn.modal) {
                $('#exportFilterModalReport').modal('hide');
            } else {
                modalEl.classList.remove('show');
                modalEl.style.display = 'none';
            }
        }

        function submitReportExport(type) {
            const form = document.getElementById('exportFilterReportForm');
            if (type === 'csv') {
                form.action = "{{ route('reports.molds.export-csv') }}";
                form.target = "_self";
            } else {
                form.action = "{{ route('reports.molds.print-pdf') }}";
                form.target = "_blank";
            }
        }
    </script>
</x-app-layout>
