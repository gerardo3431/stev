<?php switch($analito->tipo_resultado):
    case ('numerico'): ?>
        <?php if($analito->valor_captura < $analito->numero_uno || $analito->valor_captura > $analito->numero_dos): ?>
            <strong style="color:crimson">
                <?php echo e($analito->valor_captura); ?>

            <strong>
        <?php else: ?>
            <strong>
                <?php echo e($analito->valor_captura); ?>

            <strong>
        <?php endif; ?>
        <?php break; ?>
    
    <?php case ('referencia'): ?>
        <?php
            $referencia = $analito->referencia;
        ?>
        <?php if($referencia !== null): ?>
            <?php if($analito->valor_captura < $referencia->referencia_inicial || $analito->valor_captura > $referencia->referencia_final): ?>
                <strong style="color:crimson">
                    <?php echo e($analito->valor_captura); ?>

                <strong>
            <?php else: ?>
                <strong>
                    <?php echo e($analito->valor_captura); ?>

                <strong>
            <?php endif; ?>
        <?php endif; ?>
        
        <?php break; ?>
    
    <?php case ('texto'): ?>
        <strong>
            <?php echo htmlentities($analito->valor_captura, ENT_NOQUOTES); ?>

        </strong>
        <?php break; ?>

    
    <?php default: ?>
    
<?php endswitch; ?><?php /**PATH /home2/pixelar6/micromed.book-medical.com/resources/views/layout/partials/resultados/indicadores/resultados_n.blade.php ENDPATH**/ ?>