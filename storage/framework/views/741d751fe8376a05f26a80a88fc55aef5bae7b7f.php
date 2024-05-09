<div class="header separador-bottom" style="width: 100%">
    
    <table >
        <tbody>
            <tr>
                <td>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                </td>
            </tr>
            <tr>
                <td class="col-left"  style="border-bottom: none; ">
                    <strong>Nombre: </strong><?php echo e($paciente->nombre); ?> <?php echo e($paciente->ap_paterno); ?> <?php echo e($paciente->ap_materno); ?>

                    <br>
                    <strong>Edad:</strong> <?php echo e($edad); ?>

                    <br>
                    <strong>Fecha de nacimiento:</strong> <?php echo e($paciente->fecha_nacimiento); ?>

                    <br>
                    <strong>Telefono:</strong> <?php echo e($paciente->celular); ?>

                </td>
                <td class="col-center"  style="border-bottom: none; " style="white-space: wrap">
                    <strong>Flebotomia: </strong><?php echo e($folios->f_flebotomia); ?> - <?php echo e($folios->h_flebotomia); ?>

                    <br>
                    <strong>Sexo: </strong><?php echo e(strtoupper($paciente->sexo)); ?>

                    <br>
                    <strong>Doctor que solicita:</strong> <?php echo e($doctor->nombre); ?> <?php echo e($doctor->ap_paterno); ?> <?php echo e($doctor->ap_materno); ?>

                    <br>
                    <strong>Usuario:</strong> <?php echo e(auth()->user()->sucursal()->where('estatus', 'activa')->first()->sucursal); ?>

                </td>
                <td class="col-right"  style="border-bottom: none;  text-align: right;">
                    
                    
                    <strong>Fecha de pago:</strong> <?php echo e($pago->created_at); ?> 
                    <br>
                    
                    <strong>Token de acceso: </strong> <?php echo e($folios->token); ?>

                    <br>
                    
                        <?php
                            echo '<img src="data:image/svg+xml;base64,'.base64_encode($barcode).'" />';
                        ?>
                </td>
            </tr>
            
        </tbody>
    </table>
</div>

<?php /**PATH /home2/pixelar6/micromed.book-medical.com/resources/views/layout/partials/ticket/headerPDF.blade.php ENDPATH**/ ?>