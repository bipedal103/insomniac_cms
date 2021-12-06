<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\ChartController;
use App\Http\Controllers\Api\MediaController;
use App\Http\Controllers\Api\ConfigController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\SpotifyController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\PushDeviceController;
use App\Http\Controllers\Api\SmsWebhookController;
use App\Http\Controllers\Api\NotificationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

// FORTIFY ROUTES
Route::middleware('throttle:' . config('fortify.limiters.verification'))->prefix('auth/email')->name('verification.')->group(function ($route) {
	$c = AuthController::class;

	// GET
	$route->middleware('signed')->get('verify/{id}/{hash}', [$c, 'verifyEmail'])->name('verify');

	// POST
	$route->middleware('auth')->post('verification-notification', [$c, 'resendEmailVerificationNotification'])->name('send');
});

Route::name('api.')->group(function ($route) {

	// SPOTIFY ROUTES
	$route->prefix('spotify')->name('spotify.')->group(function ($route) {
		$c = SpotifyController::class;
		// GET
		$route->get('redirect', [$c, 'redirect'])->name('redirect');
	});

	// CONFIG ROUTE
	$route->get('config', [ConfigController::class, 'config'])->name('config');

	// AUTH ROUTES
	$route->prefix('auth')->name('auth.')->group(function ($route) {
		$c = AuthController::class;

		// POST
		$route->post('register', [$c, 'register'])->name('register');
		$route->post('reset-password', [$c, 'passwordReset'])->name('reset-password');

		// LOGIN ROUTES
		$route->prefix('login')->name('login.')->group(function ($route) use ($c) {
			// POST
			$route->post('', [$c, 'login'])->name('standard');
			$route->post('{driver}', [$c, 'oauthLogin'])->name('oauth');
		});
	});

	// BLOG ROUTES
	$route->prefix('blogs')->name('blogs.')->group(function ($route) {
		$c = BlogController::class;

		// GET
		$route->get('', [$c, 'index'])->name('list');
		$route->get('{id}/activities', [$c, 'activities'])->name('activities');
		$route->get('{id}', [$c, 'single'])->name('single');
	});

	// TAG ROUTES
	$route->prefix('tags')->name('tags.')->group(function ($route) {
		$c = TagController::class;

		// GET
		$route->get('', [$c, 'index'])->name('list');
	});

	// MEDIA ROUTES
	$route->middleware('signed')->prefix('media')->name('media.')->group(function ($route) {
		$c = MediaController::class;

		// GET
		$route->get('{id}', [$c, 'getMediaUrl'])->name('url');
	});

	// WEBHOOK ROUTES
	$route->prefix('webhooks')->name('webhooks.')->group(function ($route) {

		// SMS
		$route->prefix('sms')->name('sms.')->group(function ($route) {
			$c = SmsWebhookController::class;

			// VONAGE
			$route->prefix('vonage')->name('vonage.')->group(function ($route) use ($c) {
				$route->match(['get', 'post'], 'incoming', [$c, 'vonageIncoming'])->name('incoming');
				$route->match(['get', 'post'], '{id}', [$c, 'vonageReport'])->name('report');
			});

			// TWILIO
			$route->prefix('twilio')->name('twilio.')->group(function ($route) use ($c) {
				$route->match(['get', 'post'], 'incoming', [$c, 'twilioIncoming'])->name('incoming');
				$route->post('{id}', [$c, 'twilioReport'])->name('report');
			});

			// INFOBIP
			$route->prefix('infobip')->name('infobip.')->group(function ($route) use ($c) {
				$route->post('incoming', [$c, 'infobipIncoming'])->name('incoming');
				$route->post('', [$c, 'infobipReport'])->name('report');
			});

			// NTH
			$route->prefix('nth')->name('nth.')->group(function ($route) use ($c) {
				$route->post('incoming', [$c, 'nthIncoming'])->name('incoming');
				$route->post('{id}', [$c, 'nthReport'])->name('report');
			});

			// 46elks
			$route->prefix('elks')->name('elks.')->group(function ($route) use ($c) {
				$route->post('incoming', [$c, 'elksIncoming'])->name('incoming');
				$route->post('{id}', [$c, 'elksReport'])->name('report');
			});
		});
	});

	// JWT PROTECTED ROUTES
	$route->middleware(['auth', 'verified', 'check_role_permissions'])->group(function ($route) {
		// PROFILE ROUTES
		$route->prefix('me')->name('me.')->group(function ($route) {
			$c = ProfileController::class;

			// GET
			$route->get('', [$c, 'me'])->name('get');
			$route->get('sessions', [$c, 'sessions'])->name('sessions');

			// POST
			$route->post('', [$c, 'update'])->name('update');
			$route->post('password', [$c, 'updatePassword'])->name('update-password');
			$route->post('avatar', [$c, 'updateAvatar'])->name('update-avatar');

			// DELETE
			$route->delete('', [$c, 'remove'])->name('remove');
			$route->delete('sessions/{id}', [$c, 'removeSession'])->name('remove-session');

			// OAUTH ROUTES
			$route->prefix('oauth')->name('oauth.')->group(function ($route) use ($c) {
				// POST
				$route->post('{driver}', [$c, 'connectOAuth'])->name('connect');

				// DELETE
				$route->delete('{driver}', [$c, 'disconnectOAuth'])->name('disconnect');
			});
		});

		// Location ROUTES
		$route->prefix('location')->name('location.')->group(function ($route) {
			$c = LocationController::class;

			// GET
			$route->get('countries', [$c, 'countries'])->name('countries');
			$route->get('address', [$c, 'address'])->name('address');
			$route->get('lat-lng', [$c, 'latLng'])->name('lat-lng');
		});

		// NOTIFICATION ROUTES
		$route->prefix('notifications')->name('notifications.')->group(function ($route) {
			$c = NotificationController::class;

			// GET
			$route->get('', [$c, 'index'])->name('list');
			$route->get('{id}', [$c, 'single'])->name('single');

			// POST
			$route->post('seen', [$c, 'seenAll'])->name('seen-all');

			// DELETE
			$route->delete('{id}', [$c, 'remove'])->name('remove');
		});

		// USER DEVICES ROUTES
		$route->prefix('devices')->name('devices.')->group(function ($route) {
			$c = PushDeviceController::class;

			// GET
			$route->get('', [$c, 'index'])->name('list');

			// POST
			$route->post('', [$c, 'store'])->name('store');

			// DELETE
			$route->delete('', [$c, 'removeAll'])->name('remove-all');
			$route->delete('{id:device_id}', [$c, 'remove'])->name('remove');
		});

		// CHART ROUTES
		$route->prefix('charts')->name('charts.')->group(function ($route) {
			$c = ChartController::class;

			// POST
			$route->post('notifications', [$c, 'notifications'])->name('notifications');
			$route->post('devices', [$c, 'devices'])->name('devices');
		});
	});
});
