<?php

namespace App\Jobs;

use App\Models\Recepcions;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Milon\Barcode\DNS1D;
use setasign\Fpdi\Fpdi;

class GeneratePdfImg implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $usuario;
    protected $folio;
    protected $estudios;
    protected $seleccion;
    protected $pregunta;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $usuario, Recepcions $folio, array $estudios = null, $seleccion, $pregunta)
    {
        //
        //
        $this->usuario  = $usuario;
        $this->folio    = $folio;
        $this->estudios = $estudios;
        $this->seleccion= $seleccion;
        $this->pregunta = $pregunta;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(){
        //
        $user           = $this->usuario;
        $idFolio        = $this->folio;
        $estudios       = $this->estudios;
        $laboratorio    = $user->labs()->first();
        try {
            $queryValida = $idFolio->valida()->first()->firma;
            if($queryValida){
                // $img_valido     = base64_encode(Storage::disk('public')->get($idFolio->valida()->first()->firma));
                $img_valido     = base64_encode(Storage::disk('public')->get($laboratorio->firma_img));
            }
        } catch (\Throwable $e) {
            dd("Error consultar la firma de quien valida: ". $e->getMessage() );
        }

        // Barcode
        $barcode        = DNS1D::getBarcodeSVG($idFolio->folio, 'C128', 1.20, 30, 'black', false);

         // MEMBRETE
        try {
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
        } catch (\Throwable $e) {
            dd("Error al obtener membrete: ". $e->getMessage() );
        }
        // try {
        //     $fondo = Storage::disk('public')->get('membrete_laboratorios/membrete_img.png');
        // } catch (\Throwable $e) {
        //     dd("Error al obtener membrete: ". $e->getMessage() );
        // }
        $pregunta = $this->pregunta;

        try {
            //code...
            $pdf = Pdf::loadView('invoices.imagenologia.invoice-single-imagenologia', [
                'laboratorio'   => $laboratorio, 
                'usuario'       => $user,
                'folios'        => $idFolio,
    
                'barcode'       => $barcode,
    
                'fondo'         => $pregunta,
    
                'barcode'       => $barcode,
                // 'membrete'      => 'data:image/jpeg;base64,' .base64_encode($fondo),
                
                'img_valido'    => $img_valido,
            ]);
            $entrega = $idFolio->historials()->update(['entrega'=> 'entregado']);
            $pdf->setPaper('letter', 'portrait');
            $path = 'public/imagenologia/F-'.$idFolio->folio.'.pdf';
            $pathSave = Storage::put($path, $pdf->output());
            $idFolio->update(['res_file_img' => 'imagenologia/F-'.$idFolio->folio.'.pdf']);


        } catch (\Throwable $e) {
            dd("Error al generar reporte: ". $e->getMessage() );
        }

        // $ruta = public_path() . '/storage/imagenologia/F-'.$idFolio->folio.'.pdf';
        // dd(public_path() . '/storage/imagenologia/F-'.$idFolio->folio.'.pdf');
        // dd(public_path() . '/storage/' . $idFolio->res_file);
        
        try {
            if($this->pregunta == 'si'){
                $membreteFile = new Fpdi('P', 'mm', 'letter');
                $documento = $membreteFile->setSourceFile(public_path() . '/storage/' . $idFolio->res_file_img);
                $imagen     = public_path(). '/storage/' . $fondo;
                // $img = Storage::disk('public')->get($fondo);
                
                for($pageNo = 1; $pageNo <= $documento; $pageNo++){
                    $template = $membreteFile->importPage($pageNo);
                    $membreteFile->AddPage();
                    $membreteFile->Image($imagen, 0, 0, 216, 279);
                    $membreteFile->useTemplate($template, ['adjustPageSize' => true]);
                }
                $membreteFile->Output('F', 'public/storage/imagenologia/F-'.$idFolio->folio.'.pdf');
            }
        } catch (\Throwable $e) {
            dd($e);
        }
    }

    public function failed(Exception $exception){
        // Registrar el error en un archivo de registro
        dd("Error registrado: " .  $exception->getMessage());

        // Volver a encolar la Job para que se intente de nuevo en 5 minutos
        $this->release(5 * 60);
    }
}
