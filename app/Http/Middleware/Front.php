<?php

namespace App\Http\Middleware;

use Closure;
use Session;
class Front
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
        $loginUser = auth('front')->user();  //$loginUser->role != "ADMIN" || $loginUser->role != "VENDOR"  ||
        
        if (empty($loginUser)) {
            return redirect("/");
        }
        $response = $next($request);

        $response->headers->set('Access-Control-Allow-Origin' , '*');
        $response->headers->set('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With, Application');
        return $response;
                        
    }
}
