<?php
    $suma = 0;
?>
<div class="footer"  style="width: 100%">
    <table>
        <tbody>
            <tr>
                <td>
                    <strong>Subtotal</strong>
                    $ <?php echo e($estudios->sum('precio')); ?>


                    <strong>Descuento</strong>
                    $ <?php echo e($folios->descuento); ?>

                    
                    <strong>Total</strong>  
                    $ <?php echo e($estudios->sum('precio') - $folios->descuento); ?>


                    <strong>Pago</strong>
                    $ <?php echo e($pago->importe); ?>


                    <strong>Pago pendiente</strong>
                    $ <?php echo e($estudios->sum('precio') - $folios->pago()->sum('importe')); ?>


                    <strong>Metodo de pago</strong>
                    <?php echo e($pago->metodo_pago); ?>


                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td class='columna-dos' style="text-align: justify; vertical-align:top; line-heigth: 1; " >
                    <p style="font-size: 7px;">
                        Autorizo a <?php echo e($laboratorio->nombre); ?> realice los estudios solicitados, conociendo los requisitos para la realizacion y riesgos del procedimiento de la toma de muestra: Hematoma, Desmayo, Repeticion de la toma, Solicitud de nueva muestra. 
                        Acepto la responsabilidad al otorgar la concesion para realizar los estudios en caso de no cumplir con los requisitos. El Laboratorio Clinico se compromete a la confidencialidad de la informacion solicitada, excepto en los casos indicados por las autoriades competentes.
                        
                        
                        
                    </p>
                </td>
                <td>
                    <td class="columna-una" style="border-bottom: none; text-align: justify; text-justify: inter-word;">
                        <?php if(auth()->user()->first()->labs()->first()->paquete()->first()->paquete == 'completo'): ?>
                            <?php
                                echo '<img src="data:image/svg+xml;base64,'.base64_encode($qr).'"/>';
                            ?>
                        <?php endif; ?>
                    </td>
                </td>
            </tr>
        </tfoot>
    </table>
    
</div>
<?php /**PATH /home2/pixelar6/micromed.book-medical.com/resources/views/layout/partials/ticket/footerPDF.blade.php ENDPATH**/ ?>