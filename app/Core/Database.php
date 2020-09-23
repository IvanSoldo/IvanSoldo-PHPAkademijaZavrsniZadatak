<?php

namespace App\Core;

class Database extends \PDO {

    private static $instance;

    private $host = DB_HOST;
    private $user = DB_USER;
    private $password = DB_PASS;
    private $dbName = DB_NAME;

    private function __construct() {

        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbName . ';charset=utf8';
        parent::__construct($dsn, $this->user, $this->password);

        $this->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
    }

    private function __clone()
    {
    }

    public static function getInstance(): self
    {
        if (static::$instance === null) {
            self::$instance = new static();
        }

        return self::$instance;
    }

}