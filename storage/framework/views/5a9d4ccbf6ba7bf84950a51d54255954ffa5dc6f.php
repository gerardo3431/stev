<?php $__env->startPush('plugin-styles'); ?> 
<link href="<?php echo e(asset('public/assets/plugins/@mdi/css/materialdesignicons.min.css')); ?>" rel="stylesheet" />

<link href="<?php echo e(asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css')); ?>" rel="stylesheet" />
<?php $__env->stopPush(); ?>


<?php $__env->startSection('content'); ?>
  
  <nav class="page-breadcrumb">
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo e(route('stevlab.dashboard')); ?>">StevLab</a></li>
          <li class="breadcrumb-item"> <a href="<?php echo e(route('stevlab.recepcion.index')); ?>">Recepcion</a> </li>
          <li class="breadcrumb-item active" aria-current="page"> <a href="<?php echo e(route('stevlab.recepcion.editar')); ?>">Editar solicitud</a> </li>
      </ol>
  </nav>
  
  
  
<!----------------------------------------------------------------------------------------------------->
<?php if(session('status') == 'Debes aperturar caja antes de empezar a trabajar.'): ?>

<div class="alert alert-secondary alert-dismissible fade show" role="alert">
    <i data-feather="alert-circle"></i>
    <strong>Aviso!</strong> <?php echo e(session('status')); ?> <a href="<?php echo e(route('stevlab.caja.index')); ?>" class="alert-link">Click aquí</a>. 
</div>

<?php elseif(session('status')== 'Caja cerrada automáticamente...'): ?>

<div class="alert alert-secondary alert-dismissible fade show" role="alert">
    <i data-feather="alert-circle"></i>
    <strong>Aviso!</strong> <?php echo e(session('status')); ?> <a href="<?php echo e(route('stevlab.caja.index')); ?>" class="alert-link">Click aquí</a> 
</div>

<?php else: ?>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title">Solicitudes</h6>
          <div class="table-responsive">
            <table id="dataTableExample" class="table table-hover nowrap" style="width:100%">
              <thead>
                <tr>
                  <th>Folio</th>
                  <th>Nombre</th>
                  <th>Fecha nacimiento</th>
                  <th>Empresa</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody id="recepcionsList">
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('plugin-scripts'); ?>
<script src="<?php echo e(asset('public/assets/plugins/datatables-net/jquery.dataTables.js')); ?>"></script>
<script src="<?php echo e(asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js')); ?>"></script>
<script src="<?php echo e(asset('public/assets/js/axios.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/assets/plugins/sweetalert2/sweetalert2.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('custom-scripts'); ?>
  <script src="<?php echo e(asset('public/stevlab/recepcion/edicion/edit_index/data-table.js')); ?>?v=<?php echo rand();?>"></script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/pixelar6/micromed.book-medical.com/resources/views/recepcion/editar/index.blade.php ENDPATH**/ ?>