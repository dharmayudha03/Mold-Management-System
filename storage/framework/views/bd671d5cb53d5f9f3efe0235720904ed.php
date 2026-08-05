<?php if($paginator->hasPages()): ?>
    <nav role="navigation" aria-label="Pagination Navigation" class="d-flex align-items-center justify-content-between flex-wrap gap-3 w-100 py-1">
        <!-- Left side: Information Text in Bahasa Indonesia -->
        <div class="text-xs text-gray-700 font-weight-extrabold d-flex align-items-center gap-1">
            Menampilkan
            <?php if($paginator->firstItem()): ?>
                <span class="font-weight-black text-gray-900 px-1 py-0.5 bg-light rounded" style="color: #0f172a !important;"><?php echo e($paginator->firstItem()); ?></span>
                sampai
                <span class="font-weight-black text-gray-900 px-1 py-0.5 bg-light rounded" style="color: #0f172a !important;"><?php echo e($paginator->lastItem()); ?></span>
            <?php else: ?>
                <?php echo e($paginator->count()); ?>

            <?php endif; ?>
            dari
            <span class="font-weight-black text-gray-900 px-1 py-0.5 bg-light rounded" style="color: #0f172a !important;"><?php echo e($paginator->total()); ?></span>
            total data
        </div>

        <!-- Right side: Sleek Modern Pagination Controls -->
        <ul class="pagination pagination-sm mb-0 d-flex align-items-center gap-1 border-0">
            
            <?php if($paginator->onFirstPage()): ?>
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link border-0 text-gray-300 bg-gray-100 d-inline-flex align-items-center justify-content-center" style="border-radius: 0.6rem; width: 34px; height: 34px; cursor: not-allowed;">
                        <i class="fas fa-chevron-left text-xs"></i>
                    </span>
                </li>
            <?php else: ?>
                <li class="page-item">
                    <a class="page-link border-0 text-gray-700 bg-white shadow-xs d-inline-flex align-items-center justify-content-center hover:bg-gray-100 transition-all" href="<?php echo e($paginator->previousPageUrl()); ?>" rel="prev" style="border-radius: 0.6rem; width: 34px; height: 34px; border: 1px solid #e2e8f0 !important;">
                        <i class="fas fa-chevron-left text-xs"></i>
                    </a>
                </li>
            <?php endif; ?>

            
            <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                
                <?php if(is_string($element)): ?>
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link border-0 text-gray-400 bg-transparent px-2 font-weight-bold"><?php echo e($element); ?></span>
                    </li>
                <?php endif; ?>

                
                <?php if(is_array($element)): ?>
                    <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($page == $paginator->currentPage()): ?>
                            <li class="page-item active" aria-current="page">
                                <span class="page-link border-0 text-white font-weight-black d-inline-flex align-items-center justify-content-center" style="border-radius: 0.6rem; min-width: 34px; height: 34px; padding: 0 0.5rem; background-color: #2563eb !important; box-shadow: 0 4px 10px rgba(37,99,235,0.3) !important;">
                                    <?php echo e($page); ?>

                                </span>
                            </li>
                        <?php else: ?>
                            <li class="page-item">
                                <a class="page-link border-0 text-gray-800 font-weight-bold bg-white shadow-xs d-inline-flex align-items-center justify-content-center hover:bg-gray-100 transition-all" href="<?php echo e($url); ?>" style="border-radius: 0.6rem; min-width: 34px; height: 34px; padding: 0 0.5rem; border: 1px solid #e2e8f0 !important; color: #1e293b !important;">
                                    <?php echo e($page); ?>

                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            
            <?php if($paginator->hasMorePages()): ?>
                <li class="page-item">
                    <a class="page-link border-0 text-gray-700 bg-white shadow-xs d-inline-flex align-items-center justify-content-center hover:bg-gray-100 transition-all" href="<?php echo e($paginator->nextPageUrl()); ?>" rel="next" style="border-radius: 0.6rem; width: 34px; height: 34px; border: 1px solid #e2e8f0 !important;">
                        <i class="fas fa-chevron-right text-xs"></i>
                    </a>
                </li>
            <?php else: ?>
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link border-0 text-gray-300 bg-gray-100 d-inline-flex align-items-center justify-content-center" style="border-radius: 0.6rem; width: 34px; height: 34px; cursor: not-allowed;">
                        <i class="fas fa-chevron-right text-xs"></i>
                    </span>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\project\resources\views/vendor/pagination/custom.blade.php ENDPATH**/ ?>