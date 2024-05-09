'use strict';

$('#transfer').on('click', function(e){
    $('#transfer').prop('disabled', true);
    $('.search').show();
    let trans = axios.get('/stevlab/utils/patch-data-areas', {
    }).then(function(done){
        console.log(done);
    }).then(function(success){
        console.log(success);
    }).catch(function(error){
        console.log(error);
    }).finally(function (example) {
        console.log(example);
        $('#transfer').prop('disabled', false);
        $('.search').show();
    });
});