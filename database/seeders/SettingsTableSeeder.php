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
			'app_email' => 'weare@lloyds-digital.com',
			'noreply_email' => 'noreply@lloyds-design.hr',
			'smtp_host' => 'mail.lloyds-design.hr',
			'smtp_port' => 465,
			'smtp_username' => 'noreply@lloyds-design.hr',
			'smtp_password' => 'x5LV%x1z@,Bp',
			'smtp_protocol' => 'ssl',
			'date_format' => 'd/m/Y',
			'time_format' => 'H:i',
			'currency_code' => 'USD',
			'google_api_key' => 'AIzaSyALIWQWRzkuSQ8SE6qLDOHDZEOycM27_3c',
			'aws_access_key_id' => 'AKIAID6H5BG32NO4E6LQ',
			'aws_secret_access_key' => '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',
			'aws_default_region' => 'eu-central-1',
			'aws_bucket_name' => 'lloyds-backend',
			'aws_bucket_url' => 'https://lloyds-backend.s3.amazonaws.com',
			'jwt_secret_key' => Str::random(32),
			'debug_mode_active' => $isLocal,
			'queue_driver' => $isLocal ? 'sync' : 'redis',
			'media_storage' => $isLocal ? 'public' : 's3',
			'responsive_images_breakpoints' => implode("\n", [400]),
			'csp_allowed_scripts' => implode("\n", ['maps.googleapis.com', 'amcharts.com']),
			'csp_allowed_styles' => implode("\n", ['fonts.googleapis.com', 'amcharts.com']),
			'spotify_app_id' => 'ccb4251897de4472839e5ce6f4adefbc',
			'spotify_app_secret' => '51a8f644cd1247a3b87a13a0bf67f018',
			'spotify_redirect_url' => route('api.spotify.redirect'),
			'spotify_perms' => 'user-read-private,user-read-email,user-follow-read,user-follow-modify,streaming,playlist-read-private,user-library-modify,user-library-read,user-read-playback-state,user-read-recently-played',
			'spotify_connect_url' => null,
		]);
	}
}
