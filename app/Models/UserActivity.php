<?php

namespace App\Models;

use App\Traits\HasLimitedScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserActivity extends Model
{
	use HasLimitedScope;

	public const TYPE_CREATE = 1;
	public const TYPE_READ = 2;
	public const TYPE_UPDATE = 3;
	public const TYPE_DELETE = 4;

	protected $casts = [
		'updated_fields' => 'array',
	];

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}

	public function item(): MorphTo
	{
		return $this->morphTo();
	}

	public function scopeIncludes(Builder $query): Builder
	{
		return $query->with([
			'user' => function ($query) {
				$query->includes();
			}
		]);
	}

	public function scopeSearch(Builder $query, ?string $search = null): Builder
	{
		$search = preg_replace('/\s+/', '%', $search ?? '');
		$search = empty($search) ? null : '%' . $search . '%';

		return !$search ? $query : $query->whereHas('user', function ($query) use ($search) {
			$query->where('name', 'like', $search)->orWhere('email', 'like', $search);
		});
	}

	public function scopeUserScope(Builder $query): Builder
	{
		return $query->whereHas('user', function ($query) {
			$query->userScope();
		});
	}
}
