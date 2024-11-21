<?php

namespace computerShop;

/**
 * Database Connection Manager
 * Handles database connection using RedBean ORM
 */
class Database
{

    use TSingletone;

    protected function __construct()
    {
        $db = require_once CONF . '/config_db.php';

        class_alias('\RedBeanPHP\R', '\R');

        \R::setup($db['dsn'], $db['user'], $db['pass']);

        if (!\R::testConnection()) {
            throw new \Exception("Database connection failed", 500);
        }

        \R::freeze(true);

        if (DEBUG) {
            \R::debug(true, 1);
        }
    }
}
