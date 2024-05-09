<?php if($resultados !== null): ?>
    <?php
        $totalAreas = count($resultados);
        $contadorArea = 1;
    ?>
    <?php $__empty_1 = true; $__currentLoopData = $resultados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keyArea => $estudios): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        
        <div class="invoice-content">
            
            <?php echo $__env->make('layout.partials.resultados.indicadores.cuerpo_resultados', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <?php endif; ?>
<?php endif; ?>


<?php if($perfiles !== null): ?>
    <?php $__empty_1 = true; $__currentLoopData = $perfiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keyPerfil => $perfil): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="invoice-content">
            <h1><?php echo e($perfil->descripcion); ?></h1>
            <?php
                $totalAreas = count($perfil->estudios);
                $contadorArea = 1;
            ?>
            <?php $__currentLoopData = $perfil->estudios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keyArea => $estudios): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                
                
                <?php echo $__env->make('layout.partials.resultados.indicadores.cuerpo_resultados', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <?php endif; ?>
<?php endif; ?><?php /**PATH C:\laragon\www\laboratorios\resources\views/layout/partials/resultados/body-all-PDF.blade.php ENDPATH**/ ?>