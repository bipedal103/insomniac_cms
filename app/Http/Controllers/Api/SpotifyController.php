<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreSpotify;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Services\Spotify\SpotifyHandler;

class SpotifyController extends Controller
{
	public function redirect(StoreSpotify $request): RedirectResponse
	{
		if ($request->filled('error')) {
			abort(403, 'User has denied auth!');
		}

		$spotify = new SpotifyHandler;
		$token = $spotify->getToken($request->code);

		if (!$token) {
			abort(403, 'Getting token failed!');
		}

		$reddirect_url = base64_decode($request->state) . '?token=' . $token;

		return redirect()->away($reddirect_url);
	}
}
