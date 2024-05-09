@php
    use Illuminate\Support\Facades\Storage;
@endphp
@isset($clave)
    @php
        $picture  = $folios->picture()->where('clave', $clave['clave'])->first();
    @endphp
    @foreach ($folios->deparment()->where('picture_id', '=', $picture->id)->get() as $area)
            <h2>{{$area->descripcion}}</h2>
            @forelse ($folios->picture()->where('deparments_id', '=', $area->id )->get() as $a => $estudio)
                <div class="invoice-content">
                    <div style="line-height: 0.5">
                        <h3>{{$estudio->descripcion}}</h3>
                    </div>

                    @foreach ($estudio->analitos()->get() as $b => $analito)
                        @foreach ($folios->historials_pictures()->where('picture_id', '=', $estudio->id)->orderBy('id', 'DESC')->get() as $c => $resultado)
                            <div class='content' style="font-size: 10px; overflow:hidden; ">
                                @if ($analito->clave == $resultado->clave && $resultado->valor !=null)
                                    @if($analito->tipo_resultado === 'imagen')
                                        @include('layout.partials.imagenologia.imagen')
                                    @elseif($analito->tipo_resultado === 'subtitulo')
                                            <div style="white-space: wrap">
                                                <?php echo "<span style='line-height: 0.6; font-size: 10px;'>". $analito->valor_captura ."</span>";?>
                                            </div>
                                        </tr>
                                    @endif
                                @endif
                            </div>

                            @if ($analito->clave == $resultado->clave && $resultado->valor !=null)
                                @if ($analito->tipo_resultado == 'documento')
                                    <div style="clear:both; margin-top:20px; white-space: pre-wrap; overflow:auto">
                                        <span>
                                            @php
                                                echo $resultado->valor;
                                            @endphp
                                        </span>
                                    </div>
                                @endif
                            @endif
                        @endforeach
                    @endforeach
                </div>
            @empty
                
            @endforelse
        @endforeach
@else
    @php
        $label = '';
    @endphp
    
    @forelse ($folios->picture()->where('estatus_area', 'validado')->get() as $a => $estudio)
        <div class="invoice-content">
            {{-- <h3>
                {{$area->descripcion}}
            </h3> --}}
            <div style="line-height: 0.5">
                <h3>{{$estudio->descripcion}}</h3>
            </div>

            @foreach ($estudio->analitos()->get() as $b => $analito)
                @foreach ($folios->historials_pictures()->where('picture_id', '=', $estudio->id)->orderBy('id', 'DESC')->get() as $c => $resultado)
                    <div class='content' style="font-size: 10px; overflow:hidden; ">
                        @if ($analito->clave == $resultado->clave && $resultado->valor !=null)
                            @if($analito->tipo_resultado === 'imagen')
                                @include('layout.partials.imagenologia.imagen')
                            @elseif($analito->tipo_resultado === 'subtitulo')
                                    <div style="white-space: wrap">
                                        <?php echo "<span style='line-height: 0.6; font-size: 10px;'>". $analito->valor_captura ."</span>";?>
                                    </div>
                                </tr>
                            @else
                                <div style="clear:both; margin-top:20px; white-space: pre-wrap; overflow:auto">
                                    <span>
                                        @php
                                            echo $resultado->valor;
                                        @endphp
                                    </span>
                                </div>
                            @endif
                        @endif
                    </div>

                @endforeach
            @endforeach
            @if ($a+1 !== $folios->picture()->where('estatus_area', 'validado')->count())
                <div class="break"></div>
            @endif
        </div>
    @empty
    @endforelse
@endisset
