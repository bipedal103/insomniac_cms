<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Route;

class MiddlewareTest extends TestCase
{
	public function testRestrictByUserTypeMiddleware(): void
	{
		$user = $this->getUser();

		Route::middleware(['api', 'auth', 'restrict_by_user_type:' . get_class($user->user)])->get('api/test-route', function () {
			return response()->json();
		});

		$response = $this->withToken($user->token())->getJson('api/test-route');

		$response->assertOk();
	}

	public function testChangeLocaleMiddleware(): void
	{
		Route::middleware(['api', 'auth', 'change_locale'])->get('api/test-route', function () {
			return response()->json();
		});

		$oldLocale = app()->getLocale();

		$user = $this->getUser([
			'locale' => 'hr'
		]);

		$response = $this->withToken($user->token())->getJson('api/test-route');

		$response->assertOk();

		$this->assertEquals(app()->getLocale(), 'hr');

		app()->setLocale($oldLocale);
	}
}
