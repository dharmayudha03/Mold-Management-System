<x-app-layout>
    <x-slot name="header">
        Edit Form Schedule
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="mb-4">
            <a href="{{ route('form-schedules.index') }}" class="btn btn-sm btn-light border font-weight-bold px-3.5 py-2 text-gray-700 shadow-xs" style="border-radius: 0.75rem;">
                <i class="fas fa-arrow-left mr-1.5"></i> Kembali ke Form Schedule
            </a>
        </div>

        <div class="card shadow-sm border-0 mb-4" style="border-radius: 1rem;">
            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-extrabold text-gray-900"><i class="fas fa-calendar-alt text-primary mr-2"></i>Edit Form Schedule Pemeliharaan</h6>
                <span class="badge bg-light text-gray-700 border px-3 py-1 font-weight-bold" style="border-radius: 50rem;">No Doc: {{ $formSchedule->nodoc }}</span>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('form-schedules.update', $formSchedule->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Header Doc Info -->
                    <div class="form-grid-2 mb-4">
                        <div class="form-group-item">
                            <label class="form-label">No Document</label>
                            <input type="text" name="nodoc" value="{{ $formSchedule->nodoc }}" readonly class="form-control font-weight-extrabold text-primary bg-light">
                        </div>
                        <div class="form-group-item">
                            <label class="form-label">Tanggal Schedule <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal" value="{{ old('tanggal', $formSchedule->tanggal) }}" required class="form-control">
                        </div>
                    </div>

                    <!-- Detail Karyawan -->
                    <div class="border-bottom pb-3 mb-4 pt-2">
                        <h6 class="font-weight-extrabold text-gray-900 mb-1"><i class="fas fa-users text-primary mr-2"></i>Detail Karyawan / Group Role</h6>
                    </div>

                    <div class="form-grid-2 mb-4">
                        <div class="form-group-item">
                            <label class="form-label">Group Role <span class="text-danger">*</span></label>
                            <select name="role_id" id="role_id" required class="form-select">
                                <option value="">-- Pilih Group Role --</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ (optional($formSchedule->detailUser)->role_id == $role->id) ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group-item">
                            <label class="form-label">Pilih Karyawan PIC <span class="text-danger">*</span></label>
                            <select name="detail_user_id" id="detail_user_id" required class="form-select">
                                <option value="">-- Pilih PIC --</option>
                                @foreach($detailUsers as $du)
                                    <option value="{{ $du->id }}" {{ $formSchedule->detail_user_id == $du->id ? 'selected' : '' }}>{{ $du->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Detail Code Item & Rencana Schedule -->
                    <div class="border-bottom pb-3 mb-4 pt-2">
                        <h6 class="font-weight-extrabold text-gray-900 mb-1"><i class="fas fa-cubes text-info mr-2"></i>Detail Code Item & Rencana Schedule</h6>
                    </div>

                    <div class="form-grid-3 mb-4">
                        <div class="form-group-item">
                            <label class="form-label">Code Item <span class="text-danger">*</span></label>
                            <select name="list_code_item_id" id="list_code_item_id" required class="form-select">
                                <option value="">-- Pilih Code Item --</option>
                                @foreach($listCodeItems as $ci)
                                    <option value="{{ $ci->id }}" {{ $formSchedule->list_code_item_id == $ci->id ? 'selected' : '' }}>{{ $ci->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group-item">
                            <label class="form-label">Mold Set <span class="text-danger">*</span></label>
                            <select name="set_code_item_id" id="set_code_item_id" required class="form-select">
                                <option value="">-- Pilih Mold Set --</option>
                                @foreach($setCodeItems as $s)
                                    <option value="{{ $s->id }}" {{ $formSchedule->set_code_item_id == $s->id ? 'selected' : '' }}>{{ $s->moldset }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group-item">
                            <label class="form-label">Mold Cavity <span class="text-danger">*</span></label>
                            <select name="cav_code_item_id" id="cav_code_item_id" required class="form-select">
                                <option value="">-- Pilih Mold Cavity --</option>
                                @foreach($cavCodeItems as $c)
                                    <option value="{{ $c->id }}" {{ $formSchedule->cav_code_item_id == $c->id ? 'selected' : '' }}>{{ $c->moldcav }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-grid-3 mb-4">
                        <div class="form-group-item">
                            <label class="form-label">Kategori Pemeliharaan <span class="text-danger">*</span></label>
                            <select name="kategori_id" id="kategori_id" required class="form-select">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategoris as $k)
                                    <option value="{{ $k->id }}" {{ $formSchedule->kategori_id == $k->id ? 'selected' : '' }}>{{ $k->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group-item">
                            <label class="form-label">Mesin Produksi <span class="text-danger">*</span></label>
                            <select name="list_mesin_id" id="list_mesin_id" required class="form-select">
                                <option value="">-- Pilih Mesin --</option>
                                @foreach($listMesins as $m)
                                    <option value="{{ $m->id }}" {{ $formSchedule->list_mesin_id == $m->id ? 'selected' : '' }}>{{ $m->code }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group-item">
                            <label class="form-label">Shift <span class="text-danger">*</span></label>
                            <select name="shift" id="shift" required class="form-select">
                                <option value="">-- Pilih Shift --</option>
                                <option value="Shift 1" {{ old('shift', $formSchedule->shift) == 'Shift 1' ? 'selected' : '' }}>Shift 1</option>
                                <option value="Shift 2" {{ old('shift', $formSchedule->shift) == 'Shift 2' ? 'selected' : '' }}>Shift 2</option>
                                <option value="Shift 3" {{ old('shift', $formSchedule->shift) == 'Shift 3' ? 'selected' : '' }}>Shift 3</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-grid-1 mb-4">
                        <div class="form-group-item">
                            <label class="form-label">Catatan / Rencana Kegiatan <span class="text-danger">*</span></label>
                            <textarea name="keterangan" required rows="3" placeholder="Masukkan rencana kegiatan..." class="form-control">{{ old('keterangan', $formSchedule->keterangan) }}</textarea>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex align-items-center justify-content-end gap-2 pt-3 border-top">
                        <a href="{{ route('form-schedules.index') }}" class="btn btn-light border font-weight-bold px-4 py-2" style="border-radius: 0.75rem;">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary font-weight-bold px-4 py-2" style="background-color: #2563eb; border: none; border-radius: 0.75rem;">
                            <i class="fas fa-save mr-1.5"></i> Update Form Schedule
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const roleSelect = document.getElementById('role_id');
            const picSelect = document.getElementById('detail_user_id');
            const codeItemSelect = document.getElementById('list_code_item_id');
            const setSelect = document.getElementById('set_code_item_id');
            const cavSelect = document.getElementById('cav_code_item_id');

            const mesinSelect = document.getElementById('list_mesin_id');
            const katSelect = document.getElementById('kategori_id');

            const rawMesins = [
                @foreach($listMesins as $m)
                @php
                    $isOccupied = in_array($m->id, $occupiedMesinIds ?? []) && ($formSchedule->list_mesin_id != $m->id);
                @endphp
                {
                    id: "{{ $m->id }}",
                    code: "{{ $m->code }}",
                    isOccupied: {{ $isOccupied ? 'true' : 'false' }}
                },
                @endforeach
            ];

            let tsCodeItem = null;

            // TomSelect for PIC, Code Item, and Mesin
            if (typeof TomSelect !== 'undefined') {
                if (picSelect && !picSelect.tomselect) {
                    new TomSelect('#detail_user_id', { plugins: ['dropdown_input'], create: false, maxItems: 1, closeAfterSelect: true, placeholder: '-- Ketik / Pilih PIC --' });
                }
                if (codeItemSelect && !codeItemSelect.tomselect) {
                    tsCodeItem = new TomSelect('#list_code_item_id', {
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
                        onChange: function (val) {
                            updateSets(val).then(() => {
                                updateCavs(val, setSelect ? setSelect.value : '');
                            });
                        }
                    });
                }
                if (mesinSelect && !mesinSelect.tomselect) {
                    new TomSelect('#list_mesin_id', { 
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

            function updateMesinFilter() {
                if (!katSelect || !mesinSelect) return;

                const selectedOpt = katSelect.options[katSelect.selectedIndex];
                const selectedText = selectedOpt ? selectedOpt.text.toUpperCase() : '';
                const isHideOccupied = selectedText.includes('NAIK') || selectedText.includes('SANDBLASTING');

                const validMesins = rawMesins.filter(m => {
                    if (isHideOccupied && m.isOccupied) {
                        return false;
                    }
                    return true;
                });

                const ts = mesinSelect.tomselect;
                const currentVal = ts ? ts.getValue() : mesinSelect.value;

                if (ts) {
                    ts.clearOptions();
                    validMesins.forEach(m => {
                        ts.addOption({
                            value: m.id,
                            text: m.code + (m.isOccupied ? ' (Sedang Produksi)' : '')
                        });
                    });
                    ts.refreshOptions(false);

                    if (currentVal && validMesins.some(m => m.id == currentVal)) {
                        ts.setValue(currentVal, true);
                    } else {
                        ts.clear();
                    }
                } else {
                    mesinSelect.innerHTML = '<option value="">-- Pilih Mesin --</option>';
                    validMesins.forEach(m => {
                        const opt = document.createElement('option');
                        opt.value = m.id;
                        opt.textContent = m.code + (m.isOccupied ? ' (Sedang Produksi)' : '');
                        if (currentVal && m.id == currentVal) opt.selected = true;
                        mesinSelect.appendChild(opt);
                    });
                }
            }

            if (katSelect) {
                katSelect.addEventListener('change', updateMesinFilter);
                updateMesinFilter();
            }

            function updateSets(listId, preselectId = null) {
                return new Promise(resolve => {
                    if (!setSelect) return resolve();
                    if (!listId) {
                        setSelect.innerHTML = '<option value="">-- Pilih Code Item Terlebih Dahulu --</option>';
                        setSelect.value = '';
                        if (cavSelect) {
                            cavSelect.innerHTML = '<option value="">-- Pilih Code Item Terlebih Dahulu --</option>';
                            cavSelect.value = '';
                        }
                        return resolve();
                    }
                    setSelect.innerHTML = '<option value="">-- Memuat Mold Set... --</option>';
                    fetch(`{{ route('api.code-item.sets') }}?list_code_item_id=${listId}`)
                        .then(res => res.json())
                        .then(data => {
                            setSelect.innerHTML = '<option value="">-- Pilih Mold Set --</option>';
                            if (data && data.length > 0) {
                                data.forEach(item => {
                                    const opt = document.createElement('option');
                                    opt.value = item.id;
                                    opt.textContent = item.moldset;
                                    if (preselectId && item.id == preselectId) opt.selected = true;
                                    setSelect.appendChild(opt);
                                });
                            } else {
                                setSelect.innerHTML = '<option value="">-- Tidak Ada Mold Set --</option>';
                            }
                            resolve();
                        })
                        .catch(err => {
                            console.error(err);
                            setSelect.innerHTML = '<option value="">-- Gagal Memuat Mold Set --</option>';
                            resolve();
                        });
                });
            }

            function updateCavs(listId, setId = null, preselectId = null) {
                return new Promise(resolve => {
                    if (!cavSelect) return resolve();
                    if (!listId) {
                        cavSelect.innerHTML = '<option value="">-- Pilih Code Item Terlebih Dahulu --</option>';
                        cavSelect.value = '';
                        return resolve();
                    }
                    cavSelect.innerHTML = '<option value="">-- Memuat Mold Cavity... --</option>';
                    let url = `{{ route('api.code-item.cavs') }}?list_code_item_id=${listId}`;
                    if (setId) url += `&set_code_item_id=${setId}`;

                    fetch(url)
                        .then(res => res.json())
                        .then(data => {
                            cavSelect.innerHTML = '<option value="">-- Pilih Mold Cavity --</option>';
                            if (data && data.length > 0) {
                                data.forEach(item => {
                                    const opt = document.createElement('option');
                                    opt.value = item.id;
                                    opt.textContent = item.moldcav;
                                    if (preselectId && item.id == preselectId) opt.selected = true;
                                    cavSelect.appendChild(opt);
                                });
                            } else {
                                cavSelect.innerHTML = '<option value="">-- Tidak Ada Mold Cavity --</option>';
                            }
                            resolve();
                        })
                        .catch(err => {
                            console.error(err);
                            cavSelect.innerHTML = '<option value="">-- Gagal Memuat Mold Cavity --</option>';
                            resolve();
                        });
                });
            }

            if (codeItemSelect && !codeItemSelect.tomselect) {
                codeItemSelect.addEventListener('change', function () {
                    const listId = this.value;
                    updateSets(listId).then(() => {
                        updateCavs(listId, setSelect ? setSelect.value : '');
                    });
                });
            }

            if (setSelect) {
                setSelect.addEventListener('change', function () {
                    const listId = tsCodeItem ? tsCodeItem.getValue() : (codeItemSelect ? codeItemSelect.value : '');
                    const setId = this.value;
                    updateCavs(listId, setId);
                });
            }
        });
    </script>
</x-app-layout>
