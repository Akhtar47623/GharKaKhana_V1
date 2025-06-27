<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use App\Model\Users;
use Closure;
use Lang;
use DB;

class APIToken
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
		try {
			$authToken = $request->header('Authorization', null);
			if($authToken != null){
				$checkToken = Users::select(['id','token'])
									->where(['token'=>$authToken])
									->first();
				if(empty($checkToken) && $checkToken === null){
					return response()->json([
						'status' => false,
						'message' => Lang::get('Unauthorized'),
					]);
				} 
				return $next($request);
			}
			return response()->json([
				'status' => false,
				'message' => Lang::get('AUTHORIZATION KEY MISSING IN HEADER'),  //invalid_api_request
			]); 
			
		} catch (Exception $e) {
			return response()->json([
				'status' => false,
				'message' => Lang::get('Oops something went wrong'),
				'error_log' => 'Caught exception: '. $e->getMessage(),
			]); 
		}  
	}
}


