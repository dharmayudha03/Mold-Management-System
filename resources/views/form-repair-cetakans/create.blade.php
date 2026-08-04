<x-app-layout>
    <x-slot name="header">
        Tambah Form PEJO (Repair)
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="mb-4">
            <a href="{{ route('form-repair-cetakans.index') }}" class="btn btn-sm btn-light border font-weight-bold px-3.5 py-2 text-gray-700 shadow-xs" style="border-radius: 0.75rem;">
                <i class="fas fa-arrow-left mr-1.5"></i> Kembali ke Form Repair
            </a>
        </div>

        <div class="card shadow-sm border-0 mb-4" style="border-radius: 1rem;">
            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-extrabold text-gray-900"><i class="fas fa-wrench text-rose-500 mr-2"></i>Form Tambah Repair Cetakan Baru</h6>
                <span class="badge bg-light text-gray-700 border px-3 py-1 font-weight-bold" style="border-radius: 50rem;">Laporan Maintenance</span>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('form-repair-cetakans.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Header Doc Info -->
                    <div class="form-grid-2 mb-4">
                        <div class="form-group-item">
                            <label class="form-label">No Document</label>
                            <input type="text" name="nodoc" value="{{ $nodoc }}" readonly class="form-control font-weight-extrabold text-rose-600 bg-light">
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
                                <option value="">-- Pilih Group Role --</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
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

                    <!-- Detail Mold & Problem -->
                    <div class="border-bottom pb-3 mb-4 pt-2">
                        <h6 class="font-weight-extrabold text-gray-900 mb-0"><i class="fas fa-cubes text-info mr-2"></i>Detail Code Item & Problem</h6>
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
                            <label class="form-label">Deskripsi Problem / Masalah <span class="text-danger">*</span></label>
                            <textarea name="masalah" required rows="3" placeholder="Masukkan rincian kerusakan atau masalah pada cetakan..." class="form-control">{{ old('masalah') }}</textarea>
                        </div>
                        <div class="form-group-item">
                            <label class="form-label">Tindakan Perbaikan <span class="text-danger">*</span></label>
                            <textarea name="tindakan" rows="3" placeholder="Masukkan langkah perbaikan yang dilakukan..." class="form-control">{{ old('tindakan') }}</textarea>
                        </div>

                    </div>

                    <!-- Upload Foto / Gambar (Multiple, Max 10MB) -->
                    <div class="border-bottom pb-3 mb-4 pt-2">
                        <h6 class="font-weight-extrabold text-gray-900 mb-0">
                            <i class="fas fa-images text-emerald-600 mr-2"></i>Upload Foto Kerusakan (Opsional, Boleh >1 Foto)
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
                        <a href="{{ route('form-repair-cetakans.index') }}" class="btn btn-sm btn-outline-secondary font-weight-bold px-4 py-2" style="border-radius: 0.75rem;">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-sm btn-primary font-weight-bold px-4 py-2" style="border-radius: 0.75rem; background-color: #2563eb; border: none;">
                            <i class="fas fa-save mr-1.5"></i> Simpan Form Repair
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
            const baseUrl = "{{ url('/') }}";

            // TomSelect for Code Item (Single select, searchable)
            if (window.TomSelect && codeItemEl && !codeItemEl.tomselect) {
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

            // 1. Filter User by Role
            if (roleSelect && userSelect) {
                roleSelect.addEventListener('change', function () {
                    const roleId = this.value;
                    userSelect.innerHTML = '<option value="">-- Pilih Karyawan --</option>';
                    if (!roleId) {
                        userSelect.innerHTML = '<option value="">-- Pilih Group Role Terlebih Dahulu --</option>';
                        return;
                    }

                    fetch(`{{ route('api.role.detail-users') }}?role_id=${roleId}`)
                        .then(res => res.json())
                        .then(data => {
                            data.forEach(user => {
                                const opt = document.createElement('option');
                                opt.value = user.id;
                                opt.textContent = user.name;
                                userSelect.appendChild(opt);
                            });
                        });
                });
            }

            // 2. Dynamic Cascading Dropdowns
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
