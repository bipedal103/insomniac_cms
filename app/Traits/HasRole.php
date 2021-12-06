<?php

namespace App\Traits;

use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasRole
{
	use HasJwt;

	public function canViewRoute(string $route, bool $persisted = false): bool
	{
		return !$this->role_id || $this->role->canViewRoute($route, $persisted);
	}

	public function scopeCanViewRouteQuery(Builder $query, string $route): Builder
	{
		return $query->doesntHave('role')->orWhereHas('role', function ($query) use ($route) {
			$query->canViewRouteQuery($route);
		});
	}

	public function role(): BelongsTo
	{
		return $this->belongsTo(Role::class);
	}
}
