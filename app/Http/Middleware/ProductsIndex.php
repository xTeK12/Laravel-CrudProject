<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ProductsIndex
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!Auth::check()) {
            return redirect('login');
        }
        $user = Auth::user();

        if($user->hasRole('admin') || $user->hasRole('seller')) {
            return $next($request);
        }
        abort(403, 'Unauthorized action.');
    }
}
