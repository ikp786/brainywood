<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @param  string|null  $guard
	 * @return mixed
	 */
	public function handle($request, Closure $next, $guard = null)
	{
		/*  echo "string";
		print_r($guard);exit();*/
		if (Auth::guard($guard)->check()) {
			return redirect('/admin/home');
		}
		/*if (Auth::guard($guard)->guest()) {
			if ($guard === 'api') {
				//return response('Unauthorized.', 401);
				return response()->json(['statusCode' => 401, 'message' => 'Unauthorized!', 'data' => array()]);
			} else {
				return redirect('/admin/home');
			}
		}*/

		return $next($request);
	}
}
