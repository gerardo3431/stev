<div class="invoice-content break">

    <h2>Detalle</h2>

    <table>
        <thead>
            <tr>
                <th >
                    <p>
                        Caja id
                    </p>
                </th>
                <th >
                    <p>
                        Monto de apertura
                    </p>
                </th>
                <th >
                    <p>
                        Entradas totales
                    </p>
                </th>
                <th >
                    <p>
                        Salidas totales
                    </p>
                </th>
                <th>
                    <p>
                        Retiros
                    </p>
                </th>
                <th >
                    <p>
                        Saldo total en caja
                    </p>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td >
                    <p>
                        {{$cuenta->id}}
                    </p>
                </td>
                <td>
                    <p>
                        $ {{$cuenta->apertura}}
                    </p>
                </td>
                <td >
                    <p>
                        $ {{$cuenta->entradas}}
                    </p>
                </td>
                <td >
                    <p>
                        $ {{$cuenta->salidas}}
                    </p>
                </td>
                <td>
                    <p>
                        $ {{$cuenta->retiros}}
                    </p>
                </td>
                <td >
                    <p>
                        $ {{$cuenta->total}}
                    </p>
                </td>
            </tr>
        </tbody>
    </table>
    <h2>Movimientos</h2>
    <table>
        <thead>
            <tr>
                <th >
                    <p>
                        Descripcion
                    </p>
                </th>
                <th >
                    <p>
                        Importe
                    </p>
                </th>
                <th >
                    <p>
                        Tipo movimiento
                    </p>
                </th>
                <th>
                    <p>
                        Metodo pago
                    </p>
                </th>
                <th>
                    <p>
                        Empresa
                    </p>
                </th>
                <th>
                    <p>
                        Fecha
                    </p>
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($movimientos as $movimiento)
                @if ($movimiento->importe != 0)
                    <tr>
                        <td >
                            <p>
                                @php
                                    if($movimiento->folio()->first()){
                                        echo  $movimiento->folio()->first()->paciente->first() ? $movimiento->folio()->first()->paciente()->first()->nombre : 'Sin paciente';
                                    }else{
                                        $movimiento->descripcion;
                                    }
                                @endphp
                            </p>
                        </td>
                        <td >
                            <p>
                                {{$movimiento->importe}}
                            </p>
                        </td>
                        <td >
                            <p>
                                {{$movimiento->tipo_movimiento}}
                            </p>
                        </td>
                        <td >
                            <p>
                                {{$movimiento->metodo_pago}}
                            </p>
                        </td>
                        <td >
                            <p>
                                {{($movimiento->folio()->first()) ? $movimiento->folio()->first()->empresas()->first()->descripcion : ''}}
                            </p>
                        </td>
                        <td>
                            <p>
                                {{$movimiento->created_at}}
                            </p>
                        </td>
                    </tr>
                @endif
            @empty
                <tr>
                    <td>
                        No hay datos disponibles.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>