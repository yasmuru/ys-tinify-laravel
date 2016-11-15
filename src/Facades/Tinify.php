<?php 
namespace yasmuru\LaravelTinify\Facades;
use Illuminate\Support\Facades\Facade;
class Tinify extends Facade {
	protected static function getFacadeAccessor(){
		return 'tinify';
	}
}