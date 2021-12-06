<?php

use App\Models\User;
use App\Models\Setting;
use Illuminate\Support\Carbon;

function setting(?string $key = null, mixed $default = null, bool $invalidateCache = false): mixed
{
	static $setting = null;

	$setting = $setting && !$invalidateCache ? $setting : Setting::first();

	return $key ? ($setting->{$key} ?? $default) : $setting;
}

function formatTimestamp(Carbon|DateTimeInterface|string $carbon = null, ?string $format = 'Y-m-d H:i:s', string $inputFormat = 'Y-m-d H:i:s', ?string $inputTimezone = 'UTC'): ?string
{
	return formatLocalTimestamp($carbon, $format, 'UTC', $inputFormat, $inputTimezone);
}

function formatLocalTimestamp(Carbon|DateTimeInterface|string $carbon = null, ?string $format = null, ?string $timezone = null, string $inputFormat = 'Y-m-d H:i:s', ?string $inputTimezone = 'UTC'): ?string
{
	$format ??= setting('date_format') . ' ' . setting('time_format');
	$timezone ??= auth()->user()?->timezone ?? setting('timezone');

	$carbon ??= now($timezone);

	if (is_string($carbon)) {
		$carbon = now($timezone)->createFromFormat($inputFormat, $carbon, $inputTimezone);
	} elseif ($carbon instanceof DateTimeInterface) {
		$carbon = now($timezone)->createFromInterface($carbon);
	}

	return $carbon ? $carbon->setTimezone($timezone)->format($format) : null;
}

function getUser(bool $invalidateCache = false): ?User
{
	static $user = null;

	$invalidateCache = $invalidateCache ?: app()->runningUnitTests();

	if ($user && !$invalidateCache) {
		return $user;
	}

	$user = auth(getCurrentAuthGuard())->user();

	return $user;
}

function getCurrentAuthGuard(?string $default = null): ?string
{
	$guards = array_keys(config('auth.guards'));

	foreach ($guards as $guard) {
		$guard = (string) $guard;

		if (auth($guard)->check()) {
			auth()->shouldUse($guard);

			return $guard;
		}
	}

	return $default;
}

function renderTimezones(): array
{
	$timezones = [];

	foreach (timezone_identifiers_list() as $timezone) {
		$items = explode('/', $timezone);

		if (count($items) == 1) {
			$timezones[$timezone] = str_replace('_', ' ', $timezone);
		} else {
			$timezones[array_shift($items)][$timezone] = str_replace('_', ' ', implode(' - ', $items));
		}
	}

	return $timezones;
}

function stringifyAttr(array $attributes): string
{
	foreach ($attributes as $key => &$value) {
		if (is_bool($value)) {
			if ($value) {
				$value = $key;
			}
		} else {
			$value = $key . '="' . $value . '"';
		}
	}

	return implode(' ', $attributes);
}
