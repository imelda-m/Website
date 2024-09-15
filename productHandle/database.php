<?php

class Database {
    private $databaseHandle;

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        // Load database configuration from JSON file
        $config = json_decode(file_get_contents('./productHandle/file.json'), true);

        // Check if JSON decoding was successful
        if (json_last_error() !== JSON_ERROR_NONE) {
            die("Error decoding JSON: " . json_last_error_msg());
        }

        // Create connection using PDO
        try {
            $dsn = "mysql:host={$config['host']};dbname={$config['database']}";
            $this->databaseHandle = new PDO($dsn, $config['user'], $config['password']);
            // Set the PDO error mode to exception
            $this->databaseHandle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
           // echo "Successfully connected to the database";
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
    public function getDatabaseHandle() {
        return $this->databaseHandle;
    }
}



?>
