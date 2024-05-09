<div class="invoice-content break">
    <?php
        $apertura = 0;
        $retiros = 0;
        $entrada = 0;
        $salida = 0;
        $total = 0;
    ?>
    <h2>Detalle</h2>

    <table>
        <thead>
            <tr>
                <th>
                    <p>
                        Caja id
                    </p>
                </th>
                <th>
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
                        Retiros totales
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
            
            <?php $__empty_1 = true; $__currentLoopData = $cajas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $caja): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $apertura   = $apertura + $caja->apertura;
                    $entrada    = $entrada + $caja->entradas;
                    $salida     = $salida + $caja->salidas;
                    $retiros    = $retiros + $caja->retiros;
                    $total      = $total + $caja->total;
                ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <?php endif; ?>
            <tr>
                <td>
                    <p>
                        All cajas
                    </p>
                </td>
                <td >
                    <p>
                        $ <?php echo e($apertura); ?>

                    </p>
                </td>
                <td >
                    <p>
                        $ <?php echo e($entrada); ?>

                    </p>
                </td>
                <td>
                    <p>
                        $ <?php echo e($salida); ?>

                    </p>
                </td>
                <td>
                    <p>
                        $ <?php echo e($retiros); ?>

                    </p>
                </td>
                <td>
                    <p>
                        $ <?php echo e($total); ?>

                    </p>
                </td>
            </tr>
        </tbody>
    </table>

    <h2>Movimientos</h2>

    <table>
        <thead>
            <tr>
                <th>
                    <p>
                        Descripcion
                    </p>
                </th>
                <th>
                    <p>
                        Importe
                    </p>
                </th>
                <th>
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
            <?php $__empty_1 = true; $__currentLoopData = $cajas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $caja): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $movimientos = $caja->pagos()->get();
                ?>
                <?php $__empty_2 = true; $__currentLoopData = $movimientos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $movimiento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                    <?php if($movimiento->importe != 0): ?>
                        <tr>
                            <td >
                                <p>
                                    <?php echo e(($movimiento->folio()->first()) ? $movimiento->folio()->first()->paciente()->first()->nombre : $movimiento->descripcion); ?>

                                </p>
                            </td>
                            <td >
                                <p>
                                    $ <?php echo e($movimiento->importe); ?>

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
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <?php endif; ?>
        </tbody>
    </table>

    <h2>Cajas totales</h2>
    <table>
        <thead>
            <tr>
                <th>
                    <p>
                        #
                    </p>
                </th>
                <th>
                    <p>
                        Apertura
                    </p>
                </th>
                <th>
                    <p>
                        Entradas
                    </p>
                </th>
                <th >
                    <p>
                        Salidas
                    </p>
                </th>
                <th >
                    <p>
                        Efectivo
                    </p>
                </th>
                <th>
                    <p>
                        Tarjeta
                    </p>
                </th>
                <th>
                    <p>
                        Transferencia
                    </p>
                </th>
                <th>
                    Total
                    <p

                    <p>
                </th>
                <th>
                    <p>
                        Estatus
                    </p>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $cajas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $caja): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <p>
                            <?php echo e($caja->id); ?>

                        </p>
                    </td>
                    <td>
                        <p>
                            $ <?php echo e($caja->apertura); ?>

                        </p>
                    </td>
                    <td>
                        <p>
                            $ <?php echo e($caja->entradas); ?>

                        </p>
                    </td>
                    <td>
                        <p>
                            $ <?php echo e($caja->salidas); ?>

                        </p>
                    </td>
                    <td>
                        <p>
                            $ <?php echo e($caja->ventas_efectivo); ?>

                        </p>
                    </td>
                    <td>
                        <p>
                            $ <?php echo e($caja->ventas_tarjeta); ?>

                        </p>
                    </td>
                    <td>
                        <p>
                            $ <?php echo e($caja->ventas_transferencia); ?>

                        </p>
                    </td>
                    <td>
                        <p>
                            $ <?php echo e($caja->total); ?>

                        </p>
                    </td>
                    <td>
                        <p>
                            <?php echo e($caja->estatus); ?>

                        </p>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <?php endif; ?>
        </tbody>
    </table>
</div><?php /**PATH /home2/pixelar6/micromed.book-medical.com/resources/views/layout/partials/caja/body-arqueo-completo.blade.php ENDPATH**/ ?>