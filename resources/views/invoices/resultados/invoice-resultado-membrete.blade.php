<html>
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet"> 
    @include('layout.partials.resultados.estilo')
    
</head>
    <body>
        @php
            $pregunta = ($fondo != null) ? $fondo : 'si';
        @endphp
        @if ($pregunta == 'no')
        @else
            <style>
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
            </style>
            <div id="image">
            </div>
        @endif
        {{-- @if (isset($membrete))
            @include('layout.partials.resultados.imagenPDF')
        @else
        @endif --}}
        {{-- <div id="image">
        </div> --}}

        {{-- Encabezado y pie de página --}}
        @include('layout.partials.resultados.headerPDF')
        @include('layout.partials.resultados.footerPDF')
        @include('layout.partials.resultados.bodyPDF')
    </body>
</html>