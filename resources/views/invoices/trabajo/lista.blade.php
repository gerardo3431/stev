<html>
    <head>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet"> 
        @include('layout.partials.trabajo.estilo')
    </head>

    <body>

        <div id="image">
        </div>
        {{-- Encabezado y pie de página --}}  
        @include('layout.partials.trabajo.header')
        @include('layout.partials.trabajo.footer')
        @include('layout.partials.trabajo.body')
    </body>
</html>