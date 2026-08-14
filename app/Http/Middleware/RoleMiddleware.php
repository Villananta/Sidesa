<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Role;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('/');
        }

        $rolesName = Role::find(Auth::user()->role_id)->name;

        if (!in_array($rolesName, $roles)) {
            return back();
        }

        return $next($request);
    }
}