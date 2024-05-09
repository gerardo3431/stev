$(function() {
    'use strict';
    
    if($('#fecha').length) {
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        $('#fecha').datepicker({
            format: "dd/mm/yyyy",
            todayHighlight: true,
            autoclose: true
        });
        $('#fecha').datepicker('setDate', today);
    }
    
});
