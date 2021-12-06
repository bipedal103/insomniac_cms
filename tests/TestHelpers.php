<?php

namespace Tests;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

trait TestHelpers
{
	protected function getUser(array $extraData = []): User|Collection
	{
		return User::factory()->create($extraData);
	}

	protected function getInactiveUser(array $extraData = []): User|Collection
	{
		return User::factory()->inactive()->create($extraData);
	}
}
