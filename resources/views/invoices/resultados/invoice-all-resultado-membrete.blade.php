<html>
    <head>
        {{-- <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">  --}}
        @include('layout.partials.resultados.estilo')

    </head>
    
    <body>
        {{-- @if ($fondo === 'si')
            @include('layout.partials.resultados.imagenPDF')
        @endif --}}
        {{-- Encabezado y pie de página --}}  
        @include('layout.partials.resultados.headerPDF')
        @include('layout.partials.resultados.footerPDF')
        @include('layout.partials.resultados.body-all-PDF')
    </body>
</html>