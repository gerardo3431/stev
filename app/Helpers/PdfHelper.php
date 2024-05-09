<?php

namespace App\Helpers;

use App\Models\Historial;
use App\Models\Recepcions;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Milon\Barcode\DNS1D;
use Milon\Barcode\DNS2D;
use setasign\Fpdi\Fpdi;

class PdfHelper{
    protected $usuario;
    protected $folio;
    // protected $estudios;
    protected $seleccion;
    protected $pregunta;

    public function __construct(User $usuario, Recepcions $folio, $seleccion, $pregunta){
        $this->usuario  = $usuario;
        $this->folio    = $folio;
        // $this->estudios = $estudios;
        $this->seleccion= $seleccion;
        $this->pregunta = $pregunta;
    }

    public function generatePdfCaptura(){
        try {
            
            $laboratorio    = $this->usuario->labs()->first();

            // Para obtener la firma
            $firmaResponsableSanitario = Storage::disk('public')->get($laboratorio->firma_sanitario) ? base64_encode(Storage::disk('public')->get($laboratorio->firma_sanitario)) : null;

            // Estudios  & perfiles
            $estudios = $this->getAllStudies();
            $perfiles = $this->getAllProfiles();

            $barcode        = DNS1D::getBarcodeSVG($this->folio->folio, 'C128', 1.20, 30, 'black', false);

            // Membrete
            $fondo = $this->getMembrete($laboratorio);

            $pdf = Pdf::loadView('invoices.resultados.invoice-all-resultado-membrete',[
                'laboratorio'   => $laboratorio, 
                'usuario'       => $this->usuario,
                'folios'        => $this->folio,

                'resultados'    => $estudios,
                'perfiles'      => $perfiles,
                'fondo'         => $this->pregunta, //Se usa para mostrar la firma cuando no se solicita membrete
                'barcode'       => $barcode,
                'img_valido'    => $firmaResponsableSanitario
            ]);

            $pdf->setPaper('letter', 'portrait');
            $archivo = $pdf->output();

            $path       = 'resultados-completos/F-'.$this->folio->folio.'.pdf';
            $pathSave   = Storage::disk('public')->put($path, $archivo);
            
            $this->folio->update(['res_file' => 'resultados-completos/F-'.$this->folio->folio.'.pdf']);

            // Agregado del membrete
            if($this->pregunta == 'si'){
                $membreteFile = new Fpdi('P', 'mm', 'letter');
                $documento = $membreteFile->setSourceFile(public_path() . '/storage/'. $this->folio->res_file);
                $imagen     = public_path(). '/storage/' . $fondo;
                
                for($pageNo = 1; $pageNo <= $documento; $pageNo++){
                    $template = $membreteFile->importPage($pageNo);
                    $membreteFile->AddPage();
                    $membreteFile->Image($imagen, 0, 0, 216, 279);
                    $membreteFile->useTemplate($template, ['adjustPageSize' => true]);
                }
                $membreteFile->Output('F', 'public/storage/resultados-completos/F-'.$this->folio->folio.'.pdf');
            }
            
            return response()->json([
                'pdf' =>  $path
            ],200);

        } catch (\Throwable $th) {
            return response()->json([
                'message'   =>  $th->getMessage()
            ],400);
        }
    }

    public function generatePdfImg(){
        $laboratorio    = $this->usuario->labs()->first();
        $firmaResponsableSanitario = Storage::disk('public')->get($laboratorio->firma_sanitario) ? base64_encode(Storage::disk('public')->get($laboratorio->firma_sanitario)) : null;
        $barcode        = DNS1D::getBarcodeSVG($this->folio->folio, 'C128', 1.20, 30, 'black', false);
        
        $fondo = $this->getMembrete($laboratorio);

        $pdf = Pdf::loadView('invoices.imagenologia.invoice-single-imagenologia', [
            'folios'        => $this->folio,
            'laboratorio'   => $laboratorio, 
            'usuario'       => $this->usuario,

            'barcode'       => $barcode,
            'fondo'         => $this->pregunta,
            'img_valido'    => $firmaResponsableSanitario,

        ]);

        $pdf->setPaper('letter', 'portrait');
        $archivo = $pdf->output();

        $path = 'imagenologia/F-'.$this->folio->folio.'.pdf';
        Storage::disk('public')->put($path, $archivo);

        $this->folio->update([
            'res_file_img' => $path, 
            'entrega'=> 'entregado'
        ]);

        if($this->pregunta == 'si'){
            $membreteFile = new Fpdi('P', 'mm', 'letter');
            $documento = $membreteFile->setSourceFile(public_path() . '/storage/' . $this->folio->res_file_img);
            $imagen     = public_path(). '/storage/' . $fondo;
            
            for($pageNo = 1; $pageNo <= $documento; $pageNo++){
                $template = $membreteFile->importPage($pageNo);
                $membreteFile->AddPage();
                $membreteFile->Image($imagen, 0, 0, 216, 279);
                $membreteFile->useTemplate($template, ['adjustPageSize' => true]);
            }
            $membreteFile->Output('F', 'public/storage/imagenologia/F-'.$this->folio->folio.'.pdf');
        }

        return $path;

    }

