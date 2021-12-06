<?php

namespace App\Contracts;

use Illuminate\Support\Carbon;

interface HasJwt
{
	public function getJwtId(): string;

	public function getJwtValidFromTime(): ?Carbon;

	public function getJwtValidUntilTime(): ?Carbon;

	public function getJwtCustomClaims(): array;

	public function token(array $config = []): string;
}
