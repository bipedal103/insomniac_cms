<?php

namespace App\Http\Controllers\Api;

use App\Models\Session;
use App\Http\Requests\OAuthToken;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\UpdateAvatar;
use App\Services\Auth\OAuthHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfile;
use App\Http\Requests\ChangePassword;
use App\Http\Resources\SessionResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileController extends Controller
{
	public function me(): JsonResource
	{
		return auth()->user()->getModelResource();
	}

	public function sessions(): JsonResource
	{
		return SessionResource::collection(auth()->user()->sessions()->orderBy('last_activity', 'desc')->simplePaginate());
	}

	public function removeSession(Session $id): JsonResponse
	{
		if ($id->user_id != auth()->user()->id) {
			abort(403);
		}

		return response()->json(['data' => [
			'deleted' => $id->delete(),
		]]);
	}

	public function remove(): JsonResponse
	{
		return response()->json(['data' => [
			'deleted' => auth()->user()->delete(),
		]]);
	}

	public function update(UpdateProfile $request): JsonResource
	{
		$user = $request->user();

		$user->update([
			'name' => $request->name,
			'email' => $request->email,
			'allow_push_notifications' => $request->boolean('allow_push_notifications'),
		]);

		$user->user->update($user->user->updateProfileLogic($request));

		return $user->getModelResource();
	}

	public function updatePassword(ChangePassword $request): JsonResource
	{
		$user = $request->user();

		$user->update([
			'password' => $request->password,
		]);

		return $user->getModelResource();
	}

	public function updateAvatar(UpdateAvatar $request): JsonResource
	{
		$user = $request->user();

		$user->update([
			'avatar' => $user->storage()->deleteFiles('avatar')->handle()->getFirstThumb('avatar')
		]);

		return $user->getModelResource();
	}

	public function connectOAuth(OAuthToken $request, string $driver): JsonResource
	{
		$oAuthHandler = new OAuthHandler;
		$oAuthUser = $oAuthHandler->getUser($driver, $request->access_token, true);

		if (!$oAuthUser) {
			abort(401, $oAuthHandler->getLastExceptionMessage());
		}

		$user = $request->user();
		$syncData = $request->boolean('sync_data');

		$user->update([
			$driver => $oAuthUser->getId(),
			'name' => $syncData ? $oAuthUser->getName() : $user->name,
			'email' => $syncData ? $oAuthUser->getEmail() : $user->email,
			'avatar' => $syncData ? $oAuthUser->getAvatar() : $user->getAvatar()
		]);

		return $user->getModelResource();
	}

	public function disconnectOAuth(string $driver): JsonResource
	{
		$user = auth()->user();

		$user->update([
			$driver => null
		]);

		return $user->getModelResource();
	}
}
