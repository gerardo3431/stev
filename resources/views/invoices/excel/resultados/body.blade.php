@if ($estudios != null)
    @forelse ($estudios as $key=>$estudio)
        <table>
            <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th>
                        {{$estudio->descripcion}}
                    </th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
        </table>
        <table>
            <thead>
                <tr>
                    <th></th>
                    <th>Nombre</th>
                    <th>Resultado</th>
                    <th> % </th>
                    <th>Unidad</th>
                    <th>Referencia</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($estudio->analito as $analito)
                    <tr>
                        @foreach ($estudio->resultado as $resultado)
                            
                            @if($analito->clave == $resultado->clave)
                                @if($resultado->valor != null)
                                    <td></td>
                                    <td>
                                        @if ($analito->tipo_resultado == 'subtitulo')
                                            {{$analito->valor_referencia}}
                                        @elseif($analito->tipo_resultado == 'documento')
                                        @else
                                            {{$analito->descripcion}}
                                        @endif
                                    </td>
                                    <td >
                                        @if ($analito->tipo_resultado == 'imagen')
                                        @elseif($analito->tipo_resultado == 'documento')
                                        @elseif($analito->tipo_resultado == 'subtitulo')
                                        @elseif($analito->tipo_resultado == 'numerico')
                                            {{$resultado->valor}}
                                        @else
                                            {{$resultado->valor}}
                                        @endif
                                    </td >
                                    <td>
                                        @if ($resultado->valor_abs != null)
                                            {{$resultado->valor_abs}}
                                        @endif
                                    </td>
                                    <td>
                                        {{$analito->unidad}}
                                    </td>
                                    <td>
                                        @if ($analito->tipo_resultado == 'texto')
                                            {{$analito->valor_referencia}}
                                        @elseif ($analito->tipo_resultado == 'documento')
                                        @elseif ($analito->tipo_resultado == 'imagen')
                                        @elseif ($analito->tipo_resultado == 'numerico')
                                            {{$analito->numero_uno}} - {{$analito->numero_dos}}
                                        @elseif ($analito->tipo_resultado == 'referencia')
                                            {{$analito->referencia}}
                                        @else
                                        @endif
                                    </td>
                                @endif
                            @endif
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
        
    @empty
    @endforelse
@endif


