<x-app-layout>
    <x-slot name="header">
        Edit Form PEJO (Repair Cetakan)
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="mb-4">
            <a href="{{ route('form-repair-cetakans.index') }}" class="btn btn-sm btn-light border font-weight-bold px-3.5 py-2 text-gray-700 shadow-xs" style="border-radius: 0.75rem;">
                <i class="fas fa-arrow-left mr-1.5"></i> Kembali ke Form PEJO
            </a>
        </div>

        <div class="card shadow-sm border-0 mb-4" style="border-radius: 1rem;">
            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-extrabold text-gray-900"><i class="fas fa-wrench text-rose-500 mr-2"></i>Edit Form PEJO (Pengajuan Repair Cetakan)</h6>
                <span class="badge bg-light text-gray-700 border px-3 py-1 font-weight-bold" style="border-radius: 50rem;">No Doc: {{ $formRepairCetakan->nodoc }}</span>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('form-repair-cetakans.update', $formRepairCetakan->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Header Doc Info -->
                    <div class="form-grid-2 mb-4">
                        <div class="form-group-item">
                            <label class="form-label">No Document</label>
                            <input type="text" name="nodoc" value="{{ $formRepairCetakan->nodoc }}" readonly class="form-control font-weight-extrabold text-rose-600 bg-light">
                        </div>
                        <div class="form-group-item">
                            <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal" value="{{ old('tanggal', $formRepairCetakan->tanggal) }}" required class="form-control">
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
                                    <option value="{{ $role->id }}" {{ (optional($formRepairCetakan->detailUser)->role_id == $role->id) ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group-item">
                            <label class="form-label">PIC Karyawan <span class="text-danger">*</span></label>
                            <select name="detail_user_id" id="detail_user_id" required class="form-select">
                                <option value="">-- Pilih PIC --</option>
                                @foreach($detailUsers as $du)
                                    <option value="{{ $du->id }}" {{ $formRepairCetakan->detail_user_id == $du->id ? 'selected' : '' }}>
                                        {{ $du->name }}
                                    </option>
                                @endforeach
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
                                    <option value="{{ $ci->id }}" {{ $formRepairCetakan->list_code_item_id == $ci->id ? 'selected' : '' }}>{{ $ci->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group-item">
                            <label class="form-label">Mold Set <span class="text-danger">*</span></label>
                            <select name="set_code_item_id" id="set_code_item_id" required class="form-select">
                                <option value="">-- Pilih Mold Set --</option>
                                @foreach($setCodeItems as $set)
                                    <option value="{{ $set->id }}" {{ $formRepairCetakan->set_code_item_id == $set->id ? 'selected' : '' }}>{{ $set->moldset }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group-item">
                            <label class="form-label">Mold Cavity <span class="text-danger">*</span></label>
                            <select name="cav_code_item_id" id="cav_code_item_id" required class="form-select">
                                <option value="">-- Pilih Mold Cavity --</option>
                                @foreach($cavCodeItems as $cav)
                                    <option value="{{ $cav->id }}" {{ $formRepairCetakan->cav_code_item_id == $cav->id ? 'selected' : '' }}>{{ $cav->moldcav }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-grid-1 mb-4">
                        <div class="form-group-item">
                            <label class="form-label">Deskripsi Problem / Masalah <span class="text-danger">*</span></label>
                            <textarea name="masalah" required rows="3" placeholder="Masukkan rincian kerusakan..." class="form-control">{{ old('masalah', $formRepairCetakan->masalah) }}</textarea>
                        </div>
                        <div class="form-group-item">
                            <label class="form-label">Tindakan Perbaikan</label>
                            <textarea name="tindakan" rows="3" placeholder="Masukkan langkah perbaikan..." class="form-control">{{ old('tindakan', $formRepairCetakan->tindakan) }}</textarea>
                        </div>

                    </div>

                    <!-- Upload Foto / Gambar (Multiple, Max 10MB) -->
                    <div class="border-bottom pb-3 mb-4 pt-2">
                        <h6 class="font-weight-extrabold text-gray-900 mb-0">
                            <i class="fas fa-images text-emerald-600 mr-2"></i>Upload Foto Kerusakan
                        </h6>
                    </div>

                    <div class="form-grid-1 mb-4">
                        <div class="form-group-item">
                            @php
                                $imgs = json_decode($formRepairCetakan->gambar, true);
                                if (!is_array($imgs)) {
                                    $imgs = $formRepairCetakan->gambar ? [$formRepairCetakan->gambar] : [];
                                }
                            @endphp
                            @if(count($imgs) > 0)
                                <div class="mb-3">
                                    <span class="text-xs text-gray-500 font-weight-bold d-block mb-1.5">Foto Terupload Saat Ini:</span>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($imgs as $imgPath)
                                            @php $cleanUrl = asset(ltrim(str_replace('\\', '/', $imgPath), '/')); @endphp
                                            <a href="{{ $cleanUrl }}" target="_blank" class="d-inline-block border rounded p-1 bg-white shadow-xs hover:shadow-sm" title="Klik untuk lihat foto">
                                                <img src="{{ $cleanUrl }}" class="rounded" style="width: 54px; height: 54px; object-fit: cover;">
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            <label class="form-label">Tambah / Ubah Foto (Maksimal 10 MB per file, Boleh >1 Foto)</label>
                            <input type="file" name="gambar[]" id="gambar_input" multiple accept="image/*" class="form-control text-xs">
                            <span class="text-gray-500 text-xs mt-1 d-block">Format: JPG, JPEG, PNG, WEBP. Maksimal ukuran per foto: <strong>10 MB</strong>.</span>
                            <div id="image_preview_container" class="d-flex flex-wrap gap-2 mt-2"></div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex align-items-center justify-content-end gap-2 pt-3 border-top">
                        <a href="{{ route('form-repair-cetakans.index') }}" class="btn btn-light border font-weight-bold px-4 py-2" style="border-radius: 0.75rem;">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary font-weight-bold px-4 py-2" style="background-color: #2563eb; border: none; border-radius: 0.75rem;">
                            <i class="fas fa-save mr-1.5"></i> Update Form PEJO
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
            const baseUrl = "{{ url('/') }}";

            // TomSelect for PIC and Code Item
            if (typeof TomSelect !== 'undefined') {
                if (picSelect && !picSelect.tomselect) {
                    new TomSelect('#detail_user_id', { plugins: ['dropdown_input'], create: false, maxItems: 1, closeAfterSelect: true, placeholder: '-- Ketik / Pilih PIC --' });
                }
                if (codeItemSelect && !codeItemSelect.tomselect) {
                    new TomSelect('#list_code_item_id', { 
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
                        }
                    });
                }
            }

            // Dynamic Cascade for Mold Set
            if (codeItemSelect && setSelect) {
                codeItemSelect.addEventListener('change', function () {
                    const listId = this.value;
                    setSelect.innerHTML = '<option value="">-- Pilih Mold Set --</option>';
                    if (cavSelect) cavSelect.innerHTML = '<option value="">-- Pilih Mold Cavity --</option>';

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

            // Dynamic Cascade for Mold Cavity
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
                                div.className = 'border rounded p-1 bg-white shadow-xs';
                                div.style.width = '54px';
                                div.style.height = '54px';
                                div.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover rounded" title="${file.name}">`;
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
