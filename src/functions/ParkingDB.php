<?php

include_once 'ParkingDB.conf.php';

class ParkingDB{
    private $connection = null;
    private static $instance = null;

    private function __construct()
    {
        try {
            $this->connection = new PDO('mysql:host='.DB_HOST_NAME.';dbname='.DB_NAME.';charset=utf8', DB_USERNAME, DB_PASSWORD); 
        } catch(PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Проблем при свързването към базата'],JSON_UNESCAPED_UNICODE);
        }
    }

    public static function getInstance(){
        if(!self::$instance){
            self::$instance = new ParkingDB();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }
}