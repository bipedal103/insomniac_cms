<?php

namespace App\Models;

class Setting extends Model
{
	protected $casts = [
		'paypal_sandbox' => 'boolean',
		'debug_mode_active' => 'boolean',
		'queue_media_conversions' => 'boolean',
		'registration_active' => 'boolean',
		'telescope_active' => 'boolean',
		'telescope_same_ip' => 'boolean',
		'monitor_active' => 'boolean',
		'pass_uppercase_char' => 'boolean',
		'pass_numeric_char' => 'boolean',
		'pass_special_char' => 'boolean',
		'bitbucket_active' => 'boolean',
		'github_active' => 'boolean',
		'gitlab_active' => 'boolean',
		'facebook_active' => 'boolean',
		'twitter_active' => 'boolean',
		'google_active' => 'boolean',
		'linkedin_active' => 'boolean',
		'apple_active' => 'boolean',
	];

	public function setAppDescriptionAttribute(?string $value): void
	{
		$this->attributes['app_description'] = $value ? preg_replace('/\s+/', ' ', $value) : null;
	}

	public function setAppEmailAttribute(string $value): void
	{
		$this->attributes['app_email'] = strtolower($value);
	}

	public function setNoreplyEmailAttribute(string $value): void
	{
		$this->attributes['noreply_email'] = strtolower($value);
	}

	public function setAppNameAttribute(string $value): void
	{
		$this->attributes['app_name'] = preg_replace('/\s+/', ' ', $value);
	}

	public function setAppSchemeAttribute(?string $value): void
	{
		$this->attributes['app_scheme'] = $value ? preg_replace('/\s+/', '', strtolower($value)) : null;
	}

	public function setCurrencyCodeAttribute(string $value): void
	{
		$this->attributes['currency_code'] = strtoupper($value);
	}

	public function setVonageFromNumberAttribute(?string $value): void
	{
		$this->attributes['vonage_from_number'] = $value ? preg_replace('/\s+/', '', $value) : null;
	}

	public function setTwilioFromNumberAttribute(?string $value): void
	{
		$this->attributes['twilio_from_number'] = $value ? preg_replace('/\s+/', '', $value) : null;
	}

	public function setInfobipFromNumberAttribute(?string $value): void
	{
		$this->attributes['infobip_from_number'] = $value ? preg_replace('/\s+/', '', $value) : null;
	}

	public function setNthFromNumberAttribute(?string $value): void
	{
		$this->attributes['nth_from_number'] = $value ? preg_replace('/\s+/', '', $value) : null;
	}

	public function setElksFromNumberAttribute(?string $value): void
	{
		$this->attributes['elks_from_number'] = $value ? preg_replace('/\s+/', '', $value) : null;
	}

	//Clear spaces, replace commas with %20 - url space separator
	public function setSpotifyPermsAttribute(?string $value): void
	{
		$this->attributes['spotify_perms'] =  $value ? preg_replace('/,/', '%20', preg_replace('/\s+/', '', $value)) : '';
	}

	public function setSpotifyConnectUrlAttribute(): void
	{												//https://accounts.spotify.com/en/authorize?scope=user-read-private%20user-read-email&state=12345
		$this->attributes['spotify_connect_url'] = "https://accounts.spotify.com/en/authorize?response_type=code&client_id={$this->spotify_app_id}&redirect_uri={$this->spotify_redirect_url}&scope={$this->spotify_perms}";
	}
}
