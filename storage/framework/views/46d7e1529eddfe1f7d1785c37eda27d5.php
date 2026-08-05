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
        Dashboard
     <?php $__env->endSlot(); ?>


    <!-- 5 Top Metric Cards (1:1 Heater Project Aesthetic) -->
    <div class="row mb-4">

        <!-- Card 1: Total Code Item -->
        <div class="col-xl col-md-6 mb-3">
            <div class="card border-0 shadow-xs h-100 bg-white" style="border-radius: 0.85rem; border: 1px solid #f1f5f9 !important;">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="rounded-xl bg-primary text-white d-flex align-items-center justify-content-center shrink-0" style="width: 44px; height: 44px; border-radius: 0.75rem; background-color: #2563eb !important;">
                        <i class="fas fa-cubes fa-lg text-white"></i>
                    </div>
                    <div>
                        <div class="text-[10px] font-weight-black uppercase tracking-wider" style="color: #64748b;">TOTAL CODE ITEM</div>
                        <div class="h4 mb-0 font-weight-black" id="totalCodeItem" style="color: #0f172a; font-size: 1.3rem; line-height: 1.2;"><?php echo e(number_format($totalCodeItem)); ?></div>
                        <div class="text-[10px] font-weight-bold" style="color: #94a3b8;">Data Mold Master</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: Mesin Aktif -->
        <div class="col-xl col-md-6 mb-3">
            <div class="card border-0 shadow-xs h-100 bg-white" style="border-radius: 0.85rem; border: 1px solid #f1f5f9 !important;">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="rounded-xl text-white d-flex align-items-center justify-content-center shrink-0" style="width: 44px; height: 44px; border-radius: 0.75rem; background-color: #16a34a !important;">
                        <i class="fas fa-check-circle fa-lg text-white"></i>
                    </div>
                    <div>
                        <div class="text-[10px] font-weight-black uppercase tracking-wider" style="color: #64748b;">MESIN AKTIF</div>
                        <div class="h4 mb-0 font-weight-black" id="totalMesin" style="color: #0f172a; font-size: 1.3rem; line-height: 1.2;"><?php echo e(number_format($totalMesin)); ?></div>
                        <div class="text-[10px] font-weight-bold" style="color: #94a3b8;">Status Aktif Produksi</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3: Form Setup -->
        <div class="col-xl col-md-6 mb-3">
            <div class="card border-0 shadow-xs h-100 bg-white" style="border-radius: 0.85rem; border: 1px solid #f1f5f9 !important;">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="rounded-xl text-white d-flex align-items-center justify-content-center shrink-0" style="width: 44px; height: 44px; border-radius: 0.75rem; background-color: #0284c7 !important;">
                        <i class="fas fa-file-invoice fa-lg text-white"></i>
                    </div>
                    <div>
                        <div class="text-[10px] font-weight-black uppercase tracking-wider" style="color: #64748b;">FORM SETUP</div>
                        <div class="h4 mb-0 font-weight-black" id="totalSetup" style="color: #0f172a; font-size: 1.3rem; line-height: 1.2;"><?php echo e(number_format($totalSetup)); ?></div>
                        <div class="text-[10px] font-weight-bold" style="color: #94a3b8;">Form Setup Terdaftar</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 4: Cetakan Naik -->
        <div class="col-xl col-md-6 mb-3">
            <div class="card border-0 shadow-xs h-100 bg-white" style="border-radius: 0.85rem; border: 1px solid #f1f5f9 !important;">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="rounded-xl text-white d-flex align-items-center justify-content-center shrink-0" style="width: 44px; height: 44px; border-radius: 0.75rem; background-color: #ea580c !important;">
                        <i class="fas fa-fire fa-lg text-white"></i>
                    </div>
                    <div>
                        <div class="text-[10px] font-weight-black uppercase tracking-wider" style="color: #64748b;">CETAKAN NAIK</div>
                        <div class="h4 mb-0 font-weight-black" id="totalCetakanNaik" style="color: #0f172a; font-size: 1.3rem; line-height: 1.2;"><?php echo e(number_format($totalCetakanNaik)); ?></div>
                        <div class="text-[10px] font-weight-bold" style="color: #94a3b8;">Sedang Produksi</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 5: Sandblasting -->
        <div class="col-xl col-md-6 mb-3">
            <div class="card border-0 shadow-xs h-100 bg-white" style="border-radius: 0.85rem; border: 1px solid #f1f5f9 !important;">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="rounded-xl text-white d-flex align-items-center justify-content-center shrink-0" style="width: 44px; height: 44px; border-radius: 0.75rem; background-color: #f59e0b !important;">
                        <i class="fas fa-bolt fa-lg text-white"></i>
                    </div>
                    <div>
                        <div class="text-[10px] font-weight-black uppercase tracking-wider" style="color: #64748b;">SANDBLASTING</div>
                        <div class="h4 mb-0 font-weight-black" id="totalSandblasting" style="color: #0f172a; font-size: 1.3rem; line-height: 1.2;"><?php echo e(number_format($totalSandblasting)); ?></div>
                        <div class="text-[10px] font-weight-bold" style="color: #94a3b8;">Proses Sandblasting</div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Secondary Clean Metrics Row (Matching Heater Project Clean Style) -->
    <div class="row mb-4">
        <div class="col-6 col-md">
            <a href="<?php echo e(route('form-repair-cetakans.index')); ?>" class="card border-0 shadow-xs text-decoration-none bg-white hover:bg-slate-50 transition-all" style="border-radius: 0.75rem; border: 1px solid #f1f5f9 !important;">
                <div class="card-body p-2.5 d-flex align-items-center justify-content-between">
                    <div>
                        <div class="uppercase text-[10px] font-weight-black" style="color: #64748b;">PEJO REPAIR</div>
                        <div class="h5 mb-0 font-weight-black" id="totalRepair" style="color: #0f172a;"><?php echo e(number_format($totalRepair)); ?></div>
                    </div>
                    <span class="rounded-circle text-white p-1 d-inline-flex align-items-center justify-content-center" style="width: 28px; height: 28px; background-color: #f43f5e;">
                        <i class="fas fa-wrench text-xs"></i>
                    </span>
                </div>
            </a>
        </div>
        <div class="col-6 col-md">
            <a href="<?php echo e(route('form-mjos.index')); ?>" class="card border-0 shadow-xs text-decoration-none bg-white hover:bg-slate-50 transition-all" style="border-radius: 0.75rem; border: 1px solid #f1f5f9 !important;">
                <div class="card-body p-2.5 d-flex align-items-center justify-content-between">
                    <div>
                        <div class="uppercase text-[10px] font-weight-black" style="color: #64748b;">FORM MJO</div>
                        <div class="h5 mb-0 font-weight-black" id="totalMjo" style="color: #0f172a;"><?php echo e(number_format($totalMjo)); ?></div>
                    </div>
                    <span class="rounded-circle text-white p-1 d-inline-flex align-items-center justify-content-center" style="width: 28px; height: 28px; background-color: #0284c7;">
                        <i class="fas fa-tools text-xs"></i>
                    </span>
                </div>
            </a>
        </div>
        <?php if(!auth()->user()->hasRole('Leader') && !auth()->user()->hasRole('Supervisor') && !auth()->user()->hasRole('leader') && !auth()->user()->hasRole('supervisor')): ?>
        <div class="col-6 col-md">
            <a href="<?php echo e(route('form-schedules.index')); ?>" class="card border-0 shadow-xs text-decoration-none bg-white hover:bg-slate-50 transition-all" style="border-radius: 0.75rem; border: 1px solid #f1f5f9 !important;">
                <div class="card-body p-2.5 d-flex align-items-center justify-content-between">
                    <div>
                        <div class="uppercase text-[10px] font-weight-black" style="color: #64748b;">SCHEDULE</div>
                        <div class="h5 mb-0 font-weight-black" id="totalSchedule" style="color: #0f172a;"><?php echo e(number_format($totalSchedule)); ?></div>
                    </div>
                    <span class="rounded-circle text-white p-1 d-inline-flex align-items-center justify-content-center" style="width: 28px; height: 28px; background-color: #10b981;">
                        <i class="fas fa-calendar-check text-xs"></i>
                    </span>
                </div>
            </a>
        </div>
        <?php endif; ?>
        <?php if(auth()->user()->hasRole('super_admin')): ?>
        <div class="col-6 col-md">
            <a href="<?php echo e(route('users.index')); ?>" class="card border-0 shadow-xs text-decoration-none bg-white hover:bg-slate-50 transition-all" style="border-radius: 0.75rem; border: 1px solid #f1f5f9 !important;">
                <div class="card-body p-2.5 d-flex align-items-center justify-content-between">
                    <div>
                        <div class="uppercase text-[10px] font-weight-black" style="color: #64748b;">USERS SYSTEM</div>
                        <div class="h5 mb-0 font-weight-black" id="totalUser" style="color: #0f172a;"><?php echo e(number_format($totalUser)); ?></div>
                    </div>
                    <span class="rounded-circle text-white p-1 d-inline-flex align-items-center justify-content-center" style="width: 28px; height: 28px; background-color: #8b5cf6;">
                        <i class="fas fa-users text-xs"></i>
                    </span>
                </div>
            </a>
        </div>
        <?php endif; ?>
    </div>

    <!-- Main Table 1: Status Cetakan Naik Terbaru (Matching Heater Project Table Style) -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-xs bg-white" style="border-radius: 0.85rem; border: 1px solid #f1f5f9 !important; overflow: hidden;">
                <div class="card-header py-3 px-4 d-flex align-items-center justify-content-between bg-white border-bottom-0">
                    <h5 class="m-0 font-weight-extrabold text-gray-900" style="font-size: 1.05rem; color: #0f172a;">Status Cetakan Naik Terbaru</h5>
                    <div class="d-flex align-items-center gap-2">
                        <?php if(auth()->user()->hasRole('User') || auth()->user()->hasRole('Leader') || auth()->user()->hasRole('Supervisor') || auth()->user()->hasRole('leader') || auth()->user()->hasRole('supervisor') || auth()->user()->hasRole('super_admin')): ?>
                        <a href="<?php echo e(route('cetakan-naiks.index')); ?>" class="btn btn-sm btn-primary font-weight-bold px-3 py-1.5 text-xs text-white" style="border-radius: 0.6rem; background-color: #2563eb; border: none;">
                            <?php echo e(auth()->user()->hasRole('User') ? 'Lihat Cetakan Naik →' : 'Kelola Cetakan Naik →'); ?>

                        </a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive custom-scrollbar" style="max-height: 320px; overflow-y: auto;">
                        <table class="table table-hover mb-0 text-xs w-100">
                            <thead class="bg-light" style="background-color: #f8fafc !important;">
                                <tr style="border-bottom: 1px solid #e2e8f0;">
                                    <th class="py-3 px-4 font-weight-extrabold text-gray-800" style="color: #334155 !important;">NO MESIN</th>
                                    <th class="py-3 px-4 font-weight-extrabold text-gray-800" style="color: #334155 !important;">CODE ITEM</th>
                                    <th class="py-3 px-4 font-weight-extrabold text-gray-800" style="color: #334155 !important;">MOLD SET</th>
                                    <th class="py-3 px-4 font-weight-extrabold text-gray-800" style="color: #334155 !important;">MOLD CAVITY</th>
                                    <th class="py-3 px-4 font-weight-extrabold text-gray-800" style="color: #334155 !important;">TANGGAL NAIK</th>
                                    <th class="py-3 px-4 font-weight-extrabold text-gray-800 text-center" style="color: #334155 !important;">STATUS</th>
                                </tr>
                            </thead>
                            <tbody id="recentCetakanNaikTbody">
                                <?php $__empty_1 = true; $__currentLoopData = $recentCetakanNaik; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr style="border-bottom: 1px solid #f1f5f9;">
                                        <td class="py-3 px-4 font-weight-black text-gray-900">
                                            <span class="font-weight-black text-gray-900" style="color: #0f172a;"><?php echo e($item->listMesin->code ?? '-'); ?></span>
                                        </td>
                                        <td class="py-3 px-4 font-weight-extrabold" style="color: #0f172a;"><?php echo e($item->listCodeItem->name ?? '-'); ?></td>
                                        <td class="py-3 px-4 font-weight-bold" style="color: #475569;"><?php echo e($item->setCodeItem->moldset ?? '-'); ?></td>
                                        <td class="py-3 px-4 font-weight-bold" style="color: #475569;"><?php echo e($item->cavCodeItem->moldcav ?? '-'); ?></td>
                                        <td class="py-3 px-4 font-weight-bold" style="color: #64748b;"><?php echo e(\Carbon\Carbon::parse($item->tanggalnaik)->format('d/m/Y')); ?></td>
                                        <td class="py-3 px-4 text-center">
                                            <span class="badge rounded-circle bg-secondary text-white d-inline-flex align-items-center justify-content-center font-weight-bold" style="width: 28px; height: 28px; background-color: #64748b !important;">
                                                <i class="fas fa-check text-xs"></i>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-gray-500 py-4 italic">Belum ada cetakan sedang aktif produksi saat ini</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Secondary Table Row: 3 Clean Grid Tables (Setup, Sandblasting, History) -->
    <div class="row align-items-stretch mb-4">

        <!-- 1. Setup Cetakan Terbaru -->
        <div class="col-lg-4 mb-4 d-flex">
            <div class="card border-0 shadow-xs w-100 h-100 d-flex flex-column justify-content-between bg-white" style="border-radius: 0.85rem; border: 1px solid #f1f5f9 !important; overflow: hidden;">
                <div class="card-header py-3 px-3 d-flex align-items-center justify-content-between bg-white border-bottom-0">
                    <h6 class="m-0 font-weight-extrabold text-gray-900 text-xs uppercase" style="color: #0f172a;"><i class="fas fa-file-invoice text-primary mr-1.5"></i>Setup Cetakan Terbaru</h6>
                    <?php if(auth()->user()->hasRole('Setup & Maintenance') || auth()->user()->hasRole('User') || auth()->user()->hasRole('super_admin')): ?>
                    <a href="<?php echo e(route('form-setup-cetakans.index')); ?>" class="text-[11px] text-primary font-weight-bold text-decoration-none">View All &rarr;</a>
                    <?php endif; ?>
                </div>
                <div class="card-body p-0 d-flex flex-column flex-grow-1">
                    <div class="table-responsive flex-grow-1 custom-scrollbar" style="max-height: 240px; overflow-y: auto;">
                        <table class="table table-hover mb-0 text-xs w-100">
                            <thead class="bg-light" style="background-color: #f8fafc !important;">
                                <tr>
                                    <th style="width: 45%; color: #334155; font-weight: 800;">CODE ITEM</th>
                                    <th style="width: 30%; color: #334155; font-weight: 800;">MOLD SET</th>
                                    <th style="width: 25%; color: #334155; font-weight: 800;">TANGGAL</th>
                                </tr>
                            </thead>
                            <tbody id="recentSetupTbody">
                                <?php $__empty_1 = true; $__currentLoopData = $recentSetup; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr style="border-bottom: 1px solid #f1f5f9;">
                                        <td style="color: #0f172a; font-weight: 800;"><?php echo e($item->listCodeItem->name ?? '-'); ?></td>
                                        <td style="color: #475569; font-weight: 700;"><?php echo e($item->setCodeItem->moldset ?? '-'); ?></td>
                                        <td style="color: #64748b; font-weight: 700;"><?php echo e(\Carbon\Carbon::parse($item->tanggal)->format('d/m/Y')); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="3" class="text-center text-gray-500 py-3 italic">Belum ada data setup</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Sandblasting Terbaru -->
        <div class="col-lg-4 mb-4 d-flex">
            <div class="card border-0 shadow-xs w-100 h-100 d-flex flex-column justify-content-between bg-white" style="border-radius: 0.85rem; border: 1px solid #f1f5f9 !important; overflow: hidden;">
                <div class="card-header py-3 px-3 d-flex align-items-center justify-content-between bg-white border-bottom-0">
                    <h6 class="m-0 font-weight-extrabold text-gray-900 text-xs uppercase" style="color: #0f172a;"><i class="fas fa-bolt text-amber-500 mr-1.5"></i>Sandblasting Terbaru</h6>
                    <?php if(auth()->user()->hasRole('Setup & Maintenance') || auth()->user()->hasRole('User') || auth()->user()->hasRole('super_admin')): ?>
                    <a href="<?php echo e(route('form-sandblastings.index')); ?>" class="text-[11px] text-amber-600 font-weight-bold text-decoration-none">View All &rarr;</a>
                    <?php endif; ?>
                </div>
                <div class="card-body p-0 d-flex flex-column flex-grow-1">
                    <div class="table-responsive flex-grow-1 custom-scrollbar" style="max-height: 240px; overflow-y: auto;">
                        <table class="table table-hover mb-0 text-xs w-100">
                            <thead class="bg-light" style="background-color: #f8fafc !important;">
                                <tr>
                                    <th style="width: 45%; color: #334155; font-weight: 800;">CODE ITEM</th>
                                    <th style="width: 30%; color: #334155; font-weight: 800;">MOLD SET</th>
                                    <th style="width: 25%; color: #334155; font-weight: 800;">TANGGAL</th>
                                </tr>
                            </thead>
                            <tbody id="recentSandblastingTbody">
                                <?php $__empty_1 = true; $__currentLoopData = $recentSandblasting; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr style="border-bottom: 1px solid #f1f5f9;">
                                        <td style="color: #0f172a; font-weight: 800;"><?php echo e($item->listCodeItem->name ?? '-'); ?></td>
                                        <td style="color: #475569; font-weight: 700;"><?php echo e($item->setCodeItem->moldset ?? '-'); ?></td>
                                        <td style="color: #64748b; font-weight: 700;"><?php echo e(\Carbon\Carbon::parse($item->tanggal)->format('d/m/Y')); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="3" class="text-center text-gray-500 py-3 italic">Belum ada data sandblasting</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. History Cetakan Terbaru -->
        <div class="col-lg-4 mb-4 d-flex">
            <div class="card border-0 shadow-xs w-100 h-100 d-flex flex-column justify-content-between bg-white" style="border-radius: 0.85rem; border: 1px solid #f1f5f9 !important; overflow: hidden;">
                <div class="card-header py-3 px-3 d-flex align-items-center justify-content-between bg-white border-bottom-0">
                    <h6 class="m-0 font-weight-extrabold text-gray-900 text-xs uppercase" style="color: #0f172a;"><i class="fas fa-history text-info mr-1.5"></i>History Cetakan Terbaru</h6>
                    <?php if(auth()->user()->hasRole('super_admin')): ?>
                    <a href="<?php echo e(route('history-cetakans.index')); ?>" class="text-[11px] text-info font-weight-bold text-decoration-none">View All &rarr;</a>
                    <?php endif; ?>
                </div>
                <div class="card-body p-0 d-flex flex-column flex-grow-1">
                    <div class="table-responsive flex-grow-1 custom-scrollbar" style="max-height: 240px; overflow-y: auto;">
                        <table class="table table-hover mb-0 text-xs w-100">
                            <thead class="bg-light" style="background-color: #f8fafc !important;">
                                <tr>
                                    <th style="width: 35%; color: #334155; font-weight: 800;">CODE ITEM</th>
                                    <th style="width: 30%; color: #334155; font-weight: 800;">MOLD SET</th>
                                    <th style="width: 35%; color: #334155; font-weight: 800;">DESKRIPSI</th>
                                </tr>
                            </thead>
                            <tbody id="recentHistoryTbody">
                                <?php $__empty_1 = true; $__currentLoopData = $recentHistory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr style="border-bottom: 1px solid #f1f5f9;">
                                        <td style="color: #0f172a; font-weight: 800;"><?php echo e($item->listCodeItem->name ?? '-'); ?></td>
                                        <td style="color: #475569; font-weight: 700;"><?php echo e($item->setCodeItem->moldset ?? '-'); ?></td>
                                        <td style="color: #64748b; font-weight: 700;" class="text-truncate" style="max-width: 120px;" title="<?php echo e($item->deskripsi); ?>"><?php echo e($item->deskripsi); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="3" class="text-center text-gray-500 py-3 italic">Belum ada history cetakan</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Script for Live Auto-Refresh (Polling 3 Seconds) -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function escapeHtml(text) {
                if (!text) return '-';
                return String(text)
                    .replace(/&/g, "&amp;")
                    .replace(/</g, "&lt;")
                    .replace(/>/g, "&gt;")
                    .replace(/"/g, "&quot;")
                    .replace(/'/g, "&#039;");
            }

            function fetchDashboardData() {
                fetch("<?php echo e(route('dashboard.api-data')); ?>", {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) throw new Error('Network error');
                    return response.json();
                })
                .then(data => {
                    // 1. Update Metrics Cards
                    const codeItemEl = document.getElementById('totalCodeItem');
                    if (codeItemEl && data.totalCodeItem !== undefined) codeItemEl.textContent = data.totalCodeItem;

                    const mesinEl = document.getElementById('totalMesin');
                    if (mesinEl && data.totalMesin !== undefined) mesinEl.textContent = data.totalMesin;

                    const setupEl = document.getElementById('totalSetup');
                    if (setupEl && data.totalSetup !== undefined) setupEl.textContent = data.totalSetup;

                    const cetakanNaikEl = document.getElementById('totalCetakanNaik');
                    if (cetakanNaikEl && data.totalCetakanNaik !== undefined) cetakanNaikEl.textContent = data.totalCetakanNaik;

                    const sandblastingEl = document.getElementById('totalSandblasting');
                    if (sandblastingEl && data.totalSandblasting !== undefined) sandblastingEl.textContent = data.totalSandblasting;

                    const repairEl = document.getElementById('totalRepair');
                    if (repairEl && data.totalRepair !== undefined) repairEl.textContent = data.totalRepair;

                    const mjoEl = document.getElementById('totalMjo');
                    if (mjoEl && data.totalMjo !== undefined) mjoEl.textContent = data.totalMjo;

                    const scheduleEl = document.getElementById('totalSchedule');
                    if (scheduleEl && data.totalSchedule !== undefined) scheduleEl.textContent = data.totalSchedule;

                    const userEl = document.getElementById('totalUser');
                    if (userEl && data.totalUser !== undefined) userEl.textContent = data.totalUser;

                    // 2. Update Table Cetakan Naik Terbaru
                    const cetakanNaikTbody = document.getElementById('recentCetakanNaikTbody');
                    if (cetakanNaikTbody && Array.isArray(data.recentCetakanNaik)) {
                        if (data.recentCetakanNaik.length === 0) {
                            cetakanNaikTbody.innerHTML = '<tr><td colspan="6" class="text-center text-gray-500 py-4 italic">Belum ada cetakan sedang aktif produksi saat ini</td></tr>';
                        } else {
                            cetakanNaikTbody.innerHTML = data.recentCetakanNaik.map(item => `
                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                    <td class="py-3 px-4 font-weight-black text-gray-900">
                                        <span class="font-weight-black text-gray-900" style="color: #0f172a;">${escapeHtml(item.mesin)}</span>
                                    </td>
                                    <td class="py-3 px-4 font-weight-extrabold" style="color: #0f172a;">${escapeHtml(item.code_item)}</td>
                                    <td class="py-3 px-4 font-weight-bold" style="color: #475569;">${escapeHtml(item.mold_set)}</td>
                                    <td class="py-3 px-4 font-weight-bold" style="color: #475569;">${escapeHtml(item.mold_cavity)}</td>
                                    <td class="py-3 px-4 font-weight-bold" style="color: #64748b;">${escapeHtml(item.tanggal_naik)}</td>
                                    <td class="py-3 px-4 text-center">
                                        <span class="badge rounded-circle bg-secondary text-white d-inline-flex align-items-center justify-content-center font-weight-bold" style="width: 28px; height: 28px; background-color: #64748b !important;">
                                            <i class="fas fa-check text-xs"></i>
                                        </span>
                                    </td>
                                </tr>
                            `).join('');
                        }
                    }

                    // 3. Update Table Setup Cetakan Terbaru
                    const setupTbody = document.getElementById('recentSetupTbody');
                    if (setupTbody && Array.isArray(data.recentSetup)) {
                        if (data.recentSetup.length === 0) {
                            setupTbody.innerHTML = '<tr><td colspan="3" class="text-center text-gray-500 py-3 italic">Belum ada data setup</td></tr>';
                        } else {
                            setupTbody.innerHTML = data.recentSetup.map(item => `
                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                    <td style="color: #0f172a; font-weight: 800;">${escapeHtml(item.code_item)}</td>
                                    <td style="color: #475569; font-weight: 700;">${escapeHtml(item.mold_set)}</td>
                                    <td style="color: #64748b; font-weight: 700;">${escapeHtml(item.tanggal)}</td>
                                </tr>
                            `).join('');
                        }
                    }

                    // 4. Update Table Sandblasting Terbaru
                    const sandblastingTbody = document.getElementById('recentSandblastingTbody');
                    if (sandblastingTbody && Array.isArray(data.recentSandblasting)) {
                        if (data.recentSandblasting.length === 0) {
                            sandblastingTbody.innerHTML = '<tr><td colspan="3" class="text-center text-gray-500 py-3 italic">Belum ada data sandblasting</td></tr>';
                        } else {
                            sandblastingTbody.innerHTML = data.recentSandblasting.map(item => `
                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                    <td style="color: #0f172a; font-weight: 800;">${escapeHtml(item.code_item)}</td>
                                    <td style="color: #475569; font-weight: 700;">${escapeHtml(item.mold_set)}</td>
                                    <td style="color: #64748b; font-weight: 700;">${escapeHtml(item.tanggal)}</td>
                                </tr>
                            `).join('');
                        }
                    }

                    // 5. Update Table History Cetakan Terbaru
                    const historyTbody = document.getElementById('recentHistoryTbody');
                    if (historyTbody && Array.isArray(data.recentHistory)) {
                        if (data.recentHistory.length === 0) {
                            historyTbody.innerHTML = '<tr><td colspan="3" class="text-center text-gray-500 py-3 italic">Belum ada history cetakan</td></tr>';
                        } else {
                            historyTbody.innerHTML = data.recentHistory.map(item => `
                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                    <td style="color: #0f172a; font-weight: 800;">${escapeHtml(item.code_item)}</td>
                                    <td style="color: #475569; font-weight: 700;">${escapeHtml(item.mold_set)}</td>
                                    <td style="color: #64748b; font-weight: 700;" class="text-truncate" style="max-width: 120px;" title="${escapeHtml(item.deskripsi)}">${escapeHtml(item.deskripsi)}</td>
                                </tr>
                            `).join('');
                        }
                    }
                })
                .catch(err => {
                    // Quietly handle fetch errors (e.g. temporary network hiccups)
                });
            }

            // Start auto-refresh interval (every 3000ms = 3 seconds)
            setInterval(fetchDashboardData, 3000);
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
<?php /**PATH C:\xampp\htdocs\project\resources\views/dashboard.blade.php ENDPATH**/ ?>