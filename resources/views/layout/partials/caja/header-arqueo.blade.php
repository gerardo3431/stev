<div class="header separador-bottom">
    <div>
        <table style="padding-top: 160px;">
            <thead>
                <th class="col-left">
                    Laboratorio 
                    <p>
                        {{$laboratorio->nombre}}
                    </p>
                </th>
                <th class="col-center">
                    Sucursal
                    <p>
                        {{$sucursal->sucursal}}
                    </p>
                </th>
                <th class="col-right">
                    @if (isset($cuenta))
                        Caja id 
                        <p>
                            {{$cuenta->id}}
                        </p>
                    @else
                        <p>
                            Fechas
                        </p> 
                    @endif
                </th>
            </thead>
        </table>
    </div>
</div>