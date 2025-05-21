<?php

class Database {
    private static $instance = null;

    public static function connect() {
        if (self::$instance === null) {
            $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8';
            self::$instance = new PDO($dsn, DB_USER, DB_PASS);
            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$instance;
    }   
}
