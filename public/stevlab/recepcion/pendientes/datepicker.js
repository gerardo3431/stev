$(function() {
    'use strict';
    
    if($('#select_inicio').length) {
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        $('#select_inicio').datepicker({
            format: "mm/dd/yyyy",
            todayHighlight: true,
            autoclose: true
        });
        $('#select_inicio').datepicker('setDate', today);
    }
});

$(function(){
    if($('#select_final').length) {
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        $('#select_final').datepicker({
            format: "mm/dd/yyyy",
            todayHighlight: true,
            autoclose: true
        });
        $('#select_final').datepicker('setDate', today);
    }
});