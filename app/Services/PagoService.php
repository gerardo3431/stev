<?php
namespace App\Services;

use App\Models\Pago;
use App\Models\Recepcions;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Milon\Barcode\DNS1D;
use Milon\Barcode\Facades\DNS2DFacade;

class PagoService{
    protected $pdfService;

    public function __construct(PdfService $pdfService)
    {
        $this->pdfService = $pdfService;
    }
    /**
     * Create the payment for the identifier
     * @param array $pago
     * @return mixed
     */
    public function create(Request $pago){
        // dd($pago);
        $create = Pago::create([
            'descripcion'       => 'Análisis de laboratorio',
            'importe'           => $this->comparative($pago['importe'], $pago['subtotal']),
            'tipo_movimiento'   => 'ingreso',
            'metodo_pago'       => $pago['metodo_pago'],
            'observaciones'     => $pago['observaciones'],
        ]);

        activity('caja')->performedOn($create)->withProperties(['folio' => $pago['identificador_folio']])->log('Pago creado');

        $this->asociarCaja($this->cajaActual(), $create, $this->getIdentificador($pago['identificador_folio']));

        $this->updateFolio($this->getIdentificador($pago['identificador_folio']), request());

        // $create->pdf = $this->makeNote($this->getIdentificador($pago['identificador_folio']), $create, request());

        return $create->id;

    }

    /**
     * Associate the payment with a cash box, and everywhere
     * @param model $caja
     * @param model $pago
     * @return void
     */
    protected function asociarCaja(Model $caja, Model $pago, Model $folio){
        $user       = Auth::user();
        $sucursal   = Auth::user()->sucs()->where('estatus', 'activa')->first();
        
        // Pagos has cajas
        $caja->pagos()->save($pago);
        // pagos has folios (recepcions)
        $folio->pago()->save($pago);
        // Pagos_has_user
        $user->pago()->save($pago);
        // Pagos_has_subsidiaries
        $sucursal->pago()->save($pago);
    }

    /**
     * Return a folio identifier
     * @param int $id
     * @return mixed
     */
    protected function getIdentificador(Int $id){
        return Recepcions::findOrFail($id);
    }
    /**
     * Return a actual Cash Box
     * @return mixed
     */
    protected function cajaActual(){
        return Auth::user()->caja()->where('estatus', 'abierta')->first();
    }

    /**
     * Compare and returning a min value
     * @param String $import
     * @param String $subtotal
     * @return Int 
     */
    protected function comparative(String $importe, String $subtotal){
        return min($importe, $subtotal);
    }

    /**
     * Sume the array
     * @param Mixed $folio
     * @return Int
     */
    protected function sumative(Model $folio){
        return $folio->lista()->sum('precio');
    }

    /**
     * Update some values into $folio
     * @param Model $folio
     * @param Request $pago
     * @return void
     */
    protected function  updateFolio(Model $folio, Request $pago){
        // dd($folio, $pago);
        $folio->update([
            'estado' => $pago['estado'] === 'pagado' ? 'pagado' : 'no pagado',
            'num_total' => $this->sumative($folio),
            'descuento' => $folio->descuento + $pago['descuento'],
        ]);
    }

    /**
     * Prepare the data to make pdf ticket
     * @param Request $request
     * @return mixed
     */
    public function makeNote(Request $request){
        $folio = Recepcions::where('id', $request->folio)->first();
        try {
            $pago = Pago::where('id', $request->pago)->first() ?? $folio->pago()->latest()->first();

            try {
                
                $pdfData    = $this->preparePdfData($folio, $pago, $request->tipo);
                $view       = $this->determinePdfView($request->tipo);
                $paper      = $this->determinePaperSize($request->tipo);

                $pdf = Pdf::loadView($view, $pdfData);
                $pdf->setPaper($paper, 'portrait');
                $pdf->render();
                return $pdf;
            } catch (\Throwable $th) {
                return 'Pago no existe para el folio actual';
            }
        } catch (\Throwable $th) {
            return 'No hay pagos registrados';
        }
        
        
    }

    /**
     * Preparing the data into the makeNote function
     * @param Model $folio
     * @param Model $pago
     * @param String $arreglo
     * @return array
     */
    protected function preparePdfData(Model $folio, Model $pago, String $arreglo){
        $user           = Auth::user();
        $sucursal       = $user->sucs()->where('estatus', 'activa')->first();
        $laboratorio    = $user->labs()->first();
        $logotipo       = base64_encode(Storage::disk('public')->get($laboratorio->logotipo));

        $paciente       = $folio->paciente()->first();
        $edad           = $paciente->specificAge();
        $doctor         = $folio->doctores()->first();
        $lista          = $folio->lista()->get();
        $barcode        = DNS1D::getBarcodeSVG($folio->folio, 'C128', 1.20, 30, "black", true);
        $pathQr         = URL::to('/') . '/resultados/search/resultado/' . $folio->id;
        $qr             = DNS2DFacade::getBarcodeSVG($pathQr, 'QRCODE', 3, 3);

        return [
            'logotipo'      => $logotipo,
            'logo'          => $logotipo,
            'laboratorio'   => $laboratorio,
            'folios'        => $folio,
            'paciente'      => $paciente,
            'edad'          => $edad,
            'doctor'        => $doctor,
            'usuario'       => Auth::user(),
            'estudios'      => $lista,
            'pago'          => $pago,
            'barcode'       => $barcode,
            'sucursal'      => $sucursal,
            'logo'          => $logotipo,
            'qr'            => $qr,
        ];

    }

    /**
     * Return a specific width from a value request
     * @param Int $value
     * @return float
     */
    protected function calculateWidth(){
        // return (4.8 / 2.54) * 72;
        return (8 / 2.54) * 72;
    }

    /**
     * Determine the view to makeNote function
     * @param String $arreglo
     * @return String
     */
    protected function determinePdfView(String $arreglo){
        return ($arreglo === 'ticket') ? 'invoices.ticket.ticket' : 'invoices.ticket.ticket-letter';
    }

    /**
     * Determine the paper size
     * @param String $arreglo
     * @return mixed
     */
    protected function determinePaperSize(String $arreglo){
        return ($arreglo=== 'ticket') ? array(0, 0, $this->calculateWidth(), 1500) : 'letter';
    }

}