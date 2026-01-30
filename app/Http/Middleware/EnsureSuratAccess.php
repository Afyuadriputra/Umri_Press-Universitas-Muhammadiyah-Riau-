<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureSuratAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return $this->deny($request);
        }

        if (($user->role ?? null) === 'admin') {
            return $next($request);
        }

        if (! $user->canAccessSurat()) {
            return $this->deny($request);
        }

        return $next($request);
    }

    private function deny(Request $request, string $message = 'Tidak memiliki izin.')
    {
        if (Auth::check()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return redirect()->route('login')->with('error', $message);
    }
}
