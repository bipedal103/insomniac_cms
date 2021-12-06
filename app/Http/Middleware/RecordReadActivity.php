<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RecordReadActivity
{
	/**
	 * Handle an incoming request.
	 */
	public function handle(Request $request, Closure $next, string $routeParam = 'id'): Response
	{
		$response = $next($request);
		$routeParam = $request->route($routeParam);

		if ($response->isSuccessful() && is_object($routeParam)) {
			$routeParam->recordReadActivity();
		}

		return $response;
	}
}
