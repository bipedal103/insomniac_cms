<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DbController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\MiscController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StorageController;
use App\Http\Controllers\SmsMessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UptimeMonitorController;
use App\Http\Controllers\Settings\GeneralController;
use App\Http\Controllers\IncomingSmsMessageController;
use Laravel\Fortify\Http\Controllers\EmailVerificationPromptController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

// FORTIFY ROUTES
if (config('fortify.views')) {
	Route::middleware('auth')->get('email/verify', EmailVerificationPromptController::class)->name('verification.notice');
}

// LOGIN ROUTES
Route::prefix('login')->name('login.')->group(function ($route) {
	$c = AuthController::class;

	// GET
	$route->middleware('signed')->get('silent/{user}', [$c, 'silent'])->name('silent');

	// OAUTH
	$route->middleware('guest')->name('oauth.')->group(function ($route) use ($c) {
		// GET
		$route->get('{driver}/callback', [$c, 'oAuthCallback'])->name('callback');
		$route->get('{driver}', [$c, 'oAuthRedirect'])->name('redirect');
	});
});

// PROTECTED ROUTES
Route::middleware(['auth', 'verified', 'check_role_permissions', 'change_locale'])->group(function ($route) {
	$c = MiscController::class;

	// MISC ROUTES - GET
	$route->get('', [$c, 'dashboard'])->name('home');
	$route->get('dashboard', [$c, 'dashboard'])->name('dashboard');
	$route->get('tech-info', [$c, 'techinfo'])->name('tech-info');
	$route->get('telescope-auth', [$c, 'telescope'])->name('telescope-auth');
	$route->get('horizon-auth', [$c, 'horizon'])->name('horizon-auth');
	$route->get('locale', [$c, 'locale'])->name('change-locale');

	// MISC ROUTES - POST
	$route->post('feedback', [$c, 'feedback'])->name('feedback');
	$route->post('invalidate-sessions', [$c, 'invalidateSessions'])->name('invalidate-sessions');

	// SETTINGS ROUTES
	$route->prefix('settings')->name('settings.')->group(function ($route) {
		// GENERAL
		$route->prefix('general')->name('general.')->group(function ($route) {
			$c = GeneralController::class;

			// GET
			$route->get('', [$c, 'edit'])->name('edit');

			// POST
			$route->post('{id}', [$c, 'update'])->name('update');
		});
	});

	// STORAGE ROUTES
	$route->prefix('media-storage')->name('storage.')->group(function ($route) {
		$c = StorageController::class;

		// GET
		$route->get('', [$c, 'index'])->name('list');

		// DELETE
		$route->delete('', [$c, 'multiRemove'])->name('remove-multi');
	});

	// DB TABLE ROUTES
	$route->prefix('db')->name('db.')->group(function ($route) {
		$c = DbController::class;

		// GET
		$route->get('', [$c, 'index'])->name('list');
		$route->get('{table}', [$c, 'show'])->name('show');

		// DELETE
		$route->delete('', [$c, 'multiRemove'])->name('remove-multi');
		$route->delete('truncate', [$c, 'multiTruncate'])->name('truncate-multi');
		$route->delete('{table}/columns', [$c, 'multiRemoveColumns'])->name('remove-columns-multi');
	});

	// MONITOR ROUTES
	$route->prefix('monitors')->name('monitors.')->group(function ($route) {
		$c = UptimeMonitorController::class;

		// GET
		$route->get('', [$c, 'index'])->name('list');
		$route->get('add', [$c, 'create'])->name('add');
		$route->get('{id}', [$c, 'edit'])->name('edit');

		// POST
		$route->post('', [$c, 'store'])->name('store');
		$route->post('activate', [$c, 'multiActivate'])->name('activate');
		$route->post('deactivate', [$c, 'multiDeactivate'])->name('deactivate');
		$route->post('{id}', [$c, 'update'])->name('update');

		// DELETE
		$route->delete('', [$c, 'multiRemove'])->name('remove-multi');
		$route->delete('{id}', [$c, 'destroy'])->name('remove');
	});

	// BLOG ROUTES
	$route->prefix('blogs')->name('blogs.')->group(function ($route) {
		$c = BlogController::class;

		// GET
		$route->get('', [$c, 'index'])->name('list');
		$route->get('search', [$c, 'search'])->name('search');
		$route->get('add', [$c, 'create'])->name('add');
		$route->get('{id}', [$c, 'edit'])->name('edit');

		// POST
		$route->post('', [$c, 'store'])->name('store');
		$route->post('{id}', [$c, 'update'])->name('update');

		// DELETE
		$route->delete('', [$c, 'multiRemove'])->name('remove-multi');
		$route->delete('{id}', [$c, 'destroy'])->name('remove');
	});

	// USER ROUTES
	$route->prefix('users')->name('users.')->group(function ($route) {
		$c = UserController::class;

		// GET
		$route->get('profile', [$c, 'profile'])->name('profile');
		$route->get('', [$c, 'index'])->name('list');
		$route->get('add', [$c, 'create'])->name('add');
		$route->get('{id}/sessions', [$c, 'sessions'])->name('sessions');
		$route->get('{id}/2fa', [$c, 'toggle2FAForm'])->name('2fa');
		$route->get('{id}', [$c, 'edit'])->name('edit');

		// POST
		$route->post('', [$c, 'store'])->name('store');
		$route->post('activate', [$c, 'multiActivate'])->name('activate');
		$route->post('deactivate', [$c, 'multiDeactivate'])->name('deactivate');
		$route->post('{id}', [$c, 'update'])->name('update');

		// DELETE
		$route->delete('', [$c, 'multiRemove'])->name('remove-multi');
		$route->delete('sessions', [$c, 'removeSessions'])->name('remove-sessions');
		$route->delete('{id}', [$c, 'destroy'])->name('remove');
	});

	// NOTIFICATION ROUTES
	$route->prefix('notifications')->name('notifications.')->group(function ($route) {
		$c = NotificationController::class;

		// GET
		$route->get('', [$c, 'index'])->name('list');
		$route->get('add', [$c, 'create'])->name('add');
		$route->get('{id}', [$c, 'show'])->name('show');

		// POST
		$route->post('', [$c, 'store'])->name('store');

		// DELETE
		$route->delete('cancel', [$c, 'multiCancel'])->name('cancel-multi');
		$route->delete('', [$c, 'multiRemove'])->name('remove-multi');
		$route->delete('{id}/cancel', [$c, 'cancel'])->name('cancel');
		$route->delete('{id}', [$c, 'destroy'])->name('remove');
	});

	// SMS MESSAGE ROUTES
	$route->prefix('sms-messages')->name('sms-messages.')->group(function ($route) {
		// INCOMING ROUTES
		$route->prefix('incoming')->name('incoming.')->group(function ($route) {
			$c = IncomingSmsMessageController::class;

			// GET
			$route->get('', [$c, 'index'])->name('list');
			$route->get('search', [$c, 'search'])->name('search');
			$route->get('{id}', [$c, 'show'])->name('show');

			// DELETE
			$route->delete('', [$c, 'multiRemove'])->name('remove-multi');
			$route->delete('{id}', [$c, 'destroy'])->name('remove');
		});

		$c = SmsMessageController::class;

		// GET
		$route->get('', [$c, 'index'])->name('list');
		$route->get('search', [$c, 'search'])->name('search');
		$route->get('add', [$c, 'create'])->name('add');
		$route->get('{id}', [$c, 'show'])->name('show');

		// POST
		$route->post('', [$c, 'store'])->name('store');

		// DELETE
		$route->delete('', [$c, 'multiRemove'])->name('remove-multi');
		$route->delete('{id}', [$c, 'destroy'])->name('remove');
	});

	// ROLE ROUTES
	$route->prefix('roles')->name('roles.')->group(function ($route) {
		$c = RoleController::class;

		// GET
		$route->get('', [$c, 'index'])->name('list');
		$route->get('add', [$c, 'create'])->name('add');
		$route->get('{id}', [$c, 'edit'])->name('edit');

		// POST
		$route->post('', [$c, 'store'])->name('store');
		$route->post('users', [$c, 'storeUsers'])->name('store-users');
		$route->post('{id}', [$c, 'update'])->name('update');

		// DELETE
		$route->delete('', [$c, 'multiRemove'])->name('remove-multi');
		$route->delete('{id}', [$c, 'destroy'])->name('remove');
	});
});
