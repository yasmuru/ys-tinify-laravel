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
		
	}

	/**
	* Register the service provider.
	*
	* @return void
	*/
	public function register()
	{

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