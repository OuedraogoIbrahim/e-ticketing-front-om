<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifiez si le token est présent dans la session ou dans les cookies
        if (!session()->has('token-app-e-ticketing')) {
            // Redirigez vers la page de connexion si le token n'est pas présent
            return redirect()->route('login');
        }

        return $next($request);
    }
}
