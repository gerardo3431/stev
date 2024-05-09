<?php $__env->startSection('content'); ?>
<div class="page-content d-flex align-items-center justify-content-center">

    <div class="row w-100 mx-0 auth-page">
        <div class="col-md-10 col-xl-10 mx-auto">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-center mb-3 mt-4"><?php echo e($recepcion->paciente()->first()->nombre); ?></h3>
                            <p class="text-muted text-center mb-4 pb-2"><?php echo e($estudio->clave); ?></p>
                            <div class="container">  
                                <div class="row">
                                    <div class="col-md-12 stretch-card grid-margin grid-margin-md-0">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="text-center mt-3 mb-4"></h4>
                                                <img class="img-fluid rounded mx-auto d-block" src="<?php echo e(URL::to('/') . '/public/storage/logos_laboratorios/labs.png'); ?>" height="30%" width="30%" alt="Laboratorio">
                                                
                                                <p class="text-muted text-center mb-4 fw-light">Fecha de informe</p>
                                                <h2 class="text-center">
                                                    <?php echo e($valida); ?>

                                                </h2>
                                                <p class="text-muted text-center mb-4 fw-light">Resultado</p>
                                                <h5 class="text-secondary text-center mb-4">
                                                    <?php echo e($analito->valor); ?>

                                                </h5>
                                                <table class="mx-auto">
                                                    <tr>
                                                        <td>
                                                            <p class="text-black text-center mb-4 fw-light">
                                                                <?php echo e($analito->descripcion); ?>

                                                            </p> 
                                                        </td>
                                                        <td>
                                                            <p class="text-danger text-center mb-4 fw-light">
                                                                <?php echo e($analito->valor); ?>

                                                            </p>
                                                        </td>
                                                    </tr>
                                                    
                                                </table>
                                                <div class="d-grid">
                                                    <a class="btn btn-success mt-4" href="<?php echo e(route('resultados.index')); ?>">Entendido!</a>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/pixelar6/micromed.book-medical.com/resources/views/resultados/certificate.blade.php ENDPATH**/ ?>