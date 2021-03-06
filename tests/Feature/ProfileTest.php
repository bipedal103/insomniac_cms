<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;

class ProfileTest extends TestCase
{
	public function testUpdateProfile(): void
	{
		$user = $this->getUser();

		$name = $this->faker()->name();
		$email = $this->faker()->safeEmail();

		$response = $this->withToken($user->token())->postJson(route('api.me.update'), [
			'name' => $name,
			'email' => $email
		]);

		$response->assertOk()->assertJsonPath('data.name', $name)->assertJsonPath('data.email', $email);
	}

	public function testChangePassword(): void
	{
		$user = $this->getUser();

		$response = $this->withToken($user->token())->postJson(route('api.me.update-password'), [
			'current_password' => 'test1234',
			'password' => 'test12345',
			'password_confirmation' => 'test12345'
		]);

		$response->assertOk();

		$this->assertNotEquals($user->password, $user->fresh()->password);
	}

	public function testChangeAvatar(): void
	{
		$user = $this->getUser();
		$token = $user->token();

		$response = $this->withToken($token)->postJson(route('api.me.update-avatar'), [
			'avatar' => UploadedFile::fake()->image('avatar.jpg', 400, 400)
		]);

		$response->assertOk();

		$this->assertNotEquals($user->avatar, $user->fresh()->avatar);

		$response = $this->withToken($token)->postJson(route('api.me.update-avatar'));

		$response->assertOk()->assertJsonPath('data.avatar', null);
	}

	public function testDeleteProfile(): void
	{
		$user = $this->getUser();

		$response = $this->withToken($user->token())->deleteJson(route('api.me.remove'));

		$response->assertOk()->assertJsonPath('data.deleted', true);
	}

	public function testGetSessions(): void
	{
		$user = $this->getUser();

		$response = $this->withToken($user->token())->getJson(route('api.me.sessions'));

		$response->assertOk();
	}
}
