<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureTime
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $currentDateTime = Carbon::now();
        $startTime = Carbon::createFromTime(7, 0, 0); // 7:00 AM
        $endTime = Carbon::createFromTime(16, 30, 0); // 4:00 PM

        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        if (!$user->hasRole('admin') && !$currentDateTime->between($startTime, $endTime)) {
            return redirect('/timeout')->with('error', "You don't have access to this page.");
        }
        return $next($request);
    }
}
