<div class="invoice-content break">
    @php
        $apertura = 0;
        $retiros = 0;
        $entrada = 0;
        $salida = 0;
        $total = 0;
    @endphp
    <h2>Detalle</h2>

    <table>
        <thead>
            <tr>
                <th>
                    <p>
                        Caja id
                    </p>
                </th>
                <th>
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
                        Retiros totales
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
            
            @forelse ($cajas as $caja)
                @php
                    $apertura   = $apertura + $caja->apertura;
                    $entrada    = $entrada + $caja->entradas;
                    $salida     = $salida + $caja->salidas;
                    $retiros    = $retiros + $caja->retiros;
                    $total      = $total + $caja->total;
                @endphp
            @empty
            @endforelse
            <tr>
                <td>
                    <p>
                        All cajas
                    </p>
                </td>
                <td >
                    <p>
                        $ {{$apertura}}
                    </p>
                </td>
                <td >
                    <p>
                        $ {{$entrada}}
                    </p>
                </td>
                <td>
                    <p>
                        $ {{$salida}}
                    </p>
                </td>
                <td>
                    <p>
                        $ {{$retiros}}
                    </p>
                </td>
                <td>
                    <p>
                        $ {{$total}}
                    </p>
                </td>
            </tr>
        </tbody>
    </table>

    <h2>Movimientos</h2>

    <table>
        <thead>
            <tr>
                <th>
                    <p>
                        Descripcion
                    </p>
                </th>
                <th>
                    <p>
                        Importe
                    </p>
                </th>
                <th>
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
            @forelse ($cajas as $caja)
                @php
                    $movimientos = $caja->pagos()->get();
                @endphp
                @forelse ($movimientos as $movimiento)
                    @if ($movimiento->importe != 0)
                        <tr>
                            <td >
                                <p>
                                    {{($movimiento->folio()->first()) ? $movimiento->folio()->first()->paciente()->first()->nombre : $movimiento->descripcion}}
                                </p>
                            </td>
                            <td >
                                <p>
                                    $ {{$movimiento->importe}}
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
                @endforelse
            @empty
            @endforelse
        </tbody>
    </table>

    <h2>Cajas totales</h2>
    <table>
        <thead>
            <tr>
                <th>
                    <p>
                        #
                    </p>
                </th>
                <th>
                    <p>
                        Apertura
                    </p>
                </th>
                <th>
                    <p>
                        Entradas
                    </p>
                </th>
                <th >
                    <p>
                        Salidas
                    </p>
                </th>
                <th >
                    <p>
                        Efectivo
                    </p>
                </th>
                <th>
                    <p>
                        Tarjeta
                    </p>
                </th>
                <th>
                    <p>
                        Transferencia
                    </p>
                </th>
                <th>
                    Total
                    <p

                    <p>
                </th>
                <th>
                    <p>
                        Estatus
                    </p>
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($cajas as $caja)
                <tr>
                    <td>
                        <p>
                            {{$caja->id}}
                        </p>
                    </td>
                    <td>
                        <p>
                            $ {{$caja->apertura}}
                        </p>
                    </td>
                    <td>
                        <p>
                            $ {{$caja->entradas}}
                        </p>
                    </td>
                    <td>
                        <p>
                            $ {{$caja->salidas}}
                        </p>
                    </td>
                    <td>
                        <p>
                            $ {{$caja->ventas_efectivo}}
                        </p>
                    </td>
                    <td>
                        <p>
                            $ {{$caja->ventas_tarjeta}}
                        </p>
                    </td>
                    <td>
                        <p>
                            $ {{$caja->ventas_transferencia}}
                        </p>
                    </td>
                    <td>
                        <p>
                            $ {{$caja->total}}
                        </p>
                    </td>
                    <td>
                        <p>
                            {{$caja->estatus}}
                        </p>
                    </td>
                </tr>
            @empty
            @endforelse
        </tbody>
    </table>
</div>