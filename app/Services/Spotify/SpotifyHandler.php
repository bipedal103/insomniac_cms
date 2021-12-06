<?php

namespace App\Services\Spotify;

use Illuminate\Support\Facades\Http;
use App\Services\Support\BaseApiHandler;

class SpotifyHandler extends BaseApiHandler
{
	public const API_URL = 'https://api.spotify.com/v1/';
	public const APP_AUTH_URL = 'https://accounts.spotify.com/api/';

	private string $appId;
	private string $clientSecret;
	private string $token;

	public function __construct(?string $token = null)
	{
		parent::__construct();
		$this->token = $token;
		$this->appId = setting('spotify_app_id');
		$this->clientSecret = setting('spotify_app_secret');

		$this->client = $this->client->baseUrl(self::API_URL);
	}

	public function getToken(string $code): ?string
	{
		if ($this->token) {
			return $this->token;
		}

		$data = Http::acceptJson()
			->baseUrl(self::APP_AUTH_URL)
			->asForm()
			->withBasicAuth($this->appId, $this->clientSecret)
			->post('token', [
				'grant_type' => 'authorization_code',
				'code' => $code,
				'redirect_uri' => setting('spotify_redirect_url')
			]);

		$output = $this->returnResponse($data);

		if (!$output) {
			return null;
		}

		$this->token = $output['access_token'] ?? null;

		return $this->token;
	}
}
