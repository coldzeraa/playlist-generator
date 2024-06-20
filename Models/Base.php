<?php
abstract class Models_Base {
    protected PDO $connection;

    public function __construct() {
        $host = "127.0.0.1";
        $dbname = "musicgeneratordb";
        $username = "root";
        $password = "";
        try {
            $this->connection = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
}

