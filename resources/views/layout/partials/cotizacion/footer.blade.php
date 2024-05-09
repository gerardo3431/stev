<div class="footer">
    <table style="line-height: 0.5;">
        <tr >
            <td class="col-left" style="border-bottom: none; line-height: 0.5;">
                <div style="font-size: 10px">
                    <strong>Total: </strong>  $ {{ $estudios->sum('precio')  }}.00
                </div>
                <br>
                <div style="font-size: 10px">
                    <strong>Observaciones: </strong> {{$observaciones['observaciones']}}
                </div>
            </td>
            <td class="col-center" style="border-bottom: none; line-height: 0.5;">
                
            </td>
            <td class="col-right" style="border-bottom: none; line-height: 0.5; text-align: center">
                <p class="page">Page </p>

                {{-- <p>
                    Q. F. B. {{$valido->name}}
                </p>
                <p>
                    Ced. Prof. {{$valido->cedula}}
                </p>
                <p>
                    Responsable sanitario / Head of health services
                </p> --}}
            </td>
        </tr>
        {{-- <tr>
            <td class="col-left" style="border-bottom: none;">
            </td>
            <td class="col-center" style="border-bottom: none; ">
            </td>
            <td class="col-right" style="border-bottom: none; text-align: right">
            </td>
        </tr> --}}
    </table>
    <br>
    <br>
</div>
{{-- border-bottom: 1px solid #ddd; --}}
{{-- Resultado fuera de rango de referencia Alto
Resultado fuera de rango de referencia Bajo --}}
