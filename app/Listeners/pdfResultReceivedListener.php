<?php

namespace App\Listeners;

use App\Events\pdfResultReceived;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Event;

class pdfResultReceivedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\pdfResultReceived  $event
     * @return void
     */
    public function handle(pdfResultReceived $event)
    {
        $result = $event;
        Event::dispatch(new pdfResultReceived($result));
    }
}
