<?php

return [
	'title' => 'Settings',
	'general.title' => 'General settings',
	'local' => 'Local',
	'app-name' => 'App name',
	'app-scheme' => 'App scheme (deeplink prefix)',
	'min-ios-version' => 'Min. iOS version (build number)',
	'min-android-version' => 'Min. Android version (build number)',
	'min-ios-maintenance-version' => 'Min. iOS maintenance version (build number)',
	'min-android-maintenance-version' => 'Min. Android maintenance version (build number)',
	'app-description' => 'App description (SEO Meta tag)',
	'money-code' => 'Money currency code',
	'google-api' => 'Google API key',
	'mail-info' => 'Mail used for app notifications such as password resets and e-mail verifications.',
	'app-email' => 'App e-mail',
	'noreply-email' => 'Noreply e-mail',
	'smtp-user' => 'SMTP username',
	'smtp-pass' => 'SMTP password',
	'smtp-host' => 'SMTP host',
	'smtp-port' => 'SMTP port',
	'smtp-enc' => 'SMTP encryption',
	'client-id' => 'Client ID',
	'client-secret' => 'Client secret',
	'regenerate-secret-key' => 'Regenerate secret key',
	'regenerate-secret-key-message' => 'All active JWT tokens will be invalidated.',
	'date-format' => 'Date format',
	'time-format' => 'Time format',
	'active-web' => 'Active (Web only)',
	'registration-web' => 'Registration role - Web',
	'registration-api' => 'Registration role - API',
	'expiration-time' => 'Token expiration time (leave empty for unlimited)',
	'session-driver' => 'Session driver',
	'session-lifetime' => 'Session lifetime',
	'password-reset-timeout' => 'Password reset timeout',
	'email-verification-timeout' => 'E-mail verification timeout',
	'basic-auth-username-field' => 'Basic auth username field',
	'login' => 'Login',
	'registration' => 'Registration',
	'oauth-note' => 'External login systems use <strong>OAuth2</strong> technology.',
	'redirect-url' => 'Redirect URL',
	'max-attempts' => 'Max. attempts',
	'backoff-interval' => 'Backoff interval',
	'api-rate-limit' => 'Rate limit',
	'requests-per-minute' => 'requests per minute',
	'push-devices-cleanup-days' => 'Clean sessions and push devices after inactivity (leave empty for disabled)',
	'seconds' => 'seconds',
	'minutes' => 'minutes',
	'hours' => 'hours',
	'days' => 'days',
	'storage' => 'Storage',
	'max-upload-size' => 'Max. upload size (per file)',
	'max-video-length' => 'Max. video length',
	'thumb-width' => 'Thumbnail width',
	'responsive-images-breakpoints' => 'Responsive images breakpoints (width in pixels, each in new line)',
	'queue-media-conversions' => 'Queue media conversions',
	'protected-media-token-valid-until' => 'Protected media token expiration time',
	'access-key' => 'Access key ID',
	'secret-key' => 'Secret access key',
	'default-region' => 'Default region',
	'bucket-name' => 'Bucket name',
	'bucket-url' => 'Bucket URL',
	'rest-api-key' => 'REST API key',
	'app-id' => 'App ID',
	'user-auth-key' => 'User auth key',
	'onesignal-stats-check' => 'Fetch statistics for sent notifications (leave empty for disable fetching)',
	'telecope-prune' => 'Once a day clear records older than (leave empty for disable clearing)',
	'telecope-same-ip' => 'Exclude entries that originate from same IP address',
	'monitor-slack-webhook' => 'Slack webhook URL',
	'monitor-emails' => 'E-mails (each in new line)',
	'cache-driver' => 'Cache driver',
	'queue-driver' => 'Queue driver',
	'queue-sync' => 'Sync',
	'paypal-sandbox' => 'Sandbox',
	'paypal-client-id-sandbox' => 'Client ID (sandbox)',
	'paypal-client-secret-sandbox' => 'Client secret (sandbox)',
	'paypal-client-id-production' => 'Client ID (production)',
	'paypal-client-secret-production' => 'Client secret (production)',
	'api-base-url' => 'API base URL',
	'token' => 'Token',
	'token-use' => 'Use it in header:',
	'pass-min-length' => 'Min. length',
	'pass-uppercase-char' => 'Requires at least one uppercase character',
	'pass-numeric-char' => 'Requires at least one numeric character',
	'pass-special-char' => 'Requires at least one special character',
	'from-number' => 'From number (default sender, international format)',
	'api-key' => 'API key',
	'api-secret' => 'API secret',
	'infobip-api-subdomain' => 'API subdomain',
	'menu-basic' => 'Basic',
	'menu-app' => 'App',
	'menu-mail' => 'Mail',
	'menu-cache' => 'Cache & Queues',
	'menu-datetime' => 'Date & time',
	'menu-login' => 'Registration & login',
	'menu-passwords' => 'Passwords',
	'menu-media' => 'Media',
	'menu-monitor' => 'Uptime monitor',
	'menu-security' => 'Security',
	'menu-webhook-scheduler' => 'Webhook scheduler',
	'sms-default-reply' => 'Default reply for incoming SMS messages (leave empty for none)',
	'incoming-sms-webhook' => 'Incoming SMS webhook',
	'cors-allowed-origins' => 'CORS allowed origins (each in new line, leave empty for any)',
	'csp-allowed-scripts' => 'CSP allowed scripts (each in new line)',
	'csp-allowed-styles' => 'CSP allowed styles (each in new line)',
	'spotify-app-id' => 'App ID',
	'spotify-app-secret-key' => 'App Secret',
	'spotify-connect-url' => 'Connect URL',
	'spotify-redirect-url' => 'Redirect URL',
	'spotify-perms' => 'Premissions',
	'available-spotify-perms' => 'Split available permissions with coma, see more at https://developer.spotify.com/documentation/general/guides/authorization/scopes/',
];
