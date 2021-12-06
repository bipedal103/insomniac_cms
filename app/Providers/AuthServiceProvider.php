<?php

namespace App\Providers;

use App\Services\Auth\PasetoGuard;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
	/**
	 * Register any authentication / authorization services.
	 */
	public function boot(): void
	{
		$this->registerPolicies();

		auth()->extend('paseto', function ($app, $name, array $config) {
			return new PasetoGuard(auth()->createUserProvider($config['provider']));
		});
	}
}
