<?php switch($analito->tipo_resultado):
    case ('documento'): ?>
        <tr>
            <td colspan="6" style="white-space: wrap">
                <?php echo "<span style='line-height: 0.6; font-size: 10px;'>". $analito->valor_captura ."</span>";?>
            </td>
        </tr>
    <?php break; ?>

    <?php case ('imagen'): ?>
    
        <tr>
            <td colspan="6" style="white-space: wrap">
                <?php if($analito->valor_captura != null): ?>
                    <?php
                        $data = base64_encode(Storage::disk('public')->get($analito->valor_captura));
                        echo '<img src="data:image/png;base64,' . $data . '" height="200" width="200">';
                    ?>
                <?php endif; ?>
            </td>
        </tr>
    <?php break; ?>

    <?php case ('subtitulo'): ?>
        <tr>
            <td colspan="6" style="white-space: wrap">
                <h4>
                    <?php echo e($analito->descripcion); ?>

                </h4>
            </td>
        </tr>
    <?php break; ?>
    <?php default: ?>
        
<?php endswitch; ?><?php /**PATH /home2/pixelar6/micromed.book-medical.com/resources/views/layout/partials/resultados/indicadores/resultados_s.blade.php ENDPATH**/ ?>