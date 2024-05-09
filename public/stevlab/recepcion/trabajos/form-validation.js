$(function() {
	var CSRF_TOKEN = $('meta[name="_token"]').attr('content');

    // validate signup form on keyup and submit
    $("#formJob").validate({
        rules: {
            selectInicio:{
                required: true,
            },
            selectFinal:{
                required: true,
            },
            selectSucursal:{
                required: true,
            },
            selectArea:{
                required: true,
            }
            
        },
        messages: {
            selectInicio:{
                required:"Campo es requerido",
            },
            selectFinal:{
                required:"Campo es requerido",
            },
            selectSucursal:{
                required:"Campo es requerido",
            },
            selectArea:{
                required:"Campo es requerido",
            }
        },
        errorPlacement: function(error, element) {
            error.addClass( "invalid-feedback" );
            
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            }
            else if (element.prop('type') === 'radio' && element.parent('.radio-inline').length) {
                error.insertAfter(element.parent().parent());
            }
            else if (element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
                error.appendTo(element.parent().parent());
            }
            else {
                error.insertAfter(element);
            }
        },
        highlight: function(element, errorClass) {
            if ($(element).prop('type') != 'checkbox' && $(element).prop('type') != 'radio') {
                $( element ).addClass( "is-invalid" ).removeClass( "is-valid" );
            }
        },
        unhighlight: function(element, errorClass) {
            if ($(element).prop('type') != 'checkbox' && $(element).prop('type') != 'radio') {
                $( element ).addClass( "is-valid" ).removeClass( "is-invalid" );
            }
        },
        submitHandler: function() {
            // Preparing data
            $('#sending').prop('disabled', true);
            $('#search').show();

            $.ajax({
                url: '/stevlab/recepcion/getJobList',
                type: 'POST',
                data: $("#formJob").serializeArray(),
                success: function(response) {
                    // Change status
                    $('#sending').prop('disabled', false);
                    $('#search').hide();

                    window.open(response['pdf']);
                },
                error: function(error){
                    console.log(error);
                    $('#sending').prop('disabled', false);
                    $('#search').hide();
                }        
            });
        }
    });

});