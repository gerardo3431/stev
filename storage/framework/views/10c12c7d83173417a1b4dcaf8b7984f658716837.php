<html>
    <head>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet"> 
        <?php echo $__env->make('layout.partials.consentimiento.estilo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </head>
    <body>
        <?php echo $__env->make('layout.partials.consentimiento.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('layout.partials.consentimiento.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        
        <div class="invoice-content">
            <?php
                $i = 0;
            ?>
            <?php $__currentLoopData = $formatos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($key === "sangre" && $item === "true"): ?>

                    <?php echo $__env->make('layout.partials.consentimiento.sangre.body-sangre', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endif; ?>

                <?php if($key === "micro" && $item === "true"): ?>

                    <?php echo $__env->make('layout.partials.consentimiento.micro.body-quimico', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <?php endif; ?>
                
                <?php if($key === "vih" && $item === "true"): ?>

                    <?php echo $__env->make('layout.partials.consentimiento.vih.body-vih', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <?php endif; ?>
                <?php
                    $i++;
                ?>
                <?php if($i !== count($formatos)): ?>
                    <div class="break"></div>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

    </body>
</html><?php /**PATH C:\laragon\www\laboratorios\resources\views/invoices/formatos/invoice-formato.blade.php ENDPATH**/ ?>