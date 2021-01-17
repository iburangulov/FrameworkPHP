<?php

use App\components\Router;

/*
 * Roter::{get/post/any}( 'path', [
 * 	    'name' => route name,
 * 		'route' => internal path,
 * 		'protectors' => protectors list
 * 		'denied' => access denied url
 */

Router::get('/', [
	'name' => 'home',
	'route' => 'pages/index',
]);

Router::get('/about', [
	'name' => 'about',
	'route' => 'pages/about'
]);

Router::get('/post/(\d+)', [
	'route' => 'pages/post/$1'
]);

Router::any('.*', [
	'name' => 'home',
	'route' => 'pages/index',
]);