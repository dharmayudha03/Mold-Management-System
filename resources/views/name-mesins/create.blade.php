<x-app-layout>
    <x-slot name="header">
        Tambah Nama Mesin
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="mb-4">
            <a href="{{ route('name-mesins.index') }}" class="btn btn-sm btn-light border font-weight-bold px-3.5 py-2 text-gray-700 shadow-xs" style="border-radius: 0.75rem;">
                <i class="fas fa-arrow-left mr-1.5"></i> Kembali ke Nama Mesin
            </a>
        </div>

        <div class="card shadow-sm border-0 mb-4" style="border-radius: 1rem;">
            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-extrabold text-gray-900">
                    <i class="fas fa-layer-group text-primary mr-2"></i>Form Tambah Nama Mesin
                </h6>
                <span class="badge bg-light text-gray-700 border px-3 py-1 font-weight-bold" style="border-radius: 50rem;">Master Data</span>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('name-mesins.store') }}" method="POST">
                    @csrf

                    <!-- Section 1: Relasi No Mesin -->
                    <div class="border-bottom pb-3 mb-4">
                        <h6 class="font-weight-extrabold text-gray-900 mb-0">
                            <i class="fas fa-link text-indigo-600 mr-2"></i>Relasi No Mesin
                        </h6>
                    </div>

                    <div class="form-grid-1 mb-4">
                        <div class="form-group-item">
                            <label class="form-label text-xs font-weight-extrabold text-gray-900 uppercase">NO MESIN <span class="text-danger">*</span></label>
                            <select name="list_mesin_id" id="list_mesin_id" required class="form-select">
                                <option value="">-- Pilih / Ketik No Mesin --</option>
                                @foreach($listMesins as $lm)
                                    <option value="{{ $lm->id }}" {{ old('list_mesin_id') == $lm->id ? 'selected' : '' }}>{{ $lm->code }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Section 2: Nama Mesin -->
                    <div class="border-bottom pb-3 mb-4 pt-4">
                        <h6 class="font-weight-extrabold text-gray-900 mb-0">
                            <i class="fas fa-tag text-emerald-600 mr-2"></i>Nama Mesin
                        </h6>
                    </div>

                    <div class="form-grid-1">
                        <div class="form-group-item">
                            <label class="form-label text-xs font-weight-extrabold text-gray-900 uppercase">NAMA MESIN <span class="text-danger">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                placeholder="CONTOH: INJECTION TOYO 100T"
                                class="form-control uppercase">
                        </div>
                    </div>

                    <div class="pt-4 border-top d-flex align-items-center justify-content-end gap-2 mt-4">
                        <a href="{{ route('name-mesins.index') }}" class="btn btn-sm btn-outline-secondary font-weight-bold px-4 py-2" style="border-radius: 0.75rem;">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-sm btn-primary font-weight-bold px-4 py-2" style="border-radius: 0.75rem; background-color: #2563eb; border: none;">
                            <i class="fas fa-save mr-1.5"></i> Simpan Nama Mesin
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- TomSelect Script for Searchable No Mesin -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const listMesinEl = document.getElementById('list_mesin_id');
            if (window.TomSelect && listMesinEl && !listMesinEl.tomselect) {
                new TomSelect(listMesinEl, {
                    plugins: {
                        'dropdown_input': {},
                        'clear_button': { title: 'Hapus pilihan' }
                    },
                    allowEmptyOption: true,
                    create: false,
                    maxItems: 1,
                    closeAfterSelect: true,
                    placeholder: '-- Pilih / Ketik No Mesin --',
                    sortField: [],
                    render: {
                        no_results: function(data, escape) {
                            return '<div class="no-results" style="padding: 8px 12px; color: #dc2626; font-weight: bold; font-size: 0.85rem;"><i class="fas fa-exclamation-triangle mr-1"></i> Data yang anda cari tidak ada</div>';
                        }
                    }
                });
            }
        });
    </script>
</x-app-layout>
