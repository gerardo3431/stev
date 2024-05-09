<div class="invoice-content break">
    {{-- <div>
        <h2>Estudios solicitados</h2>
    </div> --}}
    <table class="result ">
        <thead>
            <tr>
                <th class="col-one">Clave</th>
                <th class="col-two">Nombre</th>
                <th class="col-three">Fecha de entrega</th>
                <th class="col-four">Precio</th>
            </tr>
        </thead>
        <tbody>
            @php
                $count = 1;
            @endphp
            @forelse ($estudios as $a => $estudio)
                <tr>
                    <td class="col-one">{{$estudio->clave}}</td>
                    <td class="col-two">{{$estudio->descripcion}}</td>
                    <td class="col-three">
                        @php
                            $estudie  = DB::table('estudios')->where('clave', $estudio['clave'])->first();
                        @endphp
                        @if ($estudio->tipo === 'Estudio')
                            {{ $estudie->dias_proceso}} días después.    
                        @else
                            Lo que indique el estudio.      
                        @endif
                    </td>
                    <td class="col-four">$ {{$estudio->precio}}</td>
                </tr>
                @php
                    $count ++;
                @endphp
            @empty
            @endforelse
        </tbody>
    </table>
</div>