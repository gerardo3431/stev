
<?php if($estudio->metodo()->first()->descripcion  !== 'No asignado'): ?>
    <div style="font-size: 10px">
        <strong>Método: </strong><?php echo e($estudio->metodo()->first()->descripcion); ?>

    </div>
<?php endif; ?>
<div style="font-size: 10px">
    <strong>Muestra: </strong><?php echo e($estudio->muestra()->first()->descripcion); ?>

</div>
<?php if($estudio->observaciones !== 'Sin observaciones' || $estudio->observaciones !== null || $estudio->observaciones !== ''): ?>
    <div style="font-size: 10px">
        <strong>Observaciones: </strong> 
        <?php echo e($estudio->observaciones); ?>

    </div>
<?php endif; ?><?php /**PATH /home2/pixelar6/micromed.book-medical.com/resources/views/layout/partials/resultados/indicadores/observaciones.blade.php ENDPATH**/ ?>