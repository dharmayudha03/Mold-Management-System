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
        History Cetakan
     <?php $__env->endSlot(); ?>

    <!-- Compact Filter Card -->
    <div class="card shadow-xs border border-gray-200 mb-3 bg-white" style="border-radius: 0.75rem;">
        <div class="card-header bg-white py-2 px-3 border-bottom d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-black text-gray-900 text-xs uppercase" style="color: #0f172a !important;">
                <i class="fas fa-filter text-primary mr-1.5"></i>Filter History Cetakan
            </h6>
            <span class="badge bg-light text-gray-700 border px-2.5 py-1 font-weight-bold" style="border-radius: 50rem; font-size: 0.65rem;">Filter Range</span>
        </div>
        <div class="card-body p-3">
            <form method="GET" action="<?php echo e(route('history-cetakans.index')); ?>">
                <div class="row g-2">

                    <!-- Filter Tanggal Awal & Akhir -->
                    <div class="col-md-3">
                        <label class="form-label uppercase mb-1" style="font-size: 0.65rem !important; font-weight: 800 !important; color: #475569 !important;">Mulai Tanggal</label>
                        <input type="date" name="tanggal_awal" value="<?php echo e($tanggalAwal); ?>" class="form-control text-xs" style="border-radius: 0.5rem; height: 36px;">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label uppercase mb-1" style="font-size: 0.65rem !important; font-weight: 800 !important; color: #475569 !important;">Sampai Tanggal</label>
                        <input type="date" name="tanggal_akhir" value="<?php echo e($tanggalAkhir); ?>" class="form-control text-xs" style="border-radius: 0.5rem; height: 36px;">
                    </div>

                    <!-- Filter Code Item Range -->
                    <div class="col-md-3">
                        <label class="form-label uppercase mb-1" style="font-size: 0.65rem !important; font-weight: 800 !important; color: #475569 !important;">Code Item Mulai</label>
                        <select name="start_code_item_id" id="start_code_item_id" class="form-select text-xs">
                            <option value="">-- Code Item Awal --</option>
                            <?php $__currentLoopData = $listCodeItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ci): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($ci->id); ?>" <?php echo e($startCodeItemId == $ci->id ? 'selected' : ''); ?>><?php echo e($ci->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label uppercase mb-1" style="font-size: 0.65rem !important; font-weight: 800 !important; color: #475569 !important;">Code Item Sampai</label>
                        <select name="end_code_item_id" id="end_code_item_id" class="form-select text-xs">
                            <option value="">-- Code Item Akhir --</option>
                            <?php $__currentLoopData = $listCodeItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ci): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($ci->id); ?>" <?php echo e($endCodeItemId == $ci->id ? 'selected' : ''); ?>><?php echo e($ci->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <!-- Search Keyword & Action Buttons -->
                    <div class="col-md-8">
                        <label class="form-label uppercase mb-1" style="font-size: 0.65rem !important; font-weight: 800 !important; color: #475569 !important;">Cari Deskripsi / Kata Kunci</label>
                        <div class="position-relative">
                            <i class="fas fa-search position-absolute text-gray-400" style="left: 10px; top: 50%; transform: translateY(-50%); font-size: 0.75rem;"></i>
                            <input type="text" name="search" value="<?php echo e($search); ?>" placeholder="Ketik kata kunci deskripsi..." 
                                class="form-control text-xs" style="border-radius: 0.5rem; height: 36px; padding-left: 28px !important;">
                        </div>
                    </div>

                    <div class="col-md-4 d-flex align-items-end justify-content-end gap-3">
                        <?php if($search || $tanggalAwal || $tanggalAkhir || $startCodeItemId || $endCodeItemId): ?>
                            <a href="<?php echo e(route('history-cetakans.index')); ?>" class="btn btn-sm btn-outline-secondary font-weight-bold px-3.5 text-xs d-inline-flex align-items-center justify-content-center shrink-0" style="border-radius: 0.5rem; height: 36px; min-width: 95px;">
                                <i class="fas fa-undo mr-1.5"></i> Reset
                            </a>
                        <?php endif; ?>
                        <button type="submit" class="btn btn-sm btn-primary font-weight-bold px-4 text-xs w-100 d-inline-flex align-items-center justify-content-center" style="border-radius: 0.5rem; height: 36px; background-color: #2563eb; border: none;">
                            <i class="fas fa-filter mr-1.5"></i> Filter Data
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="card shadow-xs border border-gray-200 mb-4 bg-white" style="border-radius: 0.75rem; overflow: hidden;">
        <div class="card-header bg-white py-2.5 px-3 border-bottom d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-black text-gray-900 text-xs uppercase" style="color: #0f172a !important;">
                <i class="fas fa-history text-gray-700 mr-1.5"></i>Daftar History Cetakan
            </h6>
            <span class="badge bg-light text-gray-800 border px-3 py-1 font-weight-extrabold" style="border-radius: 50rem; font-size: 0.7rem;">Total: <?php echo e($historyCetakans->total()); ?> Records</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 text-xs">
                    <thead class="bg-light text-gray-900 font-weight-extrabold border-bottom" style="background-color: #f8fafc !important;">
                        <tr>
                            <th style="color: #0f172a !important; font-weight: 800 !important;">TANGGAL</th>
                            <th style="color: #0f172a !important; font-weight: 800 !important;">CODE ITEM</th>
                            <th style="color: #0f172a !important; font-weight: 800 !important;">MOLD SET</th>
                            <th style="color: #0f172a !important; font-weight: 800 !important;">MOLD CAVITY</th>
                            <th style="color: #0f172a !important; font-weight: 800 !important;">DESKRIPSI</th>
                            <th class="text-right pr-4" style="color: #0f172a !important; font-weight: 800 !important;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $historyCetakans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td style="color: #475569 !important; font-weight: 700 !important;"><?php echo e(\Carbon\Carbon::parse($item->tanggal)->format('d/m/Y')); ?></td>
                                <td style="color: #0f172a !important; font-weight: 800 !important;" class="text-sm"><?php echo e($item->listCodeItem->name ?? '-'); ?></td>
                                <td style="color: #334155 !important; font-weight: 700 !important;"><?php echo e($item->setCodeItem->moldset ?? '-'); ?></td>
                                <td style="color: #334155 !important; font-weight: 700 !important;"><?php echo e($item->cavCodeItem->moldcav ?? '-'); ?></td>
                                <td style="color: #0f172a !important; font-weight: 700 !important;"><?php echo e($item->deskripsi); ?></td>
                                <td class="text-right pr-4">
                                    <div class="dropdown d-inline-block">
                                        <button class="btn btn-xs btn-light text-gray-600 border shadow-xs p-1" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 28px; height: 28px; border-radius: 0.5rem;">
                                            <i class="fas fa-ellipsis-v text-xs"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 py-1" style="border-radius: 0.75rem; font-size: 0.8rem;">
                                            <li>
                                                <a href="<?php echo e(route('history-cetakans.edit', $item->id)); ?>" class="dropdown-item py-1.5 px-3 text-gray-700 font-weight-bold">
                                                    <i class="fas fa-edit text-primary mr-2"></i> Edit
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider my-1"></li>
                                            <li>
                                                <form action="<?php echo e(route('history-cetakans.destroy', $item->id)); ?>" method="POST" onsubmit="return confirm('Hapus history cetakan ini?')">
                                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="dropdown-item py-1.5 px-3 text-danger font-weight-bold">
                                                        <i class="fas fa-trash-alt text-danger mr-2"></i> Hapus
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="6" class="text-center text-gray-500 py-4 font-weight-bold">Tidak ada data history cetakan yang sesuai filter rentang ini.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="p-3 border-top bg-white"><?php echo e($historyCetakans->links()); ?></div>
        </div>
    </div>

    <!-- Script TomSelect for Code Item Range -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const startCodeItemEl = document.getElementById('start_code_item_id');
            const endCodeItemEl = document.getElementById('end_code_item_id');

            if (window.TomSelect) {
                if (startCodeItemEl) new TomSelect(startCodeItemEl, { create: false, maxItems: 1, placeholder: '-- Code Item Awal --' });
                if (endCodeItemEl) new TomSelect(endCodeItemEl, { create: false, maxItems: 1, placeholder: '-- Code Item Akhir --' });
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
<?php /**PATH C:\xampp\htdocs\project\resources\views/history-cetakans/index.blade.php ENDPATH**/ ?>