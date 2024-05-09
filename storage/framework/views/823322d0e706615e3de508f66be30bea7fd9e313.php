<div class="invoice-content break">
    
    <table class="result ">
        <thead>
            <tr>
                <th class="col-one">Clave</th>
                <th class="col-two">Nombre</th>
                <th class="col-three">Fecha de entrega</th>
                <th class="col-four">Precio</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $count = 1;
            ?>
            <?php $__empty_1 = true; $__currentLoopData = $estudios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a => $estudio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="col-one"><?php echo e($estudio->clave); ?></td>
                    <td class="col-two"><?php echo e($estudio->descripcion); ?></td>
                    <td class="col-three">
                        <?php
                            $estudie  = DB::table('estudios')->where('clave', $estudio['clave'])->first();
                        ?>
                        <?php if($estudio->tipo === 'Estudio'): ?>
                            <?php echo e($estudie->dias_proceso); ?> días después.    
                        <?php else: ?>
                            Lo que indique el estudio.      
                        <?php endif; ?>
                    </td>
                    <td class="col-four">$ <?php echo e($estudio->precio); ?></td>
                </tr>
                <?php
                    $count ++;
                ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <?php endif; ?>
        </tbody>
    </table>
</div><?php /**PATH /home2/pixelar6/micromed.book-medical.com/resources/views/layout/partials/ticket/bodyPDF.blade.php ENDPATH**/ ?>