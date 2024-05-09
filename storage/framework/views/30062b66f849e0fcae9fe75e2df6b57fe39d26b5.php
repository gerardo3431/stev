<html>
    <head>
        
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet"> 

        <?php echo $__env->make('layout.partials.ticket.style_half', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        
    </head>
    <body>
        <div id="image">
        </div>
        
        <?php echo $__env->make('layout.partials.ticket.headerPDF', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('layout.partials.ticket.footerPDF', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('layout.partials.ticket.bodyPDF', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </body>
</html><?php /**PATH /home2/pixelar6/micromed.book-medical.com/resources/views/invoices/ticket/ticket-letter-complete.blade.php ENDPATH**/ ?>