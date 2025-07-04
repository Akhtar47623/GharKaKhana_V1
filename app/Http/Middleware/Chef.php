<?php

namespace App\Http\Middleware;

use Closure;

class Chef
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $loginUser = auth('chef')->user();  //$loginUser->role != "ADMIN" || $loginUser->role != "VENDOR"  ||
        
        if (empty($loginUser)) {
            return redirect("/");
        }
        $response = $next($request);

        return $response->header('Cache-Control', 'nocache, no-store, max-age=0, must-revalidate')
                        ->header('Pragma', 'no-cache')
                        ->header('Expires', 'Sun, 02 Jan 1990 00:00:00 GMT');
        
    }
}
