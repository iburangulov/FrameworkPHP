<?php

if (!file_exists(ROOT . 'vendor/autoload.php')) die('File not found: ' . ROOT . 'vendor/autoload.php');
require_once ROOT . 'vendor/autoload.php';

(new \App\components\ErrorHandler())->register();

define('APP_CONFIG', require_once ROOT . 'config/app.php');
define('DB_CONFIG', require_once ROOT . 'config/database.php');

require_once ROOT . 'routes/web.php';