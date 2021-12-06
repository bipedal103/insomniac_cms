<?php

namespace App\Services\Auth;

use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;

class PasetoGuard implements Guard
{
	use GuardHelpers;

	private ?array $decodedToken = null;

	public function __construct(UserProvider $provider)
	{
		$this->setProvider($provider);
	}

	/**
	 * Get the currently authenticated user.
	 */
	public function user(): ?Authenticatable
	{
		if ($this->decodedToken && !app()->runningUnitTests()) {
			return $this->user;
		}

		$this->decodedToken = $this->getTokenPayload();

		if (!$this->decodedToken) {
			return null;
		}

		$this->user = $this->getProvider()->retrieveById($this->decodedToken['jti']);

		return $this->user;
	}

	public function validate(array $credentials = []): bool
	{
		return !empty($this->attempt($credentials));
	}

	public function attempt(array $credentials = []): ?Authenticatable
	{
		$provider = $this->getProvider();

		$this->user = $provider->retrieveByCredentials($credentials);
		$this->user = $this->user && $provider->validateCredentials($this->user, $credentials) ? $this->user : null;

		return $this->user;
	}

	public function getTokenPayload(): ?array
	{
		$token = $this->getTokenFromRequest();

		if (!$token) {
			return null;
		}

		$paseto = new Paseto;

		return $paseto->decodeToken($token)->getClaims();
	}

	private function getTokenFromRequest(): ?string
	{
		$request = request();

		return $request->bearerToken() ?? $request->token;
	}
}
