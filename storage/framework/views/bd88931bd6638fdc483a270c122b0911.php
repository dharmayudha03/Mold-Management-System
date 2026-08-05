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
        Code Item Management
     <?php $__env->endSlot(); ?>

    <!-- Header Actions & Search Filter Card -->
    <div class="card shadow-sm border-0 mb-4" style="border-radius: 1rem;">
        <div class="card-body p-3.5">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                
                <!-- Filter Form -->
                <form method="GET" action="<?php echo e(route('code-items.index')); ?>" class="d-flex flex-wrap align-items-center gap-2">
                    <div class="position-relative" style="width: 280px;">
                        <i class="fas fa-search position-absolute text-gray-400" style="left: 12px; top: 50%; transform: translateY(-50%); font-size: 0.8rem;"></i>
                        <input type="text" name="search" value="<?php echo e($search); ?>" placeholder="Cari Part Name / Number / Code Item..." 
                            class="form-control text-xs py-2" style="border-radius: 0.75rem; padding-left: 32px !important;">
                    </div>

                    <select name="status" class="form-select text-xs py-2" style="width: 140px; border-radius: 0.75rem;">
                        <option value="">Semua Status</option>
                        <option value="Aktif" <?php echo e($status == 'Aktif' ? 'selected' : ''); ?>>Aktif</option>
                        <option value="Tidak Aktif" <?php echo e($status == 'Tidak Aktif' ? 'selected' : ''); ?>>Tidak Aktif</option>
                    </select>

                    <button type="submit" class="btn btn-sm btn-primary font-weight-bold px-3.5 py-2" style="border-radius: 0.75rem; background-color: #2563eb; border: none;">
                        <i class="fas fa-filter mr-1"></i> Filter
                    </button>
                    <?php if($search || $status): ?>
                        <a href="<?php echo e(route('code-items.index')); ?>" class="btn btn-sm btn-outline-secondary font-weight-bold px-3 py-2" style="border-radius: 0.75rem;">Reset</a>
                    <?php endif; ?>
                </form>

                <!-- Create Button -->
                <div class="shrink-0">
                    <a href="<?php echo e(route('code-items.create')); ?>" class="btn btn-sm btn-primary font-weight-bold px-3.5 py-2" style="background-color: #2563eb; border: none; border-radius: 0.75rem;">
                        <i class="fas fa-plus mr-1.5"></i> Tambah Code Item
                    </a>
                </div>

            </div>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="card shadow-sm border-0 mb-4" style="border-radius: 1rem;">
        <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-extrabold text-gray-900"><i class="fas fa-cubes text-gray-700 mr-2"></i>Daftar Master Code Item</h6>
            <span class="badge bg-light text-gray-700 border px-3 py-1.5 font-weight-bold" style="border-radius: 50rem;">Total: <?php echo e($codeItems->total()); ?> Records</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 text-xs">
                    <thead class="bg-light text-gray-900 font-weight-extrabold border-bottom">
                        <tr>
                            <th>Name Code Item</th>
                            <th>Mold Set</th>
                            <th>Mold Cav</th>
                            <th>Part Name</th>
                            <th>Part Number</th>
                            <th>Customer</th>
                            <th>Posisi</th>
                            <th>Status</th>
                            <th class="text-right pr-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $codeItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="font-weight-extrabold text-gray-900 text-sm">
                                    <?php echo e($item->listCodeItem->name ?? $item->partname ?? '-'); ?>

                                </td>
                                <td>
                                    <span class="badge bg-light text-gray-800 border px-2.5 py-1 font-weight-bold" style="border-radius: 0.5rem;">
                                        <?php echo e($item->setCodeItem->moldset ?? '-'); ?>

                                    </span>
                                </td>
                                <td class="font-weight-bold text-gray-800">
                                    <?php echo e($item->cavCodeItem->moldcav ?? '-'); ?>

                                </td>
                                <td class="font-weight-bold text-gray-900"><?php echo e($item->partname); ?></td>
                                <td class="font-weight-semibold text-gray-700"><?php echo e($item->partnumber); ?></td>
                                <td class="font-weight-bold text-gray-800"><?php echo e($item->customer); ?></td>
                                <td class="font-weight-semibold text-gray-700"><?php echo e($item->moldposisi); ?></td>
                                <td>
                                    <?php if($item->status == 'Aktif'): ?>
                                        <span class="badge bg-success-10 text-success px-2.5 py-1 font-weight-extrabold" style="border-radius: 50rem;">
                                            <i class="fas fa-circle text-[7px] mr-1"></i> Aktif
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-danger-10 text-danger px-2.5 py-1 font-weight-extrabold" style="border-radius: 50rem;">
                                            <i class="fas fa-circle text-[7px] mr-1"></i> Tidak Aktif
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-right pr-4">
                                    <div class="dropdown d-inline-block">
                                        <button class="btn btn-xs btn-light text-gray-600 border shadow-xs p-1" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 28px; height: 28px; border-radius: 0.5rem;">
                                            <i class="fas fa-ellipsis-v text-xs"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 py-1" style="border-radius: 0.75rem; font-size: 0.8rem;">
                                            <li>
                                                <a href="<?php echo e(route('code-items.edit', $item->id)); ?>" class="dropdown-item py-1.5 px-3 text-gray-700 font-weight-bold">
                                                    <i class="fas fa-edit text-primary mr-2"></i> Edit
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider my-1"></li>
                                            <li>
                                                <form action="<?php echo e(route('code-items.destroy', $item->id)); ?>" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus Code Item ini?')">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
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
                            <tr>
                                <td colspan="9" class="text-center text-gray-500 py-4 font-weight-bold">
                                    Tidak ada data Code Item.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="p-3 border-top bg-white">
                <?php echo e($codeItems->links()); ?>

            </div>
        </div>
    </div>
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
<?php /**PATH C:\xampp\htdocs\project\resources\views/code-items/index.blade.php ENDPATH**/ ?>