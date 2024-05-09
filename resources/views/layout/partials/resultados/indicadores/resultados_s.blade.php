@switch($analito->tipo_resultado)
    @case('documento')
        <tr>
            <td colspan="6" style="white-space: wrap">
                <?php echo "<span style='line-height: 0.6; font-size: 10px;'>". $analito->valor_captura ."</span>";?>
            </td>
        </tr>
    @break

    @case('imagen')
    
        <tr>
            <td colspan="6" style="white-space: wrap">
                @if ($analito->valor_captura != null)
                    @php
                        $data = base64_encode(Storage::disk('public')->get($analito->valor_captura));
                        echo '<img src="data:image/png;base64,' . $data . '" height="200" width="200">';
                    @endphp
                @endif
            </td>
        </tr>
    @break

    @case('subtitulo')
        <tr>
            <td colspan="6" style="white-space: wrap">
                <h4>
                    {{ $analito->descripcion }}
                </h4>
            </td>
        </tr>
    @break
    @default
        
@endswitch