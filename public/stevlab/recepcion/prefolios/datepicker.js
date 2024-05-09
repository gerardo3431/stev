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
      $('#datePickerExample').datepicker('setDate', today);
    }
    
    if($('#fecha_nacimiento').length){
      var date = new Date();
      var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());  
      // Cumpleaños
      $('#fecha_nacimiento').datepicker({
        format: "dd/mm/yyyy",
        todayHighlight: true,
        autoclose: true
      });
      $('#fecha_nacimiento').datepicker('setDate', today);
    }
    if($('#vigencia_inicio').length){
      var date = new Date();
      var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());  
      // Vigencia inicio
      $('#vigencia_inicio').datepicker({
        format: "dd/mm/yyyy",
        todayHighlight: true,
        autoclose: true
      });
      $('#vigencia_inicio').datepicker('setDate', today);
    }

    if($('#vigencia_fin').length){
      var date = new Date();
      var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());  
      $('#vigencia_fin').datepicker({
        format: "dd/mm/yyyy",
        todayHighlight: true,
        autoclose: true
      });
      $('#vigencia_fin').datepicker('setDate', today);
    }
    

    if($('#fecha_entrega').length){
      var date = new Date();
      var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());  
      $('#fecha_entrega').datepicker({
        format: "dd/mm/yyyy",
        todayHighlight: true,
        autoclose: true
      });
      $('#fecha_entrega').datepicker('setDate', today);
    }
  });
