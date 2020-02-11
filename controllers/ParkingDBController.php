<?php
require_once '../models/ParkingDB.php';
class ParkingDBController{
    private $connection;

    public function __construct()
    {
        $this->connection = ParkingDB::getInstance()->getConnection();
    }

    public function changeUserStatus($newData) {
        $sql = "UPDATE users SET u_role = :role WHERE u_email = :email;";
        $query = $this->connection->prepare($sql);
        $query->execute($newData);
    }
}
