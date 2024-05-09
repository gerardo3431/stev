<div class="invoice-content">
    @forelse ($folios as $a => $folio)
        @php
            $check = $folio->estudios->isEmpty();
        @endphp
        @if ($check != true)
            <h2 style="">Fecha {{ $folio->created_at}}</h2>
            <table>
                <tr>
                    <td class="col-left">
                        <p>
                            <?php 
                                $barcode =  DNS1D::getBarcodeSVG($folio->folio, 'C128', 1.20, 35, 'black' , false); 
                                echo '<img src="data:image/svg+xml;base64,'.base64_encode($barcode).'" />'
                            ?>
                        </p>
                        <p>
                            <strong>Folio: </strong>
                            {{$folio->folio}}
                        </p>
                        
                    </td>
                    <td class="col-center">
                        
                        <p>
                            <strong>Paciente: </strong>
                            {{$folio->paciente()->first()->nombre}}
                        </p>
                        <p>
                            <strong>Edad: </strong>
                            {{$folio->paciente()->first()->getAge()}} año(s)
                        </p>
                        <p>
                            <strong>Sexo: </strong>
                            {{$folio->paciente()->first()->sexo}}
                        </p>
                    </td>
                    <td class="col-right">
                        <p>
                            <strong>Sucursal: </strong>
                            {{$folio->sucursales()->first()->sucursal}}
                        </p>
                        <p>
                            <strong>Fecha:</strong>
                            {{$folio->f_flebotomia }}
                        </p>
                        <p>
                            <strong>Hora: </strong>
                            {{$folio->h_flebotomia}}
                        </p>
                    </td>
                </tr>
            </table>
            <table width="100%">
                <tbody>
                    @php
                        $contador =  optional($folio->allEstudio)->count(); 
                        $i = 1 ;
                    @endphp
                    @forelse ($folio->estudios as $key => $estudio)
                        {{-- @dd($estudio); --}}
                            {{-- {{$estudio->clave }} - {{$estudio->descripcion}} <br> --}}
                        @php
                            $analitos = $estudio->analitos()->orderBy('orden', 'asc')->get();
                        @endphp
                            @if ( ( $i % 2 ) == 0)
                            <td>
                                <table style="font-size: 11px;">
                                    <thead>
                                        <tr>
                                            <td colspan="2"> 
                                                <h3> {{ $estudio->clave}} - {{$estudio->descripcion}}</h3>
                                            </td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($analitos as $c=> $analito)
                                            <tr>
                                                <td>
                                                    @if ($analito->tipo_resultado != 'subtitulo')
                                                        {{$analito->descripcion}}
                                                    @else
                                                        <strong>{{$analito->descripcion}}</strong>
                                                    @endif
                                                </td>
                                                <td>
                                                    __________
                                                </td>
                                            </tr>
                                        @empty
                                        @endforelse
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                            @else
                        <tr>
                            <td>
                                <table style="font-size: 11px;">
                                    <thead>
                                        <tr>
                                            <td colspan="2"> <h3>{{$estudio->descripcion}}</h3></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($analitos as $c=> $analito)
                                            <tr>
                                                <td>
                                                    @if ($analito->tipo_resultado != 'subtitulo')
                                                        {{$analito->descripcion}}
                                                    @else
                                                        <strong>{{$analito->descripcion}}</strong>
                                                    @endif
                                                </td>
                                                <td>
                                                    __________
                                                </td>
                                            </tr>
                                        @empty
                                        @endforelse
                                    </tbody>
                                </table>
                            </td>
                            @endif

                            <?php
                                $i++; 
                                if(($i % 2) != 0 && $i == $contador){
                                    echo "</tr>";
                                }
                            ?>
                    @empty
                    @endforelse
                </tbody>
            </table>
        @endif
        <br>
        <br>
        <br>
    @empty
    @endforelse
</div>