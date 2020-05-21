<?php

namespace Cirote\Layouts\ServiceProvider;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
	public function register()
	{
		$this->register_views();
	}

	public function boot()
	{
		$this->loadTranslationsFrom(__DIR__ . '/../Translations', 'layouts');
	}

	private function register_views()
	{
		$this->loadViewsFrom(__DIR__ . '/../Views', 'layouts');
	}

}