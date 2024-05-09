@php
    $suma = 0;
@endphp
<div class="footer"  style="width: 100%">
    <table>
        <tbody>
            <tr>
                <td>
                    <strong>Subtotal</strong>
                    $ {{ $estudios->sum('precio')}}

                    <strong>Descuento</strong>
                    $ {{$folios->descuento}}
                    
                    <strong>Total</strong>  
                    $ {{$estudios->sum('precio') - $folios->descuento}}

                    <strong>Pago</strong>
                    $ {{$pago->importe}}

                    <strong>Pago pendiente</strong>
                    $ {{($estudios->sum('precio') - $folios->pago()->sum('importe')) - $folios->descuento}}
                    {{-- @php
                        dd($estudios->sum('precio'), $folios->pago()->sum('importe'), $folios->descuento);
                    @endphp --}}

                    <strong>Metodo de pago</strong>
                    {{$pago->metodo_pago}}

                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td class='columna-dos' style="text-align: justify; vertical-align:top; line-heigth: 1; " >
                    <p style="font-size: 7px;">
                        Autorizo a {{$laboratorio->nombre}} realice los estudios solicitados, conociendo los requisitos para la realizacion y riesgos del procedimiento de la toma de muestra: Hematoma, Desmayo, Repeticion de la toma, Solicitud de nueva muestra. 
                        Acepto la responsabilidad al otorgar la concesion para realizar los estudios en caso de no cumplir con los requisitos. El Laboratorio Clinico se compromete a la confidencialidad de la informacion solicitada, excepto en los casos indicados por las autoriades competentes.
                        
                        {{-- Laboratorio de análisis clínicos KUXTAL --}}
                        {{-- Los resultados serán entregados según lo acordado anteriormente. Por confidencialidad solo serán entregados al paciente o persona autorizada por él, presentando este comprobante de pago. 
                        Este recibo contiene información privada, MANTENGALO EN RESGUARDO. <br>
                        <strong> CONSENTIMIENTO INFORMADO: </strong> Autorizo al flebotomista en turno {{$laboratorio->nombre}}  para que en busca de mi bienestar y salud realicen en mi persona una toma de 
                        muestra biológica para el análisis de los estudios mencionados en este comprobante; comprendo que dicho procedimiento puede tener los siguientes riesgos y beneficios durante la toma de 
                        muestra. RIESGOS: hematomas, ligeros sangrados, desmayos, repeticiones de toma y solicitud de nueva muestra, la cantidad de sangre a extraer será criterio del flebotomista. BENEFICIOS: ayuda 
                        al diagnóstico de un problema de salud. Me comprometo a cumplir las indicaciones, recomendaciones y cuidados necesarios que se me ha informado después del procedimiento y me hago 
                        responsable de las consecuencias por mi incumplimiento de éstas. El Laboratorio clínico, se compromete a mantener la confidencialidad de toda la información relacionada con los resultados de 
                        los análisis realizados a excepción de los casos indicados por las autoridades competentes. En cumplimiento de la Norma Oficial Mexicana NOM 007-SSA3-2011, se informará a la secretaria de salud 
                        los casos de positivos de enfermedades transmisibles y de notificación obligatoria establecidos por dicha dependencia. En caso de menores de edad, o personas con discapacidad, se informó y 
                        autoriza el familiar de la o él paciente. {{$laboratorio->nombre}}  le informa que algunos exámenes podrán ser procesados en otros laboratorios (Nacionales e internacionales) con 
                        un sistema de gestión de calidad implementado, esto dependiendo de las necesidades del laboratorio. --}}
                    </p>
                </td>
                <td>
                    <td class="columna-una" style="border-bottom: none; text-align: justify; text-justify: inter-word;">
                        @if (auth()->user()->first()->labs()->first()->paquete()->first()->paquete == 'completo')
                            @php
                                echo '<img src="data:image/svg+xml;base64,'.base64_encode($qr).'"/>';
                            @endphp
                        @endif
                    </td>
                </td>
            </tr>
        </tfoot>
    </table>
    
</div>
