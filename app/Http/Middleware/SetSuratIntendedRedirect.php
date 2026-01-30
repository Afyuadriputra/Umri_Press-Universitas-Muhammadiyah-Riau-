<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetSuratIntendedRedirect
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()) {
            $request->session()->put('url.intended', route('dashboard-surat.index'));
        }

        return $next($request);
    }
}
