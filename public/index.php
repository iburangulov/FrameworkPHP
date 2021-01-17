<?php

define('ROOT', $_SERVER['DOCUMENT_ROOT'] . '/');

if (!file_exists(ROOT . 'config.php')) die('File not found: ' . ROOT . 'config.php');

require_once ROOT . 'config.php';

$Router = new \App\components\Router();
$Router->run();