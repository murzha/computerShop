<?php

require_once dirname(__DIR__) . '/config/init.php';

new \computerShop\ErrorHandler();

require_once LIBS . '/functions.php';
require_once CONF . '/routes.php';

new \computerShop\App();

\computerShop\Router::getRoutes();
