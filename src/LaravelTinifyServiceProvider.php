<?php 

namespace yasmuru\LaravelTinify;

use Illuminate\Support\ServiceProvider;
use Tinify\Tinify;

class LaravelTinifyServiceProvider extends ServiceProvider {

	/**
	* Indicates if loading of the provider is deferred.
	*
	* @var bool
	*/
	protected $defer = false;

	/**
	* Register custom form macros on package start
	* @return void
	*/
	public function boot()
	{	
		$configPath = __DIR__ . '/../config/tinify.php';
        $this->publishes([$configPath => config_path('tinify.php')], 'config');
	}

	/**
	* Register the service provider.
	*
	* @return void
	*/
	public function register()
	{
		$configPath = __DIR__ . '/../config/tinify.php';
        $this->mergeConfigFrom($configPath, 'tinify');
		$this->app->bind('tinify', 'yasmuru\LaravelTinify\Services\TinifyService');

	}

	/**
	* Get the services provided by the provider.
	*
	* @return array
	*/
	public function provides()
	{
		return array();
	}

}