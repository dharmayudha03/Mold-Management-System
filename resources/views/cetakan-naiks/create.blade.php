<x-app-layout>
    <x-slot name="header">
        Tambah Cetakan Naik
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="mb-4">
            <a href="{{ route('cetakan-naiks.index') }}" class="btn btn-sm btn-light border font-weight-bold px-3.5 py-2 text-gray-700 shadow-xs" style="border-radius: 0.75rem;">
                <i class="fas fa-arrow-left mr-1.5"></i> Kembali ke Cetakan Naik
            </a>
        </div>

        <div class="card shadow-sm border-0 mb-4" style="border-radius: 1rem;">
            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-extrabold text-gray-900"><i class="fas fa-plus-circle text-primary mr-2"></i>Form Tambah Cetakan Naik</h6>
                <span class="badge bg-light text-gray-700 border px-3 py-1 font-weight-bold" style="border-radius: 50rem;">Input Operating Data</span>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('cetakan-naiks.store') }}" method="POST">
                    @csrf

                    <div class="form-grid-2 mb-4">
                        <div class="form-group-item">
                            <label class="form-label">Tanggal Naik <span class="text-danger">*</span></label>
                            <input type="date" name="tanggalnaik" value="{{ old('tanggalnaik', date('Y-m-d')) }}" required class="form-control">
                        </div>

                        <div class="form-group-item">
                            <label class="form-label">Mesin <span class="text-danger">*</span></label>
                            <select name="list_mesin_id" id="list_mesin_id" required class="form-select">
                                <option value="">-- Pilih Mesin --</option>
                                @foreach($listMesins as $lm)
                                    <option value="{{ $lm->id }}" {{ old('list_mesin_id') == $lm->id ? 'selected' : '' }}>{{ $lm->code }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-grid-3 mb-4">
                        <div class="form-group-item">
                            <label class="form-label">Code Item <span class="text-danger">*</span></label>
                            <select name="list_code_item_id" id="list_code_item_id" required class="form-select">
                                <option value="">-- Pilih Code Item --</option>
                                @foreach($listCodeItems as $ci)
                                    <option value="{{ $ci->id }}" {{ old('list_code_item_id') == $ci->id ? 'selected' : '' }}>{{ $ci->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group-item">
                            <label class="form-label">Mold Set <span class="text-danger">*</span></label>
                            <select name="set_code_item_id" id="set_code_item_id" required class="form-select">
                                <option value="">-- Pilih Code Item Terlebih Dahulu --</option>
                            </select>
                        </div>

                        <div class="form-group-item">
                            <label class="form-label">Mold Cavity <span class="text-danger">*</span></label>
                            <select name="cav_code_item_id" id="cav_code_item_id" required class="form-select">
                                <option value="">-- Pilih Code Item Terlebih Dahulu --</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-grid-1 mb-4">
                        <div class="form-group-item">
                            <label class="form-label">Keterangan <span class="text-danger">*</span></label>
                            <input type="text" name="keterangan" value="{{ old('keterangan') }}" required placeholder="Contoh: CETAKAN NAIK UNTUK RUNNING PRODUKSI" class="form-control uppercase">
                        </div>
                    </div>

                    <div class="pt-3 border-top d-flex align-items-center justify-content-end gap-2">
                        <a href="{{ route('cetakan-naiks.index') }}" class="btn btn-sm btn-outline-secondary font-weight-bold px-4 py-2" style="border-radius: 0.75rem;">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-sm btn-primary font-weight-bold px-4 py-2" style="border-radius: 0.75rem; background-color: #2563eb; border: none;">
                            <i class="fas fa-save mr-1.5"></i> Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const codeItemEl = document.getElementById('list_code_item_id');
            const setEl = document.getElementById('set_code_item_id');
            const cavEl = document.getElementById('cav_code_item_id');
            const mesinEl = document.getElementById('list_mesin_id');
            const baseUrl = "{{ url('/') }}";

            // TomSelect for Code Item & Mesin
            if (window.TomSelect) {
                if (codeItemEl && !codeItemEl.tomselect) {
                    new TomSelect(codeItemEl, { 
                        plugins: {
                            'dropdown_input': {},
                            'clear_button': { title: 'Hapus pilihan' }
                        },
                        allowEmptyOption: true,
                        create: false, 
                        maxItems: 1, 
                        closeAfterSelect: true,
                        placeholder: '-- Pilih Code Item --',
                        sortField: [],
                        render: {
                            no_results: function(data, escape) {
                                return '<div class="no-results p-2 text-xs text-gray-500 font-weight-bold">Code item yang dicari tidak ada</div>';
                            }
                        },
                        onChange: function(val) {
                            updateSets(val);
                            updateCavs(val, setEl ? setEl.value : '');
                        }
                    });
                }
                if (mesinEl && !mesinEl.tomselect) {
                    new TomSelect(mesinEl, { 
                        plugins: {
                            'dropdown_input': {},
                            'clear_button': { title: 'Hapus pilihan' }
                        },
                        allowEmptyOption: true,
                        create: false, 
                        maxItems: 1, 
                        closeAfterSelect: true, 
                        placeholder: '-- Pilih / Ketik Mesin --',
                        sortField: [],
                        render: {
                            no_results: function(data, escape) {
                                return '<div class="no-results" style="padding: 8px 12px; color: #dc2626; font-weight: bold; font-size: 0.85rem;"><i class="fas fa-exclamation-triangle mr-1"></i> Data yang anda cari tidak ada</div>';
                            }
                        }
                    });
                }
            }

            function updateSets(listId) {
                if (!setEl) return;
                setEl.innerHTML = '<option value="">-- Memuat Mold Set... --</option>';
                if (!listId) {
                    setEl.innerHTML = '<option value="">-- Pilih Code Item Terlebih Dahulu --</option>';
                    return;
                }
                fetch(`${baseUrl}/api/code-item/sets?list_code_item_id=${listId}`)
                    .then(res => res.json())
                    .then(data => {
                        setEl.innerHTML = '<option value="">-- Pilih Mold Set --</option>';
                        data.forEach(item => {
                            const opt = document.createElement('option');
                            opt.value = item.id;
                            opt.textContent = item.moldset;
                            setEl.appendChild(opt);
                        });
                    });
            }

            function updateCavs(listId, setId) {
                if (!cavEl) return;
                cavEl.innerHTML = '<option value="">-- Memuat Mold Cavity... --</option>';
                if (!listId) {
                    cavEl.innerHTML = '<option value="">-- Pilih Code Item Terlebih Dahulu --</option>';
                    return;
                }
                fetch(`${baseUrl}/api/code-item/cavs?list_code_item_id=${listId}&set_code_item_id=${setId}`)
                    .then(res => res.json())
                    .then(data => {
                        cavEl.innerHTML = '<option value="">-- Pilih Mold Cavity --</option>';
                        data.forEach(item => {
                            const opt = document.createElement('option');
                            opt.value = item.id;
                            opt.textContent = item.moldcav;
                            cavEl.appendChild(opt);
                        });
                    });
            }

            if (codeItemEl) {
                codeItemEl.addEventListener('change', function () {
                    const listId = this.value;
                    updateSets(listId);
                    updateCavs(listId, setEl ? setEl.value : '');
                });
            }

            if (setEl) {
                setEl.addEventListener('change', function () {
                    const listId = codeItemEl ? codeItemEl.value : '';
                    const setId = this.value;
                    updateCavs(listId, setId);
                });
            }
        });
    </script>
</x-app-layout>
