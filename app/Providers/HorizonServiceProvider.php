<?php

namespace App\Providers;

use Laravel\Horizon\Horizon;
use Illuminate\Support\Facades\Gate;
use Laravel\Horizon\HorizonApplicationServiceProvider;

class HorizonServiceProvider extends HorizonApplicationServiceProvider
{
	/**
	 * Bootstrap any application services.
	 */
	public function boot(): void
	{
		if ($this->app->isLocal()) {
			return;
		}

		$notify_emails = (array) preg_split('/\s+/', setting('monitor_emails'));

		parent::boot();

		// Horizon::routeSmsNotificationsTo('15556667777');
		Horizon::routeMailNotificationsTo($notify_emails[0] ?? setting('app_email'));
		Horizon::routeSlackNotificationsTo(setting('monitor_slack_webhook'));

		// Horizon::night();
	}

	/**
	 * Register the Horizon gate.
	 *
	 * This gate determines who can access Horizon in non-local environments.
	 */
	protected function gate(): void
	{
		Gate::define('viewHorizon', function ($user) {
			return $user && $user->isAvailable() && $user->canViewRoute('horizon-auth', true);
		});
	}
}
