<?php $__currentLoopData = $estudios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keyEstudio => $estudio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    
    
    <div style="line-height: 0.5;">
        
    </div>
    <table class="result" style='<?php echo e($salto === "si" ? "page-break-inside: avoid;" : ""); ?>'>
        <thead>
            <tr><th colspan="6"><h3 style="text-align: center"><?php echo e($estudio->descripcion); ?></h3></th></tr>
            <tr>
                <th class="col-one">Nombre</th>
                <th class="col-two"></th>
                <th class="col-three">Resultado</th>
                <th class="col-four"> % </th>
                <th class="col-five">Unidad</th>
                <th class="col-six">Referencia</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $estudio->analitos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keyAnalito => $analito): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php if($analito->valor_captura !== null): ?>
                    <?php if($analito->tipo_resultado === 'subtitulo' || $analito->tipo_resultado === 'imagen' || $analito->tipo_resultado === 'documento'): ?>
                        <?php echo $__env->make('layout.partials.resultados.indicadores.resultados_s', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php else: ?>
                        <tr>
                            <td class="col-one" >
                                <?php echo e($analito->descripcion); ?>

                            </td>
                            <td class="col-two">
                                <?php if($analito->tipo_resultado === 'numerico' || $analito->tipo_resultado === 'referencia'): ?>
                                    <?php echo $__env->make('layout.partials.resultados.indicadores.indicadores', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <?php endif; ?>
                            </td>
                            <td class="col-three">
                                <?php echo $__env->make('layout.partials.resultados.indicadores.resultados_n', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </td>
                            <td class="col-four">
                                <?php if($analito->valor_captura_abs !== null): ?>
                                    <?php echo e($analito->valor_captura_abs); ?>

                                <?php endif; ?>
                            </td>
                            <td class="col-five">
                                <?php echo e($analito->unidad); ?>

                            </td>
                            <td class="col-six">
                                <?php echo $__env->make('layout.partials.resultados.indicadores.valor_ejemplo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <?php if($analito->qr): ?>
                        <img src="data:image/png;base64,<?php echo e($analito->qr); ?>" alt="" height="100" width="100">
                    <?php endif; ?>
                    
                <?php endif; ?>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <?php endif; ?>
            
        </tbody>
    </table>
    <?php echo $__env->make('layout.partials.resultados.indicadores.observaciones', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php echo $__env->make('layout.partials.resultados.indicadores.page_break', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/pixelar6/micromed.book-medical.com/resources/views/layout/partials/resultados/indicadores/cuerpo_resultados.blade.php ENDPATH**/ ?>