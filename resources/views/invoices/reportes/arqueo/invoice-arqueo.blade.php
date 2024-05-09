<html>
    <head>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet"> 
        <style>
            /* Cambiar las propiedades para alinearse con el generador de pdf */
            @page { 
                margin: 165px 10px; 
            }
            
            body{
                font-family: 'Noto Sans', sans-serif;
                line-height: 1;
                margin-top: 60px;
                /* background-color: aqua; */
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
                height: 165px; 
                /* background-color: lightblue;  */
            }
            .footer .page:after {
                content: counter(page); 
            }

            /* Saltar a nueva pagina */
            .break {
                page-break-after: always;
            }

            /* Contenido */
            .invoice-content {
                /* background-color: rgb(105, 70, 70); */
                /* border: 1px solid #f0f0f0; */
                border-radius: 4px;
                padding-bottom: 10px;
                padding-right: 20px;
                padding-left: 20px;
                text-align: justify;
                text-justify: inter-word;
            }
            /* Separador, solo borde inferior */
            .separador-bottom{
                border-style: none none solid none;
            }
            /* .separador-resultados{
                border:  1px solid rgba(158, 156, 156, 0.495);
            } */
            
            h1{
                font-size: 18px;
                margin-top: 2px;
                margin-bottom: 2px;
            }
            h2{
                font-size: 16px;
                margin-top: 2px;
                margin-bottom: 2px;
            }
            h3{
                font-size: 14px;
                margin-top: 2px;
                margin-bottom: 2px;
            }
            h4{
                font-size: 12px;
                margin-top: 2px;
                margin-bottom: 2px;
            }
            h5{
                font-size: 10.8px;
                margin-top: 2px;
                margin-bottom: 2px;
            }
            p{
                font-size: 8px;
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
                margin: auto;
                white-space:nowrap;
            }
            th, td {
                border-bottom: 1px solid #ddd;
                word-break: break-all;
                text-align: justify
            }

            /* Para divisiones de 3 */
            .col-left{
                width: 25%; 
                text-align: left;
                font-size: 10px;
            }
            .col-center{
                width: 50%; 
                text-align: center;
                font-size: 10px;
            }
            .col-right{
                width: 25%; 
                text-align: right;
                font-size: 10px;
            }

            /* Para divisiones de 4 */
            .result{
                font-size: 8px
            }

            .col-one{
                width: 25%; 
                text-align: left;
                
            }
            .col-two{
                width: 3%; 
                text-align: left;
                
            }
            .col-three{
                width: 40%; 
                text-align: left;
                
            }
            .col-four{
                width: 10%; 
                text-align: left;
                
            }
            .col-five{
                width: 27%; 
                text-align: left;
                
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
        {{-- @if ($fondo == 'no')
        @else
            <div id="image">
            </div>
        @endif --}}
        
        {{-- Encabezado y pie de página --}}  
        @include('layout.partials.reportes.arqueos.header')
        @include('layout.partials.reportes.arqueos.footer')
        @include('layout.partials.reportes.arqueos.body')

    </body>
</html>