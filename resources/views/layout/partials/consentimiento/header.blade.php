<div class="header">
    {{-- Data del laboratorio o empresa --}}
    <table>
        <tbody>
            <tr>
                <td class="col-left"  style="border-bottom: none; ">
                    @php
                        echo '<img src="data:image/png;base64, '. $logotipo .'" alt="" height="75" width="175">';
                    @endphp

                </td>
                <td class="col-center"  style="border-bottom: none; white-space: normal; font-size: 16px">
                    Laboratorios {{$laboratorio->nombre}}
                </td>
                <td class="col-right"  style="border-bottom: none; ">
                </td>
            </tr>
            
        </tbody>
    </table>
    {{-- Data del folio y paciente --}}
    <table >
        <tbody>
            <tr>
                <td class="col-left"  style="border-bottom: none; ">
                </td>
                <td class="col-center"  style="border-bottom: none; white-space: normal">
                    <strong>Carta De Consentimiento Informado</strong>
                    
                </td>
                <td class="col-right"  style="border-bottom: none; ">
                </td>
            </tr>
        </tbody>
    </table>
</div>

