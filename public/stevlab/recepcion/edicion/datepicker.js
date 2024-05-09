$(function() {
    'use strict';
    
    if($('#datePickerExample').length) {
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        $('#datePickerExample').datepicker({
            format: "dd/mm/yyyy",
            todayHighlight: true,
            autoclose: true
        });
        $('#datePickerExample').datepicker();
    }
    
    if($('#fecha_entrega').length){
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());  
        $('#fecha_entrega').datepicker({
            format: "mm/dd/yyyy",
            todayHighlight: true,
            autoclose: true
        });
        $('#fecha_entrega').datepicker();
    }
});