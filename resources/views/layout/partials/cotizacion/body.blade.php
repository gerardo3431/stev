
<div class="invoice-content break">
    {{-- <div>
        <h2>Estudios solicitados</h2>
    </div> --}}
    <table>
        <thead>
            <tr>
                <th class="col-one" >
                    {{strtoupper('clave')}}
                </th>
                <th class="col-two" >
                    {{strtoupper('descripcion')}}
                </th>
                <th class="col-three" >
                    {{strtoupper('costo')}}
                </th>
                <th class="col-four" >
                    {{strtoupper('dias')}}
                </th>
                <th class="col-five" >
                    {{strtoupper('condiciones')}}
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($estudios as $estudio)
                <tr>
                    <td class="col-one">{{$estudio->clave}}</td>
                    <td class="col-two">{{$estudio->descripcion}}</td>
                    <td class="col-three">$ {{$estudio->precio}}.00</td>
                    <td class="col-four">{{$estudio->dias_proceso}}</td>
                    <td class="col-five">{{$estudio->condiciones}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
</div>