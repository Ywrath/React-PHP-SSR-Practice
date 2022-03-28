<?php

require dirname(__DIR__) . "/database/db-config.php";

class Database {
    private $host = DB_SERVER;
    private $db_name = DB_DATABASE;
    private $user = DB_USERNAME;
    private $password = DB_PASSWORD;
    

    protected function get_connection(): PDO {
        $dsn = 'mysql:host='. $this->host . ';dbname='. $this->db_name .';charset=utf8';

        return new PDO($dsn, $this->user, $this->password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_STRINGIFY_FETCHES => false
        ]);
    }
}