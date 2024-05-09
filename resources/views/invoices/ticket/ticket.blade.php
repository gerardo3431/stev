
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Ticket</title>

	<link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet"> 

    <style>

        *{
            margin: 0;
            padding: 1;
        }

        body{
            font-family: 'Noto Sans', sans-serif;
			font-size: 12px;
            /* background-color: teal; */
            margin: 10px 2px 10px;
            padding: 0 20px;
            line-height: 1;
            text-justify: inter-word;
		}

        table{
            width: 100%;
            border-collapse: collapse;
            padding: 10px 0;
        }

        /* th, td {
            border-bottom: 1px solid gainsboro;
        } */

        strong {
            font-size: 16px;
        }

        .logotipo{
            /* height: 80px;
            width: 110px;  */
            width: 100%; 
            height: 100%;
        }

        /* Decoradores */
        .text-center{
            text-align: center;
        }
        
        .text-left{
            text-align: left;
        }

        .text-right{
            text-align: right;
        }

        .justify{
            text-align: justify;
        }

        .interword{
            text-justify: inter-word;
        }

        .italic{
            font-style: italic;
        }

        
        .line-dot-under{
            border-bottom: 2px black dotted;
        }

        /* Proporciones */
        .prop-horizontal{
            width: 100%;
        }

        .down-desplace{
            overflow-y: auto;
        }

        /* Texto o fuente */
        .text-sm{
            font-size: 8px;
        }

        .text-md{
            font-size: 10px;
        }

        .text-bg{
            font-size: 12px
        }

        .text-xl{
            font-size: 14px;
        }

    </style>
</head>

<body>
    <div class="prop-horizontal text-center" style="height: 100px; ">
        <img class="logotipo" src="data:image/png;base64, {{$logotipo}}" alt="" >
    </div>
    <div class="text-center text-xl">
        <p>
            {{$laboratorio->razon_social}} 
        </p>
        <p>
            {{auth()->user()->sucursal()->where('estatus', 'activa')->first()->sucursal}}
        </p>
        <p>
            <strong>
                {{$laboratorio->responsable_sanitario}}
            </strong>
        </p>
        <p>
            {{-- <strong>Fecha de pago: </strong> {{ date('m-d-Y h:i:s a', time()) }} --}}
            <strong>Fecha de pago: </strong> {{ $pago->created_at }}
        </p>
        <p>
            <strong>Cliente: </strong> {{ $paciente->nombre }}
        </p>
        <p>
            <strong>Edad: </strong> {{ $edad }}
        </p>
        <p>
            <strong>Fecha nacimiento: </strong> {{ $paciente->fecha_nacimiento }}
        </p>
        <p>
            <strong> Folio: </strong> {{ $folios->folio}}
        </p>
        @if (auth()->user()->first()->labs()->first()->paquete()->first()->paquete == 'completo')
            <p>
                <strong>Token: </strong> {{$folios->token}}
            </p>
        @endif
        <p>
            <img src="data:image/svg+xml;base64,{{base64_encode($barcode)}}" alt="">
        </p>
    </div>

    <table class="line-dot-under text-bg">
        <thead>
            <tr>
                <td class="text-left">
                    <strong>
                        Estudio
                    </strong>
                </td>
                <td class="text-center">
                    <strong>
                        Costo
                    </strong>
                </td>
            </tr>
        </thead>
        <tbody>
            @foreach ($estudios as $estudio)
                <tr>
                    <td class="text-left">{{$estudio->descripcion}}</td>
                    <td class="text-right">$ {{$estudio->precio}}.00</td>
                </tr>
            @endforeach
            
        </tbody>
    </table>

    <div class="text-right text-bg">
        <p>Subtotal:  $ {{ $estudios->sum('precio') }}</p>
        <p>Descuento: $ {{ $folios->descuento }}</p>
        <h3>Total:    $ {{ $estudios->sum('precio') - $folios->descuento }}</h3>
        <p>Pago:      $ {{ $pago->importe }}</p>
        <p>Pendiente: $ {{ (( $estudios->sum('precio') - $folios->pago()->sum('importe')) - $folios->descuento) }}</p>
        <p>Método:    {{ $pago->metodo_pago }}</p>
    </div>

    <div class="justify text-bg">
        <p class="text-center">
            <strong>Impreso por: </strong> {{auth()->user()->sucursal()->where('estatus', 'activa')->first()->sucursal}}
        </p>
        <br>
        <p class="text-md italic">
            Autorizo a {{$laboratorio->nombre}} realice los estudios solicitados, conociendo los requisitos para la realización y riesgos del 
            procedimiento de la toma de muestra: Hematoma, Desmayo, Repetición de la toma, Solicitud de nueva muestra.  Acepto la responsabilidad 
            al otorgar la concesión para realizar los estudios en caso de no cumplir con los requisitos. 
            El Laboratorio Clínico se compromete a la confidencialidad de la información solicitada, excepto en los casos indicados por las autoridades competentes.
        </p>
        @if (auth()->user()->first()->labs()->first()->paquete()->first()->paquete == 'completo')
            <p>
                Puede acceder a sus resultados con el número de folio y token asignado a tráves del siguiente enlace:
            </p>
            <br>
            <p class="text-xl text-center down-desplace" style="  max-height: 200px;  word-wrap: break-word;">
                <strong>
                    {{URL::to('/') . '/resultados/index'}} 
                </strong>
                    {{-- https://laboratorio.book-medical.com/resultados/index --}}
            </p>
            <br>
            <p>
                O también puede acceder a tráves del siguiente código qr:
            </p>
            <br>
            <p class="text-center">
                <img src="data:image/svg+xml;base64,{{base64_encode($qr)}}" alt="">
            </p>
        @endif
        <p class="prop-horizontal text-center" style="height: 100px;">
            Este documento no es un comprobante fiscal.
        </p>
    </div>

</body>
</html>
