<?php

namespace App\Jobs;

use App\Mail\EnvioResultado;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class ProcesaCorreo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $tries = 5;
    public $timeout = 9600;

    public $pdf;
    public $path;
    public $correo;
    public $laboratorio;
    public $paciente;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($pdf, $path, $correo, $laboratorio, $paciente)
    {
        //
        
        $this->pdf          = $pdf;
        $this->path         = $path;
        $this->correo       = $correo;
        $this->laboratorio  = $laboratorio;
        $this->paciente     = $paciente;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $correo = new EnvioResultado($this->pdf, $this->path, $this->laboratorio, $this->paciente);
        $envio = Mail::to($this->correo)->send($correo);
    }

    public function failed(Throwable $exception){
        dd($exception);
        // // Registra el error en el log
        // Log::error('Error al enviar correo de resultados: '.$exception->getMessage());
        // // Enviar una notificación al administrador del sistema
        // $adminEmail = 'admin@example.com';
        // $message = 'Error al enviar correo de resultados: '.$exception->getMessage();
        // Mail::to($adminEmail)->send(new NotificationMail($message));
    }
}