<x-app-layout>
    <x-slot name="header">
        Tambah Form MJO
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="mb-4">
            <a href="{{ route('form-mjos.index') }}" class="btn btn-sm btn-light border font-weight-bold px-3.5 py-2 text-gray-700 shadow-xs" style="border-radius: 0.75rem;">
                <i class="fas fa-arrow-left mr-1.5"></i> Kembali ke Form MJO
            </a>
        </div>

        <div class="card shadow-sm border-0 mb-4" style="border-radius: 1rem;">
            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-extrabold text-gray-900"><i class="fas fa-tools text-cyan-600 mr-2"></i>Form Tambah Form MJO (Maintenance Job Order)</h6>
                <span class="badge bg-light text-gray-700 border px-3 py-1 font-weight-bold" style="border-radius: 50rem;">Job Order</span>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('form-mjos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Referensi PEJO (Optional) -->
                    <div class="bg-cyan-50/60 border border-cyan-200 rounded-xl p-3.5 mb-4">
                        <div class="form-group-item mb-0">
                            <label class="form-label font-weight-extrabold text-cyan-900 mb-1">
                                <i class="fas fa-link text-cyan-600 mr-1.5"></i> Referensi Laporan PEJO (Pengajuan Repair Cetakan)
                            </label>
                            <select name="form_repair_cetakan_id" id="form_repair_cetakan_id" class="form-select border-cyan-300">
                                <option value="">-- Pilih Dokumen PEJO Asal (Atau Kosongkan Jika Input Manual) --</option>
                                @foreach($pejos as $p)
                                    <option value="{{ $p->id }}" 
                                        data-code-item="{{ $p->list_code_item_id }}" 
                                        data-set-item="{{ $p->set_code_item_id }}" 
                                        data-cav-item="{{ $p->cav_code_item_id }}"
                                        data-problem="{{ $p->masalah }}"
                                        {{ (old('form_repair_cetakan_id', $selectedPejoId) == $p->id) ? 'selected' : '' }}>
                                        {{ $p->nodoc }} — Code Item: {{ $p->listCodeItem->name ?? '-' }} (Tgl: {{ \Carbon\Carbon::parse($p->tanggal)->format('d/m/Y') }})
                                    </option>
                                @endforeach
                            </select>
                            <span class="text-gray-500 text-xs mt-1 d-block">Memilih Laporan PEJO akan otomatis mengisikan Code Item, Mold Set, Mold Cavity, dan Deskripsi Masalah.</span>
                        </div>
                    </div>

                    <!-- Header Doc Info -->
                    <div class="form-grid-2 mb-4">
                        <div class="form-group-item">
                            <label class="form-label">No Document</label>
                            <input type="text" name="nodoc" value="{{ $nodoc }}" readonly class="form-control font-weight-extrabold text-cyan-600 bg-light">
                        </div>
                        <div class="form-group-item">
                            <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required class="form-control">
                        </div>
                    </div>

                    <!-- Detail Karyawan -->
                    <div class="border-bottom pb-3 mb-4 pt-2">
                        <h6 class="font-weight-extrabold text-gray-900 mb-0"><i class="fas fa-users text-primary mr-2"></i>Detail Karyawan / Group Role</h6>
                    </div>

                    <div class="form-grid-2 mb-4">
                        <div class="form-group-item">
                            <label class="form-label">Group Role <span class="text-danger">*</span></label>
                            <select name="role_id" id="role_id" required class="form-select">
                                @if(count($roles) > 1)
                                    <option value="">-- Pilih Group Role --</option>
                                @endif
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ (old('role_id') == $role->id || count($roles) == 1) ? 'selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group-item">
                            <label class="form-label">Pilih Karyawan PIC <span class="text-danger">*</span></label>
                            <select name="detail_user_id" id="detail_user_id" required class="form-select">
                                <option value="">-- Pilih Group Role Terlebih Dahulu --</option>
                            </select>
                        </div>
                    </div>

                    <!-- Detail Mold -->
                    <div class="border-bottom pb-3 mb-4 pt-2">
                        <h6 class="font-weight-extrabold text-gray-900 mb-0"><i class="fas fa-cogs text-cyan-600 mr-2"></i>Detail Mold</h6>
                    </div>

                    <div class="form-grid-3 mb-4">
                        <div class="form-group-item">
                            <label class="form-label">Code Item <span class="text-danger">*</span></label>
                            <select name="list_code_item_id" id="list_code_item_id" required class="form-select">
                                <option value="">-- Pilih Code Item --</option>
                                @foreach($listCodeItems as $ci)
                                    <option value="{{ $ci->id }}">{{ $ci->name }}</option>
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
                            <label class="form-label">Perbaikan yang Diminta / Deskripsi Masalah <span class="text-danger">*</span></label>
                            <textarea name="masalah" required rows="3" placeholder="Masukkan rincian perbaikan atau masalah yang dilaporkan..." class="form-control">{{ old('masalah') }}</textarea>
                        </div>
                        <div class="form-group-item">
                            <label class="form-label">Tindakan Perbaikan</label>
                            <textarea name="tindakan" rows="3" placeholder="Masukkan tindakan perbaikan MJO yang dilakukan..." class="form-control">{{ old('tindakan') }}</textarea>
                        </div>
                    </div>

                    <!-- Upload Foto / Gambar MJO (Multiple, Max 10MB) -->
                    <div class="border-bottom pb-3 mb-4 pt-2">
                        <h6 class="font-weight-extrabold text-gray-900 mb-0">
                            <i class="fas fa-images text-cyan-600 mr-2"></i>Upload Foto MJO (Opsional, Boleh >1 Foto)
                        </h6>
                    </div>

                    <div class="form-grid-1 mb-4">
                        <div class="form-group-item">
                            <label class="form-label text-xs font-weight-extrabold text-gray-700 uppercase">Pilih Foto / Gambar (Maksimal 10 MB per file)</label>
                            <input type="file" name="gambar[]" id="gambar_input" multiple accept="image/*" class="form-control text-xs p-1" style="border-radius: 0.75rem;">
                            <small class="text-gray-500 font-weight-bold mt-1 d-block">
                                <i class="fas fa-info-circle text-info mr-1"></i>Format: JPG, JPEG, PNG, WEBP. Ukuran maks per foto: <strong>10 MB</strong>. Anda dapat memilih beberapa foto sekaligus.
                            </small>
                            <div id="image_preview_container" class="d-flex flex-wrap gap-2 mt-3"></div>
                        </div>
                    </div>

                    <div class="pt-3 border-top d-flex align-items-center justify-content-end gap-2">
                        <a href="{{ route('form-mjos.index') }}" class="btn btn-sm btn-outline-secondary font-weight-bold px-4 py-2" style="border-radius: 0.75rem;">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-sm btn-primary font-weight-bold px-4 py-2" style="border-radius: 0.75rem; background-color: #2563eb; border: none;">
                            <i class="fas fa-save mr-1.5"></i> Simpan Form MJO
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const roleSelect = document.getElementById('role_id');
            const userSelect = document.getElementById('detail_user_id');
            const codeItemEl = document.getElementById('list_code_item_id');
            const setEl = document.getElementById('set_code_item_id');
            const cavEl = document.getElementById('cav_code_item_id');
            const mesinEl = document.getElementById('list_mesin_id');
            const pejoEl = document.getElementById('form_repair_cetakan_id');
            const masalahEl = document.querySelector('textarea[name="masalah"]');
            const baseUrl = "{{ url('/') }}";

            let tsCodeItem = null;

            // TomSelect for Code Item & Mesin (Single select, searchable)
            if (window.TomSelect) {
                if (codeItemEl && !codeItemEl.tomselect) {
                    tsCodeItem = new TomSelect(codeItemEl, { 
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
                        sortField: { field: '$order' },
                        render: {
                            no_results: function(data, escape) {
                                return '<div class="no-results p-2 text-xs text-gray-500 font-weight-bold">Mesin yang anda cari tidak ada</div>';
                            }
                        }
                    });
                }
            }

            // 1. Filter User by Role
            if (roleSelect && userSelect) {
                roleSelect.addEventListener('change', function () {
                    const roleId = this.value;
                    userSelect.innerHTML = '<option value="">-- Pilih Karyawan --</option>';
                    if (!roleId) return;

                    fetch(`{{ route('api.role.detail-users') }}?role_id=${roleId}`)
                        .then(res => res.json())
                        .then(data => {
                            data.forEach(user => {
                                const opt = document.createElement('option');
                                opt.value = user.id;
                                opt.textContent = user.name;
                                userSelect.appendChild(opt);
                            });
                            if (data.length === 1) {
                                userSelect.value = data[0].id;
                            }
                        });
                });

                if (roleSelect.value) {
                    roleSelect.dispatchEvent(new Event('change'));
                }
            }

            // 2. Dynamic Cascading Dropdowns with Promise Support
            function updateSets(listId, targetSetId = null) {
                if (!setEl) return Promise.resolve();
                setEl.innerHTML = '<option value="">-- Memuat Mold Set... --</option>';
                if (!listId) {
                    setEl.innerHTML = '<option value="">-- Pilih Code Item Terlebih Dahulu --</option>';
                    return Promise.resolve();
                }
                return fetch(`${baseUrl}/api/code-item/sets?list_code_item_id=${listId}`)
                    .then(res => res.json())
                    .then(data => {
                        setEl.innerHTML = '<option value="">-- Pilih Mold Set --</option>';
                        data.forEach(item => {
                            const opt = document.createElement('option');
                            opt.value = item.id;
                            opt.textContent = item.moldset;
                            if (targetSetId && item.id == targetSetId) {
                                opt.selected = true;
                            }
                            setEl.appendChild(opt);
                        });
                        if (targetSetId) {
                            setEl.value = targetSetId;
                        }
                    });
            }

            function updateCavs(listId, setId, targetCavId = null) {
                if (!cavEl) return Promise.resolve();
                cavEl.innerHTML = '<option value="">-- Memuat Mold Cavity... --</option>';
                if (!listId) {
                    cavEl.innerHTML = '<option value="">-- Pilih Code Item Terlebih Dahulu --</option>';
                    return Promise.resolve();
                }
                return fetch(`${baseUrl}/api/code-item/cavs?list_code_item_id=${listId}&set_code_item_id=${setId}`)
                    .then(res => res.json())
                    .then(data => {
                        cavEl.innerHTML = '<option value="">-- Pilih Mold Cavity --</option>';
                        data.forEach(item => {
                            const opt = document.createElement('option');
                            opt.value = item.id;
                            opt.textContent = item.moldcav;
                            if (targetCavId && item.id == targetCavId) {
                                opt.selected = true;
                            }
                            cavEl.appendChild(opt);
                        });
                        if (targetCavId) {
                            cavEl.value = targetCavId;
                        }
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

            // Lock / Unlock Helper
            function setFieldLock(isLocked) {
                if (tsCodeItem) {
                    if (isLocked) tsCodeItem.disable();
                    else tsCodeItem.enable();
                } else if (codeItemEl) {
                    codeItemEl.disabled = isLocked;
                }

                if (setEl) {
                    setEl.disabled = isLocked;
                    setEl.classList.toggle('bg-light', isLocked);
                }
                if (cavEl) {
                    cavEl.disabled = isLocked;
                    cavEl.classList.toggle('bg-light', isLocked);
                }
                if (masalahEl) {
                    masalahEl.readOnly = isLocked;
                    masalahEl.classList.toggle('bg-light', isLocked);
                }
            }

            // PEJO Auto Fill & Lock Handler
            async function applyPejoSelection() {
                if (!pejoEl) return;
                const opt = pejoEl.options[pejoEl.selectedIndex];
                if (opt && opt.value) {
                    const codeId = opt.getAttribute('data-code-item');
                    const setId = opt.getAttribute('data-set-item');
                    const cavId = opt.getAttribute('data-cav-item');
                    const problem = opt.getAttribute('data-problem');

                    // 1. Temporarily unlock to apply values
                    setFieldLock(false);

                    // 2. Set Code Item
                    if (tsCodeItem && codeId) {
                        tsCodeItem.setValue(codeId);
                    } else if (codeItemEl && codeId) {
                        codeItemEl.value = codeId;
                    }

                    // 3. Sequentially fetch sets and cavities
                    if (codeId) {
                        await updateSets(codeId, setId);
                        if (setId) {
                            await updateCavs(codeId, setId, cavId);
                        }
                    }

                    // 4. Set Masalah
                    if (masalahEl && problem) {
                        masalahEl.value = problem;
                    }

                    // 5. Lock fields so PE cannot alter mold items from PEJO
                    setFieldLock(true);
                } else {
                    setFieldLock(false);
                }
            }

            if (pejoEl) {
                pejoEl.addEventListener('change', applyPejoSelection);
                if (pejoEl.value) {
                    applyPejoSelection();
                }
            }

            // Re-enable disabled inputs right before form submit so Laravel receives their values
            const mjoForm = pejoEl ? pejoEl.closest('form') : null;
            if (mjoForm) {
                mjoForm.addEventListener('submit', function () {
                    if (setEl) setEl.disabled = false;
                    if (cavEl) cavEl.disabled = false;
                    if (tsCodeItem) tsCodeItem.enable();
                    if (codeItemEl) codeItemEl.disabled = false;
                });
            }

            // Image 10MB Validation & Preview Handler
            const gambarInput = document.getElementById('gambar_input');
            const previewContainer = document.getElementById('image_preview_container');

            if (gambarInput && previewContainer) {
                gambarInput.addEventListener('change', function () {
                    previewContainer.innerHTML = '';
                    const files = Array.from(this.files);
                    let sizeExceeded = false;

                    files.forEach(file => {
                        if (file.size > 10 * 1024 * 1024) { // 10MB
                            sizeExceeded = true;
                        } else {
                            const reader = new FileReader();
                            reader.onload = function (e) {
                                const div = document.createElement('div');
                                div.className = 'position-relative border rounded p-1 bg-white shadow-xs';
                                div.style.width = '75px';
                                div.style.height = '75px';
                                div.innerHTML = `<img src="${e.target.result}" class="w-100 h-100 rounded" style="object-fit: cover;" title="${file.name}">`;
                                previewContainer.appendChild(div);
                            };
                            reader.readAsDataURL(file);
                        }
                    });

                    if (sizeExceeded) {
                        alert('Perhatian: Salah satu atau beberapa foto yang Anda pilih melebihi ukuran 10 MB! Silakan pilih foto dengan ukuran maksimal 10 MB.');
                        this.value = '';
                        previewContainer.innerHTML = '';
                    }
                });
            }
        });
    </script>
</x-app-layout>
