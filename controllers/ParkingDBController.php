<?php
require_once '../models/ParkingDB.php';
class ParkingDBController{
    private $connection;

    public function __construct()
    {
        $this->connection = ParkingDB::getInstance()->getConnection();
    }
}
