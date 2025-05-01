<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Filament\Facades\Filament;
use Illuminate\Http\Request;

class SellerPanel
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
            if ($auth->user()->type === 'seller') {
                return $next($request);
            }elseif ($auth->user()->type === 'buyer') {
                $user = User::find($auth->user()->id);
                $cek = $user->seller();
                if ($cek) {
                    return $next($request);
                }else{
                    abort(403, 'Forbidden access this resource.');
                }
            }
            abort(403, 'Forbidden access this resource.');
        }
        redirect(Filament::getLoginUrl());
    }

}
