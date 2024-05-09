<?php $__env->startComponent('mail::message'); ?>
# Buen día <?php echo e($paciente->nombre); ?> <?php echo e($paciente->ap_paterno); ?> <?php echo e($paciente->ap_materno); ?>


Laboratorio **<?php echo e($laboratorio->nombre); ?>** le envia sus resultados de estudio.


Gracias por usar,<br>
**<?php echo e(config('app.name')); ?>** <br>
<?php $__env->startComponent('mail::panel'); ?>
Si tiene algún problema para visualizar o descargar el archivo pdf, por favor copie y pegue en su navegador el enlace a continuación: **<?php echo e($pdf); ?>**
<?php echo $__env->renderComponent(); ?>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH C:\laragon\www\laboratorios\resources\views/mail/resultados/envio-resultado.blade.php ENDPATH**/ ?>