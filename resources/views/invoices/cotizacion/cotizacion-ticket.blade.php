
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
            <strong>Fecha: </strong> {{ date('m-d-Y h:i:s a', time()) }}
        </p>
        <p>
            <strong>Cliente: </strong> {{ $paciente['nombre'] }}
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
        <h3>Total:    $ {{ $estudios->sum('precio')  }}.00</h3>
        <p class="text-justify">
            {{$observaciones['observaciones']}}
        </p>
        
        <p class="prop-horizontal text-center" style="height: 100px;">
            Este documento no es un comprobante fiscal.
        </p>
    </div>

</body>
</html>
