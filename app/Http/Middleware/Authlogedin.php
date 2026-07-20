<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;

class Authlogedin
{
	public function handle(Request $request, Closure $next){
		$session  = $request->session()->get('auth_user');
		if (empty($session)) {
			return redirect('/login');
		}
		return $next($request);
	}
}