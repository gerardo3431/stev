
<div class="invoice-content break">
    
    <table>
        <thead>
            <tr>
                <th class="col-one" >
                    <?php echo e(strtoupper('clave')); ?>

                </th>
                <th class="col-two" >
                    <?php echo e(strtoupper('descripcion')); ?>

                </th>
                <th class="col-three" >
                    <?php echo e(strtoupper('costo')); ?>

                </th>
                <th class="col-four" >
                    <?php echo e(strtoupper('dias')); ?>

                </th>
                <th class="col-five" >
                    <?php echo e(strtoupper('condiciones')); ?>

                </th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $estudios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estudio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td class="col-one"><?php echo e($estudio->clave); ?></td>
                    <td class="col-two"><?php echo e($estudio->descripcion); ?></td>
                    <td class="col-three">$ <?php echo e($estudio->precio); ?>.00</td>
                    <td class="col-five"><?php echo e($estudio->dias_proceso); ?></td>
                    <td class="col-five"><?php echo e($estudio->condiciones); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <div style="font-size: 10px">
        <strong>Total: </strong>  $ <?php echo e($estudios->sum('precio')); ?>.00
    </div>
    <div style="font-size: 10px">
        <strong>Observaciones: </strong> <?php echo e($observaciones['observaciones']); ?>

    </div>
</div><?php /**PATH /home2/pixelar6/micromed.book-medical.com/resources/views/layout/partials/cotizacion/body.blade.php ENDPATH**/ ?>