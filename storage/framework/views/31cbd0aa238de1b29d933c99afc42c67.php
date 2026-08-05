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
        Form Setup Cetakan
     <?php $__env->endSlot(); ?>

    <!-- Header Actions & Search Card -->
    <div class="card shadow-sm border-0 mb-4" style="border-radius: 1rem;">
        <div class="card-body p-3.5">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                
                <!-- Search Form -->
                <form method="GET" action="<?php echo e(route('form-setup-cetakans.index')); ?>" class="d-flex align-items-center gap-2">
                    <div class="position-relative" style="width: 280px;">
                        <i class="fas fa-search position-absolute text-gray-400" style="left: 12px; top: 50%; transform: translateY(-50%); font-size: 0.8rem;"></i>
                        <input type="text" name="search" value="<?php echo e($search); ?>" placeholder="Cari No Doc / Code Item / Mesin..." 
                            class="form-control text-xs py-2" style="border-radius: 0.75rem; padding-left: 32px !important;">
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary font-weight-bold px-3.5 py-2" style="border-radius: 0.75rem; background-color: #2563eb; border: none;">
                        <i class="fas fa-filter mr-1"></i> Filter
                    </button>
                    <?php if($search): ?>
                        <a href="<?php echo e(route('form-setup-cetakans.index')); ?>" class="btn btn-sm btn-outline-secondary font-weight-bold px-3 py-2" style="border-radius: 0.75rem;">Reset</a>
                    <?php endif; ?>
                </form>

                <!-- Action Buttons -->
                <div class="d-flex align-items-center gap-2 shrink-0">
                    <?php if(!auth()->user()->hasRole('Setup & Maintenance') && !auth()->user()->hasRole('Setup') && !auth()->user()->hasRole('Maintenance')): ?>
                    <a href="<?php echo e(route('form-setup-cetakans.export-csv')); ?>" class="btn btn-sm btn-success font-weight-bold px-3 py-2" style="background-color: #059669; border: none; border-radius: 0.75rem;">
                        <i class="fas fa-file-csv mr-1.5"></i> Export CSV
                    </a>
                    <a href="<?php echo e(route('form-setup-cetakans.print-pdf')); ?>" target="_blank" class="btn btn-sm btn-warning font-weight-bold px-3 py-2 text-dark" style="background-color: #f59e0b; border: none; border-radius: 0.75rem; color: #1e293b !important;">
                        <i class="fas fa-print mr-1.5"></i> Print PDF
                    </a>
                    <?php endif; ?>
                    <?php if(!auth()->user()->hasRole('User')): ?>
                    <a href="<?php echo e(route('form-setup-cetakans.create')); ?>" class="btn btn-sm btn-primary font-weight-bold px-3.5 py-2" style="background-color: #2563eb; border: none; border-radius: 0.75rem;">
                        <i class="fas fa-plus mr-1.5"></i> Tambah Setup
                    </a>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card shadow-sm border-0 mb-4" id="data-table-card" style="border-radius: 1rem;">
        <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-extrabold text-gray-900"><i class="fas fa-file-invoice text-gray-700 mr-2"></i>Daftar Form Setup Cetakan</h6>
            <span class="badge bg-light text-gray-700 border px-3 py-1.5 font-weight-bold" style="border-radius: 50rem;">Total: <?php echo e($formSetupCetakans->total()); ?> Records</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 text-xs">
                    <thead class="bg-light text-gray-900 font-weight-extrabold border-bottom">
                        <tr>
                            <th class="py-3 pl-4">No Doc</th>
                            <th class="py-3">Tanggal</th>
                            <th class="py-3">Kategori</th>
                            <th class="py-3">Shift</th>
                            <th class="py-3">Code Item</th>
                            <th class="py-3">Mold Set</th>
                            <th class="py-3">Mold Cav</th>
                            <th class="py-3">Mesin</th>
                            <th class="py-3 text-center">Guide Pen</th>
                            <th class="py-3 text-center">Busing</th>
                            <th class="py-3 text-center">Baut</th>
                            <th class="py-3 text-center">Core</th>
                            <th class="py-3 text-center">Piston</th>
                            <th class="py-3 text-center">Pot</th>
                            <th class="py-3 text-center">PL</th>
                            <th class="py-3 text-center">Cav NG</th>
                            <th class="py-3 text-right pr-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $formSetupCetakans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="font-weight-extrabold text-gray-900 pl-4"><?php echo e($item->nodoc); ?></td>
                                <td class="text-gray-700 font-weight-bold"><?php echo e(\Carbon\Carbon::parse($item->tanggal)->format('d/m/Y')); ?></td>
                                <td>
                                    <span class="badge bg-light text-gray-800 border px-2.5 py-1 font-weight-bold" style="border-radius: 0.5rem;">
                                        <?php echo e($item->kategori->name ?? '-'); ?>

                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary text-white px-2 py-0.5 font-weight-bold" style="border-radius: 50rem;">
                                        Shift <?php echo e($item->shift); ?>

                                    </span>
                                </td>
                                <td class="font-weight-extrabold text-gray-900 text-sm"><?php echo e($item->listCodeItem->name ?? '-'); ?></td>
                                <td class="font-weight-bold text-gray-800"><?php echo e($item->setCodeItem->moldset ?? '-'); ?></td>
                                <td class="font-weight-bold text-gray-800"><?php echo e($item->cavCodeItem->moldcav ?? '-'); ?></td>
                                <td class="font-weight-extrabold text-gray-900"><?php echo e($item->listMesin->code ?? '-'); ?></td>

                                <?php $__currentLoopData = ['guidepen' => $item->guidepen, 'busing' => $item->busing, 'baut' => $item->baut, 'core' => $item->core, 'piston' => $item->piston, 'pot' => $item->pot, 'pl' => $item->pl]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <td class="text-center">
                                    <?php if($val === '√'): ?>
                                        <span class="badge font-weight-extrabold px-2 py-1" style="background-color: #ecfdf5; color: #065f46; border: 1px solid #6ee7b7; border-radius: 0.5rem; font-size: 0.75rem;">√</span>
                                    <?php else: ?>
                                        <span class="badge font-weight-extrabold px-2 py-1" style="background-color: #fef2f2; color: #991b1b; border: 1px solid #fca5a5; border-radius: 0.5rem; font-size: 0.75rem;">–</span>
                                    <?php endif; ?>
                                </td>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                
                                <td class="text-center">
                                    <?php if($item->cav_ng > 0): ?>
                                        <span class="badge font-weight-extrabold px-2.5 py-1" style="background-color: #fff1f2; color: #9f1239; border: 1px solid #fecdd3; border-radius: 0.5rem; font-size: 0.75rem;">
                                            <i class="fas fa-exclamation-triangle mr-1" style="font-size: 0.6rem;"></i><?php echo e($item->cav_ng); ?>

                                        </span>
                                    <?php else: ?>
                                        <span class="badge font-weight-extrabold px-2.5 py-1" style="background-color: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; border-radius: 0.5rem; font-size: 0.75rem;">0</span>
                                    <?php endif; ?>
                                </td>

                                <td class="text-right pr-4">
                                    <?php if((!auth()->user()->hasRole('Setup & Maintenance') && !auth()->user()->hasRole('User')) || auth()->user()->hasRole('super_admin')): ?>
                                    <div class="dropdown d-inline-block">
                                        <button class="btn btn-xs btn-light text-gray-600 border shadow-xs p-1" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 28px; height: 28px; border-radius: 0.5rem;">
                                            <i class="fas fa-ellipsis-v text-xs"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 py-1" style="border-radius: 0.75rem; font-size: 0.8rem;">
                                            <li>
                                                <a href="<?php echo e(route('form-setup-cetakans.edit', $item->id)); ?>" class="dropdown-item py-1.5 px-3 text-gray-700 font-weight-bold">
                                                    <i class="fas fa-edit text-primary mr-2"></i> Edit
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider my-1"></li>
                                            <li>
                                                <form action="<?php echo e(route('form-setup-cetakans.destroy', $item->id)); ?>" method="POST" onsubmit="return confirm('Hapus Form Setup ini?')">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="dropdown-item py-1.5 px-3 text-danger font-weight-bold">
                                                        <i class="fas fa-trash-alt text-danger mr-2"></i> Hapus
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                    <?php else: ?>
                                    <span class="text-gray-400 font-weight-bold">-</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="17" class="text-center text-gray-500 py-4 font-weight-bold">
                                    Tidak ada data Form Setup Cetakan.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="p-3 border-top bg-white">
                <?php echo e($formSetupCetakans->links()); ?>

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
<?php /**PATH C:\xampp\htdocs\project\resources\views/form-setup-cetakans/index.blade.php ENDPATH**/ ?>