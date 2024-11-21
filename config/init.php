<?php

define("DEBUG", 1);
define("ROOT", dirname(__DIR__));
define("WWW", ROOT . '/public');
define("APP", ROOT . '/app');
define("CORE", ROOT . '/vendor/computerShop/core');
define("LIBS", ROOT . '/vendor/computerShop/core/libs');
define("CACHE", ROOT . '/tmp/cache');
define("DEBUG_LOG", ROOT . '/tmp/debug.log');
define("CONF", ROOT . '/config');
define("LAYOUT", 'base');
define("VIEWS", APP . '/views');
define("COMPONENTS", VIEWS . '/components');
define("PAGES", VIEWS . '/pages');
define("LAYOUTS", VIEWS . '/layouts');

$app_path = "{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}";
$app_path = preg_replace("#[^/]+$#", '', $app_path);
$app_path = str_replace('/public/', '', $app_path);
define("PATH", $app_path);

require_once ROOT . '/vendor/autoload.php';
