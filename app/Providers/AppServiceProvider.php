<?php

namespace App\Providers;

use App\Services\Config;
use League\Flysystem\Filesystem;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Cached\CachedAdapter;
use League\Flysystem\Cached\Storage\Memory;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap any application services.
	 */
	public function boot(): void
	{
		$this->adjustDbSettings();
		$this->bindConfigs();
		$this->enableCachedAdapter();
	}

	/**
	 * Register any application services.
	 */
	public function register(): void
	{
	}

	private function adjustDbSettings(): self
	{
		Schema::defaultStringLength(191);

		return $this;
	}

	private function bindConfigs(): self
	{
		Config::bindWithSettings();

		return $this;
	}

	private function enableCachedAdapter(): self
	{
		Storage::extend('s3', function ($app, $config) {
			return new Filesystem(new CachedAdapter($app['filesystem']->createS3Driver($config)->getDriver()->getAdapter(), new Memory));
		});

		return $this;
	}
}
