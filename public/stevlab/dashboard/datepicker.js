$(function() {
    'use strict';
    
    if($('#fecha_inicial').length) {
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        $('#fecha_inicial').datepicker({
            format: "mm/dd/yyyy",
            todayHighlight: true,
            autoclose: true
        });
        $('#fecha_inicial').datepicker('setDate', today);
    }
});

$(function(){
    if($('#fecha_final').length) {
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        $('#fecha_final').datepicker({
            format: "mm/dd/yyyy",
            todayHighlight: true,
            autoclose: true
        });
        $('#fecha_final').datepicker('setDate', today);
    }
});