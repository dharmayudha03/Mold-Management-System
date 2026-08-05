<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        Tambah Form Sandblasting
     <?php $__env->endSlot(); ?>

    <div class="max-w-4xl mx-auto">
        <div class="mb-4">
            <a href="<?php echo e(route('form-sandblastings.index')); ?>" class="btn btn-sm btn-light border font-weight-bold px-3.5 py-2 text-gray-700 shadow-xs" style="border-radius: 0.75rem;">
                <i class="fas fa-arrow-left mr-1.5"></i> Kembali ke Form Sandblasting
            </a>
        </div>

        <div class="card shadow-sm border-0 mb-4" style="border-radius: 1rem;">
            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-extrabold text-gray-900"><i class="fas fa-bolt text-amber-500 mr-2"></i>Form Tambah Sandblasting Baru</h6>
                <span class="badge bg-light text-gray-700 border px-3 py-1 font-weight-bold" style="border-radius: 50rem;">Laporan Sandblasting</span>
            </div>
            <div class="card-body p-4">
                <form action="<?php echo e(route('form-sandblastings.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>

                    <!-- Header Doc Info & Schedule Reference -->
                    <div class="form-grid-3 mb-4">
                        <div class="form-group-item">
                            <label class="form-label">No Document</label>
                            <input type="text" name="nodoc" value="<?php echo e($nodoc); ?>" readonly class="form-control font-weight-extrabold text-amber-600 bg-light">
                        </div>
                        <div class="form-group-item">
                            <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal" value="<?php echo e($selectedSchedule ? $selectedSchedule->tanggal : date('Y-m-d')); ?>" required class="form-control">
                        </div>
                        <div class="form-group-item">
                            <label class="form-label text-purple-700 font-weight-bold"><i class="fas fa-calendar-alt mr-1"></i> Mengacu Ref. Schedule (Opsional)</label>
                            <select name="form_schedule_id" id="form_schedule_id" class="form-select bg-purple-50 border-purple-200">
                                <option value="">-- Tanpa Referensi Schedule --</option>
                                <?php $__currentLoopData = $formSchedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($sch->id); ?>" <?php echo e(($selectedSchedule && $selectedSchedule->id == $sch->id) ? 'selected' : ''); ?>

                                        data-codeitem="<?php echo e($sch->list_code_item_id); ?>"
                                        data-set="<?php echo e($sch->set_code_item_id); ?>"
                                        data-cav="<?php echo e($sch->cav_code_item_id); ?>"
                                        data-mesin="<?php echo e($sch->list_mesin_id); ?>"
                                        data-kategori="<?php echo e($sch->kategori_id); ?>"
                                        data-tanggal="<?php echo e($sch->tanggal); ?>">
                                        <?php echo e($sch->nodoc); ?> - <?php echo e($sch->listCodeItem->name ?? 'Code Item'); ?> (<?php echo e($sch->tanggal); ?>)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
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
                                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($role->id); ?>"><?php echo e($role->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="form-group-item">
                            <label class="form-label">Pilih Nama Karyawan PIC <span class="text-danger">*</span></label>
                            <div id="detail_user_container" class="p-3 bg-light rounded-xl border max-h-48 overflow-y-auto" style="border-radius: 0.75rem;">
                                <p class="text-xs text-gray-500 italic mb-0">Pilih Group Role terlebih dahulu untuk memilih nama karyawan.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Code Item & Mesin -->
                    <div class="border-bottom pb-3 mb-4 pt-2">
                        <h6 class="font-weight-extrabold text-gray-900 mb-0"><i class="fas fa-cubes text-info mr-2"></i>Detail Code Item & Mesin</h6>
                    </div>

                    <div class="form-grid-3 mb-4">
                        <div class="form-group-item">
                            <label class="form-label">Code Item <span class="text-danger">*</span></label>
                            <select name="list_code_item_id" id="list_code_item_id" required class="form-select">
                                <option value="">-- Pilih Code Item --</option>
                                <?php $__currentLoopData = $listCodeItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ci): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($ci->id); ?>" <?php echo e(($selectedSchedule && $selectedSchedule->list_code_item_id == $ci->id) ? 'selected' : ''); ?>><?php echo e($ci->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="form-group-item">
                            <label class="form-label">Mold Set <span class="text-danger">*</span></label>
                            <select name="set_code_item_id" id="set_code_item_id" required class="form-select">
                                <option value="">-- Pilih Code Item Terlebih Dahulu --</option>
                                <?php $__currentLoopData = $setCodeItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($st->id); ?>" <?php echo e(($selectedSchedule && $selectedSchedule->set_code_item_id == $st->id) ? 'selected' : ''); ?>><?php echo e($st->moldset); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="form-group-item">
                            <label class="form-label">Mold Cavity <span class="text-danger">*</span></label>
                            <select name="cav_code_item_id" id="cav_code_item_id" required class="form-select">
                                <option value="">-- Pilih Code Item Terlebih Dahulu --</option>
                                <?php $__currentLoopData = $cavCodeItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($cv->id); ?>" <?php echo e(($selectedSchedule && $selectedSchedule->cav_code_item_id == $cv->id) ? 'selected' : ''); ?>><?php echo e($cv->moldcav); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="form-group-item">
                            <label class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select name="kategori_id" id="kategori_id" required class="form-select">
                                <option value="">-- Pilih Kategori --</option>
                                <?php $__currentLoopData = $kategoris; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($k->id); ?>" <?php echo e(($selectedSchedule && $selectedSchedule->kategori_id == $k->id) ? 'selected' : ''); ?>><?php echo e($k->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="form-group-item">
                            <label class="form-label">Mesin (Opsional)</label>
                            <select name="list_mesin_id" id="list_mesin_id" class="form-select">
                                <option value="">-- Tanpa Mesin (Opsional) --</option>
                                <?php $__currentLoopData = $listMesins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $isOccupied = in_array($m->id, $occupiedMesinIds ?? []);
                                    ?>
                                    <?php if(!$isOccupied): ?>
                                        <option value="<?php echo e($m->id); ?>" <?php echo e(($selectedSchedule && $selectedSchedule->list_mesin_id == $m->id) ? 'selected' : ''); ?>><?php echo e($m->code); ?></option>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="form-group-item">
                            <label class="form-label">Shift <span class="text-danger">*</span></label>
                            <select name="shift" required class="form-select">
                                <option value="">-- Pilih Shift --</option>
                                <?php if(!auth()->user()->hasRole('Setup & Maintenance')): ?>
                                <option value="NS" <?php echo e((old('shift', $prefilledShift ?? '') == 'NS') ? 'selected' : ''); ?>>NS</option>
                                <?php endif; ?>
                                <option value="1" <?php echo e((old('shift', $prefilledShift ?? '') == '1' || old('shift', $prefilledShift ?? '') == 'Shift 1') ? 'selected' : ''); ?>>Shift 1</option>
                                <option value="2" <?php echo e((old('shift', $prefilledShift ?? '') == '2' || old('shift', $prefilledShift ?? '') == 'Shift 2') ? 'selected' : ''); ?>>Shift 2</option>
                                <option value="3" <?php echo e((old('shift', $prefilledShift ?? '') == '3' || old('shift', $prefilledShift ?? '') == 'Shift 3') ? 'selected' : ''); ?>>Shift 3</option>
                            </select>
                        </div>
                        <div class="form-group-item">
                            <label class="form-label">Rak (Opsional)</label>
                            <select name="rak" id="rak" class="form-select">
                                <option value="">-- Pilih / Ketik Rak --</option>
                                <?php $__currentLoopData = array_keys($rackData); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($rName); ?>" <?php echo e(old('rak') == $rName ? 'selected' : ''); ?>><?php echo e($rName); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                        <h6 class="font-weight-extrabold text-gray-900 mb-0"><i class="fas fa-tasks text-amber-500 mr-2"></i>Pemeriksaan Item Sandblasting & Cavity NG</h6>
                    </div>

                    <div class="form-grid-3 mb-4">
                        <?php $__currentLoopData = ['sandblasting' => 'Sandblasting', 'cuci' => 'Cuci Cetakan', 'autosol' => 'Autosol', 'gerinda' => 'Gerinda / Kikir', 'oiling' => 'Oiling']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="p-3 bg-light rounded-xl border d-flex flex-column justify-content-between" style="border-radius: 0.85rem; border: 1px solid #e2e8f0;">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="text-xs font-weight-extrabold text-gray-900 uppercase"><i class="fas fa-check-circle text-amber-500 mr-1.5"></i><?php echo e($label); ?></span>
                                </div>
                                <select name="<?php echo e($field); ?>" class="form-select text-xs font-weight-bold text-gray-900 bg-white" style="border-radius: 0.6rem; padding: 0.5rem 0.75rem;">
                                    <option value="">-- Pilih --</option>
                                    <option value="√">√ (Pakai / Sesuai)</option>
                                    <option value="-">- (Tidak)</option>
                                </select>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <div class="p-3 bg-light rounded-xl border d-flex flex-column justify-content-between" style="border-radius: 0.85rem; border: 1px solid #e2e8f0;">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="text-xs font-weight-extrabold text-gray-900 uppercase"><i class="fas fa-exclamation-triangle text-rose-500 mr-1.5"></i>Jumlah Cavity NG</span>
                            </div>
                            <input type="number" name="cav_ng" value="<?php echo e(old('cav_ng', 0)); ?>" min="0" placeholder="0" class="form-control text-xs font-weight-bold text-gray-900 bg-white" style="border-radius: 0.6rem; padding: 0.45rem 0.75rem;">
                        </div>
                    </div>

                    <div class="pt-3 border-top d-flex align-items-center justify-content-end gap-2">
                        <a href="<?php echo e(route('form-sandblastings.index')); ?>" class="btn btn-sm btn-outline-secondary font-weight-bold px-4 py-2" style="border-radius: 0.75rem;">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-sm btn-primary font-weight-bold px-4 py-2" style="background-color: #2563eb; border: none; border-radius: 0.75rem;">
                            <i class="fas fa-save mr-1.5"></i> Simpan Form Sandblasting
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
            const codeItemEl = document.getElementById('list_code_item_id');
            const setEl = document.getElementById('set_code_item_id');
            const cavEl = document.getElementById('cav_code_item_id');
            const mesinEl = document.getElementById('list_mesin_id');
            const rakEl = document.getElementById('rak');
            const noRakEl = document.getElementById('norak');
            const scheduleSelect = document.getElementById('form_schedule_id');
            const rackData = <?php echo json_encode($rackData, 15, 512) ?>;

            function updateNoRaks(selectedRak, preselectNoRak = null) {
                if (!noRakEl) return;
                if (!selectedRak) {
                    noRakEl.innerHTML = '<option value="">-- Pilih Rak Terlebih Dahulu --</option>';
                    noRakEl.value = '';
                    return;
                }
                const availableNoRaks = (rackData && rackData[selectedRak]) ? rackData[selectedRak] : [];
                if (availableNoRaks.length > 0) {
                    noRakEl.innerHTML = '<option value="">-- Pilih No Rak --</option>';
                    availableNoRaks.forEach(nr => {
                        const opt = document.createElement('option');
                        opt.value = nr;
                        opt.textContent = nr;
                        if (preselectNoRak && nr === preselectNoRak) opt.selected = true;
                        noRakEl.appendChild(opt);
                    });
                } else {
                    noRakEl.innerHTML = '<option value="">-- Tidak Ada No Rak Tersedia --</option>';
                }
            }

            // TomSelect for searchable dropdowns
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
                        placeholder: '-- Pilih / Ketik Code Item --',
                        sortField: [],
                        render: {
                            no_results: function(data, escape) {
                                return '<div class="no-results p-2 text-xs text-gray-500 font-weight-bold">Code item yang dicari tidak ada</div>';
                            }
                        },
                        onChange: function (val) {
                            updateSets(val).then(() => {
                                updateCavs(val, setEl ? setEl.value : '');
                            });
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
                                return '<div class="no-results p-2 text-xs text-gray-500 font-weight-bold">Mesin yang anda cari tidak ada</div>';
                            }
                        }
                    });
                }
                if (rakEl && !rakEl.tomselect) {
                    new TomSelect(rakEl, { 
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
            }

            if (scheduleSelect) {
                scheduleSelect.addEventListener('change', function () {
                    const opt = this.options[this.selectedIndex];
                    if (!opt || !opt.value) return;

                    const codeItemVal = opt.getAttribute('data-codeitem');
                    const setVal = opt.getAttribute('data-set');
                    const cavVal = opt.getAttribute('data-cav');
                    const mesinVal = opt.getAttribute('data-mesin');
                    const katVal = opt.getAttribute('data-kategori');
                    const tglVal = opt.getAttribute('data-tanggal');

                    if (tglVal) {
                        const tglInput = document.querySelector('input[name="tanggal"]');
                        if (tglInput) tglInput.value = tglVal;
                    }
                    if (katVal) {
                        const katSelect = document.getElementById('kategori_id');
                        if (katSelect) katSelect.value = katVal;
                    }
                    if (mesinVal && mesinEl) {
                        if (mesinEl.tomselect) {
                            mesinEl.tomselect.setValue(mesinVal);
                        } else {
                            mesinEl.value = mesinVal;
                        }
                    }
                    if (codeItemVal && codeItemEl) {
                        if (codeItemEl.tomselect) {
                            codeItemEl.tomselect.setValue(codeItemVal);
                        } else {
                            codeItemEl.value = codeItemVal;
                        }
                        updateSets(codeItemVal, setVal).then(() => {
                            updateCavs(codeItemVal, setVal, cavVal);
                        });
                    }
                });
            }

            // 1. Filter Karyawan by Group Role
            let loadRoleUsersSeq = 0;
            function loadRoleUsers(roleIdVal) {
                if (!roleSelect || !detailUserContainer) return;
                const roleId = (roleIdVal !== undefined && roleIdVal !== null) ? roleIdVal : roleSelect.value;
                detailUserContainer.innerHTML = '';
                if (!roleId) {
                    detailUserContainer.innerHTML = '<p class="text-xs text-gray-500 italic mb-0">Pilih Group Role terlebih dahulu untuk memilih nama karyawan.</p>';
                    return;
                }

                detailUserContainer.innerHTML = '<p class="text-xs text-gray-500 italic mb-0"><i class="fas fa-spinner fa-spin mr-1"></i> Memuat nama karyawan...</p>';

                const currentSeq = ++loadRoleUsersSeq;
                fetch(`<?php echo e(route('api.role.detail-users')); ?>?role_id=${roleId}`)
                    .then(res => res.json())
                    .then(data => {
                        if (currentSeq !== loadRoleUsersSeq) return;
                        detailUserContainer.innerHTML = '';
                        if (!data || data.length === 0) {
                            detailUserContainer.innerHTML = '<p class="text-xs text-gray-500 italic mb-0">Tidak ada karyawan untuk group ini.</p>';
                        } else {
                            const flexContainer = document.createElement('div');
                            flexContainer.className = 'd-flex flex-wrap gap-2';
                            data.forEach(user => {
                                const div = document.createElement('div');
                                div.className = 'form-check form-check-inline bg-white px-2.5 py-1.5 rounded-lg border';
                                div.innerHTML = `
                                    <input type="checkbox" name="detail_user_id[]" value="${user.id}" id="user_${user.id}" class="form-check-input">
                                    <label for="user_${user.id}" class="form-check-label text-xs font-weight-bold text-gray-800">${user.name}</label>
                                `;
                                flexContainer.appendChild(div);
                            });
                            detailUserContainer.appendChild(flexContainer);
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        detailUserContainer.innerHTML = '<p class="text-xs text-danger mb-0">Gagal memuat nama karyawan.</p>';
                    });
            }

            if (roleSelect && detailUserContainer) {
                roleSelect.addEventListener('change', function() {
                    loadRoleUsers(this.value);
                });
                if (roleSelect.value) {
                    loadRoleUsers(roleSelect.value);
                }
            }

            // 2. Dynamic Cascading Dropdowns
            function updateSets(listId, preselectId = null) {
                return new Promise(resolve => {
                    if (!setEl) return resolve();
                    if (!listId) {
                        setEl.innerHTML = '<option value="">-- Pilih Code Item Terlebih Dahulu --</option>';
                        setEl.value = '';
                        return resolve();
                    }
                    setEl.innerHTML = '<option value="">-- Memuat Mold Set... --</option>';
                    fetch(`<?php echo e(route('api.code-item.sets')); ?>?list_code_item_id=${listId}`)
                        .then(res => res.json())
                        .then(data => {
                            setEl.innerHTML = '<option value="">-- Pilih Mold Set --</option>';
                            if (data && data.length > 0) {
                                data.forEach(item => {
                                    const opt = document.createElement('option');
                                    opt.value = item.id;
                                    opt.textContent = item.moldset;
                                    if (preselectId && item.id == preselectId) opt.selected = true;
                                    setEl.appendChild(opt);
                                });
                            } else {
                                setEl.innerHTML = '<option value="">-- Tidak Ada Mold Set Untuk Code Item Ini --</option>';
                            }
                            resolve();
                        }).catch(() => resolve());
                });
            }

            function updateCavs(listId, setId, preselectId = null) {
                return new Promise(resolve => {
                    if (!cavEl) return resolve();
                    if (!listId) {
                        cavEl.innerHTML = '<option value="">-- Pilih Code Item Terlebih Dahulu --</option>';
                        cavEl.value = '';
                        return resolve();
                    }
                    cavEl.innerHTML = '<option value="">-- Memuat Mold Cavity... --</option>';
                    let url = `<?php echo e(route('api.code-item.cavs')); ?>?list_code_item_id=${listId}`;
                    if (setId) url += `&set_code_item_id=${setId}`;

                    fetch(url)
                        .then(res => res.json())
                        .then(data => {
                            cavEl.innerHTML = '<option value="">-- Pilih Mold Cavity --</option>';
                            if (data && data.length > 0) {
                                data.forEach(item => {
                                    const opt = document.createElement('option');
                                    opt.value = item.id;
                                    opt.textContent = item.moldcav;
                                    if (preselectId && item.id == preselectId) opt.selected = true;
                                    cavEl.appendChild(opt);
                                });
                            } else {
                                cavEl.innerHTML = '<option value="">-- Tidak Ada Mold Cavity Untuk Code Item Ini --</option>';
                            }
                            resolve();
                        }).catch(() => resolve());
                });
            }

            if (codeItemEl && !codeItemEl.tomselect) {
                codeItemEl.addEventListener('change', function () {
                    const listId = this.value;
                    updateSets(listId).then(() => {
                        updateCavs(listId, setEl ? setEl.value : '');
                    });
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
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\project\resources\views/form-sandblastings/create.blade.php ENDPATH**/ ?>