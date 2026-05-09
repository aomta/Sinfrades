<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

// FIX: Middleware disesuaikan dengan signature Laravel 10/11
class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Cek apakah role user termasuk yang diizinkan
        if (!in_array(auth()->user()->role, $roles)) {
            return redirect()->route('dashboard')
                ->with('error', 'Akses ditolak! Anda tidak memiliki izin untuk halaman tersebut.');
        }

        return $next($request);
    }
}
