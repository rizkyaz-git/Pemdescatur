<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
class EnsurePelapor
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth('pelapor')->check()) return redirect()->route('pelapor.login.request')->with('error', 'Silakan gunakan tautan login dari email Anda.');
        return $next($request);
    }
}
