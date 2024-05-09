<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de caja</title>

    <style>
        /* Cambiar las propiedades para alinearse con el generador de pdf */
        @page { 
            margin: 165px 10px; 
        }
        
        body{
            font-family: 'Noto Sans', sans-serif;
            line-height: 1;
            padding-top: 60px;
            
        }

        #image {
            top: -155px;
            position: fixed;
            height: 2200px;
            width: 800px;
            z-index: -9999;
            
            background-image: url({{$membrete}});
            background-repeat: no-repeat;
            background-size: 100%;
            
        }
        
        /* Estilos globales */
        .header { 
            position: fixed; 
            top: -165px;
            left: 25px; 
            right: 25px; 
            height: 220px; 
            margin-top: 0; /*-30px*/
            /* background-color: orange;  */
            /* text-align: center;  */
        }
        .footer { 
            position: fixed; 
            bottom: -165px; 
            left: 25px; 
            right: 25px; 
            height: 220px; 
            /* background-color: lightblue;  */
        }
        .footer .page:after {
            content: counter(page); 
        }

        /* Saltar a nueva pagina */
        .break {
            page-break-after: avoid;
        }

        /* Contenido */
        .invoice-content {
			border-radius: 4px;
			padding-bottom: 50px;
			padding-right: 20px;
            padding-left: 20px;
        }
        /* Separador, solo borde inferior */
        .separador-bottom{
            border-style: none none solid none;
        }
        
        h1{
            font-size: 18px;
        }
        h2{
            font-size: 16px;
        }
        h3{
            font-size: 14px;
        }
        h4{
            font-size: 12px;
        }
        h5{
            font-size: 10.8px;
        }
        p{
            font-size: 10px;
        }
        /* strong{
            font-size: 13px;
        } */
        .align-center{
            text-align: center;
        }
        
        
        /* tabla */
        table{
            width: 100%;
            max-width: 100%;
            margin: auto;
            white-space:nowrap;
        }
        th, td {
            /* border-bottom: 1px solid #ddd; */
            word-break: break-all;
            text-align: justify
        }

        /* Para divisiones de 3 */
        .col-left{
            width: 25%; 
            text-align: center;
        }
        .col-center{
            width: 50%; 
            text-align: center;
        }
        .col-right{
            width: 25%; 
            text-align: center;
        }

        /* Para divisiones de 4 */
        .result{
            font-size:10px
        }

        .col-one{
            width: 10%; 
            text-align: center;
            
        }
        .col-two{
            width: 20%; 
            text-align: center;
            
        }
        .col-three{
            width: 20%; 
            text-align: center;
            
        }
        .col-four{
            width: 20%; 
            text-align: center;
            
        }
        .col-five{
            width: 20%; 
            text-align: center;
            
        }
        .col-six{
            width: 10%; 
            text-align: center;
        }
        
        /* Para divisiones de dos con un div mas grande lado izquierdo con miras al centro de la hoja (segun largo)*/
        .col-resize-right{
            text-align: right;
        }
        .col-resize-left{
            text-align: left;
        }

        .columna-una{
            width: 25%;
            text-align: left;
        }
        .columna-dos{
            width: 75%;
            text-align: left;
        }
    </style>
</head>
<body>
    <div id="image">
    </div>

    @include('layout.partials.caja.header-arqueo')    

    @if (isset($movimientos))
        {{-- Para el reporte de la caja --}}
        @include('layout.partials.caja.body-arqueo')
    @elseif(isset($cajas))
        {{-- Para el reporte de periodo --}}
        @include('layout.partials.caja.body-arqueo-completo')
    @elseif (isset($folios))
        {{-- Para el reporte de pacientes en la caja --}}
        @include('layout.partials.caja.body-arqueo-pacientes')
    @else
        @include('layout.partials.caja.body-arqueo-rapido')
    @endif

    @include('layout.partials.caja.footer-arqueo')
</body>
</html>