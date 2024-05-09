<?php

namespace App\Jobs;

use App\Models\Analito;
use App\Models\Historial;
use App\Models\Log;
use App\Models\Recepcions;
use App\Models\User;
use App\Services\AnalitoService;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Milon\Barcode\DNS1D;
use Milon\Barcode\Facades\DNS2DFacade;
use setasign\Fpdi\Fpdi;

class GeneratePdf implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $usuario;
    protected $folio;
    protected $estudios;
    protected $seleccion;
    protected $pregunta;
    protected $analitoService;

    // public $ruta;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $usuario, Recepcions $folio, array $estudios = null, $seleccion, $pregunta , AnalitoService $analitoService)
    {
        //
        $this->usuario  = $usuario;
        $this->folio    = $folio;
        $this->estudios = $estudios;
        $this->seleccion= $seleccion;
        $this->pregunta = $pregunta;
        $this->analitoService = $analitoService;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user           = $this->usuario;
        $idFolio        = $this->folio;
        $estudios       = $this->estudios;
        $laboratorio    = $user->labs()->first();

        // FIRMA
        try {
            $queryValida = $idFolio->valida()->first() ? $idFolio->valida()->first()->firma : null;
            $img_valido = Storage::disk('public')->get($laboratorio->firma_sanitario) ? base64_encode(Storage::disk('public')->get($laboratorio->firma_sanitario)) : null;
            
        } catch (\Throwable $e) {
            dd("Error consultar la firma de quien valida: ". $e->getMessage() );
        }
        

        // Preguntamos acerca de los estudios y perfiles
        $queryEstudios = $idFolio->estudios()->distinct()->get();
        foreach ($queryEstudios as $key => $estudio) {
            $estudio->analitos          = $estudio->analitos()->orderBy('analitos_has_estudios.orden', 'asc')->get();
            $estudio->completo          = $estudio->historial()->get()->isEmpty() ? false : true;
            $estudio->area              = $estudio->areas()->first()->descripcion;
            $estudio->conteo_analito    = $estudio->analitos->count();

            foreach ($estudio->analitos as $key => $analito) {
                $historial = Historial::where('historials.clave', $analito->clave)
                    ->where('historials.estatus', 'validado')
                    ->whereHas('recepcions', function ($query) use ($idFolio, $estudio){
                        $query->where('recepcions_id', $idFolio->id)->where('estudio_id', $estudio->id);
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
                
            }

            if(($estudio->valida_qr == 'on') && $estudio->resultado_esperado){
                $pathQr         = URL::to('/') . '/resultados/valida/' . $idFolio->folio . '/' . $estudio->clave;
                $analito->qr    = base64_encode(DNS2DFacade::getBarcodeSVG($pathQr, 'QRCODE',5,5 ));
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


        $queryPerfiles = $idFolio->recepcion_profiles()->distinct()->get();
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
                        ->whereHas('recepcions', function ($query) use ($idFolio, $estudio){
                            $query->where('recepcions_id', $idFolio->id)->where('estudio_id', $estudio->id);
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
                        $pathQr         = URL::to('/') . '/resultados/valida/' . $idFolio->folio . '/' . $estudio->clave;
                        $analito->qr    = base64_encode(DNS2DFacade::getBarcodeSVG($pathQr, 'QRCODE',5,5 ));
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

        // BARCODE
        $barcode        = DNS1D::getBarcodeSVG($idFolio->folio, 'C128', 1.20, 30, 'black', false);
        
        // MEMBRETE
        try {
            switch ($this->seleccion) {
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
                    $fondo = $laboratorio->membrete;
                    break;
            }
        } catch (\Throwable $e) {
            dd("Error al obtener membrete: ". $e->getMessage() );
        }

        // Generar pdf
        try {
            $pdf = Pdf::loadView('invoices.resultados.invoice-all-resultado-membrete', [
                'laboratorio'   => $laboratorio, 
                'usuario'       => $user,
                'folios'        => $idFolio,
                
                'resultados'    => ($estudiosAgrupados->isEmpty() !== true) ? $estudiosAgrupados : null,
                'perfiles'      => ($queryPerfiles->isEmpty() !== true) ? $queryPerfiles : null,
                'fondo'         => $this->pregunta,
    
                'barcode'       => $barcode,
                'img_valido'    => ($img_valido != null) ? $img_valido : null,
            ]);

            //contraseña
            $pdf->setPaper('letter', 'portrait');
            $path       = 'public/resultados-completos/F-'.$idFolio->folio.'.pdf';
            $pathSave   = Storage::put($path, $pdf->output());
            $idFolio->update(['res_file' => 'resultados-completos/F-'.$idFolio->folio.'.pdf']);
        } catch (\Throwable $e) {
            dd("Error al generar reporte: ". $e->getMessage() );
        }

        // Incrusta fondo
        try {
            if($this->pregunta == 'si'){
                $membreteFile = new Fpdi('P', 'mm', 'letter');
                $documento = $membreteFile->setSourceFile(public_path() . '/storage/'. $idFolio->res_file);
                $imagen     = public_path(). '/storage/' . $fondo;
                
                for($pageNo = 1; $pageNo <= $documento; $pageNo++){
                    $template = $membreteFile->importPage($pageNo);
                    $membreteFile->AddPage();
                    $membreteFile->Image($imagen, 0, 0, 216, 279);
                    $membreteFile->useTemplate($template, ['adjustPageSize' => true]);
                }
                $membreteFile->SetCompression(true);
                $membreteFile->Output('F', 'public/storage/resultados-completos/F-'.$idFolio->folio.'.pdf');
            }
        } catch (\Throwable $e) {
            dd($e);
        }
        // dd($idFolio->maq_file);

        // if($idFolio->maq_file != null){
        //     try {
        //          // Adquiero archivo
        //         $archivos = array(
        //             public_path('/storage/' . $idFolio->res_file),
        //             public_path('/storage/' . $idFolio->maq_file),
        //         );
        //         // dd($archivos);

        //         $file = new Fpdi('P', 'mm', 'letter');
        //         foreach ($archivos as $a => $archivo) {
        //             $document = $file->setSourceFile($archivo);
        //             for ($pageNo = 1 ; $pageNo <= $document ; $pageNo++) { 
        //                 $template = $file->importPage($pageNo);
        //                 $file->AddPage();
        //                 $file->useTemplate($template, ['adjustPageSize' => true]);
        //             }
        //         }
        //         $file->Output('F', 'public/storage/resultados-completos/F-'.$idFolio->folio.'.pdf');
        //         $entrega = $idFolio->historials()->update(['entrega'=> 'entregado']);
        //     } catch (\Throwable $e) {
        //         // Log::error( );
        //         dd("Error al generar reporte: ". $e->getMessage());
        //     }
        // }

    }

    public function failed(Exception $exception){
        // Registrar el error en un archivo de registro
        dd("Error registrado: " .  $exception->getMessage());

        // Volver a encolar la Job para que se intente de nuevo en 5 minutos
        $this->release(5 * 60);
    }
}


// Revisar las areas de recepcion si el estudio es cambiado de area.
// El folio contendria el area que fue registrado al momento de integrar el estudio,
// Más no la nueva área asignada en la edición del estudio.