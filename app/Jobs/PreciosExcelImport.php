<?php

namespace App\Jobs;

use App\Imports\ListaImport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\UploadedFile;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class PreciosExcelImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $file;
    protected $lista;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($file, $lista)
    {
        //
        $this->file = $file;
        $this->lista = $lista;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $uploaded_file = new UploadedFile($this->file, basename($this->file));

        $import = new ListaImport($this->lista);
        $data = Excel::import($import, $uploaded_file,null, \Maatwebsite\Excel\Excel::XLSX);

        
    }
}
