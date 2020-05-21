<?php

namespace Cirote\Opciones\ServiceProvider;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Cirote\Opciones\Actions\CalcularMesOpcionAction;
use Cirote\Opciones\Actions\CalcularAnoOpcionAction;
use Cirote\Opciones\Actions\CalcularStrikeOpcionAction;
use Cirote\Opciones\Actions\CalcularTickerCompletoOpcionAction;
use Cirote\Opciones\Actions\CalcularVencimientoOpcionAction;

class ServiceProvider extends BaseServiceProvider
{
	public function register()
	{
		$this->register_migrations();

		$this->register_routes();

		$this->register_views();
	}

	public function boot()
	{
		$this->loadTranslationsFrom(__DIR__ . '/../Translations', 'opciones');

		$this->bind_class();
	}

	private function bind_class()
	{
		$this->app->singleton(CalcularStrikeOpcionAction::class, function ($app) 
		{
    		return new CalcularStrikeOpcionAction();
		});

		$this->app->singleton(CalcularVencimientoOpcionAction::class, function ($app) 
		{
    		return new CalcularVencimientoOpcionAction();
		});

		$this->app->singleton(CalcularTickerCompletoOpcionActionCalcularTickerCompletoOpcionAction::class, function ($app) 
		{
    		return new CalcularTickerCompletoOpcionAction($app->make(CalcularVencimientoOpcionAction::class));
		});
	}

	private function register_migrations()
	{
		$this->loadMigrationsFrom(__DIR__ . '/../Migrations');
	}

	private function register_routes()
	{
		$this->loadRoutesFrom(__DIR__ . '/../Routes/routes.php');
	}

	private function register_views()
	{
		$this->loadViewsFrom(__DIR__ . '/../Views', 'opciones');
	}

}