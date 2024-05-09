<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class DatosExport implements FromView, WithColumnWidths, WithCustomStartCell{

    protected $laboratorio;
    protected $usuario;
    protected $folios;
    protected $estudios;
    protected $perfiles;
    protected $barcode;
    protected $valida;


    public function __construct( $laboratorio,  $usuario,  $folios,  $estudios = null,  $perfiles = null){
        $this->laboratorio  = $laboratorio;
        $this->usuario      = $usuario;
        $this->folios       = $folios;
        $this->estudios     = $estudios;
        $this->perfiles     = $perfiles;  
    }

    public function startCell(): string
    {
        return 'B2';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 25,
            'B' => 45,  
            'C' => 25,
            'D' => 20,
            'E' => 15,
            'F' => 55,
            'G' => 55,          
        ];
    }

    public function view():View{
        return view('invoices.excel.resultados.body', [
            'laboratorio'   => $this->laboratorio,
            'usuario'       => $this->usuario,
            'folios'        => $this->folios,
            'estudios'      => $this->estudios,
            'perfiles'      => $this->perfiles,
        ]);
    }
}
