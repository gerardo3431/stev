<html>
    <head>
        
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet"> 

        @include('layout.partials.ticket.style_half')
        {{-- @include('layout.partials.ticket.style_complete') --}}
    </head>
    <body>
        <div id="image">
        </div>
        {{-- Encabezado y pie de página --}}
        @include('layout.partials.ticket.headerPDF')
        @include('layout.partials.ticket.footerPDF')
        @include('layout.partials.ticket.bodyPDF')
    </body>
</html>