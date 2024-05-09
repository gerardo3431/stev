'use strict';

$(function(){

    $('#notifications button').on('click',function() {
        $('#notifications').hide();
        $('#errors').empty();
    });
    
    renderiza();

    
});