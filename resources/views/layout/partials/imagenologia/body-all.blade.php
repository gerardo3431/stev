@php
    use Illuminate\Support\Facades\Storage;
@endphp
@isset($clave)
    @php
        $picture  = $folios->picture()->where('clave', $clave['clave'])->first();
    @endphp
    @foreach ($folios->deparment()->where('picture_id', '=', $picture->id)->get() as $area)
            <h2>{{$area->descripcion}}</h2>
            @forelse ($folios->picture()->where('deparments_id', '=', $area->id )->get() as $a => $estudio)
                <div class="invoice-content">
                    <div style="line-height: 0.5">
                        <h3>{{$estudio->descripcion}}</h3>
                    </div>

                    @foreach ($estudio->analitos()->get() as $b => $analito)
                        @foreach ($folios->historials_pictures()->where('picture_id', '=', $estudio->id)->orderBy('id', 'DESC')->get() as $c => $resultado)
                            <div class='content' style="font-size: 10px; overflow:hidden; ">
                                @if ($analito->clave == $resultado->clave && $resultado->valor !=null)
                                    @if($analito->tipo_resultado == 'imagen')
                                        @php
                                            $zipper = new \Madnest\Madzipper\Madzipper;
                                            // Obtener el contenido del archivo ZIP como una cadena
                                            $zipContent = $resultado->valor;
                                            $tempZip  ='public/storage/temp';

                                            $zipper->make($zipContent)->folder('prueba')->extractTo($tempZip);
                                            $files  = Storage::disk('public')->files('temp');
                                            $count  = count($files);

                                            if($count > 2){
                                                foreach ($files as $key => $file) {
                                                    $filename = basename($file);
                                                    $data = base64_encode(Storage::disk('public')->get($file));
                                                    $prop = (($key + 1) % 2 != 0) ? 'float:left' : '';
                                                    
                                                    echo "<img src='data:image/png;base64,". $data . "' style=' margin-top: 120px; height: 280px; max-height:300px; width:300px; max-width:280px; margin: 5px; margin-top:0;  padding:0; border: none; '>";
                                                }
                                            }else{
                                                foreach ($files as $file) {
                                                    $filename = basename($file);
                                                    $data = base64_encode(Storage::disk('public')->get($file));
                                                    echo "<img src='data:image/png;base64,". $data . "' height='575px' width='575px' style='margin:5px;  margin-top:0;  padding:0; border: none; margin: 5px; '>";
                                                }
                                            }

                                            foreach ($files as $file) {
                                                if ($tempZip == '.' || $tempZip == '..') {
                                                    continue;
                                                }
                                                if (is_dir($tempZip . '/' . basename($file) )) {
                                                    deleteDirectory($tempZip . '/' . basename($file));
                                                } else {
                                                    unlink($tempZip . '/' . basename($file));
                                                }
                                            }

                                            // Verificar que la carpeta está vacía
                                            if (count(scandir($tempZip)) == 2) {
                                            // echo "La carpeta se ha limpiado exitosamente";
                                            } else {
                                            // echo "No se pudo limpiar la carpeta";
                                            }

                                        @endphp
                                    @endif
                                @endif
                            </div>

                            @if ($analito->clave == $resultado->clave && $resultado->valor !=null)
                                @if ($analito->tipo_resultado == 'documento')
                                    <div style="clear:both; margin-top:20px; white-space: pre-wrap; overflow:auto">
                                        <span>
                                            @php
                                                echo $resultado->valor;
                                            @endphp
                                        </span>
                                    </div>
                                @endif
                            @endif
                        @endforeach
                    @endforeach
                </div>
            @empty
                
            @endforelse
        @endforeach
@else
    @php
        $label = '';
    @endphp
    @foreach ($folios->deparment()->get() as $area)
    {{-- @dd($area) --}}
        @php
            $label = $area->descripcion
        @endphp
        @forelse ($folios->picture()->get() as $a => $estudio)
            @if ($area->descripcion == $estudio->deparment()->first()->descripcion)
                    <div class="invoice-content">
                        <h3>
                            {{$area->descripcion}}
                        </h3>
                    <div style="line-height: 0.5">
                        <h3>{{$estudio->descripcion}}</h3>
                    </div>

                    @foreach ($estudio->analitos()->get() as $b => $analito)
                        @foreach ($folios->historials_pictures()->where('picture_id', '=', $estudio->id)->orderBy('id', 'DESC')->get() as $c => $resultado)
                            <div class='content' style="font-size: 10px; overflow:hidden; ">
                                @if ($analito->clave == $resultado->clave && $resultado->valor !=null)
                                    @if($analito->tipo_resultado == 'imagen')
                                        @php
                                            $zipper = new \Madnest\Madzipper\Madzipper;
                                            // Obtener el contenido del archivo ZIP como una cadena
                                            $zipContent = $resultado->valor;
                                            $tempZip  ='public/storage/temp';
    
                                            $zipper->make($zipContent)->folder('prueba')->extractTo($tempZip);
                                            $files  = Storage::disk('public')->files('temp');
                                            $count  = count($files);
    
                                            if($count > 2){
                                                foreach ($files as $key => $file) {
                                                    $filename = basename($file);
                                                    $data = base64_encode(Storage::disk('public')->get($file));
                                                    $prop = (($key + 1) % 2 != 0) ? 'float:left' : '';
                                                    
                                                    echo "<img src='data:image/png;base64,". $data . "' style=' margin-top: 120px; height: 280px; max-height:300px; width:300px; max-width:280px; margin: 5px; margin-top:0;  padding:0; border: none; '>";
                                                }
                                            }else{
                                                foreach ($files as $file) {
                                                    $filename = basename($file);
                                                    $data = base64_encode(Storage::disk('public')->get($file));
                                                    echo "<img src='data:image/png;base64,". $data . "' height='575px' width='575px' style='margin:5px;  margin-top:0;  padding:0; border: none; margin: 5px; '>";
                                                }
                                            }
    
                                            foreach ($files as $file) {
                                                if ($tempZip == '.' || $tempZip == '..') {
                                                    continue;
                                                }
                                                if (is_dir($tempZip . '/' . basename($file) )) {
                                                    deleteDirectory($tempZip . '/' . basename($file));
                                                } else {
                                                    unlink($tempZip . '/' . basename($file));
                                                }
                                            }
    
                                            // Verificar que la carpeta está vacía
                                            if (count(scandir($tempZip)) == 2) {
                                            // echo "La carpeta se ha limpiado exitosamente";
                                            } else {
                                            // echo "No se pudo limpiar la carpeta";
                                            }
    
                                        @endphp
                                    @endif
                                @endif
                            </div>

                            @if ($analito->clave == $resultado->clave && $resultado->valor !=null)
                                @if ($analito->tipo_resultado == 'documento')
                                    <div style="clear:both; margin-top:20px; white-space: pre-wrap; overflow:auto">
                                        <span>
                                            @php
                                                echo $resultado->valor;
                                            @endphp
                                        </span>
                                    </div>
                                @endif
                            @endif
                        @endforeach
                    @endforeach
                </div>
            @endif
        @empty
        @endforelse
    @endforeach
@endisset
