<html>
    <head>
        <style>
            /* Cambiar las propiedades para alinearse con el generador de pdf */
            @page { 
                margin: 165px 40px; 
            }
            
            body{
                font-family: 'Noto Sans', sans-serif;
                margin: 90px 0 20px 0;
                font-size:16px;
            }
            
            #image {
                height: 1646px;
                max-height: 1646px; 
                width: 1271px;
                max-width: 1271px;
                top: -164px;
                position: fixed;
                margin: 0 -23px 0 -39px;
                z-index: -9999;
                background-image: url({{$membrete}});
                background-repeat: no-repeat;
                background-size: cover;
            }
            
            /* Estilos globales */
            .header { 
                position: fixed; 
                top: 10px;
                width: 100%;
            }

            .footer { 
                position: fixed; 
                bottom: 0; 
                width: 100%;
            }

            .footer .page:after {
                content: counter(page); 
            }

            /* Contenido */
            .invoice-content {
                padding-bottom: 10px;
                text-align: justify;
                text-justify: inter-word;
            }
            
            /* Separador, solo borde inferior */
            .separador-bottom{
                border-style: none none solid none;
            }
            
            /* tabla */
            table{
                width: 100%;
                margin: auto;
                white-space:nowrap;
            }

            th {
                text-align: center;    
            }

            td {
                border-bottom: 1px solid #888282;
                word-break: break-all;
                text-align: start;
            }

            /* Para divisiones de 3 */
            .col-left{
                width: 25%; 
                text-align: left;
            }

            .col-center{
                width: 50%; 
                text-align: center;
            }
            .col-right{
                width: 25%; 
                text-align: right;
            }

            .border-none{
                border-bottom: none;
            }
        </style>
    </head>

    <body>
        <div id="image">
        </div>
        
        {{-- Encabezado y pie de página --}}  
        @include('layout.partials.reportes.arqueos.header')
        @include('layout.partials.reportes.arqueos.footer')
        @include('layout.partials.reportes.arqueos.body')

    </body>
</html>