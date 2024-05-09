<?php $__env->startSection('content'); ?>
<div class="page-content d-flex align-items-center justify-content-center">

    <div class="row w-100 mx-0 auth-page">
        <div class="col-md-8 col-xl-6 mx-auto">
            <div class="card">
                <div class="row">
                    <div class="col-md-4 pe-md-0">
                        <div class="auth-side-wrapper" style="background-image: url(<?php echo e(asset('public/assets/images/images/login.jpg')); ?>)">

                        </div>
                    </div>
                    <div class="col-md-8 ps-md-0">
                        <div class="auth-form-wrapper px-4 py-5">
                            <a href="#" class="noble-ui-logo d-block mb-2">Stev<span>Lab</span></a>
                            <h5 class="text-muted fw-normal mb-4">Entrega de resultados. Por favor ingrese los datos correspondiente.</h5>
                            <?php if(session('status')): ?>
                                <div class="alert alert-success mb-3 rounded-0" role="alert">
                                    <?php echo e(session('status')); ?>

                                </div>
                            <?php endif; ?>
                            <?php if(session('message')): ?>
                                <div class="alert alert-danger mb-3 rounded-0" role="alert">
                                    <?php echo e(session('message')); ?>

                                </div>
                            <?php endif; ?>
                            <form class="forms-sample" action="<?php echo e(route('resultados.search')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <div class="mb-3">
                                    <label for="username" class="form-label">Folio</label>
                                    <input value="<?php echo e(old('folio')); ?>" type="text" class="form-control <?php echo e($errors->has('folio') ? 'is-invalid' : ''); ?>" name='folio' placeholder="Folio">
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input-error','data' => ['for' => 'folio']]); ?>
<?php $component->withName('jet-input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'folio']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                </div>
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Token</label>
                                    <input value="<?php echo e(old('token')); ?>" type="nombre" class="form-control <?php echo e($errors->has('token') ? 'is-invalid' : ''); ?>" name='token' placeholder="Token">
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input-error','data' => ['for' => 'token']]); ?>
<?php $component->withName('jet-input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'token']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                </div>
                                <div>
                                    <button class="btn btn-primary me-2 mb-2 mb-md-0" type="submit">Buscar resultados</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\laboratorios\resources\views/resultados/index.blade.php ENDPATH**/ ?>