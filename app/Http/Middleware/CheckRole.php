<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (! Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();
        if ($user->role != $role) {
            return redirect('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman tersebut!');
        }

        return $next($request);
    }
}