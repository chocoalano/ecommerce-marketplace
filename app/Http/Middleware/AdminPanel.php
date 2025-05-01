<?php

namespace App\Http\Middleware;

use Closure;
use Filament\Facades\Filament;
use Illuminate\Http\Request;

class AdminPanel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $auth = Filament::auth();
        if ($auth->check()) {
            if ($auth->user()->type === 'admin') {
                return $next($request);
            }
            abort(403, 'Forbidden access this resource.');
        }
        redirect(Filament::getLoginUrl());
    }
}
