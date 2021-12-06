<?php

$form_action = route('roles.store');
$actions = $updated_at = null;
$name = $list_mode = '';
$user = auth()->user();
$routes = collect();
$protected = false;
$api_rate_limit = setting('api_rate_limit');
$api_rate_limit_backoff_minutes = setting('api_rate_limit_backoff_minutes');

if (isset($role)) {
	$name = $role->name;
	$protected = $role->protected;
	$list_mode = $role->mode;
	$api_rate_limit = $role->api_rate_limit;
	$api_rate_limit_backoff_minutes = $role->api_rate_limit_backoff_minutes;
	$routes = $role->routes;
	$updated_at = $role->updated_at;

	$form_action = route('roles.update', $role->id);

	$actions = [
		[
			'type' => 'remove',
			'action' => ['roles.remove' => $role->id]
		]
	];
}

$all_routes_tmp = collect(Route::getRoutes())->filter(function ($route, $key) use ($user) {
	return in_array('check_role_permissions', $route->gatherMiddleware()) && $user->canViewRoute($route->getName(), true);
});

$all_routes = [];

foreach ($all_routes_tmp as $route) {
	Illuminate\Support\Arr::set($all_routes, $route->getName(), $route);
}

$list_modes = [
	App\Models\Role::LIST_MODE_WHITE => __('roles.whitelist'),
	App\Models\Role::LIST_MODE_BLACK => __('roles.blacklist')
];

$fields = [
	[
		'label' => __('forms.name'),
		'tag' => 'input',
		'attributes' => [
			'id' => 'name',
			'name' => 'name',
			'type' => 'text',
			'value' => $name,
			'maxlength' => 50,
			'required' => true,
			'autofocus' => true
		]
	],
	[
		'label' => __('settings.api-rate-limit'),
		'tag' => 'input',
		'group' => [
			'right' => __('settings.requests-per-minute')
		],
		'attributes' => [
			'id' => 'api_rate_limit',
			'name' => 'api_rate_limit',
			'type' => 'number',
			'value' => $api_rate_limit,
			'min' => 1,
			'required' => true
		]
	],
	[
		'label' => __('settings.backoff-interval'),
		'tag' => 'input',
		'group' => [
			'right' => __('settings.minutes')
		],
		'attributes' => [
			'id' => 'api_rate_limit_backoff_minutes',
			'name' => 'api_rate_limit_backoff_minutes',
			'type' => 'number',
			'value' => $api_rate_limit_backoff_minutes,
			'min' => 1,
			'required' => true
		]
	],
	[
		'label' => __('roles.protected-details'),
		'tag' => 'checkbox',
		'attributes' => [
			'id' => 'protected',
			'name' => 'protected',
			'value' => 1,
			'type' => 'checkbox',
			'checked' => $protected
		]
	],
	[
		'label' => __('roles.mode'),
		'tag' => 'select',
		'options' => $list_modes,
		'selected' => $list_mode,
		'attributes' => [
			'id' => 'mode',
			'name' => 'mode',
			'required' => true
		]
	]
];

?>

@extends('layouts.master')

@section('content')
	@include('layouts.single_header', ['title' => __('roles.title-s'), 'icon' => 'fa fa-ban', 'actions' => $actions, 'updated_at' => $updated_at])
	<form class="form form-notify" action="{{ $form_action }}" method="post" autocomplete="off" id="main-form">
		<div class="card-body">
			@csrf

			@include('layouts.forms.generate_form_fields', ['fields' => $fields])

			<div class="form-group checkbox-list">
				<label class="checkbox checkbox-primary" title="{{ __('forms.toggle-all') }}">
					<input type="checkbox" data-toggle-nested-id="routes-all">
					<span></span>
					<strong>{{ __('roles.routes') }}</strong>
				</label>

				<div class="ml-10" id="routes-all">
					@include('layouts.render_routes', ['all_routes' => $all_routes, 'routes' => $routes])
				</div>
			</div>
		</div>
		@include('layouts.submit_button')
	</form>
@endsection