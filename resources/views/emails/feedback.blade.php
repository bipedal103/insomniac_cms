<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
	<head>
		<title>{{ setting('app_name') }} | {{ __('emails.feedback') }}</title>
		<meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">

		<style type="text/css">
			body {
				font-family: Poppins, sans-serif;
			}
		</style>
	</head>
	<body>
		<a href="{{ config('app.url') }}" target="_blank">
			<img src="{{ asset('img/logo.png') }}" alt="{{ setting('app_name') }}">
		</a>

		<h2>{{ $user->name }} (<a href="mailto:{{ $user->email }}" target="_blank">{{ $user->email }}</a>):</h2>

		<p>{{ $message }}</p>
	</body>
</html>