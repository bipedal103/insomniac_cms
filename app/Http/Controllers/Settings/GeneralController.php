<?php

namespace App\Http\Controllers\Settings;

use App\Models\Role;
use App\Models\Setting;
use Illuminate\View\View;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreGeneralSettings;

class GeneralController extends Controller
{
	public function edit(): View
	{
		$settings = Setting::firstOrFail();
		$roles = Role::available()->orderBy('name')->get();

		return view('settings.general', compact('settings', 'roles'));
	}

	public function update(Setting $id, StoreGeneralSettings $request): RedirectResponse
	{
		$id->update([
			'app_name' => $request->app_name,
			'app_scheme' => $request->app_scheme,
			'ios_min_version' => $request->ios_min_version,
			'android_min_version' => $request->android_min_version,
			'ios_maintenance_min_version' => $request->ios_maintenance_min_version,
			'android_maintenance_min_version' => $request->android_maintenance_min_version,
			'app_description' => $request->app_description,
			'debug_mode_active' => $request->boolean('debug_mode_active'),

			'app_email' => $request->app_email,
			'noreply_email' => $request->noreply_email,
			'smtp_host' => $request->smtp_host,
			'smtp_port' => $request->smtp_port,
			'smtp_username' => $request->smtp_username,
			'smtp_password' => $request->smtp_password,
			'smtp_protocol' => $request->smtp_protocol,

			'timezone' => $request->timezone,
			'date_format' => $request->date_format,
			'time_format' => $request->time_format,

			'currency_code' => $request->currency_code,
			'google_api_key' => $request->google_api_key,

			'min_pass_len' => $request->min_pass_len,
			'pass_uppercase_char' => $request->boolean('pass_uppercase_char'),
			'pass_numeric_char' => $request->boolean('pass_numeric_char'),
			'pass_special_char' => $request->boolean('pass_special_char'),

			'jwt_secret_key' => $request->boolean('jwt_regenerate_secret_key') ? Str::random(32) : $id->jwt_secret_key,
			'jwt_expiration_time' => $request->jwt_expiration_time,

			'media_storage' => $request->media_storage,
			'max_upload_size' => 1024 * 1024 * $request->max_upload_size,
			'max_video_length' => $request->max_video_length,
			'thumb_width' => $request->thumb_width,
			'responsive_images_breakpoints' => $request->responsive_images_breakpoints,
			'queue_media_conversions' => $request->boolean('queue_media_conversions'),
			'protected_media_token_valid_until' => $request->protected_media_token_valid_until,

			'login_max_attempts' => $request->login_max_attempts,
			'login_backoff_minutes' => $request->login_backoff_minutes,
			'api_rate_limit' => $request->api_rate_limit,
			'api_rate_limit_backoff_minutes' => $request->api_rate_limit_backoff_minutes,

			'cors_allowed_origins' => $request->cors_allowed_origins,
			'csp_allowed_scripts' => $request->csp_allowed_scripts,
			'csp_allowed_styles' => $request->csp_allowed_styles,

			'password_reset_timeout' => $request->password_reset_timeout,
			'email_verification_timeout' => $request->email_verification_timeout,
			'registration_active' => $request->boolean('registration_active'),
			'registration_role_id' => $request->registration_role_id,
			'registration_api_role_id' => $request->registration_api_role_id,
			'session_driver' => $request->session_driver,
			'session_lifetime' => $request->session_lifetime,
			'basic_auth_username_field' => $request->basic_auth_username_field,
			'push_devices_cleanup_days' => $request->push_devices_cleanup_days,

			'aws_access_key_id' => $request->aws_access_key_id,
			'aws_secret_access_key' => $request->aws_secret_access_key,
			'aws_default_region' => $request->aws_default_region,
			'aws_bucket_name' => $request->aws_bucket_name,
			'aws_bucket_url' => $request->aws_bucket_url,

			'cache_store' => $request->cache_store,
			'queue_driver' => $request->queue_driver,

			'onesignal_app_id' => $request->onesignal_app_id,
			'onesignal_rest_api_key' => $request->onesignal_rest_api_key,
			'onesignal_user_auth_key' => $request->onesignal_user_auth_key,
			'onesignal_stats_check_days' => $request->onesignal_stats_check_days,

			'telescope_active' => $request->boolean('telescope_active'),
			'telescope_same_ip' => $request->boolean('telescope_same_ip'),
			'telescope_prune_hours' => $request->telescope_prune_hours,

			'monitor_active' => $request->boolean('monitor_active'),
			'monitor_slack_webhook' => $request->monitor_slack_webhook,
			'monitor_emails' => $request->monitor_emails,

			'paypal_sandbox' => $request->boolean('paypal_sandbox'),
			'paypal_client_id' => $request->paypal_client_id,
			'paypal_client_secret' => $request->paypal_client_secret,
			'paypal_sandbox_client_id' => $request->paypal_sandbox_client_id,
			'paypal_sandbox_client_secret' => $request->paypal_sandbox_client_secret,

			'webhook_scheduler_url' => $request->webhook_scheduler_url,
			'webhook_scheduler_token' => $request->webhook_scheduler_token,

			'bitbucket_active' => $request->boolean('bitbucket_active'),
			'bitbucket_client_id' => $request->bitbucket_client_id,
			'bitbucket_client_secret' => $request->bitbucket_client_secret,

			'github_active' => $request->boolean('github_active'),
			'github_client_id' => $request->github_client_id,
			'github_client_secret' => $request->github_client_secret,

			'gitlab_active' => $request->boolean('gitlab_active'),
			'gitlab_client_id' => $request->gitlab_client_id,
			'gitlab_client_secret' => $request->gitlab_client_secret,

			'facebook_active' => $request->boolean('facebook_active'),
			'facebook_client_id' => $request->facebook_client_id,
			'facebook_client_secret' => $request->facebook_client_secret,

			'twitter_active' => $request->boolean('twitter_active'),
			'twitter_client_id' => $request->twitter_client_id,
			'twitter_client_secret' => $request->twitter_client_secret,

			'google_active' => $request->boolean('google_active'),
			'google_client_id' => $request->google_client_id,
			'google_client_secret' => $request->google_client_secret,

			'linkedin_active' => $request->boolean('linkedin_active'),
			'linkedin_client_id' => $request->linkedin_client_id,
			'linkedin_client_secret' => $request->linkedin_client_secret,

			'apple_active' => $request->boolean('apple_active'),
			'apple_client_id' => $request->apple_client_id,
			'apple_client_secret' => $request->apple_client_secret,

			'sms_default_reply' => $request->sms_default_reply,

			'vonage_from_number' => $request->vonage_from_number,
			'vonage_api_key' => $request->vonage_api_key,
			'vonage_api_secret' => $request->vonage_api_secret,

			'twilio_from_number' => $request->twilio_from_number,
			'twilio_api_key' => $request->twilio_api_key,
			'twilio_api_secret' => $request->twilio_api_secret,

			'infobip_from_number' => $request->infobip_from_number,
			'infobip_api_subdomain' => $request->infobip_api_subdomain,
			'infobip_username' => $request->infobip_username,
			'infobip_password' => $request->infobip_password,

			'nth_from_number' => $request->nth_from_number,
			'nth_api_key' => $request->nth_api_key,
			'nth_api_secret' => $request->nth_api_secret,

			'elks_from_number' => $request->elks_from_number,
			'elks_api_key' => $request->elks_api_key,
			'elks_api_secret' => $request->elks_api_secret,

			'spotify_app_id' => $request->spotify_app_id,
			'spotify_app_secret' => $request->spotify_app_secret,
			'spotify_redirect_url' => $request->spotify_redirect_url,
			'spotify_perms' => $request->spotify_perms,
			'spotify_connect_url' => null,
		]);

		return $this->redirectFromSave();
	}
}
