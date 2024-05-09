<html>
    <head>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet"> 
        @include('layout.partials.consentimiento.estilo')
    </head>
    <body>
        @include('layout.partials.consentimiento.header')
        @include('layout.partials.consentimiento.footer')
        
        <div class="invoice-content">
            @php
                $i = 0;
            @endphp
            @foreach ($formatos as $key=> $item)
                @if ($key === "sangre" && $item === "true")

                    @include('layout.partials.consentimiento.sangre.body-sangre')
                @endif

                @if ($key === "micro" && $item === "true")

                    @include('layout.partials.consentimiento.micro.body-quimico')

                @endif
                
                @if ($key === "vih" && $item === "true")

                    @include('layout.partials.consentimiento.vih.body-vih')

                @endif
                @php
                    $i++;
                @endphp
                @if ($i !== count($formatos))
                    <div class="break"></div>
                @endif
            @endforeach
        </div>

    </body>
</html>