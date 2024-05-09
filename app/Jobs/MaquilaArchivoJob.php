<?php

namespace App\Jobs;

use App\Logger;
use App\Models\Recepcions;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;

class MaquilaArchivoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $folio;
    protected $file;
    protected $img;
    protected $request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($folio, $file, $img = null, $request = null)
    {
        //
        $this->folio = $folio;
        $this->file = $file;
        $this->img = $img;
        $this->request = $request;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $folio = Recepcions::where('folio', $this->folio)->first();


            if(Storage::disk('public')->exists($folio->maq_file)){
                $prePath = 'public/storage/maquila/T-' . $this->folio . '.pdf';
                
                $pdf = new Fpdi('P', 'mm', 'letter');

                $document = $pdf->setSourceFile($this->file);

                for ($pageNo = 1 ; $pageNo <= $document ; $pageNo++) { 
                    $template = $pdf->importPage($pageNo);
                    $pdf->AddPage();
                    if($this->img != null){
                        $pdf->Image($this->img, 0, 0, 216, 279);
                    }
                    $pdf->useTemplate($template, ['adjustPageSize' => true]);
                }
        
                $pdf->Output('F', $prePath);


                $filePath = 'public/storage/maquila/M-' . $this->folio . '.pdf';
                // Anexion al arhcivo principal
                $archivos = array(
                        public_path('/storage/' . $folio->maq_file),
                        public_path('/storage/maquila/T-' . $this->folio . '.pdf'),
                    );
                    // dd($archivos);
                $file = new Fpdi('P', 'mm', 'letter');
                foreach ($archivos as $a => $archivo) {
                    $document = $file->setSourceFile($archivo);
                    for ($pageNo = 1 ; $pageNo <= $document ; $pageNo++) { 
                        $template = $file->importPage($pageNo);
                        $file->AddPage();
                        $file->useTemplate($template, ['adjustPageSize' => true]);
                    }
                }
    
                $file->Output('F', $filePath);
            }else{
                $filePath = 'public/storage/maquila/M-' . $this->folio . '.pdf';

                $pdf = new Fpdi('P', 'mm', 'letter');

                $document = $pdf->setSourceFile($this->file);

                for ($pageNo = 1 ; $pageNo <= $document ; $pageNo++) { 
                    $template = $pdf->importPage($pageNo);
                    $pdf->AddPage();
                    if($this->img != null){
                        $pdf->Image($this->img, 0, 0, 216, 279);
                    }
                    $pdf->useTemplate($template, ['adjustPageSize' => true]);
                }
        
                $pdf->Output('F', $filePath);

            }

            
            $folio->update(['maq_file' => 'maquila/M-'. $this->folio . '.pdf']);
        } catch (\Throwable $th) {
            // Logger::logAction($request, 'Estudio', $estudio->id, 'delete', 'Folios', $folio->id,);
        }
    }
}
