<x-app-layout>
    <x-slot name="header">
        Edit Data Mesin
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="mb-4">
            <a href="{{ route('mesins.index') }}" class="btn btn-sm btn-light border font-weight-bold px-3.5 py-2 text-gray-700 shadow-xs" style="border-radius: 0.75rem;">
                <i class="fas fa-arrow-left mr-1.5"></i> Kembali ke Daftar Mesin
            </a>
        </div>

        <div class="card shadow-sm border-0 mb-4" style="border-radius: 1rem;">
            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-extrabold text-gray-900"><i class="fas fa-edit text-primary mr-2"></i>Form Edit Data Mesin</h6>
                <span class="badge bg-light text-gray-700 border px-3 py-1 font-weight-bold" style="border-radius: 50rem;">Update Master Data</span>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('mesins.update', $mesin->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-grid-3">
                        {{-- Step 1: No Mesin (TomSelect/Searchable) --}}
                        <div class="form-group-item">
                            <label class="form-label">No Mesin <span class="text-danger">*</span></label>
                            <select name="list_mesin_id" id="list_mesin_id" required class="form-select">
                                @foreach($listMesins as $lm)
                                    <option value="{{ $lm->id }}" {{ old('list_mesin_id', $mesin->list_mesin_id) == $lm->id ? 'selected' : '' }}>{{ $lm->code }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Step 2: Nama Mesin (pre-loaded from current, then cascade) --}}
                        <div class="form-group-item">
                            <label class="form-label">Nama Mesin <span class="text-danger">*</span></label>
                            <select name="name_mesin_id" id="name_mesin_id" required class="form-select"
                                data-selected="{{ old('name_mesin_id', $mesin->name_mesin_id) }}">
                                <option value="">-- Pilih Nama Mesin --</option>
                                @foreach($nameMesins as $nm)
                                    <option value="{{ $nm->id }}" {{ old('name_mesin_id', $mesin->name_mesin_id) == $nm->id ? 'selected' : '' }}>{{ $nm->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Step 3: Class Mesin (pre-loaded from current, then cascade) --}}
                        <div class="form-group-item">
                            <label class="form-label">Class Mesin <span class="text-danger">*</span></label>
                            <select name="class_mesin_id" id="class_mesin_id" required class="form-select"
                                data-selected="{{ old('class_mesin_id', $mesin->class_mesin_id) }}">
                                <option value="">-- Pilih Class Mesin --</option>
                                @foreach($classMesins as $cm)
                                    <option value="{{ $cm->id }}" {{ old('class_mesin_id', $mesin->class_mesin_id) == $cm->id ? 'selected' : '' }}>{{ $cm->class }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-grid-2">
                        <div class="form-group-item">
                            <label class="form-label">Posisi Mesin <span class="text-danger">*</span></label>
                            <select name="posisi" required class="form-select">
                                <option value="Plant 1" {{ old('posisi', $mesin->posisi) == 'Plant 1' ? 'selected' : '' }}>Plant 1</option>
                                <option value="Plant 2" {{ old('posisi', $mesin->posisi) == 'Plant 2' ? 'selected' : '' }}>Plant 2</option>
                                <option value="Plant 4" {{ old('posisi', $mesin->posisi) == 'Plant 4' ? 'selected' : '' }}>Plant 4</option>
                            </select>
                        </div>
                        <div class="form-group-item">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" required class="form-select">
                                <option value="Aktif" {{ old('status', $mesin->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="Tidak Aktif" {{ old('status', $mesin->status) == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                        </div>
                    </div>

                    <div class="pt-3 border-top d-flex align-items-center justify-content-end gap-2">
                        <a href="{{ route('mesins.index') }}" class="btn btn-sm btn-outline-secondary font-weight-bold px-4 py-2" style="border-radius: 0.75rem;">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-sm btn-primary font-weight-bold px-4 py-2" style="border-radius: 0.75rem; background-color: #2563eb; border: none;">
                            <i class="fas fa-save mr-1.5"></i> Update Data
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
            const selectedNameId = nameEl ? nameEl.dataset.selected : null;
            const selectedClassId = classEl ? classEl.dataset.selected : null;

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
                        if (listMesinEl) {
                            const event = new Event('change');
                            listMesinEl.dispatchEvent(event);
                        }
                    }
                });
            }

            // When No Mesin changes → load Nama Mesin
            if (listMesinEl && nameEl) {
                listMesinEl.addEventListener('change', function () {
                    const listId = this.value;
                    nameEl.innerHTML = '<option value="">-- Memuat Nama Mesin... --</option>';
                    classEl.innerHTML = '<option value="">-- Pilih Nama Mesin Terlebih Dahulu --</option>';

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
                                if (String(item.id) === String(selectedNameId)) opt.selected = true;
                                nameEl.appendChild(opt);
                            });
                        });
                });
            }

            // When Nama Mesin changes → load Class Mesin
            if (nameEl && classEl) {
                nameEl.addEventListener('change', function () {
                    const listId = listMesinEl ? listMesinEl.value : '';
                    const nameId = this.value;
                    classEl.innerHTML = '<option value="">-- Memuat Class Mesin... --</option>';

                    if (!nameId) {
                        classEl.innerHTML = '<option value="">-- Pilih Nama Mesin Terlebih Dahulu --</option>';
                        return;
                    }

                    fetch(`${baseUrl}/api/mesin/classes?list_mesin_id=${listId}&name_mesin_id=${nameId}`)
                        .then(res => res.json())
                        .then(data => {
                            classEl.innerHTML = '<option value="">-- Pilih Class Mesin --</option>';
                            data.forEach(item => {
                                const opt = document.createElement('option');
                                opt.value = item.id;
                                opt.textContent = item.class;
                                if (String(item.id) === String(selectedClassId)) opt.selected = true;
                                classEl.appendChild(opt);
                            });
                        });
                });
            }
        });
    </script>
</x-app-layout>
