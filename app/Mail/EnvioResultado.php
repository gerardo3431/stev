<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnvioResultado extends Mailable
{
    use Queueable, SerializesModels;
    public $subject = 'Stevlab - Envio de resultados';
    public $pdf; 
    public $path;
    public $laboratorio;
    public $paciente;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pdf, $path, $laboratorio, $paciente)
    {
        $this->pdf          = $pdf;
        $this->path         = $path;
        $this->laboratorio  = $laboratorio;
        $this->paciente     = $paciente;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.resultados.envio-resultado')
                    ->attach($this->path, [
                        'as'    => 'Resultados.pdf',
                        'mime'  => 'application/pdf',
                    ])
                    ->with(['laboratorio'=> $this->laboratorio, 'paciente' => $this->paciente]);
    }
}
