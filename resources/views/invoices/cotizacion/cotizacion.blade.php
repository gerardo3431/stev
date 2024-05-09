<html>
    <head>
        
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet"> 
        @include('layout.partials.cotizacion.style_complete')
        {{-- @include('layout.partials.cotizacion.style_half') --}}

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