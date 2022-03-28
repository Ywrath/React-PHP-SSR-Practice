<?php
require dirname(__DIR__) . "/database/Database.php";

class Model extends Database {
    protected PDO $conn;
    public function __construct() {
        $this->conn = $this->get_connection();
    }
}