    protected function getAllStudies(){
        // Obtener los estudios
        $queryEstudios = $this->folio->estudios()->distinct()->get();
        foreach ($queryEstudios as $key => $estudio) {
            $estudio->analitos          = $estudio->analitos()->orderBy('analitos_has_estudios.orden', 'asc')->get();
            $estudio->completo          = $estudio->historial()->get()->isEmpty() ? false : true;
            $estudio->area              = $estudio->areas()->first()->descripcion;
            $estudio->conteo_analito    = $estudio->analitos->count();

            foreach ($estudio->analitos as $key => $analito) {
                $historial = Historial::where('historials.clave', $analito->clave)
                    ->where('historials.estatus', 'validado')
                    ->whereHas('recepcions', function ($query) use ($estudio){
                        $query->where('recepcions_id', $this->folio->id)->where('estudio_id', $estudio->id);
                    })
                    ->latest()->first();

                if($historial){
                    $analito->estado                = true;
                    $analito->resultado_esperado    = $historial->valor;
                    $analito->resultado_abs         = $historial->valor_abs;
                }else{
                    $analito->estado                = false;
                    $analito->resultado_esperado    = null;
                    $analito->resultado_abs         = null;
                }
                
                if(($estudio->valida_qr == 'on') && $estudio->resultado_esperado){
                    $pathQr         = URL::to('/') . '/resultados/valida/' . $this->folio . '/' . $estudio->clave;
                    $analito->qr    = base64_encode(DNS2D::getBarcodeSVG($pathQr, 'QRCODE',5,5 ));
                }
            }


        }

        // Filtrar los estudios con resultado_esperado
        $queryEstudiosFiltrados = $queryEstudios->filter(function ($estudio) {
            return $estudio->analitos->contains(function ($analito) {
                return $analito->resultado_esperado !== null;
            });
        });
        
        // Agrupar los estudios filtrados por áreas
        $estudiosAgrupados = $queryEstudiosFiltrados->groupBy(function ($estudio) {
            return $estudio->areas()->first()->descripcion;
        });

        return (! $estudiosAgrupados->isEmpty()) ? $estudiosAgrupados : null;
    }

    protected function getAllProfiles(){
        // Obtener los perfiles
        $queryPerfiles = $this->folio->recepcion_profiles()->distinct()->get();
        foreach ($queryPerfiles as $keyPerfil => $perfil) {
            $query = $perfil->perfil_estudio()->get();

            foreach ($query as $keyEstudio => $estudio) {
                $estudio->analitos          = $estudio->analitos()->orderBy('analitos_has_estudios.orden', 'asc')->get();
                $estudio->completo          = $estudio->historial()->get()->isEmpty() ? false : true;
                $estudio->area              = $estudio->areas()->first()->descripcion;
                $estudio->conteo_analito    = $estudio->analitos->count();

                foreach ($estudio->analitos as $key => $analito) {
                    $historial = Historial::where('historials.clave', $analito->clave)
                        ->where('historials.estatus', 'validado')
                        ->whereHas('recepcions', function ($query) use ($estudio){
                            $query->where('recepcions_id', $this->folio->id)->where('estudio_id', $estudio->id);
                        })
                        ->latest()->first();

                    if($historial){
                        $analito->estado                = true;
                        $analito->resultado_esperado    = $historial->valor;
                        $analito->resultado_abs         = $historial->valor_abs;
                    }else{
                        $analito->estado                = false;
                        $analito->resultado_esperado    = null;
                        $analito->resultado_abs         = null;
                    }

                    if(($estudio->valida_qr == 'on' ) && $analito->resultado_esperado){
                        $pathQr         = URL::to('/') . '/resultados/valida/' . $this->folio . '/' . $estudio->clave;
                        $analito->qr    = base64_encode(DNS2D::getBarcodeSVG($pathQr, 'QRCODE',5,5 ));
                    }
                }
            }

            // Filtrar los estudios con resultado_esperado
            $perfil->estudios = $query->filter(function ($estudio) {
                return $estudio->analitos->contains(function ($analito) {
                    return $analito->resultado_esperado !== null;
                });
            });
            // Agrupar los estudios filtrados por áreas
            $perfil->estudios = $perfil->estudios->groupBy(function ($estudio) {
                return $estudio->areas()->first()->descripcion;
            });
            
        }

        return (! $queryPerfiles->isEmpty()) ? $queryPerfiles : null;
    }

    protected function getMembrete($laboratorio){
        switch ($this->seleccion) {
            case 'imagenologia':
                $fondo = $laboratorio->membrete_img;
                break;
            case 'principal':
                $fondo = $laboratorio->membrete;
                break;
            case 'secundario':
                $fondo = $laboratorio->membrete_secundario;
                break;
            case 'terciario':
                $fondo = $laboratorio->membrete_terciario;
                break;
            default:
                $fondo = $laboratorio->membrete_img;
                break;
        }

        return $fondo;
    }

}