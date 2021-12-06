<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RestrictByUserType
{
	/**
	 * Handle an incoming request.
	 */
	public function handle(Request $request, Closure $next, string ...$types): Response
	{
		$user = $request->user()?->user;

		if (!$user || empty($types)) {
			return $next($request);
		}

		if (!in_array($user::class, $types)) {
			abort(Response::HTTP_FORBIDDEN);
		}

		return $next($request);
	}
}
