<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		$isLocal = app()->isLocal();

		Setting::create([
			'app_name' => config('app.name'),
			'app_email' => 'noreply@insomni.ac',
			'noreply_email' => 'noreply@insomni.ac',
			'smtp_host' => 'mail.insomni.ac',
			'smtp_port' => 465,
			'smtp_username' => 'noreply@insomni.ac',
			'smtp_password' => 'MHDQKP+wajD[',
			'smtp_protocol' => 'ssl',
			'date_format' => 'd/m/Y',
			'time_format' => 'H:i',
			'currency_code' => 'USD',
			'jwt_secret_key' => Str::random(32),
			'debug_mode_active' => $isLocal,
			'queue_driver' => $isLocal ? 'sync' : 'redis',
			'media_storage' => $isLocal ? 'public' : 's3',
			'responsive_images_breakpoints' => implode("\n", [400]),
			'csp_allowed_scripts' => implode("\n", ['maps.googleapis.com', 'amcharts.com']),
			'csp_allowed_styles' => implode("\n", ['fonts.googleapis.com', 'amcharts.com']),
			'spotify_app_id' => 'b0188c8e12644c74b136ff592d65f545',
			'spotify_app_secret' => '9c9c153b2b824b658bde481ac1bd9943',
			'spotify_redirect_url' => route('api.spotify.redirect'),
			'spotify_perms' => 'user-read-private,user-read-email,user-follow-read,user-follow-modify,streaming,playlist-read-private,user-library-modify,user-library-read,user-read-playback-state,user-read-recently-played',
			'spotify_connect_url' => null,
		]);
	}
}
