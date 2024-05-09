
<?php if($analito->tipo_resultado === 'numerico'): ?>
    <?php
        $num1   = $analito->numero_uno;
        $num2   = $analito->numero_dos;
        $valor  = $analito->valor_captura;
    ?>
    
<?php elseif($analito->tipo_resultado === 'referencia'): ?>
    <?php
        $referencia = $analito->referencia ?? null;
        $num1   = isset($referencia->referencia_inicial)? $referencia->referencia_inicial : "No especificado";
        $num2   = isset($referencia->referencia_final)? $referencia->referencia_final : "No especificado";
        $valor  = $analito->valor_captura;
    ?>
<?php endif; ?>


<?php if($valor < $num1 ): ?>
    <?php echo $__env->make('layout.partials.resultados.indicadores.down', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php elseif($valor > $num2): ?>
    <?php echo $__env->make('layout.partials.resultados.indicadores.up', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php else: ?>
    <?php echo $__env->make('layout.partials.resultados.indicadores.check', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?><?php /**PATH /home2/pixelar6/micromed.book-medical.com/resources/views/layout/partials/resultados/indicadores/indicadores.blade.php ENDPATH**/ ?>