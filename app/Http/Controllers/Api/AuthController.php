<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\User;
use App\Models\Admin;
use Laravel\Fortify\Fortify;
use App\Http\Requests\OAuthToken;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\VerifyEmail;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterUser;
use App\Services\Auth\OAuthHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPassword;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;
use App\Http\Requests\ResendEmailVerification;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthController extends Controller
{
	public function login(LoginRequest $request): JsonResource
	{
		$user = User::includes()->where('email', $request->email)->loginLogic($request)->first();

		if (!$user || !Hash::check($request->password, $user->password)) {
			abort(401);
		}

		$user->fireLoginEvent('api');

		return $user->getModelResource();
	}

	public function register(RegisterUser $request): JsonResource
	{
		$user = Admin::create()->authParent()->create([
			'name' => $request->name,
			'email' => $request->email,
			'password' => $request->password,
			'role_id' => setting('registration_api_role_id')
		]);

		$oAuthDriver = (string) $request->oauth_driver;

		if ($oAuthDriver && ($oAuthUser = $this->getOAuthUserFromToken($oAuthDriver, $request->oauth_token))) {
			$user->update([
				$oAuthDriver => $oAuthUser->getId()
			]);
		}

		return $user->getModelResource();
	}

	public function passwordReset(ResetPassword $request): JsonResponse
	{
		$status = null;

		try {
			$status = Password::broker(config('fortify.passwords'))->sendResetLink(['email' => $request->email]);
		} catch (Exception $e) {
			abort(403, $e->getMessage());
		}

		return response()->json([
			'data'=> [
				'status' => $status == Password::RESET_LINK_SENT
			]
		]);
	}

	public function verifyEmail(VerifyEmail $request, User $id): JsonResource|RedirectResponse
	{
		if ($id->hasVerifiedEmail()) {
			return redirect()->intended(Fortify::redirects('email-verification'));
		}

		if ($id->markEmailAsVerified()) {
			event(new Verified($id));
		}

		return $request->wantsJson()
			? $id->getModelResource()
			: redirect()->intended(Fortify::redirects('email-verification'));
	}

	public function resendEmailVerificationNotification(ResendEmailVerification $request): JsonResponse|RedirectResponse
	{
		$request->user()->sendEmailVerificationNotification();

		return $request->wantsJson()
			? response()->json([
				'data'=> [
					'status' => true
				]
			])
			: back()->with('status', 'verification-link-sent');
	}

	public function oauthLogin(OAuthToken $request, string $driver): JsonResource
	{
		$user = $this->getOAuthUserFromToken($driver, $request->access_token);

		if (!$user) {
			abort(401);
		}

		$user = User::has('user')->where($driver, $user->getId())->firstOrFail();

		$user->fireLoginEvent('api');

		return $user->getModelResource();
	}

	private function getOAuthUserFromToken(string $driver, string $token): ?object
	{
		$oAuthHandler = new OAuthHandler;

		return $oAuthHandler->getUser($driver, $token, true);
	}
}
