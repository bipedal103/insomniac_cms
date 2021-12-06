<?php

namespace App\Models;

use App\Traits\HasLimitedScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotificationTarget extends Model
{
	use HasLimitedScope;

	protected $casts = [
		'seen_at' => 'datetime',
	];

	public function notification(): BelongsTo
	{
		return $this->belongsTo(Notification::class);
	}

	public function user(): MorphTo
	{
		return $this->morphTo();
	}

	public function scopeUserScope(Builder $query): Builder
	{
		return $query->whereHas('user', function ($query) {
			$query->userScope();
		});
	}
}
