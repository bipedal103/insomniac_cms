<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Notifications\Notification;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailNotification;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;

trait IsUser
{
	use Prunable, HasJwt;

	public function authParent(): MorphOne
	{
		return $this->morphOne(User::class, 'user');
	}

	public function profileRoute(?string $default = null): ?string
	{
		return $default;
	}

	public function getUserType(): string
	{
		return strtolower(class_basename($this));
	}

	public function verifyEmailNotification(): Notification
	{
		return new VerifyEmailNotification;
	}

	public function passwordResetNotification(string $token): Notification
	{
		$notification = new ResetPasswordNotification($token);

		$notification->createUrlUsing(function ($user, string $token) {
			return $this->passwordResetTokenUrl($token);
		});

		return $notification;
	}

	public function passwordResetTokenUrl(string $token): string
	{
		return route('password.reset', $token);
	}

	public function verifyEmailRedirectUrl(): ?string
	{
		return null;
	}

	public function passwordResetRedirectUrl(): ?string
	{
		return null;
	}

	public function getModelResource(User $authParent): JsonResource
	{
		return new UserResource($authParent);
	}

	public function getUserExtraData(?Request $request = null): ?array
	{
		return null;
	}

	public function getPublicUserExtraData(?Request $request = null): ?array
	{
		return $this->getUserExtraData($request);
	}

	public function mustVerifyEmail(): bool
	{
		return app()->isProduction();
	}

	public function isAvailable(): bool
	{
		return true;
	}

	public function hasLimitedScope(object $model): bool
	{
		return false;
	}

	public function updateProfileValidationRules(?Request $request = null): array
	{
		return [];
	}

	public function updateProfileLogic(Request $request): array
	{
		return [];
	}

	public function scopeAvailable(Builder $query): Builder
	{
		return $query->whereHas('authParent', function ($query) {
			$query->available();
		});
	}

	public function scopeIncludes(Builder $query): Builder
	{
		return $query->with(['authParent', 'authParent.media']);
	}

	public function scopeSearch(Builder $query, ?string $search = null): Builder
	{
		return $query->whereHas('authParent', function ($query) use ($search) {
			$query->search($search);
		});
	}

	public function scopeNotifiable(Builder $query): Builder
	{
		return $query->with('authParent')->whereHas('authParent', function ($query) {
			$query->notifiable();
		});
	}

	public function scopeCanViewRoute(Builder $query, ?string $route = null): Builder
	{
		return $query->with('authParent')->whereHas('authParent', function ($query) use ($route) {
			$query->canViewRoute($route);
		});
	}

	public function scopeUserScope(Builder $query): Builder
	{
		return $query->whereHas('authParent', function ($query) {
			$query->userScope();
		});
	}

	public function scopeLoginLogic(Builder $query, Request $request): Builder
	{
		return $query;
	}

	public function prunable(): Builder
	{
		return static::doesntHave('authParent');
	}

	protected static function bootIsUser(): void
	{
		static::deleting(function ($model) {
			if ($model->authParent()->exists()) {
				$model->authParent->delete();
			}
		});
	}
}
