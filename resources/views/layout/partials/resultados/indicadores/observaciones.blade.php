
@if ($estudio->metodo()->first()->descripcion  !== 'No asignado')
    <div style="font-size: 10px">
        <strong>Método: </strong>{{$estudio->metodo()->first()->descripcion}}
    </div>
@endif
<div style="font-size: 10px">
    <strong>Muestra: </strong>{{$estudio->muestra()->first()->descripcion}}
</div>
@if ($estudio->observaciones !== 'Sin observaciones' || $estudio->observaciones !== null || $estudio->observaciones !== '')
    <div style="font-size: 10px">
        <strong>Observaciones: </strong> 
        {{$estudio->observaciones}}
    </div>
@endif