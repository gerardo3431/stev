<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Cotizacion</title>

<style>
  html{
    margin: 1px;
  }
  body{
    background-position: center center;  */
		background-attachment: fixed; 
		background-size: 796px 561px; 
		/* width: 780px; */
		/* object-fit: contain; */
		opacity: 0.9;
		background-color: #f8f9fa;
		color: #272b41;
		font-family: "Poppins",sans-serif;
		font-size: 0.9375rem;
		height: 100%;
		overflow-x: hidden;
  }
  table,td  {
    text-align: center;
		border: 1px solid #000;
    border-collapse: collapse;
		/* Alto de las celdas */
		height: 30px;
		font-size: 12px;
    width: 80%;
    margin: 0 auto; 
    
		}
    img{
      position: relative;
    top: 20px; /* ajustar los valores para mover la imagen */
      margin-left: 510px;
      width: 33%;



    }
    .lab,p{
      position: absolute; top: 0px; left: 30%;
      text-align: center;

    }
    
</style>

</head>
<body>

  <div>
     {{-- <img style="margin-right: 10px;" src="../public/storage/{{$empresa['empresa']}}" alt="">  --}}
  </div>
  
  <div class="lab">
    <P><b> LABORATORIO IXTLAHUACA </b> <br>
      VICENTE GUERRERO 102, IXTLAHUACA CENTRO, MEXICO <br>
      Tel: 54578411 Email:lab_cemi102@hotamil.com</P>
  </div>
<br><br><br>
<div>
  <label for="">Paciente: </label>{{$nombre['nombre']}}<br>
</div>
<br>

<table>
  <thead>
    <tr>
      <th>Clave</th>
      <th>Descripcion</th>
      <th>Costo</th>
      <th>Dias</th>
      <th>Condiciones</th>
      
    </tr>
  </thead>

  <tbody>
    @forelse ($estudios as $estudio)
    <tr>
      <td style="width: 13%; text-align: center;">{{$estudio->clave}}</td>
      <td style="width: 60%; text-align: left;">{{$estudio->descripcion}}</td>
      <td style="width: 13%; text-align: center;">${{$estudio->precio}}</td>
      <td style="width: 5%; text-align: center;">{{$estudio->dias_proceso}}</td>
      <td>{{$estudio->condiciones}}</td>
    </tr>
    @empty

    @endforelse
  </tbody>
</table>
<br>
<label for="">Total: </label>{{$total['total']}}<br>
<label for="">Observaciones: </label>{{$observacion['observaciones']}}




</body>
</html>