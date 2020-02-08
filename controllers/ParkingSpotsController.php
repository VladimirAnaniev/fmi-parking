<?php
require 'ParkingDB.php';
require 'models/ParkingSpot.php';

class ParkingSpotsController {
    private $connection = null;

    public function __construct() {
        $this->connection = ParkingDB::getInstance()->getConnection();
    }

    public function get_all_parking_spots() {
        return ParkingSpot::get_all($this->connection);
    }

    public function count_free_spots($all) {
        return count(array_filter($all, function($spot) {
            return $spot->isFree();
        }));
    }

}

?>
