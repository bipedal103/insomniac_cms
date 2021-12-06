<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGeneralSettings extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 */
	public function authorize(): bool
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 */
	public function rules(): array
	{
		return [
			'app_name' => ['required', 'string', 'max:50'],
			'app_scheme' => ['nullable', 'string', 'max:50'],
			'ios_min_version' => ['nullable', 'integer', 'min:1'],
			'android_min_version' => ['nullable', 'integer', 'min:1'],
			'app_description' => ['nullable', 'string', 'max:500'],
			'maintenance_active' => ['boolean'],
			'debug_mode_active' => ['boolean'],
			'currency_code' => ['required', 'string', 'size:3'],
			'google_api_key' => ['nullable', 'string', 'max:50'],

			'app_email' => ['nullable', 'email', 'max:50'],
			'noreply_email' => ['nullable', 'email', 'max:50'],
			'smtp_host' => ['nullable', 'string', 'max:256'],
			'smtp_port' => ['nullable', 'integer', 'min:1'],
			'smtp_username' => ['nullable', 'string', 'max:128'],
			'smtp_password' => ['nullable', 'string', 'max:128'],
			'smtp_protocol' => ['nullable', 'string', 'in:tls,ssl'],

			'timezone' => ['required', 'timezone'],
			'date_format' => ['required', 'string', 'max:15'],
			'time_format' => ['required', 'string', 'max:15'],

			'min_pass_len' => ['required', 'integer', 'min:1'],
			'pass_uppercase_char' => ['boolean'],
			'pass_numeric_char' => ['boolean'],
			'pass_special_char' => ['boolean'],

			'jwt_regenerate_secret_key' => ['boolean'],
			'jwt_expiration_time' => ['nullable', 'integer', 'min:1'],

			'media_storage' => ['string', 'max:50'],
			'max_upload_size' => ['required', 'integer', 'min:1'],
			'max_video_length' => ['required', 'integer', 'min:1'],
			'thumb_width' => ['required', 'integer', 'min:1'],
			'responsive_images_breakpoints' => ['nullable', 'string', 'max:100'],
			'queue_media_conversions' => ['boolean'],
			'protected_media_token_valid_until' => ['required', 'integer', 'min:1'],

			'login_max_attempts' => ['required', 'integer', 'min:1'],
			'login_backoff_minutes' => ['required', 'integer', 'min:1'],
			'api_rate_limit' => ['required', 'integer', 'min:1'],
			'api_rate_limit_backoff_minutes' => ['required', 'integer', 'min:1'],

			'cors_allowed_origins' => ['nullable', 'string', 'max:250'],
			'csp_allowed_scripts' => ['nullable', 'string', 'max:250'],
			'csp_allowed_styles' => ['nullable', 'string', 'max:250'],

			'password_reset_timeout' => ['required', 'integer', 'min:1'],
			'email_verification_timeout' => ['required', 'integer', 'min:1'],

			'cache_store' => ['required', 'string', 'max:10'],
			'queue_driver' => ['required', 'string', 'max:10'],

			'registration_active' => ['boolean'],
			'registration_role_id' => ['nullable', 'uuid'],
			'registration_api_role_id' => ['nullable', 'uuid'],
			'session_driver' => ['required', 'string', 'max:10'],
			'session_lifetime' => ['required', 'integer', 'min:1'],
			'basic_auth_username_field' => ['required', 'string', 'in:id,email'],
			'push_devices_cleanup_days' => ['nullable', 'integer', 'min:1'],

			'aws_access_key_id' => ['nullable', 'string', 'max:128'],
			'aws_secret_access_key' => ['nullable', 'string', 'max:128'],
			'aws_default_region' => ['nullable', 'string', 'max:128'],
			'aws_bucket_name' => ['nullable', 'string', 'max:50'],
			'aws_bucket_url' => ['nullable', 'url', 'max:1000'],

			'onesignal_app_id' => ['nullable', 'uuid'],
			'onesignal_rest_api_key' => ['nullable', 'required_with:onesignal_app_id', 'string', 'max:128'],
			'onesignal_user_auth_key' => ['nullable', 'required_with:onesignal_app_id', 'string', 'max:128'],
			'onesignal_stats_check_days' => ['nullable', 'integer', 'min:1'],

			'telescope_active' => ['boolean'],
			'telescope_same_ip' => ['boolean'],
			'telescope_prune_hours' => ['nullable', 'integer', 'min:1'],

			'monitor_active' => ['boolean'],
			'monitor_slack_webhook' => ['nullable', 'url', 'max:1000'],
			'monitor_emails' => ['nullable', 'string', 'max:250'],

			'paypal_sandbox' => ['boolean'],
			'paypal_client_id' => ['nullable', 'string', 'max:128'],
			'paypal_client_secret' => ['nullable', 'string', 'max:128'],
			'paypal_sandbox_client_id' => ['nullable', 'string', 'max:128'],
			'paypal_sandbox_client_secret' => ['nullable', 'string', 'max:128'],

			'webhook_scheduler_url' => ['nullable', 'url', 'max:100'],
			'webhook_scheduler_token' => ['nullable', 'string', 'max:500'],

			'bitbucket_active' => ['boolean'],
			'bitbucket_client_id' => ['nullable', 'string', 'max:128'],
			'bitbucket_client_secret' => ['nullable', 'string', 'max:500'],

			'github_active' => ['boolean'],
			'github_client_id' => ['nullable', 'string', 'max:128'],
			'github_client_secret' => ['nullable', 'string', 'max:500'],

			'gitlab_active' => ['boolean'],
			'gitlab_client_id' => ['nullable', 'string', 'max:128'],
			'gitlab_client_secret' => ['nullable', 'string', 'max:500'],

			'facebook_active' => ['boolean'],
			'facebook_client_id' => ['nullable', 'string', 'max:128'],
			'facebook_client_secret' => ['nullable', 'string', 'max:500'],

			'twitter_active' => ['boolean'],
			'twitter_client_id' => ['nullable', 'string', 'max:128'],
			'twitter_client_secret' => ['nullable', 'string', 'max:500'],

			'google_active' => ['boolean'],
			'google_client_id' => ['nullable', 'string', 'max:128'],
			'google_client_secret' => ['nullable', 'string', 'max:500'],

			'linkedin_active' => ['boolean'],
			'linkedin_client_id' => ['nullable', 'string', 'max:128'],
			'linkedin_client_secret' => ['nullable', 'string', 'max:500'],

			'apple_active' => ['boolean'],
			'apple_client_id' => ['nullable', 'string', 'max:128'],
			'apple_client_secret' => ['nullable', 'string', 'max:500'],

			'sms_default_reply' => ['nullable', 'string', 'max:160'],

			'vonage_from_number' => ['nullable', 'string', 'max:20'],
			'vonage_api_key' => ['nullable', 'required_with:vonage_from_number', 'string', 'max:128'],
			'vonage_api_secret' => ['nullable', 'required_with:vonage_from_number', 'string', 'max:128'],

			'twilio_from_number' => ['nullable', 'string', 'max:20'],
			'twilio_api_key' => ['nullable', 'required_with:twilio_from_number', 'string', 'max:128'],
			'twilio_api_secret' => ['nullable', 'required_with:twilio_from_number', 'string', 'max:128'],

			'infobip_from_number' => ['nullable', 'string', 'max:20'],
			'infobip_api_subdomain' => ['nullable', 'required_with:infobip_from_number', 'string', 'max:50'],
			'infobip_username' => ['nullable', 'required_with:infobip_from_number', 'email', 'max:50'],
			'infobip_password' => ['nullable', 'required_with:infobip_from_number', 'string', 'max:50'],

			'nth_from_number' => ['nullable', 'string', 'max:20'],
			'nth_api_key' => ['nullable', 'required_with:nth_from_number', 'string', 'max:128'],
			'nth_api_secret' => ['nullable', 'required_with:nth_from_number', 'string', 'max:128'],

			'elks_from_number' => ['nullable', 'string', 'max:20'],
			'elks_api_key' => ['nullable', 'required_with:elks_from_number', 'string', 'max:128'],
			'elks_api_secret' => ['nullable', 'required_with:elks_from_number', 'string', 'max:128'],

			'spotify_app_id' => ['required', 'string', 'max:128'],
			'spotify_app_secret' => ['required', 'string', 'max:128'],
			'spotify_redirect_url' => ['url', 'max:1000'],
			'spotify_perms' => ['required', 'string', 'max:450'],
		];
	}
}
