<?php

namespace App\Http\Middleware;
use Closure;

class Authcheck
{
	public function handle($request, Closure $next){
		$session  = $request->session()->get('auth_user');
		if (!empty($session)) {
			return redirect('/');
		}
		return $next($request);
	}
}