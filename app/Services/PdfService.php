<?php
namespace App\Services;

use App\Models\Laboratory;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Model;
use setasign\Fpdi\Fpdi;
// use setasign\Fpdi\Tfpdf\Fpdi;

class PdfService {

    /**
     * Generate a instance of DomPDF for generate reports
     * @param String $view
     * @param Array $data
     * @param mixed $paperSize
     * @param string $paperOrientation
     * @param String $path  -- Deprecated
     * @param bool $encryption
     * @param string $password
     * @return mixed
     */
    public function generateAndStorePDF(string $view, array $data, mixed $paperSize, string $paperOrientation, string $path, bool $encryption, string $password = '12345')
    {
        $pdf = Pdf::loadView($view, $data);
        $pdf->setPaper($paperSize, $paperOrientation);
        // $pdf->setPaper('A4', 'portrait');
        // $pdf->setOption('dpi', 96);
        if($encryption === true){
            $pdf->setEncryption($password, 'stevdev', ['print']);
        }
        // Storage::disk('public')->put($path, $pdf->output());
        return $pdf;
    }

    /**
     * Inserting watermark into document previously generated
     * @param model $folio
     * @param string $fondo
     * @return void
     */
    public function insertWatermark(Model $folio, string $fondo, string $seleccion, string $path)
    {
        $membreteFile = new Fpdi('P', 'mm', 'letter');
        $documento = $membreteFile->setSourceFile(public_path() . '/storage/'. $folio->res_file);
        $imagen     = public_path(). '/storage/' . $this->getMembrete($seleccion);

        for($pageNo = 1; $pageNo <= $documento; $pageNo++){
            $template = $membreteFile->importPage($pageNo);
            $membreteFile->AddPage();
            $membreteFile->Image($imagen, 0, 0, 216, 279);
            $membreteFile->useTemplate($template, ['adjustPageSize' => true]);
        }

        $membreteFile->Output('F', 'public/storage/' . $path);
    }

    private function getMembrete(string $seleccion){
        $laboratorio = Laboratory::first();

        switch ($seleccion) {
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

        return $fondo;
    }

}
