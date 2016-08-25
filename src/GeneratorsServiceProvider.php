<?php

namespace jrmadsen67\MahanaGenerators;

use Illuminate\Support\ServiceProvider;

class GeneratorsServiceProvider extends ServiceProvider {
	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot() {
		//
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register() {
		$this->registerSeedGenerator();
	}

	/**
	 * Register the make:model generator.
	 */
	private function registerSeedGenerator() {
		$this->app->singleton('command.jrmadsen67.model', function ($app) {
			return $app['jrmadsen67\MahanaGenerators\Commands\ModelMakeCommand'];
		});

		$this->commands('command.jrmadsen67.model');
	}

}
