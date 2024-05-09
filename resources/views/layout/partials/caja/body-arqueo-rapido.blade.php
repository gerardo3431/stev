<div class="invoice-content break">

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
            <tr>
                <td >
                    <p>
                        {{$cuenta->id}}
                    </p>
                </td>
                <td >
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
                        ${{$cuenta->retiros}}
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
    

    <h2>Entradas</h2>

    <table>
        <thead>
            <tr>
                <th >
                    <p>
                        Efectivo
                    </p>
                </th>
                <th >
                    <p>
                        Tarjeta
                    </p>
                </th>
                <th >
                    <p>
                        Transferencia
                    </p>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td >
                    <p>
                        $ {{$cuenta->ventas_efectivo}}
                    </p>
                </td>
                <td >
                    <p>
                        $ {{$cuenta->ventas_tarjeta}}
                    </p>
                </td>
                <td >
                    <p>
                        $ {{$cuenta->ventas_transferencia}}
                    </p>
                </td>
            </tr>
        </tbody>
    </table>

    <h2>Salidas</h2>
    
    <table>
        <thead>
            <tr>
                <th >
                    <p>
                        Efectivo
                    </p>
                </th>
                <th >
                    <p>
                        Tarjeta
                    </p>
                </th>
                <th >
                    <p>
                        Transferencia
                    </p>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td >
                    <p>
                        $ {{$cuenta->salidas_efectivo}}
                    </p>
                </td>
                <td >
                    <p>
                        $ {{$cuenta->salidas_tarjeta}}
                    </p>
                </td>
                <td >
                    <p>
                        $ {{$cuenta->salidas_transferencia}}
                    </p>
                </td>
            </tr>
        </tbody>
    </table>
</div>