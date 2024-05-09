@component('mail::message')
# Buen día {{$paciente->nombre}} {{$paciente->ap_paterno}} {{$paciente->ap_materno}}

Laboratorio **{{$laboratorio->nombre}}** le envia sus resultados de estudio.


Gracias por usar,<br>
**{{ config('app.name') }}** <br>
@component('mail::panel')
Si tiene algún problema para visualizar o descargar el archivo pdf, por favor copie y pegue en su navegador el enlace a continuación: **{{$pdf}}**
@endcomponent
@endcomponent
