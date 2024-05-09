<?php

namespace App\Http\Middleware;

use App\Models\Log;
use Closure;
use Illuminate\Http\Request;

class LogActions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response =  $next($request);
        // if ($request->method() !== 'GET') { 
            $log = new Log();
            $log->user_id = auth()->id();
            $log->action = $request->method() . ' ' . $request->path();
            if ($response->isRedirect()) {
                $log->note = session()->get('note'); //desde la insercion en una variable de session en el proceso de mostrar una vista
            } else {
                $jsonResponse = json_decode($response->getContent(), true); //desde un return que contenga un response (AJAX)
                $log->note = (isset($jsonResponse['note'])) ? $jsonResponse['note'] : session()->get('note'); //Comparo si es de una ajax o si viene de un redirect
            }
            $log->description = 'Realizó la acción ' . $request->method() . ' en ' . $request->path();
        // }

        $log->save();
        
        return $response;
        
    }

}
