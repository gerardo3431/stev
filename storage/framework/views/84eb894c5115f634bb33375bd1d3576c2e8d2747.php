<?php
// $firma  = base64_encode(Storage::disk('public')->get($idFolio->valida()->first()->firma));
?>
<div class="footer">
    <table style="line-height: 0.5; font-size:9px">
        <tr >
            <td class="col-left" style="border-bottom: none; line-height: 0.5;">
                <p>
                    <strong>Fecha de impresión: </strong> 
                    <?php echo e(Date("Y-m-d h:i:s")); ?>

                </p>
                <?php echo $__env->make('layout.partials.resultados.indicadores', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                
            </td>
            <td class="col-center" style="border-bottom: none; line-height: 0.5;">
                <p>
                    <?php
                        $pregunta = ($fondo != null) ? $fondo : 'si';
                    ?>
                    <?php if($pregunta == 'no'): ?>
                    <?php else: ?>
                        <?php
                            echo '<img src="data:image/png;base64, '. $img_valido .'" alt="" height="60" >';
                        ?>
                    <?php endif; ?>
                    
                </p>
                <p> 
                    
                    <?php echo e(($laboratorio->responsable_sanitario) ? $laboratorio->responsable_sanitario : ''); ?>


                </p>
                <p>
                    
                    Ced. Prof. <?php echo e(($laboratorio->cedula_sanitario) ? $laboratorio->cedula_sanitario : ''); ?>

                </p>
                <p>
                    Responsable sanitario
                </p> 
            </td>
            <td class="col-right" style="border-bottom: none; line-height: 0.5; text-align: center">
                <p class="page">Page </p>

            </td>
        </tr>
        
    </table>
    <br>
    <br>
</div><?php /**PATH /home2/pixelar6/micromed.book-medical.com/resources/views/layout/partials/resultados/footerPDF.blade.php ENDPATH**/ ?>