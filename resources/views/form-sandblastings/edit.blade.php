<x-app-layout>
    <x-slot name="header">
        Edit Form Sandblasting
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="mb-4">
            <a href="{{ route('form-sandblastings.index') }}" class="btn btn-sm btn-light border font-weight-bold px-3.5 py-2 text-gray-700 shadow-xs" style="border-radius: 0.75rem;">
                <i class="fas fa-arrow-left mr-1.5"></i> Kembali ke Form Sandblasting
            </a>
        </div>

        <div class="card shadow-sm border-0 mb-4" style="border-radius: 1rem;">
            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-extrabold text-gray-900"><i class="fas fa-edit text-amber-500 mr-2"></i>Form Edit Sandblasting</h6>
                <span class="badge bg-light text-gray-700 border px-3 py-1 font-weight-bold" style="border-radius: 50rem;">Update Laporan Sandblasting</span>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('form-sandblastings.update', $formSandblasting->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Header Doc Info -->
                    <div class="form-grid-2 mb-4">
                        <div class="form-group-item">
                            <label class="form-label">No Document</label>
                            <input type="text" name="nodoc" value="{{ old('nodoc', $formSandblasting->nodoc) }}" readonly class="form-control font-weight-extrabold text-amber-600 bg-light">
                        </div>
                        <div class="form-group-item">
                            <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal" value="{{ old('tanggal', $formSandblasting->tanggal) }}" required 
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
                                    <option value="{{ $role->id }}" {{ ($formSandblasting->role_id == $role->id || count($roles) == 1) ? 'selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group-item">
                            <label class="form-label">Pilih Nama Karyawan PIC <span class="text-danger">*</span></label>
                            @php
                                $selectedUserIds = $formSandblasting->detailUser->pluck('id')->toArray();
                            @endphp
                            <div id="detail_user_container" class="p-3 bg-light rounded-xl border max-h-48 overflow-y-auto" style="border-radius: 0.75rem;">
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($detailUsers as $du)
                                        @if(!$formSandblasting->role_id || $du->role_id == $formSandblasting->role_id)
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
                                    <option value="{{ $ci->id }}" {{ $formSandblasting->list_code_item_id == $ci->id ? 'selected' : '' }}>{{ $ci->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group-item">
                            <label class="form-label">Mold Set <span class="text-danger">*</span></label>
                            <select name="set_code_item_id" id="set_code_item_id" required class="form-select">
                                @foreach($setCodeItems as $s)
                                    <option value="{{ $s->id }}" {{ $formSandblasting->set_code_item_id == $s->id ? 'selected' : '' }}>{{ $s->moldset }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group-item">
                            <label class="form-label">Mold Cavity <span class="text-danger">*</span></label>
                            <select name="cav_code_item_id" id="cav_code_item_id" required class="form-select">
                                @foreach($cavCodeItems as $c)
                                    <option value="{{ $c->id }}" {{ $formSandblasting->cav_code_item_id == $c->id ? 'selected' : '' }}>{{ $c->moldcav }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group-item">
                            <label class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select name="kategori_id" required class="form-select">
                                @foreach($kategoris as $k)
                                    <option value="{{ $k->id }}" {{ $formSandblasting->kategori_id == $k->id ? 'selected' : '' }}>{{ $k->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group-item">
                            <label class="form-label">Mesin (Opsional)</label>
                            <select name="list_mesin_id" id="list_mesin_id" class="form-select">
                                <option value="">-- Tanpa Mesin (Opsional) --</option>
                                @foreach($listMesins as $m)
                                    @php
                                        $isOccupied = in_array($m->id, $occupiedMesinIds ?? []) && ($formSandblasting->list_mesin_id != $m->id);
                                    @endphp
                                    @if(!$isOccupied)
                                        <option value="{{ $m->id }}" {{ $formSandblasting->list_mesin_id == $m->id ? 'selected' : '' }}>{{ $m->code }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group-item">
                            <label class="form-label">Shift <span class="text-danger">*</span></label>
                            <select name="shift" required class="form-select">
                                <option value="">-- Pilih Shift --</option>
                                <option value="NS" {{ $formSandblasting->shift == 'NS' ? 'selected' : '' }}>NS</option>
                                <option value="1" {{ $formSandblasting->shift == '1' ? 'selected' : '' }}>Shift 1</option>
                                <option value="2" {{ $formSandblasting->shift == '2' ? 'selected' : '' }}>Shift 2</option>
                                <option value="3" {{ $formSandblasting->shift == '3' ? 'selected' : '' }}>Shift 3</option>
                            </select>
                        </div>
                        <div class="form-group-item">
                            <label class="form-label">Rak (Opsional)</label>
                            <select name="rak" id="rak" class="form-select">
                                <option value="">-- Pilih / Ketik Rak --</option>
                                @foreach(array_keys($rackData) as $rName)
                                    <option value="{{ $rName }}" {{ old('rak', $formSandblasting->rak) == $rName ? 'selected' : '' }}>{{ $rName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group-item">
                            <label class="form-label">No. Rak (Opsional)</label>
                            <select name="norak" id="norak" class="form-select">
                                <option value="">-- Pilih Rak Terlebih Dahulu --</option>
                            </select>
                        </div>
                    </div>

                    <!-- Check Sandblasting 3x2 Grid -->
                    <div class="border-bottom pb-3 mb-4 pt-2">
                        <h6 class="font-weight-extrabold text-gray-900 mb-1"><i class="fas fa-tasks text-amber-500 mr-2"></i>Pemeriksaan Item Sandblasting & Cavity NG</h6>
                    </div>

                    <div class="form-grid-3 mb-4">
                        @foreach([
                            'sandblasting' => 'Sandblasting',
                            'cuci' => 'Cuci Cetakan',
                            'autosol' => 'Autosol',
                            'gerinda' => 'Gerinda / Kikir',
                            'oiling' => 'Oiling'
                        ] as $field => $label)
                            <div class="p-3 bg-light rounded-xl border d-flex flex-column justify-content-between" style="border-radius: 0.85rem; border: 1px solid #e2e8f0;">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="text-xs font-weight-extrabold text-gray-900 uppercase"><i class="fas fa-check-circle text-amber-500 mr-1.5"></i>{{ $label }}</span>
                                </div>
                                <select name="{{ $field }}" class="form-select text-xs font-weight-bold text-gray-900 bg-white" style="border-radius: 0.6rem; padding: 0.5rem 0.75rem;">
                                    <option value="">-- Pilih --</option>
                                    <option value="√" {{ $formSandblasting->$field == '√' ? 'selected' : '' }}>√ (Pakai / Sesuai)</option>
                                    <option value="-" {{ $formSandblasting->$field == '-' ? 'selected' : '' }}>- (Tidak)</option>
                                </select>
                            </div>
                        @endforeach

                        <div class="p-3 bg-light rounded-xl border d-flex flex-column justify-content-between" style="border-radius: 0.85rem; border: 1px solid #e2e8f0;">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="text-xs font-weight-extrabold text-danger uppercase"><i class="fas fa-exclamation-triangle text-danger mr-1.5"></i>Jumlah Cavity NG</span>
                            </div>
                            <input type="number" name="cav_ng" value="{{ old('cav_ng', $formSandblasting->cav_ng ?? 0) }}" min="0" class="form-control text-xs font-weight-bold text-gray-900 bg-white" style="border-radius: 0.6rem; padding: 0.5rem 0.75rem;">
                        </div>
                    </div>

                    <div class="pt-3 border-top d-flex align-items-center justify-content-end gap-2">
                        <a href="{{ route('form-sandblastings.index') }}" class="btn btn-sm btn-outline-secondary font-weight-bold px-4 py-2" style="border-radius: 0.75rem;">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-sm btn-amber font-weight-bold px-4 py-2 text-white" style="border-radius: 0.75rem; background-color: #d97706; border: none;">
                            <i class="fas fa-save mr-1.5"></i> Update Form Sandblasting
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
            const rakSelect = document.getElementById('rak');
            const noRakSelect = document.getElementById('norak');
            const baseUrl = "{{ url('/') }}";
            const rackData = @json($rackData);

            function updateNoRaks(selectedRak, preselectNoRak = null) {
                if (!noRakSelect) return;
                if (!selectedRak) {
                    noRakSelect.innerHTML = '<option value="">-- Pilih Rak Terlebih Dahulu --</option>';
                    noRakSelect.value = '';
                    return;
                }
                const availableNoRaks = (rackData && rackData[selectedRak]) ? rackData[selectedRak] : [];
                if (availableNoRaks.length > 0) {
                    noRakSelect.innerHTML = '<option value="">-- Pilih No Rak --</option>';
                    availableNoRaks.forEach(nr => {
                        const opt = document.createElement('option');
                        opt.value = nr;
                        opt.textContent = nr;
                        if (preselectNoRak && nr === preselectNoRak) opt.selected = true;
                        noRakSelect.appendChild(opt);
                    });
                } else {
                    noRakSelect.innerHTML = '<option value="">-- Tidak Ada No Rak Tersedia --</option>';
                }
            }

            // TomSelect for Code Item, Mesin, Rak & No Rak
            if (window.TomSelect) {
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
                        sortField: { field: '$order' },
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
                        sortField: { field: '$order' },
                        render: {
                            no_results: function(data, escape) {
                                return '<div class="no-results p-2 text-xs text-gray-500 font-weight-bold">Mesin yang anda cari tidak ada</div>';
                            }
                        }
                    });
                }
                if (rakSelect && !rakSelect.tomselect) {
                    new TomSelect(rakSelect, { 
                        plugins: {
                            'dropdown_input': {},
                            'clear_button': { title: 'Hapus pilihan' }
                        },
                        allowEmptyOption: true,
                        create: false, 
                        maxItems: 1, 
                        closeAfterSelect: true, 
                        placeholder: '-- Pilih / Ketik Rak --',
                        sortField: { field: '$order' },
                        render: {
                            no_results: function(data, escape) {
                                return '<div class="no-results p-2 text-xs text-gray-500 font-weight-bold">Rak yang anda cari tidak ada</div>';
                            }
                        },
                        onChange: function (val) {
                            updateNoRaks(val);
                        }
                    });
                }

                // Initial Rak & No Rak load for Edit view
                const initialRakVal = "{{ old('rak', $formSandblasting->rak) }}";
                const initialNoRakVal = "{{ old('norak', $formSandblasting->norak) }}";
                if (initialRakVal) {
                    updateNoRaks(initialRakVal, initialNoRakVal);
                }
            }

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
                    fetch(`${baseUrl}/api/role/detail-users?role_id=${roleId}`)
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

            // 2. Filter Mold Set by Code Item
            if (codeItemSelect && setSelect) {
                codeItemSelect.addEventListener('change', function () {
                    const listId = this.value;
                    setSelect.innerHTML = '<option value="">-- Pilih Mold Set --</option>';
                    cavSelect.innerHTML = '<option value="">-- Pilih Mold Cavity --</option>';

                    if (!listId) return;

                    fetch(`${baseUrl}/api/code-item/sets?list_code_item_id=${listId}`)
                        .then(res => res.json())
                        .then(data => {
                            data.forEach(item => {
                                const opt = document.createElement('option');
                                opt.value = item.id;
                                opt.textContent = item.moldset;
                                setSelect.appendChild(opt);
                            });
                        });
                });
            }

            // 3. Filter Mold Cavity by Mold Set
            if (setSelect && cavSelect) {
                setSelect.addEventListener('change', function () {
                    const listId = codeItemSelect ? codeItemSelect.value : '';
                    const setId = this.value;
                    cavSelect.innerHTML = '<option value="">-- Pilih Mold Cavity --</option>';

                    if (!listId || !setId) return;

                    fetch(`${baseUrl}/api/code-item/cavs?list_code_item_id=${listId}&set_code_item_id=${setId}`)
                        .then(res => res.json())
                        .then(data => {
                            data.forEach(item => {
                                const opt = document.createElement('option');
                                opt.value = item.id;
                                opt.textContent = item.moldcav;
                                cavSelect.appendChild(opt);
                            });
                        });
                });
            }
        });
    </script>
</x-app-layout>
