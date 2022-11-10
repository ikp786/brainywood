<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Log;
use DB;
class CheckAuthMiddleware
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
        $user = Auth::user();
        //echo '<pre />'; print_r($user); die;
        if (empty($user))
		{
            //return redirect('/no-token-found');
            $message = "User not Available.";
            return response()->json(['statusCode' => 203, 'message' => $message, 'data' => array()]);
		}
        return $next($request);
    }
}
