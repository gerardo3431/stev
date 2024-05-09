<?php

namespace App\Http\Controllers;

use App\Models\User;
// use Barryvdh\DomPDF\Facade\Pdf;
// use FPDF;
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfParser\StreamReader;
use setasign\Fpdi\PdfParser\PdfParser;
use ddn\sapp\PDFDoc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MaquilaController extends Controller
{
    //
    public function index(){
        //Verificar sucursal
        $active = User::where('id', Auth::user()->id)->first()->sucs()->where('estatus', 'activa')->first();
        // Lista de sucursales que tiene el usuario
        $sucursales = User::where('id', Auth::user()->id)->first()->sucs()->orderBy('id', 'asc')->get();

        return view('maquila.index', [
            'active'        => $active, 
            'sucursales'    => $sucursales, 
        ]);
    }


    public function upload_and_change_file(Request $request){
        // Pdf for merge
        $setFilePath = 'public/maquila/';
        $setFile = $request->file('archivo')->storeAs('public/maquila/', 'ejemplo.pdf');
        // Url publico
        $urlFilePath = public_path() . '/storage/maquila/ejemplo.pdf' ;
        // $urlFilePathCopy = public_path() . '/storage/maquila/copia.pdf' ;

        // Picture for watermark
        $setFileImg = 'public/maquila/imagenes/';
        $setFile = $request->file('imagen')->storeAs($setFileImg, 'ejemplo.png');
        // Url publico
        $urlImgPath = public_path() . '/storage/maquila/imagenes/ejemplo.png';

        try {
            // Construct
            $pdf = new Fpdi('P', 'mm', 'letter');
            // set the source file
            $document = $pdf->setSourceFile($urlFilePath);
            // Import all pages of document origin
            for ($pageNo = 1 ; $pageNo <= $document ; $pageNo++) { 
                $template = $pdf->importPage($pageNo);
                $pdf->AddPage();
                $pdf->Image($urlImgPath, 0, 0, 216, 279);
                $pdf->useTemplate($template, ['adjustPageSize' => true]);
            }
            $pdf->Output();
        } catch (\Throwable $th) {
            return redirect()->route('stevlab.utils.maquila')->with(['msj' => 'Archivo no compatible con el sistema, por favor abra el archivo dentro de un editor de pdf y guarde de nueva cuenta el archivo.']);
        }
        

        // Insert watermark text
        // $pdf->SetFont('Arial', 'I', 40);
        // $pdf->SetTextColor(255,0,0);
        // $pdf->SetXY(25, 135);
        // $pdf->MultiCell(0, 6, 'Hola',);
        
    }

}
