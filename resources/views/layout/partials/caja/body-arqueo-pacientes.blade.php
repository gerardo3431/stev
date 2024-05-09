@php
    $new_folios = [];
    // $new_folio = array_map("unserialize", array_unique(array_map("serialize", $folios)));
    // foreach($folios as $indice => $elemento) {
    //     if (!in_array($elemento, $new_folios)) {
    //         $new_folios[] = $elemento;
    //     }
    // }
    // foreach($folios as $indice => $elemento) {
    //     if (!in_array($elemento->folio, $new_folios)) {
    //         $new_folios[] = $elemento->folio;
    //     }
    // }

@endphp
<div class="invoice-content">
    <div style="line-height: 0.5">
    </div>
    <table class="result ">
        <thead>
            <tr>
                <th>Folio</th>
                <th>Paciente</th>
                <th>Medico</th>
                <th>Empresa</th>
                <th>Monto</th>
                <th>Anticipo</th>
                <th>Adeudo</th>
                <th>Descuento</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach($folios as $indice => $folio) {
                    if (!in_array($folio->folio, $new_folios)) {
                        $new_folios[] = $folio->folio;
            ?>
                        <tr>
                            <td>{{$folio->folio}}</td>
                            <td><p>
                                {{$folio->paciente()->first()->nombre}}
                                </p>
                            </td>
                            <td>
                                <p>
                                    {{$folio->doctores()->first()->nombre}}
                                </p>
                            </td>
                            <td>
                                <p>
                                    {{$folio->empresas()->first()->descripcion}}
                                </p>
                            </td>
                            <td>
                                <p>
                                    @php
                                        $suma = 0;

                                        if($folio->empresas()->first()->precio()->first()){
                                            $estudios = $folio->estudios()->get();
                                            $precios = $folio->empresas()->first()->precio()->first()->lista()->get();
                                            foreach ($estudios as $e => $estudio) {
                                                foreach ($precios as $key => $precio) {
                                                    if($estudio->clave == $precio->clave){
                                                        $suma = $suma + $precio->precio;
                                                    }
                                                }
                                            }
                                            // echo '$ ' . $suma;
                                        }else{
                                            $estudios = $folio->estudios()->get()->sum('importe');
                                            $suma = $suma + $estudios;
                                        }

                                        if($folio->empresas()->first()->precio()->first()){
                                            $perfiles = $folio->recepcion_profiles()->get();
                                            $precios = $folio->empresas()->first()->precio()->first()->lista()->get();
                                            foreach ($perfiles as $e => $perfil) {
                                                foreach ($precios as $key => $precio) {
                                                    if($perfil->clave == $precio->clave){
                                                        $suma = $suma + $precio->precio;
                                                    }
                                                }
                                            }
                                            // echo '$ ' . $suma;
                                        }else{
                                            $perfiles = $folio->recepcion_profiles()->get()->sum('importe');
                                            $suma = $suma + $perfiles;
                                        }
                                        echo "$ " . $suma;
                                    @endphp
                                </p>
                            </td>
                            <td>
                                <p>
                                    @php
                                        if($folio->pago()->count() == 1 && $folio->estado == 'no pagado' ){
                                            echo '$ ' . $folio->pago()->first()->importe;
                                        }else{
                                            // echo '$ ' .  $folio->pago()->first()->importe;
                                            echo '$ 0 ';
                                        }
                                    @endphp
                                </p>
                            </td>
                            <td>
                                <p>
                                    @php
                                        if($folio->estado == 'pagado'){
                                            // echo $suma - $folio->pago()->first()->importe;

                                            echo '$ 0';
                                        }else{
                                            // echo $folio->pago()->first()->importe;
                                            if($folio->pago()->first() == null){
                                                echo '$ 0';
                                            }else {
                                                # code...
                                                echo $suma - $folio->pago()->first()->importe;
                                            }
                                        }
                                    @endphp
                                </p>
                            </td>
                            {{-- <td>{{(isset($folio->pago()->first()->tipo_movimiento)) ? $folio->pago()->first()->tipo_movimiento : 'undefined'}}</td> --}}
                            <td>
                                <p>
                                    $ {{ $folio->descuento}}
                                </p>
                            </td>
                            {{-- <td>{{$folio->estado}}</td> --}}
                            <td>
                                <p>
                                    {{$folio->estado}}
                                </p>
                            </td>
                        </tr>
            <?php
                    }
                }
            ?>
        </tbody>
    </table>

    {{-- Segunda página --}}
    {{-- <p class="break"></p> --}}

</div>