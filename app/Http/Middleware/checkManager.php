<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class checkManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->session()->has('employe_id') || $request->session()->get('profile') !== 'Manager') {
            return redirect('/login')->with('error', 'Access denied.');
        }
        return $next($request);
    }
}
