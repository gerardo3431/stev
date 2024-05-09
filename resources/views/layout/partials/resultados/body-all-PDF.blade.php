@if($resultados !== null)
    @php
        $totalAreas = count($resultados);
        $contadorArea = 1;
    @endphp
    @forelse ($resultados as $keyArea => $estudios)
        
        <div class="invoice-content">
            {{-- <h3 class="area"> >{{$keyArea}}</h3> --}}
            @include('layout.partials.resultados.indicadores.cuerpo_resultados')
        </div>
    @empty
    @endforelse
@endif
{{-- 
@if ($resultados !== null && $perfiles !== null)
    <div class="break"></div>
@endif --}}

@if($perfiles !== null)
    @forelse ($perfiles as $keyPerfil => $perfil)
        <div class="invoice-content">
            <h1>{{$perfil->descripcion}}</h1>
            @php
                $totalAreas = count($perfil->estudios);
                $contadorArea = 1;
            @endphp
            @foreach ($perfil->estudios as $keyArea => $estudios)
                
                {{-- <h3 class="area"> >{{$keyArea}}</h3> --}}
                @include('layout.partials.resultados.indicadores.cuerpo_resultados')
            @endforeach
        </div>
    @empty
    @endforelse
@endif