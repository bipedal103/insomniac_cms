<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('settings');
	}

	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('settings', function (Blueprint $table) {
			$table->uuid('id')->primary();
			$table->string('app_name', 50);
			$table->string('app_scheme', 50)->nullable();
			$table->unsignedSmallInteger('ios_min_version')->nullable();
			$table->unsignedSmallInteger('android_min_version')->nullable();
			$table->unsignedSmallInteger('ios_maintenance_min_version')->nullable();
			$table->unsignedSmallInteger('android_maintenance_min_version')->nullable();
			$table->string('app_description', 500)->nullable();
			$table->boolean('debug_mode_active')->default(false);
			$table->string('currency_code', 3);
			$table->string('google_api_key', 50)->nullable();

			$table->string('app_email', 50)->nullable();
			$table->string('noreply_email', 50)->nullable();
			$table->string('smtp_host', 256)->nullable();
			$table->unsignedSmallInteger('smtp_port')->nullable();
			$table->string('smtp_protocol', 3)->nullable();
			$table->string('smtp_username', 128)->nullable();
			$table->string('smtp_password', 128)->nullable();

			$table->string('timezone', 50)->default('UTC');
			$table->string('date_format', 15);
			$table->string('time_format', 15);

			$table->unsignedTinyInteger('min_pass_len')->default(6);
			$table->boolean('pass_uppercase_char')->default(false);
			$table->boolean('pass_numeric_char')->default(false);
			$table->boolean('pass_special_char')->default(false);

			$table->string('jwt_secret_key', 32);
			$table->unsignedInteger('jwt_expiration_time')->nullable()->default(60 * 24 * 365);

			$table->string('media_storage', 50)->default('public');
			$table->unsignedInteger('max_upload_size')->default(5 * 1024 * 1024);
			$table->unsignedSmallInteger('max_video_length')->default(30);
			$table->unsignedSmallInteger('thumb_width')->default(1242);
			$table->string('responsive_images_breakpoints', 100)->nullable();
			$table->boolean('queue_media_conversions')->default(false);
			$table->unsignedSmallInteger('protected_media_token_valid_until')->default(60);

			$table->unsignedTinyInteger('login_max_attempts')->default(5);
			$table->unsignedTinyInteger('login_backoff_minutes')->default(1);
			$table->unsignedTinyInteger('api_rate_limit')->default(60);
			$table->unsignedTinyInteger('api_rate_limit_backoff_minutes')->default(1);

			$table->string('cors_allowed_origins', 250)->nullable();
			$table->string('csp_allowed_scripts', 250)->nullable();
			$table->string('csp_allowed_styles', 250)->nullable();

			$table->unsignedSmallInteger('password_reset_timeout')->default(60);
			$table->unsignedSmallInteger('email_verification_timeout')->default(60);
			$table->boolean('registration_active')->default(true);
			$table->uuid('registration_role_id')->nullable();
			$table->uuid('registration_api_role_id')->nullable();
			$table->string('session_driver', 10)->default('database');
			$table->unsignedSmallInteger('session_lifetime')->default(120);
			$table->string('basic_auth_username_field', 10)->default('email');
			$table->unsignedSmallInteger('push_devices_cleanup_days')->nullable()->default(30);

			$table->string('aws_access_key_id', 128)->nullable();
			$table->string('aws_secret_access_key', 128)->nullable();
			$table->string('aws_default_region', 50)->nullable();
			$table->string('aws_bucket_name', 50)->nullable();
			$table->string('aws_bucket_url', 1000)->nullable();

			$table->string('cache_store', 10)->default('file');
			$table->string('queue_driver', 10)->default('sync');

			$table->uuid('onesignal_app_id')->nullable();
			$table->string('onesignal_rest_api_key', 128)->nullable();
			$table->string('onesignal_user_auth_key', 128)->nullable();
			$table->unsignedTinyInteger('onesignal_stats_check_days')->nullable()->default(1);

			$table->boolean('telescope_active')->default(false);
			$table->boolean('telescope_same_ip')->default(true);
			$table->unsignedSmallInteger('telescope_prune_hours')->nullable()->default(24);

			$table->boolean('monitor_active')->default(false);
			$table->string('monitor_slack_webhook', 1000)->nullable();
			$table->string('monitor_emails', 250)->nullable();

			$table->boolean('paypal_sandbox')->default(true);
			$table->string('paypal_client_id', 128)->nullable();
			$table->string('paypal_client_secret', 128)->nullable();
			$table->string('paypal_sandbox_client_id', 128)->nullable();
			$table->string('paypal_sandbox_client_secret', 128)->nullable();

			$table->string('webhook_scheduler_url', 100)->nullable();
			$table->string('webhook_scheduler_token', 500)->nullable();

			$table->boolean('bitbucket_active')->default(false);
			$table->string('bitbucket_client_id', 128)->nullable();
			$table->string('bitbucket_client_secret', 500)->nullable();

			$table->boolean('github_active')->default(false);
			$table->string('github_client_id', 128)->nullable();
			$table->string('github_client_secret', 500)->nullable();

			$table->boolean('gitlab_active')->default(false);
			$table->string('gitlab_client_id', 128)->nullable();
			$table->string('gitlab_client_secret', 500)->nullable();

			$table->boolean('facebook_active')->default(false);
			$table->string('facebook_client_id', 128)->nullable();
			$table->string('facebook_client_secret', 500)->nullable();

			$table->boolean('twitter_active')->default(false);
			$table->string('twitter_client_id', 128)->nullable();
			$table->string('twitter_client_secret', 500)->nullable();

			$table->boolean('google_active')->default(false);
			$table->string('google_client_id', 128)->nullable();
			$table->string('google_client_secret', 500)->nullable();

			$table->boolean('linkedin_active')->default(false);
			$table->string('linkedin_client_id', 128)->nullable();
			$table->string('linkedin_client_secret', 500)->nullable();

			$table->boolean('apple_active')->default(false);
			$table->string('apple_client_id', 128)->nullable();
			$table->string('apple_client_secret', 500)->nullable();

			$table->string('sms_default_reply', 160)->nullable();

			$table->string('vonage_from_number', 20)->nullable();
			$table->string('vonage_api_key', 128)->nullable();
			$table->string('vonage_api_secret', 128)->nullable();

			$table->string('twilio_from_number', 20)->nullable();
			$table->string('twilio_api_key', 128)->nullable();
			$table->string('twilio_api_secret', 128)->nullable();

			$table->string('infobip_from_number', 20)->nullable();
			$table->string('infobip_api_subdomain', 50)->nullable();
			$table->string('infobip_username', 50)->nullable();
			$table->string('infobip_password', 50)->nullable();

			$table->string('nth_from_number', 20)->nullable();
			$table->string('nth_api_key', 128)->nullable();
			$table->string('nth_api_secret', 128)->nullable();

			$table->string('elks_from_number', 20)->nullable();
			$table->string('elks_api_key', 128)->nullable();
			$table->string('elks_api_secret', 128)->nullable();

			$table->string('spotify_app_id', 128);
			$table->string('spotify_app_secret', 128);
			$table->string('spotify_connect_url', 1000)->nullable();
			$table->string('spotify_redirect_url', 1000);
			$table->string('spotify_perms', 450);

			$table->timestamps();
		});
	}
};
