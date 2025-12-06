<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // если не залогинен — отправляем на логин
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // на всякий случай жёстко приводим к int
        $isAdmin = (int) ($user->is_admin ?? 0);

        if ($isAdmin !== 1) {
            abort(403, 'Admins only');
        }

        return $next($request);
    }
}
