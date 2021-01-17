<?php

use App\components\Router;

/*
 * Roter::{get/post/any}( 'path', [
 * 	    'name' => route name,
 * 		'route' => internal path,
 * 		'protectors' => protectors list
 */

Router::get('/', [
	'name' => 'home',
	'route' => 'pages/index',
	'protectors' => [],
]);

Router::get('/about', [
	'name' => 'about',
	'route' => 'pages/about',
	'protectors' => [],
]);

Router::get('/post/(\d+)', [
	'name' => 'about',
	'route' => 'blog/post/$1',
	'protectors' => [],
]);

Router::any('.*', [
	'name' => 'home',
	'route' => 'pages/home',
	'protectors' => [],
]);