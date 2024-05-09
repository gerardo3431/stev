<div class="header separador-bottom">
    <div>
        <table style="padding-top: 160px;">
            <thead>
                <th class="col-left">
                    Laboratorio 
                    <p>
                        <?php echo e($laboratorio->nombre); ?>

                    </p>
                </th>
                <th class="col-center">
                    Sucursal
                    <p>
                        <?php echo e($sucursal->sucursal); ?>

                    </p>
                </th>
                <th class="col-right">
                    <?php if(isset($cuenta)): ?>
                        Caja id 
                        <p>
                            <?php echo e($cuenta->id); ?>

                        </p>
                    <?php else: ?>
                        <p>
                            Fechas
                        </p> 
                    <?php endif; ?>
                </th>
            </thead>
        </table>
    </div>
</div><?php /**PATH /home2/pixelar6/micromed.book-medical.com/resources/views/layout/partials/caja/header-arqueo.blade.php ENDPATH**/ ?>