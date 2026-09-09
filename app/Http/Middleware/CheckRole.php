<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        $user = auth()->user();

        if (!$user->isAdmin()) {
            abort(403, 'Akses ditolak: Anda tidak memiliki hak akses administrator.');
        }

        // Normalize legacy roles if any
        $userRole = $user->role;
        if ($userRole === 'admin_modul') {
            $userRole = 'admin_pemdes';
        }
        if ($userRole === 'admin_ppp_ormawa') {
            $userRole = 'ppk_ormawa';
        }

        // Super admin has unrestricted access to all admin areas
        if ($userRole === 'super_admin') {
            return $next($request);
        }

        // If specific roles are required, verify match
        if (!empty($roles) && !in_array($userRole, $roles)) {
            abort(403, 'Akses ditolak: Peran akun Anda (' . $user->role_label . ') tidak memiliki izin untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}
