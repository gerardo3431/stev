<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectBasedOnRoles
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
        $response = $next($request);
        if(Auth::check()){
            switch (auth()->user()->getRoleNames()[0]) {
                case 'Doctor':
                    return route('stevlab.doctor.dashboard');
                    break;
                case 'Empresa':
                    return route('stevlab.empresa.dashboard');
                    break;
                default:
                    // return redirect()->route('stevlab.dashboard');
                    break;
            }
            return $response;
        }
        // return $next($request);

    }
}
