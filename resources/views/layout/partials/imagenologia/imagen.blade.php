
@php
//Obtienes contenido sin verificar 
    $zipContent = Storage::disk('public')->path($resultado->valor);
    $pathinfo = pathinfo($zipContent, PATHINFO_EXTENSION);
    if ($pathinfo === "zip" ||$pathinfo  === "rar"){
        $zipper = new \Madnest\Madzipper\Madzipper;
        // Obtener el contenido del archivo ZIP como una cadena
        // dd(pathinfo($zipContent, PATHINFO_EXTENSION));
        $tempZip    = Storage::disk('public')->path('temp');

        $zipper->make($zipContent)->extractTo($tempZip);
        
        $files  = Storage::disk('public')->files('temp');
        $count  = count($files);
        if($count > 2){
            foreach ($files as $key => $file) {
                $filename = basename($file);
                $filenameInfo = pathinfo($filename, PATHINFO_EXTENSION);
                $data = base64_encode(Storage::disk('public')->get($file));
                $prop = (($key + 1) % 2 != 0) ? 'float:left' : '';
                
                echo "<img src='data:image/". $filenameInfo .";base64,". $data . "' style=' margin-top: 120px; height: 350px; max-height:360px; width:350px; max-width: 360px; margin: 5px; margin-top:0;  padding:0; border: none; '>";
            }
        }else{
            foreach ($files as $file) {
                $filename = basename($file);
                $data = base64_encode(Storage::disk('public')->get($file));
                echo "<img src='data:image/". $pathinfo . ";base64,". $data . "' height='680px' width='800px' style='margin:5px;  margin-top:0;  padding:0; border: none; margin: 5px; '>";
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
    }else{
        $data = base64_encode(Storage::disk('public')->get($resultado->valor));
        echo "<img src='data:image/". $pathinfo . ";base64,". $data . "' height='680px' width='800px' style='margin:5px;  margin-top:0;  padding:0; border: none; margin: 5px; '>";

    }

@endphp