<?php

namespace App\Services;

use Illuminate\Support\Facades\Schema;

class Config
{
	public static function bindWithSettings(bool $invalidateCache = true): void
	{
		if ((app()->runningInConsole() && !Schema::hasTable('settings')) || !($setting = setting(null, null, $invalidateCache))) {
			return;
		}

		$isProduction = app()->isProduction();

		config([
			'app.name' => $setting->app_name,
			'app.debug' => $setting->debug_mode_active,

			'session.driver' => $setting->session_driver,
			'session.lifetime' => $setting->session_lifetime,

			'auth.passwords.users.expire' => $setting->password_reset_timeout,
			'auth.passwords.users.throttle' => $setting->api_rate_limit_backoff_minutes * 60,
			'auth.verification.expire' => $setting->email_verification_timeout,

			'cors.allowed_origins' => $setting->cors_allowed_origins ? preg_split('/\s+/', $setting->cors_allowed_origins) : ['*'],

			'cache.default' => $setting->cache_store,
			'queue.default' => $setting->queue_driver,

			'telescope.enabled' => $setting->telescope_active,

			'mail.mailers.smtp.host' => $setting->smtp_host,
			'mail.mailers.smtp.port' => $setting->smtp_port,
			'mail.mailers.smtp.encryption' => $setting->smtp_protocol,
			'mail.mailers.smtp.username' => $setting->smtp_username,
			'mail.mailers.smtp.password' => $setting->smtp_password,
			'mail.from.address' => $setting->noreply_email,
			'mail.from.name' => $setting->app_name,

			'logging.channels.stack.channels' => $isProduction && $setting->monitor_slack_webhook ? ['single', 'slack'] : ['single'],
			'logging.channels.slack.url' => $setting->monitor_slack_webhook,
			'logging.channels.slack.username' => $setting->app_name,

			'uptime-monitor.notifications.slack.webhook_url' => $setting->monitor_slack_webhook,
			'uptime-monitor.notifications.mail.to' => $setting->monitor_emails ? preg_split('/\s+/', $setting->monitor_emails) : [$setting->app_email],
			'uptime-monitor.notifications.date_format' => $setting->date_format,

			'filesystems.default' => $setting->media_storage,
			'filesystems.disks.s3.key' => $setting->aws_access_key_id,
			'filesystems.disks.s3.secret' => $setting->aws_secret_access_key,
			'filesystems.disks.s3.region' => $setting->aws_default_region,
			'filesystems.disks.s3.bucket' => $setting->aws_bucket_name,
			'filesystems.disks.s3.url' => $setting->aws_bucket_url,
		]);
	}
}
