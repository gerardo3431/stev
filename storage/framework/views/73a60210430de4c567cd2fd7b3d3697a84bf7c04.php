<?php switch($analito->tipo_resultado):
    case ('texto'): ?>
        <?php echo $analito->valor_referencia; ?>    
        <?php break; ?>

    <?php case ('numerico'): ?>
        <?php echo e($analito->numero_uno); ?> - <?php echo e($analito->numero_dos); ?>

        <?php break; ?>

    <?php case ('referencia'): ?>
        <?php
            $referencia = $analito->referencia;
        ?>
        <?php if($referencia !== null): ?>
            <strong> <?php echo e($referencia->referencia_inicial); ?> - <?php echo e($referencia->referencia_final); ?> </strong>        
        <?php endif; ?>
    <?php break; ?>

    <?php default: ?>
        <?php echo e($analito->tipo_resultado); ?>

<?php endswitch; ?><?php /**PATH /home2/pixelar6/micromed.book-medical.com/resources/views/layout/partials/resultados/indicadores/valor_ejemplo.blade.php ENDPATH**/ ?>