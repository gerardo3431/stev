$(function() {
    'use strict';
  
    if($('#caducidad').length) {
      var date = new Date();
      var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
      $('#caducidad').datepicker({
        format: "dd/mm/yyyy",
        todayHighlight: true,
        autoclose: true
      });
      $('#caducidad').datepicker('setDate', today);
    }

  });
