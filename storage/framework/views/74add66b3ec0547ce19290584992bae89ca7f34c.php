<div class="header separador-bottom">
    
    
    <table>
        <tbody>
            <tr>
                <td  style="border-bottom: none">
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                </td>
            </tr>
            
        </tbody>
    </table>
    
    <table>
        <tr>
            <td class="col-left"  style="border-bottom: none; font-size:12px">
                <strong>Nombre: </strong><?php echo e($folios->paciente()->first()->nombre); ?>

                <br>
                
                <strong>Edad:</strong> <?php echo e($folios->paciente()->first()->specificAge()); ?> 
                <br>
                <strong>Folio: </strong><?php echo e($folios->folio); ?>

            </td>
            <td class="col-center"  style="border-bottom: none">
                <strong>Fecha y hora: </strong><?php echo e($folios->f_flebotomia); ?> - <?php echo e($folios->h_flebotomia); ?>

                <br>
                <strong>Sexo: </strong><?php echo e(strtoupper($folios->paciente()->first()->sexo)); ?>

                <br>
                <strong>Doctor que solicita:</strong> <?php echo e($folios->doctores()->first()->nombre); ?> <?php echo e($folios->doctores()->first()->ap_paterno); ?> <?php echo e($folios->doctores()->first()->ap_materno); ?>

                
            </td>
            <td class="col-right"  style="border-bottom: none">
                <strong>Validacion: </strong> <?php echo e($folios->historials()->orderBy('updated_at', 'desc')->first()->updated_at); ?>

                <br>
                <strong>Turno: </strong> <?php echo e($folios->turno); ?>

                <br>
                <?php
                    echo '<img src="data:image/svg+xml;base64,'.base64_encode($barcode).'" />';
                ?>
            </td>
        </tr>
    </table>
</div>

<?php /**PATH C:\laragon\www\laboratorios\resources\views/layout/partials/resultados/headerPDF.blade.php ENDPATH**/ ?>