<x-app-layout>
    <x-slot name="header">
        Tambah Data Mesin
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="mb-4">
            <a href="{{ route('mesins.index') }}" class="btn btn-sm btn-light border font-weight-bold px-3.5 py-2 text-gray-700 shadow-xs" style="border-radius: 0.75rem;">
                <i class="fas fa-arrow-left mr-1.5"></i> Kembali ke Daftar Mesin
            </a>
        </div>

        <div class="card shadow-sm border-0 mb-4" style="border-radius: 1rem;">
            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-extrabold text-gray-900"><i class="fas fa-plus-circle text-primary mr-2"></i>Form Tambah Data Mesin</h6>
                <span class="badge bg-light text-gray-700 border px-3 py-1 font-weight-bold" style="border-radius: 50rem;">Input Master Data</span>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('mesins.store') }}" method="POST">
                    @csrf

                    <div class="form-grid-3">
                        {{-- Step 1: No Mesin (TomSelect/Searchable) --}}
                        <div class="form-group-item">
                            <label class="form-label">No Mesin <span class="text-danger">*</span></label>
                            <select name="list_mesin_id" id="list_mesin_id" required class="form-select">
                                <option value="">-- Pilih / Ketik No Mesin --</option>
                                @foreach($listMesins as $lm)
                                    <option value="{{ $lm->id }}" {{ old('list_mesin_id') == $lm->id ? 'selected' : '' }}>{{ $lm->code }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Step 2: Nama Mesin (auto-populated) --}}
                        <div class="form-group-item">
                            <label class="form-label">Nama Mesin <span class="text-danger">*</span></label>
                            <select name="name_mesin_id" id="name_mesin_id" required class="form-select">
                                <option value="">-- Pilih No Mesin Terlebih Dahulu --</option>
                            </select>
                        </div>

                        {{-- Step 3: Class Mesin (auto-populated after Nama Mesin) --}}
                        <div class="form-group-item">
                            <label class="form-label">Class Mesin <span class="text-danger">*</span></label>
                            <select name="class_mesin_id" id="class_mesin_id" required class="form-select">
                                <option value="">-- Pilih Nama Mesin Terlebih Dahulu --</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-grid-2">
                        <div class="form-group-item">
                            <label class="form-label">Posisi Mesin <span class="text-danger">*</span></label>
                            <select name="posisi" required class="form-select">
                                <option value="Plant 1" {{ old('posisi') == 'Plant 1' ? 'selected' : '' }}>Plant 1</option>
                                <option value="Plant 2" {{ old('posisi') == 'Plant 2' ? 'selected' : '' }}>Plant 2</option>
                                <option value="Plant 4" {{ old('posisi') == 'Plant 4' ? 'selected' : '' }}>Plant 4</option>
                            </select>
                        </div>
                        <div class="form-group-item">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" required class="form-select">
                                <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="Tidak Aktif" {{ old('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                        </div>
                    </div>

                    <div class="pt-3 border-top d-flex align-items-center justify-content-end gap-2">
                        <a href="{{ route('mesins.index') }}" class="btn btn-sm btn-outline-secondary font-weight-bold px-4 py-2" style="border-radius: 0.75rem;">
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
            const listMesinEl = document.getElementById('list_mesin_id');
            const nameEl = document.getElementById('name_mesin_id');
            const classEl = document.getElementById('class_mesin_id');
            const baseUrl = "{{ url('/') }}";

            function updateClasses(listId, nameId) {
                if (!classEl) return;
                classEl.innerHTML = '<option value="">-- Memuat Class Mesin... --</option>';
                if (!listId && !nameId) {
                    classEl.innerHTML = '<option value="">-- Pilih Nama Mesin Terlebih Dahulu --</option>';
                    return;
                }

                fetch(`${baseUrl}/api/mesin/classes?list_mesin_id=${listId}&name_mesin_id=${nameId || ''}`)
                    .then(res => res.json())
                    .then(data => {
                        classEl.innerHTML = '<option value="">-- Pilih Class Mesin --</option>';
                        data.forEach(item => {
                            const opt = document.createElement('option');
                            opt.value = item.id;
                            opt.textContent = item.class;
                            classEl.appendChild(opt);
                        });
                        if (data.length === 1) {
                            classEl.value = data[0].id;
                        }
                    })
                    .catch(() => {
                        classEl.innerHTML = '<option value="">-- Gagal memuat data --</option>';
                    });
            }

            function updateNames(listId) {
                if (!nameEl) return;
                nameEl.innerHTML = '<option value="">-- Memuat Nama Mesin... --</option>';
                if (classEl) classEl.innerHTML = '<option value="">-- Pilih Nama Mesin Terlebih Dahulu --</option>';

                if (!listId) {
                    nameEl.innerHTML = '<option value="">-- Pilih No Mesin Terlebih Dahulu --</option>';
                    return;
                }

                fetch(`${baseUrl}/api/mesin/names?list_mesin_id=${listId}`)
                    .then(res => res.json())
                    .then(data => {
                        nameEl.innerHTML = '<option value="">-- Pilih Nama Mesin --</option>';
                        data.forEach(item => {
                            const opt = document.createElement('option');
                            opt.value = item.id;
                            opt.textContent = item.name;
                            nameEl.appendChild(opt);
                        });
                        if (data.length === 1) {
                            nameEl.value = data[0].id;
                            updateClasses(listId, data[0].id);
                        } else {
                            updateClasses(listId, nameEl.value);
                        }
                    })
                    .catch(() => {
                        nameEl.innerHTML = '<option value="">-- Gagal memuat data --</option>';
                    });
            }

            // TomSelect only for No Mesin
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
                    },
                    onChange: function(val) {
                        updateNames(val);
                    }
                });
            }

            if (listMesinEl) {
                listMesinEl.addEventListener('change', function () {
                    updateNames(this.value);
                });
            }

            if (nameEl) {
                nameEl.addEventListener('change', function () {
                    const listId = listMesinEl ? listMesinEl.value : '';
                    updateClasses(listId, this.value);
                });
            }
        });
    </script>
</x-app-layout>
