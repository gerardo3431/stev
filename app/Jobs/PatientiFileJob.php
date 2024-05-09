<?php

namespace App\Jobs;

use App\Models\Recepcions;
use DevRaeph\PDFPasswordProtect\Facade\PDFPasswordProtect;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;


class PatientiFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $folio;
    protected $captura; 
    protected $img; 
    protected $maq_captura; 
    protected $maq_img;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($folio, $captura, $img, $maq_captura, $maq_img)
    {
        $this->folio = $folio;
        $this->captura = $captura; 
        $this->img = $img; 
        $this->maq_captura = $maq_captura; 
        $this->maq_img = $maq_img;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // dd($this->folio);
        $query = Recepcions::where('folio', $this->folio)->first();

        $array = [];
        if($this->captura === true){
            array_push($array, public_path('/storage/' . $query->res_file));
        }

        if($this->img === true){
            array_push($array, public_path('/storage/' . $query->res_file_img));
        }

        if($this->maq_captura === true){
            array_push($array, public_path('/storage/' . $query->maq_file));
        }

        if($this->maq_img === true){
            array_push($array, public_path('/storage/' . $query->maq_file_img));
        }

        try {
            //code...
            $file = new Fpdi('P', 'mm', 'letter');
            foreach ($array as $a => $archivo) {
                $document = $file->setSourceFile($archivo);
                for ($pageNo = 1 ; $pageNo <= $document ; $pageNo++) { 
                    $template = $file->importPage($pageNo);
                    $file->AddPage();
                    $file->useTemplate($template, ['adjustPageSize' => true]);
                }
            }
            $file->Output('F', 'public/storage/patient_files/F-'.$this->folio.'.pdf');
            $entre_paciente    = $query->update(['patient_file' => 'patient_files/F-'.$this->folio.'.pdf']);
            $entrega    = $query->historials()->update(['entrega'=> 'entregado']);

            // $path       = 'patient_files/F-'. $this->folio.'.pdf';
            // $fileCompress = Storage::disk('public')->path($path);
            // PDFPasswordProtect::encrypt($fileCompress, $fileCompress, Recepcions::where('folio', $this->folio)->first()->token);
        } catch (\Throwable $th) {
            dd($th);
        }
    }
}
