
<div class="invoice-content break">
    <div>
        <h2>Estudios solicitados</h2>
    </div>
    <table>
        <thead>
            <tr>
                <th class="columna-dos" >
                    Clave
                </th>
                <th class="columna-una" >
                    Descripción
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
                if(isset($estudios)){
            ?>
                @forelse ($estudios as $a=> $estudio)
                    <tr>
                        <td class="columna-dos" >
                            {{$estudio->clave}}
                        </td>
                        <td class="columna-una" >
                            {{$estudio->descripcion}}

                        </td>
                    </tr>
                @empty
                @endforelse
            <?php
                }else{
            ?>
                @forelse ($perfiles as $b=> $perfil)
                    <tr>
                        <td class="columna-dos" >
                            {{$perfil->clave}}
                        </td>
                        <td class="columna-una" >
                            {{$estudio->descripcion}}

                        </td>
                    </tr>
                @empty
                @endforelse
            <?php
                }
            ?>

        </tbody>
    </table>
</div>