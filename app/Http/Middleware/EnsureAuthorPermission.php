<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureAuthorPermission
{
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $user = $request->user();

        if (! $user) {
            return $this->deny($request);
        }

        if (($user->role ?? null) !== 'author' && ($user->role ?? null) !== 'admin') {
            return $this->deny($request);
        }

        if (! $user->hasAuthorPermission($permission)) {
            return $this->deny($request, 'Tidak memiliki izin.');
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

        return redirect()->route('login.author')->with('error', $message);
    }
}
