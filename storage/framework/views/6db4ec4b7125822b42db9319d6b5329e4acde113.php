<div class="invoice-content break">

    <h2>Detalle</h2>

    <table>
        <thead>
            <tr>
                <th >
                    <p>
                        Caja id
                    </p>
                </th>
                <th >
                    <p>
                        Monto de apertura
                    </p>
                </th>
                <th >
                    <p>
                        Entradas totales
                    </p>
                </th>
                <th >
                    <p>
                        Salidas totales
                    </p>
                </th>
                <th>
                    <p>
                        Retiros
                    </p>
                </th>
                <th >
                    <p>
                        Saldo total en caja
                    </p>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td >
                    <p>
                        <?php echo e($cuenta->id); ?>

                    </p>
                </td>
                <td>
                    <p>
                        $ <?php echo e($cuenta->apertura); ?>

                    </p>
                </td>
                <td >
                    <p>
                        $ <?php echo e($cuenta->entradas); ?>

                    </p>
                </td>
                <td >
                    <p>
                        $ <?php echo e($cuenta->salidas); ?>

                    </p>
                </td>
                <td>
                    <p>
                        $ <?php echo e($cuenta->retiros); ?>

                    </p>
                </td>
                <td >
                    <p>
                        $ <?php echo e($cuenta->total); ?>

                    </p>
                </td>
            </tr>
        </tbody>
    </table>
    <h2>Movimientos</h2>
    <table>
        <thead>
            <tr>
                <th >
                    <p>
                        Descripcion
                    </p>
                </th>
                <th >
                    <p>
                        Importe
                    </p>
                </th>
                <th >
                    <p>
                        Tipo movimiento
                    </p>
                </th>
                <th>
                    <p>
                        Metodo pago
                    </p>
                </th>
                <th>
                    <p>
                        Empresa
                    </p>
                </th>
                <th>
                    <p>
                        Fecha
                    </p>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $movimientos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $movimiento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php if($movimiento->importe != 0): ?>
                    <tr>
                        <td >
                            <p>
                                <?php
                                    if($movimiento->folio()->first()){
                                        echo  $movimiento->folio()->first()->paciente->first() ? $movimiento->folio()->first()->paciente()->first()->nombre : 'Sin paciente';
                                    }else{
                                        $movimiento->descripcion;
                                    }
                                ?>
                            </p>
                        </td>
                        <td >
                            <p>
                                <?php echo e($movimiento->importe); ?>

                            </p>
                        </td>
                        <td >
                            <p>
                                <?php echo e($movimiento->tipo_movimiento); ?>

                            </p>
                        </td>
                        <td >
                            <p>
                                <?php echo e($movimiento->metodo_pago); ?>

                            </p>
                        </td>
                        <td >
                            <p>
                                <?php echo e(($movimiento->folio()->first()) ? $movimiento->folio()->first()->empresas()->first()->descripcion : ''); ?>

                            </p>
                        </td>
                        <td>
                            <p>
                                <?php echo e($movimiento->created_at); ?>

                            </p>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td>
                        No hay datos disponibles.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div><?php /**PATH /home2/pixelar6/micromed.book-medical.com/resources/views/layout/partials/caja/body-arqueo.blade.php ENDPATH**/ ?>