<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Etiquetas de laboratorio</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet"> 

    <style>
        *{
            margin: 0;
            padding: 0;
        }
        body{
            font-family: 'Noto Sans', sans-serif;
			font-size: 9px;
			width: 50mm;
            max-width: 50mm;
            height: 25mm;
            max-height: 25mm; 
            line-height: 1;
            /* margin: 1px 5px 0px; */
            /* background-color: teal; */
            /* padding: 1px; */
            /* position: fixed; */
		}
        p{
            white-space: normal;
            word-break: break-all;
        }

        table{
            text-align:justify ;
            width: 100%;
            max-width: 100%;
            margin: auto;
            white-space:nowrap;
            /* background-color: gainsboro; */
        }
        th, td {
                /* border-bottom: 1px solid #ddd; */
                word-break: break-all;
                text-align: justify
        }

        .etiqueta{
            margin: 1px;
            /* margin-left: 1mm;
            margin-right: 1mm; */
        }

        .break {
            page-break-after: avoid;
        }
    </style>
</head>
<body>
    <div class="etiqueta">
        <table>
            @php
                $edad = ($paciente->edad !== '' || $paciente->edad !== null) ? $paciente->edad : $paciente->getAge();
            @endphp

            @forelse ($estudios as $key => $recipiente)
                @php
                    $envase = $key;
                    $labelClaves = '';
                    foreach ($recipiente as $key => $estudio) {
                        $labelClaves .= $estudio->clave . ', ';
                    }
                @endphp
                <tr>
                    <label for="">{{date('Y-m-d')}} // {{$envase}}</label>
                    <p><span> {{$paciente->nombre}} - {{$edad}} años</span></p>
                    <p>{{$labelClaves}}</p>
                    @php
                        echo "<img src='data:image/svg+xml;base64,".base64_encode($barcode)."' />";
                    @endphp
                </tr>
            @empty
                
            @endforelse

            {{-- @forelse ($perfiles as $key=> $recipiente)
                @php
                    $envase = $key;
                    $labelClaves = '';
                    foreach ($recipiente as $key => $estudio) {
                        $labelClaves .= $estudio->clave . ', ';
                    }
                @endphp
                <tr>
                    <label for="">{{date('Y-m-d')}} // {{$envase}}</label>
                    <p><span> {{$paciente->nombre}} - {{$edad}} años</span></p>
                    <p>{{$labelClaves}}</p>
                    @php
                        echo "<img src='data:image/svg+xml;base64,".base64_encode($barcode)."' />";
                    @endphp
                </tr>
            @empty
                
            @endforelse --}}

            @forelse ($pictures as $key => $picture)
                @php
                    $labelClaves = $picture->clave;
                @endphp
                <tr>
                    <label for="">{{date('Y-m-d')}} // </label>
                    <p><span> {{$paciente->nombre}} - {{$edad}} años</span></p>
                    <p>{{$labelClaves}}</p>
                    @php
                        echo "<img src='data:image/svg+xml;base64,".base64_encode($barcode)."' />";
                    @endphp
                </tr>
            @empty
                
            @endforelse
        </table>
    </div>
</body>
</html>