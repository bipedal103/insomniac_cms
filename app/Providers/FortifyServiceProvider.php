<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Hash;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use App\Actions\Fortify\ResetUserPassword;
use Illuminate\Support\Facades\RateLimiter;

class FortifyServiceProvider extends ServiceProvider
{
	/**
	 * Register any application services.
	 */
	public function register(): void
	{
	}

	/**
	 * Bootstrap any application services.
	 */
	public function boot(): void
	{
		Fortify::createUsersUsing(CreateNewUser::class);
		Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

		Fortify::authenticateUsing(function (Request $request) {
			$user = User::loginLogic($request)->canViewRouteQuery('home')->where(config('fortify.email', 'email'), $request->email)->first();

			if ($user && Hash::check($request->password, $user->password)) {
				return $user;
			}
		});

		Fortify::loginView(function () {
			return view('auth.login');
		});

		Fortify::registerView(function () {
			if (!setting('registration_active')) {
				abort(403);
			}

			return view('auth.register', [
				'oauth_driver' => session('oauth_driver'),
				'oauth_user' => session('oauth_user')
			]);
		});

		Fortify::requestPasswordResetLinkView(function () {
			return view('auth.passwords.email');
		});

		Fortify::resetPasswordView(function ($request) {
			return view('auth.passwords.reset', ['request' => $request]);
		});

		Fortify::verifyEmailView(function () {
			return view('auth.verify');
		});

		Fortify::confirmPasswordView(function () {
			return view('auth.passwords.confirm');
		});

		Fortify::twoFactorChallengeView(function () {
			return view('auth.2fa');
		});

		RateLimiter::for('login', function (Request $request) {
			return new Limit($request->email . $request->ip(), setting('login_max_attempts'), setting('login_backoff_minutes'));
		});

		RateLimiter::for('two-factor', function (Request $request) {
			return new Limit($request->session()->get('login.id'), setting('login_max_attempts'), setting('login_backoff_minutes'));
		});
	}
}
