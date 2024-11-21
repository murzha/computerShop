<?php

namespace computerShop;

/**
 * Main Application Class
 * Initializes the core components of the application
 */
class App
{

    public static Registry $app;

    public function __construct()
    {
        $query = trim($_SERVER['QUERY_STRING'], '/');
        session_start();
        self::$app = Registry::instance();
        $this->loadParams();
        Router::dispatch($query);
    }

    protected function loadParams()
    {
        $params = require_once CONF . '/params.php';
        if (!empty($params)) {
            foreach ($params as $key => $value) {
                self::$app->setProperty($key, $value);
            }
        }
    }
}
