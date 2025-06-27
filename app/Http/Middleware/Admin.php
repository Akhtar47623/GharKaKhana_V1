<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class Admin {
 
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $loginUser = auth('admin')->user();  //$loginUser->role != "ADMIN" || $loginUser->role != "VENDOR"  ||
       
        if (empty($loginUser) || Session::get('admin_id') == NULL) {
            return redirect("/admin");
        }
        $response = $next($request);

        return $response->header('Cache-Control', 'nocache, no-store, max-age=0, must-revalidate')
                        ->header('Pragma', 'no-cache')
                        ->header('Expires', 'Sun, 02 Jan 1990 00:00:00 GMT');
    }

}
