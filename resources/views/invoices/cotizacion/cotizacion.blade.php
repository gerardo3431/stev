<html>
    <head>
        
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet"> 
        <style>

            /* Cambiar las propiedades para alinearse con el generador de pdf */
            @page { 
                margin: 190px 5px; 
                /* margin: 165px 10px;  */
                /* margin: 165px 25px; */
                /* margin: 220px 25px; */
            
            }
            
        
            body{
                font-family: 'Noto Sans', sans-serif;
                line-height: 1;
                font-size: 10px;
                margin-bottom: 550px;
            }
            
            /* height: auto; */
            #image {
                top: -180px;
                position: fixed;
                /* height: 1045px; */
                height: 545px;
                max-height: 545px;
                width: 805px;
                max-width: 805px;
                z-index: -9999;
                background-image: url('../storage/app/public/membrete_laboratorios/RECIBO-DE-PAGO.png'); 
                background-size: 805px 545px;
                background-repeat: no-repeat;  
            }
        
            .header { 
                position: fixed; 
                top: -100px;
            }
        
            .footer { 
                position: fixed; 
                bottom: 370px; 
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
                /* margin-bottom: 450px;  */
                border-radius: 4px;
            }
            /* Separador, solo borde inferior */
            .separador-bottom{
                border-style: none none solid none;
            }
            
            h1{
                font-size: 16px;
            }
            h2{
                font-size: 14px;
            }
            h3{
                font-size: 13px;
            }
            h4{
                font-size: 12px;
            }
            h5{
                font-size: 10.8px;
            }
            p{
                font-size: 12px;
                text-justify: inter-word;
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
                /* white-space:nowrap; */
                /* background-color: greenyellow; */
            }
            th, td {
                /* border-bottom: 1px solid #ddd; */
                word-break: break-all;
            }
        
            /* Para divisiones de 3 */
            .col-left{
                width: 25%; 
                text-align: left;
                /* font-size: 10px; */
            }
            .col-center{
                width: 50%; 
                text-align: center;
                /* font-size: 10px; */
            }
            .col-right{
                width: 25%; 
                text-align: left;
                /* font-size: 10px; */
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
                width: 30%; 
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
        {{-- Encabezado y pie de página --}}
        @include('layout.partials.cotizacion.header')
        @include('layout.partials.cotizacion.footer')
        @include('layout.partials.cotizacion.body')

    </body>
</html>