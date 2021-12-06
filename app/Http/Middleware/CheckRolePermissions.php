<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Symfony\Component\HttpFoundation\Response;

class CheckRolePermissions
{
	/**
	 * Handle an incoming request.
	 */
	public function handle(Request $request, Closure $next): Response
	{
		$user = $request->user();

		if (!$user || !$user->isAvailable() || !$user->canViewRoute($this->getCurrentRoute($request)->getName())) {
			abort(Response::HTTP_FORBIDDEN);
		}

		$dryRunHeaderName = config('custom.dry_run_header_name');

		if ($header = $request->header($dryRunHeaderName)) {
			abort(Response::HTTP_NO_CONTENT, '', [
				$dryRunHeaderName => $header
			]);
		}

		return $next($request);
	}

	private function getCurrentRoute(Request $request): Route
	{
		return $request->route();
	}
}
