@php
    $isMsd = auth()->check() && (auth()->user()->hasRole('Msd') || auth()->user()->hasRole('msd') || auth()->user()->hasRole('MSD')) && !auth()->user()->hasRole('super_admin');
@endphp

<x-app-layout>
    <x-slot name="header">
        Edit Form MJO
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="mb-4">
            <a href="{{ route('form-mjos.index') }}" class="btn btn-sm btn-light border font-weight-bold px-3.5 py-2 text-gray-700 shadow-xs" style="border-radius: 0.75rem;">
                <i class="fas fa-arrow-left mr-1.5"></i> Kembali ke Form MJO
            </a>
        </div>

        <div class="card shadow-sm border-0 mb-4" style="border-radius: 1rem;">
            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-extrabold text-gray-900"><i class="fas fa-edit text-primary mr-2"></i>Edit Form MJO (Maintenance Job Order)</h6>
                <span class="badge bg-light text-gray-700 border px-3 py-1 font-weight-bold" style="border-radius: 50rem;">No Doc: {{ $formMjo->nodoc }}</span>
            </div>
            <div class="card-body p-4">
                @if($isMsd)
                    <div class="alert alert-warning text-xs font-weight-bold mb-4 d-flex align-items-center" style="border-radius: 0.75rem;">
                        <i class="fas fa-lock text-base mr-2.5 text-warning"></i>
                        <div>
                            Data Laporan PE dikunci (Read Only) untuk Role Mold Shop (MSD). Anda hanya perlu mengisi <strong>Bagian 2: Hasil Perbaikan Mold Shop</strong> di bawah.
                        </div>
                    </div>
                @endif

                <form action="{{ route('form-mjos.update', $formMjo->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    @if($isMsd)
                        <input type="hidden" name="nodoc" value="{{ $formMjo->nodoc }}">
                        <input type="hidden" name="tanggal" value="{{ $formMjo->tanggal }}">
                        <input type="hidden" name="detail_user_id" value="{{ $formMjo->detail_user_id }}">
                        <input type="hidden" name="list_code_item_id" value="{{ $formMjo->list_code_item_id }}">
                        <input type="hidden" name="set_code_item_id" value="{{ $formMjo->set_code_item_id }}">
                        <input type="hidden" name="cav_code_item_id" value="{{ $formMjo->cav_code_item_id }}">
                        <input type="hidden" name="masalah" value="{{ $formMjo->masalah }}">
                        <input type="hidden" name="tindakan" value="{{ $formMjo->tindakan }}">
                    @endif

                    <!-- Referensi PEJO (Optional) -->
                    @if($formMjo->formRepairCetakan)
                        <div class="bg-light border rounded-xl p-3 mb-4">
                            <div class="form-group-item mb-0">
                                <label class="form-label font-weight-extrabold text-gray-900 mb-1">
                                    <i class="fas fa-link text-primary mr-1.5"></i> Referensi Laporan PEJO (Pengajuan Repair Cetakan)
                                </label>
                                <input type="text" readonly value="{{ $formMjo->formRepairCetakan->nodoc }} — Code Item: {{ $formMjo->listCodeItem->name ?? '-' }} (Tgl: {{ \Carbon\Carbon::parse($formMjo->formRepairCetakan->tanggal)->format('d/m/Y') }})" class="form-control bg-white font-weight-bold text-gray-800">
                                <input type="hidden" name="form_repair_cetakan_id" value="{{ $formMjo->form_repair_cetakan_id }}">
                            </div>
                        </div>
                    @else
                        <div class="bg-light border rounded-xl p-3 mb-4">
                            <div class="form-group-item mb-0">
                                <label class="form-label font-weight-extrabold text-gray-900 mb-1">
                                    <i class="fas fa-link text-primary mr-1.5"></i> Referensi Laporan PEJO (Pengajuan Repair Cetakan)
                                </label>
                                <select name="form_repair_cetakan_id" id="form_repair_cetakan_id" class="form-select" {{ $isMsd ? 'disabled' : '' }}>
                                    <option value="">-- Tanpa Referensi PEJO (Input Manual) --</option>
                                    @foreach($pejos as $p)
                                        <option value="{{ $p->id }}" {{ $formMjo->form_repair_cetakan_id == $p->id ? 'selected' : '' }}>
                                            {{ $p->nodoc }} — Code Item: {{ $p->listCodeItem->name ?? '-' }} (Tgl: {{ \Carbon\Carbon::parse($p->tanggal)->format('d/m/Y') }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif

                    <!-- BAGIAN 1: LAPORAN MJO (PE) -->
                    <div class="border-bottom pb-3 mb-4 pt-2 d-flex align-items-center justify-content-between">
                        <h6 class="font-weight-extrabold text-gray-900 mb-0"><i class="fas fa-file-alt text-primary mr-2"></i>Bagian 1: Data Laporan MJO (Production Engineering / PE)</h6>
                        <span class="badge bg-primary-10 text-primary font-weight-bold px-2.5 py-1" style="border-radius: 50rem; font-size: 0.72rem;">Data PE</span>
                    </div>

                    <!-- No Document & Tanggal -->
                    <div class="form-grid-2 mb-4">
                        <div class="form-group-item">
                            <label class="form-label">No Document</label>
                            <input type="text" name="nodoc" value="{{ $formMjo->nodoc }}" readonly class="form-control font-weight-extrabold text-primary bg-light">
                        </div>
                        <div class="form-group-item">
                            <label class="form-label">Tanggal MJO <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal" value="{{ old('tanggal', $formMjo->tanggal) }}" required class="form-control" {{ $isMsd ? 'disabled' : '' }}>
                        </div>
                    </div>

                    <!-- Detail Karyawan / Group Role -->
                    <div class="border-bottom pb-3 mb-4 pt-2">
                        <h6 class="font-weight-extrabold text-gray-900 mb-0"><i class="fas fa-users text-primary mr-2"></i>Detail Karyawan / Group Role</h6>
                    </div>

                    <div class="form-grid-2 mb-4">
                        <div class="form-group-item">
                            <label class="form-label">Group Role <span class="text-danger">*</span></label>
                            <select name="role_id" id="role_id" required class="form-select" {{ $isMsd ? 'disabled' : '' }}>
                                @if(count($roles) > 1)
                                    <option value="">-- Pilih Group Role --</option>
                                @endif
                                @foreach($roles as $role)
                                    @php
                                        $selectedRoleId = old('role_id', $formMjo->detailUser->role_id ?? null);
                                    @endphp
                                    <option value="{{ $role->id }}" {{ ($selectedRoleId == $role->id) ? 'selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group-item">
                            <label class="form-label">Pilih Karyawan PIC <span class="text-danger">*</span></label>
                            <select name="detail_user_id" id="detail_user_id" required class="form-select" {{ $isMsd ? 'disabled' : '' }}>
                                <option value="">-- Pilih Group Role Terlebih Dahulu --</option>
                                @foreach($detailUsers as $du)
                                    <option value="{{ $du->id }}" {{ $formMjo->detail_user_id == $du->id ? 'selected' : '' }}>{{ $du->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Detail Mold (Code Item, Set, Cavity) -->
                    <div class="form-grid-3 mb-4">
                        <div class="form-group-item">
                            <label class="form-label">Code Item <span class="text-danger">*</span></label>
                            <select name="list_code_item_id" id="list_code_item_id" required class="form-select" {{ $isMsd ? 'disabled' : '' }}>
                                <option value="">-- Pilih Code Item --</option>
                                @foreach($listCodeItems as $ci)
                                    <option value="{{ $ci->id }}" {{ $formMjo->list_code_item_id == $ci->id ? 'selected' : '' }}>{{ $ci->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group-item">
                            <label class="form-label">Mold Set <span class="text-danger">*</span></label>
                            <select name="set_code_item_id" id="set_code_item_id" required class="form-select" {{ $isMsd ? 'disabled' : '' }}>
                                <option value="">-- Pilih Mold Set --</option>
                                @foreach($setCodeItems as $s)
                                    <option value="{{ $s->id }}" {{ $formMjo->set_code_item_id == $s->id ? 'selected' : '' }}>{{ $s->moldset }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group-item">
                            <label class="form-label">Mold Cavity <span class="text-danger">*</span></label>
                            <select name="cav_code_item_id" id="cav_code_item_id" required class="form-select" {{ $isMsd ? 'disabled' : '' }}>
                                <option value="">-- Pilih Mold Cavity --</option>
                                @foreach($cavCodeItems as $c)
                                    <option value="{{ $c->id }}" {{ $formMjo->cav_code_item_id == $c->id ? 'selected' : '' }}>{{ $c->moldcav }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Masalah Kerusakan PE -->
                    <div class="form-grid-1 mb-4">
                        <div class="form-group-item">
                            <label class="form-label">Deskripsi Kerusakan / Masalah PE <span class="text-danger">*</span></label>
                            <textarea name="masalah" rows="3" required class="form-control" placeholder="Tuliskan detail kerusakan dari PE..." {{ $isMsd ? 'readonly' : '' }}>{{ old('masalah', $formMjo->masalah) }}</textarea>
                        </div>
                        <div class="form-group-item">
                            <label class="form-label">Tindakan Perbaikan PE</label>
                            <textarea name="tindakan" rows="3" class="form-control" placeholder="Masukkan tindakan perbaikan MJO yang dilakukan..." {{ $isMsd ? 'readonly' : '' }}>{{ old('tindakan', $formMjo->tindakan) }}</textarea>
                        </div>
                    </div>

                    <!-- Foto Laporan PE -->
                    <div class="form-grid-1 mb-4">
                        <div class="form-group-item">
                            <label class="form-label"><i class="fas fa-camera text-primary mr-1.5"></i>Foto Laporan Kerusakan PE</label>
                            @php
                                $imgs = json_decode($formMjo->gambar, true);
                                if (!is_array($imgs)) {
                                    $imgs = $formMjo->gambar ? [$formMjo->gambar] : [];
                                }
                            @endphp
                            @if(count($imgs) > 0)
                                <div class="mb-2">
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
                            @else
                                <span class="text-gray-400 font-weight-bold text-xs d-block mb-2">- Tidak ada foto dari PE -</span>
                            @endif
                            @if(!$isMsd)
                                <input type="file" name="gambar[]" id="gambar_input" multiple accept="image/*" class="form-control text-xs">
                                <span class="text-gray-500 text-xs mt-1 d-block">Format: JPG, JPEG, PNG, WEBP. Maksimal ukuran per foto: <strong>10 MB</strong>.</span>
                                <div id="image_preview_container" class="d-flex flex-wrap gap-2 mt-2"></div>
                            @endif
                        </div>
                    </div>

                    <!-- BAGIAN 2: HASIL PERBAIKAN (MOLD SHOP) -->
                    <div id="moldshop" class="border-bottom pb-3 mb-4 pt-4 d-flex align-items-center justify-content-between">
                        <h6 class="font-weight-extrabold text-gray-900 mb-0"><i class="fas fa-tools text-success mr-2"></i>Bagian 2: Pembaruan Status & Hasil Perbaikan Mold Shop</h6>
                        <span class="badge bg-success-10 text-success font-weight-bold px-2.5 py-1" style="border-radius: 50rem; font-size: 0.72rem;">Mold Shop</span>
                    </div>

                    <!-- Status & Tanggal Selesai -->
                    <div class="form-grid-2 mb-4">
                        <div class="form-group-item">
                            <label class="form-label">Status Perbaikan <span class="text-danger">*</span></label>
                            <select name="status" class="form-select">
                                <option value="Proses" {{ old('status', $formMjo->status) == 'Proses' || empty($formMjo->status) ? 'selected' : '' }}>Dalam Proses (Process)</option>
                                <option value="Selesai" {{ old('status', $formMjo->status) == 'Selesai' ? 'selected' : '' }}>Selesai (Completed)</option>
                            </select>
                        </div>
                        <div class="form-group-item">
                            <label class="form-label">Tanggal Selesai Perbaikan</label>
                            <input type="date" name="tglselesai" value="{{ old('tglselesai', $formMjo->tglselesai ? \Carbon\Carbon::parse($formMjo->tglselesai)->format('Y-m-d') : date('Y-m-d')) }}" class="form-control">
                        </div>
                    </div>

                    <!-- Detail Perbaikan Mold Shop -->
                    <div class="form-grid-1 mb-4">
                        <div class="form-group-item">
                            <label class="form-label">Tindakan / Detail Perbaikan oleh Mold Shop</label>
                            <textarea name="tindakan_moldshop" rows="3" placeholder="Tuliskan tindakan perbaikan yang telah dilakukan oleh Mold Shop..." class="form-control">{{ old('tindakan_moldshop', $formMjo->tindakan_moldshop) }}</textarea>
                        </div>
                    </div>

                    <!-- Foto Bukti Hasil Perbaikan Mold Shop -->
                    <div class="form-grid-1 mb-4">
                        <div class="form-group-item">
                            <label class="form-label"><i class="fas fa-images text-success mr-1.5"></i>Foto Bukti Perbaikan Selesai (Mold Shop)</label>
                            @php
                                $imgsSelesai = json_decode($formMjo->gambar_selesai, true);
                                if (!is_array($imgsSelesai)) {
                                    $imgsSelesai = $formMjo->gambar_selesai ? [$formMjo->gambar_selesai] : [];
                                }
                            @endphp
                            @if(count($imgsSelesai) > 0)
                                <div class="mb-2">
                                    <span class="text-xs text-success font-weight-bold d-block mb-1.5">Foto Hasil Repair Terupload:</span>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($imgsSelesai as $imgPathS)
                                            @php $cleanUrlS = asset(ltrim(str_replace('\\', '/', $imgPathS), '/')); @endphp
                                            <a href="{{ $cleanUrlS }}" target="_blank" class="d-inline-block border border-success-subtle rounded p-1 bg-light shadow-xs hover:shadow-sm" title="Klik untuk lihat foto bukti repair">
                                                <img src="{{ $cleanUrlS }}" class="rounded" style="width: 54px; height: 54px; object-fit: cover;">
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            <input type="file" name="gambar_selesai[]" id="gambar_selesai_input" multiple accept="image/*" class="form-control text-xs">
                            <span class="text-gray-500 text-xs mt-1 d-block">Format: JPG, JPEG, PNG, WEBP. Maksimal ukuran per foto: <strong>10 MB</strong>.</span>
                            <div id="image_selesai_preview_container" class="d-flex flex-wrap gap-2 mt-2"></div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex align-items-center justify-content-end gap-2 pt-3 border-top">
                        <a href="{{ route('form-mjos.index') }}" class="btn btn-light border font-weight-bold px-4 py-2" style="border-radius: 0.75rem;">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary font-weight-bold px-4 py-2" style="background-color: #2563eb; border: none; border-radius: 0.75rem;">
                            <i class="fas fa-save mr-1.5"></i> Simpan Data MJO
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
            const codeItemSelect = document.getElementById('list_code_item_id');
            const setSelect = document.getElementById('set_code_item_id');
            const cavSelect = document.getElementById('cav_code_item_id');
            const baseUrl = "{{ url('/') }}";

            // 1. Filter User by Role
            if (roleSelect && userSelect) {
                roleSelect.addEventListener('change', function () {
                    const roleId = this.value;
                    const currentSelectedUserId = "{{ old('detail_user_id', $formMjo->detail_user_id) }}";
                    userSelect.innerHTML = '<option value="">-- Pilih Karyawan --</option>';
                    if (!roleId) return;

                    fetch(`{{ route('api.role.detail-users') }}?role_id=${roleId}`)
                        .then(res => res.json())
                        .then(data => {
                            data.forEach(user => {
                                const opt = document.createElement('option');
                                opt.value = user.id;
                                opt.textContent = user.name;
                                if (currentSelectedUserId && user.id == currentSelectedUserId) {
                                    opt.selected = true;
                                }
                                userSelect.appendChild(opt);
                            });
                            if (currentSelectedUserId) {
                                userSelect.value = currentSelectedUserId;
                            } else if (data.length === 1) {
                                userSelect.value = data[0].id;
                            }
                        });
                });

                if (roleSelect.value) {
                    roleSelect.dispatchEvent(new Event('change'));
                }
            }

            // TomSelect for PIC & Code Item
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

            // Image Selesai 10MB Validation & Preview Handler
            const gambarSelesaiInput = document.getElementById('gambar_selesai_input');
            const previewSelesaiContainer = document.getElementById('image_selesai_preview_container');

            if (gambarSelesaiInput && previewSelesaiContainer) {
                gambarSelesaiInput.addEventListener('change', function () {
                    previewSelesaiContainer.innerHTML = '';
                    const files = Array.from(this.files);
                    let sizeExceeded = false;

                    files.forEach(file => {
                        if (file.size > 10 * 1024 * 1024) { // 10MB
                            sizeExceeded = true;
                        } else {
                            const reader = new FileReader();
                            reader.onload = function (e) {
                                const div = document.createElement('div');
                                div.className = 'border border-success-subtle rounded p-1 bg-light shadow-xs';
                                div.style.width = '54px';
                                div.style.height = '54px';
                                div.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover rounded" title="${file.name}">`;
                                previewSelesaiContainer.appendChild(div);
                            };
                            reader.readAsDataURL(file);
                        }
                    });

                    if (sizeExceeded) {
                        alert('Perhatian: Salah satu atau beberapa foto bukti perbaikan yang Anda pilih melebihi ukuran 10 MB! Silakan pilih foto dengan ukuran maksimal 10 MB.');
                        this.value = '';
                        previewSelesaiContainer.innerHTML = '';
                    }
                });
            }

            // Auto-scroll to Mold Shop section if hash #moldshop exists
            if (window.location.hash === '#moldshop') {
                const moldshopSec = document.getElementById('moldshop');
                if (moldshopSec) {
                    setTimeout(() => {
                        moldshopSec.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }, 300);
                }
            }
        });
    </script>
</x-app-layout>
