@switch($analito->tipo_resultado)
    @case('texto')
        <?php echo $analito->valor_referencia; ?>    
        @break

    @case('numerico')
        {{$analito->numero_uno}} - {{$analito->numero_dos}}
        @break

    @case('referencia')
        @php
            $referencia = $analito->referencia;
        @endphp
        @if ($referencia !== null)
            <strong> {{ $referencia->referencia_inicial }} - {{ $referencia->referencia_final }} </strong>        
        @endif
    @break

    @default
        {{$analito->tipo_resultado}}
@endswitch