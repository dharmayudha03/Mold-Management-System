<x-app-layout>
    <x-slot name="header">
        Edit Form Setup Cetakan
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="mb-4">
            <a href="{{ route('form-setup-cetakans.index') }}" class="btn btn-sm btn-light border font-weight-bold px-3.5 py-2 text-gray-700 shadow-xs" style="border-radius: 0.75rem;">
                <i class="fas fa-arrow-left mr-1.5"></i> Kembali ke Form Setup Cetakan
            </a>
        </div>

        <div class="card shadow-sm border-0 mb-4" style="border-radius: 1rem;">
            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-extrabold text-gray-900"><i class="fas fa-edit text-indigo-600 mr-2"></i>Form Edit Setup Cetakan</h6>
                <span class="badge bg-light text-gray-700 border px-3 py-1 font-weight-bold" style="border-radius: 50rem;">Update Laporan Setup</span>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('form-setup-cetakans.update', $formSetupCetakan->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Header Doc Info -->
                    <div class="form-grid-2 mb-4">
                        <div class="form-group-item">
                            <label class="form-label">No Document</label>
                            <input type="text" name="nodoc" value="{{ old('nodoc', $formSetupCetakan->nodoc) }}" readonly class="form-control font-weight-extrabold text-indigo-600 bg-light">
                        </div>
                        <div class="form-group-item">
                            <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal" value="{{ old('tanggal', $formSetupCetakan->tanggal) }}" required 
                                class="form-control {{ !empty($isReadonlyDate) ? 'bg-light font-weight-bold' : '' }}"
                                {{ !empty($isReadonlyDate) ? 'readonly' : '' }}>
                            @if(!empty($isReadonlyDate))
                                <small class="text-xs text-muted mt-1 d-block"><i class="fas fa-lock text-primary mr-1"></i> Tanggal otomatis disesuaikan dengan tanggal operasional shift pabrik.</small>
                            @endif
                        </div>
                    </div>

                    <!-- Detail Karyawan -->
                    <div class="border-bottom pb-3 mb-4 pt-2">
                        <h6 class="font-weight-extrabold text-gray-900 mb-1"><i class="fas fa-users text-primary mr-2"></i>Detail Karyawan / Group Role</h6>
                        <p class="text-xs text-gray-500 mb-0">Pilih group role untuk menentukan daftar petugas karyawan PIC.</p>
                    </div>

                    <div class="form-grid-2 mb-4">
                        <div class="form-group-item">
                            <label class="form-label">Group Role <span class="text-danger">*</span></label>
                            <select name="role_id" id="role_id" required class="form-select">
                                <option value="">-- Pilih Group Role --</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ $formSetupCetakan->role_id == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group-item">
                            <label class="form-label">Pilih Nama Karyawan PIC <span class="text-danger">*</span></label>
                            @php
                                $selectedUserIds = $formSetupCetakan->detailUser->pluck('id')->toArray();
                            @endphp
                            <div id="detail_user_container" class="p-3 bg-light rounded-xl border max-h-48 overflow-y-auto" style="border-radius: 0.75rem;">
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($detailUsers as $du)
                                        @if(!$formSetupCetakan->role_id || $du->role_id == $formSetupCetakan->role_id)
                                            <div class="form-check form-check-inline bg-white px-2.5 py-1.5 rounded-lg border">
                                                <input type="checkbox" name="detail_user_id[]" value="{{ $du->id }}" id="user_{{ $du->id }}" {{ in_array($du->id, $selectedUserIds) ? 'checked' : '' }} class="form-check-input">
                                                <label for="user_{{ $du->id }}" class="form-check-label text-xs font-weight-bold text-gray-800">{{ $du->name }}</label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Code Item & Mesin -->
                    <div class="border-bottom pb-3 mb-4 pt-2">
                        <h6 class="font-weight-extrabold text-gray-900 mb-1"><i class="fas fa-cubes text-info mr-2"></i>Detail Code Item & Mesin</h6>
                    </div>

                    <div class="form-grid-3 mb-4">
                        <div class="form-group-item">
                            <label class="form-label">Code Item <span class="text-danger">*</span></label>
                            <select name="list_code_item_id" id="list_code_item_id" required class="form-select">
                                @foreach($listCodeItems as $ci)
                                    <option value="{{ $ci->id }}" {{ $formSetupCetakan->list_code_item_id == $ci->id ? 'selected' : '' }}>{{ $ci->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group-item">
                            <label class="form-label">Mold Set <span class="text-danger">*</span></label>
                            <select name="set_code_item_id" id="set_code_item_id" required class="form-select">
                                @foreach($setCodeItems as $s)
                                    <option value="{{ $s->id }}" {{ $formSetupCetakan->set_code_item_id == $s->id ? 'selected' : '' }}>{{ $s->moldset }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group-item">
                            <label class="form-label">Mold Cavity <span class="text-danger">*</span></label>
                            <select name="cav_code_item_id" id="cav_code_item_id" required class="form-select">
                                @foreach($cavCodeItems as $c)
                                    <option value="{{ $c->id }}" {{ $formSetupCetakan->cav_code_item_id == $c->id ? 'selected' : '' }}>{{ $c->moldcav }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group-item">
                            <label class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select name="kategori_id" id="kategori_id" required class="form-select">
                                @foreach($kategoris as $k)
                                    <option value="{{ $k->id }}" {{ $formSetupCetakan->kategori_id == $k->id ? 'selected' : '' }}>{{ $k->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group-item">
                            <label class="form-label">Mesin <span class="text-danger">*</span></label>
                            <select name="list_mesin_id" id="list_mesin_id" required class="form-select">
                                @foreach($listMesins as $m)
                                    @php
                                        $isOccupied = in_array($m->id, $occupiedMesinIds ?? []) && ($formSetupCetakan->list_mesin_id != $m->id);
                                    @endphp
                                    <option value="{{ $m->id }}"
                                        data-occupied="{{ $isOccupied ? '1' : '0' }}"
                                        {{ $formSetupCetakan->list_mesin_id == $m->id ? 'selected' : '' }}>
                                        {{ $m->code }}{{ $isOccupied ? ' (Sedang Produksi)' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group-item">
                            <label class="form-label">Shift <span class="text-danger">*</span></label>
                            <select name="shift" required class="form-select">
                                <option value="">-- Pilih Shift --</option>
                                <option value="NS" {{ $formSetupCetakan->shift == 'NS' ? 'selected' : '' }}>NS</option>
                                <option value="1" {{ $formSetupCetakan->shift == '1' ? 'selected' : '' }}>Shift 1</option>
                                <option value="2" {{ $formSetupCetakan->shift == '2' ? 'selected' : '' }}>Shift 2</option>
                                <option value="3" {{ $formSetupCetakan->shift == '3' ? 'selected' : '' }}>Shift 3</option>
                            </select>
                        </div>
                    </div>

                    <!-- Check Cetakan & Cavity NG Grid 4x2 -->
                    <div class="border-bottom pb-3 mb-4 pt-2">
                        <h6 class="font-weight-extrabold text-gray-900 mb-1"><i class="fas fa-tasks text-emerald-600 mr-2"></i>Pemeriksaan Komponen Cetakan & Cavity NG</h6>
                    </div>

                    <div class="form-grid-4 mb-4">
                        @foreach(['guidepen' => 'Guide Pen', 'busing' => 'Busing', 'baut' => 'Baut', 'core' => 'Core', 'piston' => 'Piston', 'pot' => 'Pot', 'pl' => 'PL'] as $field => $label)
                            <div class="p-3 bg-light rounded-xl border d-flex flex-column justify-content-between" style="border-radius: 0.85rem; border: 1px solid #e2e8f0;">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="text-xs font-weight-extrabold text-gray-900 uppercase"><i class="fas fa-check-circle text-emerald-500 mr-1.5"></i>{{ $label }}</span>
                                </div>
                                <select name="{{ $field }}" required class="form-select text-xs font-weight-bold text-gray-900 bg-white" style="border-radius: 0.6rem; padding: 0.5rem 0.75rem;">
                                    <option value="√" {{ $formSetupCetakan->$field == '√' ? 'selected' : '' }}>√ (Pakai)</option>
                                    <option value="-" {{ $formSetupCetakan->$field == '-' ? 'selected' : '' }}>- (Tidak)</option>
                                </select>
                            </div>
                        @endforeach

                        <div class="p-3 bg-light rounded-xl border d-flex flex-column justify-content-between" style="border-radius: 0.85rem; border: 1px solid #e2e8f0;">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="text-xs font-weight-extrabold text-danger uppercase"><i class="fas fa-exclamation-triangle text-danger mr-1.5"></i>Jumlah Cavity NG</span>
                            </div>
                            <input type="number" name="cav_ng" value="{{ old('cav_ng', $formSetupCetakan->cav_ng ?? 0) }}" min="0" class="form-control text-xs font-weight-bold text-gray-900 bg-white" style="border-radius: 0.6rem; padding: 0.5rem 0.75rem;">
                        </div>
                    </div>

                    <div class="pt-3 border-top d-flex align-items-center justify-content-end gap-2">
                        <a href="{{ route('form-setup-cetakans.index') }}" class="btn btn-sm btn-outline-secondary font-weight-bold px-4 py-2" style="border-radius: 0.75rem;">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-sm btn-primary font-weight-bold px-4 py-2" style="border-radius: 0.75rem; background-color: #2563eb; border: none;">
                            <i class="fas fa-save mr-1.5"></i> Update Form Setup
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const roleSelect = document.getElementById('role_id');
            const detailUserContainer = document.getElementById('detail_user_container');
            const codeItemSelect = document.getElementById('list_code_item_id');
            const setSelect = document.getElementById('set_code_item_id');
            const cavSelect = document.getElementById('cav_code_item_id');
            const mesinSelect = document.getElementById('list_mesin_id');
            const katSelect = document.getElementById('kategori_id');

            const rawMesins = [
                @foreach($listMesins as $m)
                @php
                    $isOccupied = in_array($m->id, $occupiedMesinIds ?? []) && ($formSetupCetakan->list_mesin_id != $m->id);
                @endphp
                {
                    id: "{{ $m->id }}",
                    code: "{{ $m->code }}",
                    isOccupied: {{ $isOccupied ? 'true' : 'false' }}
                },
                @endforeach
            ];

            // TomSelect for Role, Code Item & Mesin
            if (window.TomSelect) {
                if (roleSelect && !roleSelect.tomselect) {
                    new TomSelect(roleSelect, {
                        plugins: ['dropdown_input'],
                        create: false,
                        maxItems: 1,
                        closeAfterSelect: true,
                        placeholder: '-- Pilih Group Role --',
                        onChange: function (val) {
                            loadRoleUsers(val);
                        }
                    });
                }
                if (codeItemSelect && !codeItemSelect.tomselect) {
                    new TomSelect(codeItemSelect, { 
                        plugins: {
                            'dropdown_input': {},
                            'clear_button': { title: 'Hapus pilihan' }
                        },
                        allowEmptyOption: true,
                        create: false, 
                        maxItems: 1, 
                        closeAfterSelect: true, 
                        placeholder: '-- Pilih / Ketik Code Item --',
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
                    new TomSelect(mesinSelect, { 
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
                                return '<div class="no-results p-2 text-xs text-gray-500 font-weight-bold">Mesin yang anda cari tidak ada</div>';
                            }
                        }
                    });
                }
            }

            function updateMesinFilter() {
                if (!katSelect || !mesinSelect) return;

                const selectedOpt = katSelect.options[katSelect.selectedIndex];
                const selectedText = selectedOpt ? selectedOpt.text.toUpperCase() : '';
                const isNaik = selectedText.includes('NAIK');

                const validMesins = rawMesins.filter(m => {
                    if (isNaik && m.isOccupied) {
                        return false;
                    }
                    return true;
                });

                const ts = mesinSelect.tomselect;
                const currentVal = ts ? ts.getValue() : mesinSelect.value;

                if (ts) {
                    ts.clearOptions();
                    ts.addOption({ value: '', text: '-- Pilih Mesin --' });
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
            }
            updateMesinFilter();

            // 1. Filter Karyawan by Group Role (Instant 0ms In-Memory Filter)
            const allDetailUsers = @json($detailUsers ?? []);
            const selectedUserIds = @json($selectedUserIds ?? []);

            function loadRoleUsers(roleIdVal) {
                if (!roleSelect || !detailUserContainer) return;
                const roleId = (roleIdVal !== undefined && roleIdVal !== null) ? roleIdVal : roleSelect.value;
                if (!roleId) {
                    detailUserContainer.innerHTML = '<p class="text-xs text-gray-500 italic mb-0">Pilih Group Role terlebih dahulu untuk memilih nama karyawan.</p>';
                    return;
                }

                const filtered = allDetailUsers.filter(u => u.role_id == roleId);

                function renderUserCheckboxes(users) {
                    detailUserContainer.innerHTML = '';
                    if (!users || users.length === 0) {
                        detailUserContainer.innerHTML = '<p class="text-xs text-gray-500 italic mb-0">Tidak ada karyawan untuk group ini.</p>';
                    } else {
                        const flexContainer = document.createElement('div');
                        flexContainer.className = 'd-flex flex-wrap gap-2';
                        users.forEach(user => {
                            const isChecked = selectedUserIds.map(String).includes(String(user.id)) ? 'checked' : '';
                            const div = document.createElement('div');
                            div.className = 'form-check form-check-inline bg-white px-2.5 py-1.5 rounded-lg border shadow-2xs';
                            div.innerHTML = `
                                <input type="checkbox" name="detail_user_id[]" value="${user.id}" id="user_${user.id}" class="form-check-input" ${isChecked} style="cursor: pointer;">
                                <label for="user_${user.id}" class="form-check-label text-xs font-weight-bold text-gray-800" style="cursor: pointer;">${user.name}</label>
                            `;
                            flexContainer.appendChild(div);
                        });
                        detailUserContainer.appendChild(flexContainer);
                    }
                }

                if (filtered && filtered.length > 0) {
                    renderUserCheckboxes(filtered);
                } else {
                    fetch(`{{ route('api.role.detail-users') }}?role_id=${roleId}`)
                        .then(res => res.json())
                        .then(data => renderUserCheckboxes(data))
                        .catch(err => {
                            detailUserContainer.innerHTML = '<p class="text-xs text-danger mb-0">Gagal memuat nama karyawan.</p>';
                        });
                }
            }

            if (roleSelect && detailUserContainer) {
                roleSelect.addEventListener('change', function() {
                    loadRoleUsers(this.value);
                });
            }

            // 2. Dynamic Cascading Dropdowns
            function updateSets(listId, preselectId = null) {
                return new Promise(resolve => {
                    if (!setSelect) return resolve();
                    if (!listId) {
                        setSelect.innerHTML = '<option value="">-- Pilih Code Item Terlebih Dahulu --</option>';
                        setSelect.value = '';
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
                                setSelect.innerHTML = '<option value="">-- Tidak Ada Mold Set Untuk Code Item Ini --</option>';
                            }
                            resolve();
                        }).catch(() => resolve());
                });
            }

            function updateCavs(listId, setId, preselectId = null) {
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
                                cavSelect.innerHTML = '<option value="">-- Tidak Ada Mold Cavity Untuk Code Item Ini --</option>';
                            }
                            resolve();
                        }).catch(() => resolve());
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
                    const listId = codeItemSelect ? codeItemSelect.value : '';
                    const setId = this.value;
                    updateCavs(listId, setId);
                });
            }

            // 3. Filter Mesin Berdasarkan Kategori (Setup Naik vs Setup Turun)
            const kategoriEl = document.getElementById('kategori_id');
            const mesinEl = document.getElementById('list_mesin_id');

            function filterMesinByKategori() {
                if (!kategoriEl || !mesinEl) return;
                const selectedOpt = kategoriEl.options[kategoriEl.selectedIndex];
                const kategoriText = selectedOpt ? selectedOpt.text.toUpperCase() : '';

                const isSetupNaik = kategoriText.includes('NAIK');

                Array.from(mesinEl.options).forEach(opt => {
                    if (!opt.value) return;
                    const isOccupied = opt.getAttribute('data-occupied') === '1';

                    if (isSetupNaik) {
                        // Jika Setup Cetakan Naik: Mesin yang sedang produksi HIDDEN
                        if (isOccupied) {
                            opt.style.display = 'none';
                            opt.disabled = true;
                        } else {
                            opt.style.display = '';
                            opt.disabled = false;
                        }
                    } else {
                        // Jika Setup Cetakan Turun / Lainnya: Semua Mesin TAMPIL (termasuk yang sedang produksi)
                        opt.style.display = '';
                        opt.disabled = false;
                    }
                });

                if (mesinEl.selectedOptions[0] && mesinEl.selectedOptions[0].disabled) {
                    mesinEl.value = '';
                }
            }

            if (kategoriEl) {
                kategoriEl.addEventListener('change', filterMesinByKategori);
                filterMesinByKategori();
            }
        });
    </script>
</x-app-layout>
