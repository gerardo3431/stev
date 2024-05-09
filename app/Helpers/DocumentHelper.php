<?

namespace App\Helpers;

use Barryvdh\DomPDF\PDF;
// use Barryvdh\DomPDF\Facade\Pdf;

class DocumentService{
    protected $pdf;

    public function __construct(PDF $pdf)
    {
        $this->pdf = $pdf;
    }

    public function injectView(string $view, array $data)
    {
        return $this->pdf->loadView($view, $data);
    }

    public function paper(mixed $papersize, mixed $orientation)
    {
        $this->pdf->setPaper($papersize, $orientation);
    }

    public function encryption(bool $encryption, string $password = "12345")
    {
        if($encryption === true){
            $this->pdf->setEncryption($password, 'stevdev', ['print']);
        }
    }

}