'use strict';
$(function(){
    var options = {
        chart: {
            height: 300,
            type: 'line',
        },
        stroke: {
            width: 2,
            curve: 'smooth',
        },
        dataLabels: {
            enabled: false
        },
        series: [],
        noData: {
            text: 'Loading...'
        }
        // chart: {
        //     // height: 400,
        //     type: 'line',
        //     height: 60,
        //     sparkline: {
        //         enabled: !0
        //     }
        // },
        // stroke: {
        //     width: 2,
        //     curve: 'smooth',
        // },
        // markers: {
        //     size: 0
        // },
        // dataLabels: {
        //     enabled: false
        // },
        // series: [],
        // noData: {
        //     text: 'Loading...'
        // }
    }
    // Inicializacion para los charts
    var chartPatients = new ApexCharts(
        document.querySelector("#patientsChart"),
        options
    );
    chartPatients.render();

    var chartSolicitudes = new ApexCharts(
        document.querySelector("#solicitudesChart"),
        options
    );
    chartSolicitudes.render();


    var chartWeek = new ApexCharts(
        document.querySelector("#weekChart"),
        options
    );
    chartWeek.render();

    var chartMonth = new ApexCharts(
        document.querySelector("#monthChartResponse"),
        options
    );
    chartMonth.render();

    var chart = new ApexCharts(
        document.querySelector("#periodChartResponse"),
        options
    );
    chart.render();

    // Consultas ajax para el chart de rango de fechas
    $( ".fecha_chart_period" ).change(function() {
        var CSRF_TOKEN = $('meta[name="_token"]').attr('content');
        let fecha_inicial = $('#fecha_inicial').val();
        let fecha_final = $('#fecha_final').val();
        
        let data = new FormData();
        data.append('_token', CSRF_TOKEN);
        data.append('fecha_inicial', fecha_inicial);
        data.append('fecha_final', fecha_final);
        
        $.ajax({
            url: '/stevlab/recover-chart',
            type: 'post',
            data: data,
            contentType: false,
            processData: false,
            success: function(response) {
                let data = JSON.parse(response);
                // console.log(data);
                chart.updateSeries(data.dato);
                chart.updateOptions({
                    xaxis:{
                        type: 'datetime',
                        categories: data.labels,
                    }
                });
            },
            error: function (jqXHR, textStatus) {
                let responseText = jQuery.parseJSON(jqXHR.responseText);
                console.log(responseText);
            }
        });
    });
    
    // Ultimos 7 dias de ingresos
    $.ajax({
        url: '/stevlab/recover-ingresos-week',
        type: 'get',
        contentType: false,
        processData: false,
        success: function(response) {
            let data = JSON.parse(response);
            // console.log(data);
            chartWeek.updateSeries(data.dato);
            chartWeek.updateOptions({
                xaxis:{
                    type: 'datetime',
                    categories: data.labels,
                }
            });
        },
        error: function (jqXHR, textStatus) {
            let responseText = jQuery.parseJSON(jqXHR.responseText);
            console.log(responseText);
        }
    });

    // Ajax Chart mensual
    $.ajax({
        url: '/stevlab/recover-chart-month',
        type: 'get',
        contentType: false,
        processData: false,
        success: function(response) {
            let data = JSON.parse(response);
            // console.log(data);
            chartMonth.updateSeries(data.dato);
            chartMonth.updateOptions({
                xaxis:{
                    type: 'datetime',
                    categories: data.labels,
                }
            });
        },
        error: function (jqXHR, textStatus) {
            let responseText = jQuery.parseJSON(jqXHR.responseText);
            console.log(responseText);
        }
    });

    // Ultimos 7 dias de pacientes registrados
    $.ajax({
        url: '/stevlab/recover-patients-week',
        type: 'get',
        contentType: false,
        processData: false,
        success: function(response) {
            let data = JSON.parse(response);
            // console.log(data);
            chartPatients.updateSeries(data.dato);
            chartPatients.updateOptions({
                xaxis:{
                    type: 'datetime',
                    categories: data.labels,
                }
            });
        },
        error: function (jqXHR, textStatus) {
            let responseText = jQuery.parseJSON(jqXHR.responseText);
            console.log(responseText);
        }
    });

    // Solicitudes en los ultimos 12 meses
    $.ajax({
        url: '/stevlab/recover-solicitudes-anual',
        type: 'get',
        contentType: false,
        processData: false,
        success: function(response) {
            let data = JSON.parse(response);
            // console.log(data);
            chartSolicitudes.updateSeries(data.dato);
            chartSolicitudes.updateOptions({
                xaxis:{
                    type: 'datetime',
                    categories: data.labels,
                }
            });
        },
        error: function (jqXHR, textStatus) {
            let responseText = jQuery.parseJSON(jqXHR.responseText);
            console.log(responseText);
        }
    });
});
    
function muestraGrafica(obj){
    $(`.charts`).hide();
    $(`.btn-charts`).removeClass( "btn-primary" ).addClass( "btn-outline-primary" );
    let texto = $(obj).attr("data-id");
    $(obj).removeClass( "btn-outline-primary" ).addClass( "btn-primary" );
    $(`#${texto}Chart`).fadeIn(1000);
}