<?php

namespace App\Models;

use App\Observers\RoleObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
	public const LIST_MODE_WHITE = 1;
	public const LIST_MODE_BLACK = 2;

	protected $casts = [
		'protected' => 'boolean',
	];

	public function canViewRoute(string $route, bool $persisted = false): bool
	{
		if ($persisted) {
			return $this->canViewRoutePersisted($route);
		}

		return $this->routes()->where('route', $route)->exists() ? $this->mode == self::LIST_MODE_WHITE : $this->mode == self::LIST_MODE_BLACK;
	}

	public function scopeCanViewRouteQuery(Builder $query, string $route): Builder
	{
		return $query->where(function ($query) use ($route) {
			$query->where('mode', self::LIST_MODE_WHITE)->whereHas('routes', function ($query) use ($route) {
				$query->where('route', $route);
			});
		})
		->orWhere(function ($query) use ($route) {
			$query->where('mode', self::LIST_MODE_BLACK)->whereDoesntHave('routes', function ($query) use ($route) {
				$query->where('route', $route);
			});
		});
	}

	public function scopeAvailable(Builder $query): Builder
	{
		return $query->where('protected', false);
	}

	public function routes(): HasMany
	{
		return $this->hasMany(RoleRoute::class);
	}

	public function setNameAttribute(string $value): void
	{
		$this->attributes['name'] = preg_replace('/\s+/', ' ', $value);
	}

	public function users(): HasMany
	{
		return $this->hasMany(User::class);
	}

	protected static function initObservers(): ?string
	{
		return RoleObserver::class;
	}

	private function canViewRoutePersisted(string $route): bool
	{
		static $dbRoutes = null;

		$dbRoutes ??= $this->routes->pluck('route')->all();

		return in_array($route, $dbRoutes) ? $this->mode == self::LIST_MODE_WHITE : $this->mode == self::LIST_MODE_BLACK;
	}
}
