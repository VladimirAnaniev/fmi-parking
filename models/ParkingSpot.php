<?php

require_once 'ParkingDB.php';

class ParkingSpot
{
    private  static $SELECT_ALL_PARKING_SPOTS = "SELECT ps.number, ps.time_in, ps.time_out, ps.free, u.u_first as first, u.u_last as last FROM parking_spots ps LEFT JOIN users u ON u.u_id = ps.owner";

    private $number;
    private $owner;
    private $time_in;
    private $time_out;
    private $free;

    public function __construct($number, $owner, $time_in, $time_out, $free)
    {
        $this->number = $number;
        $this->owner = $owner;
        $this->time_in = $time_in;
        $this->time_out = $time_out;
        $this->free = $free;
    }

    public static function get_all($connection) {
        $query = $connection->query(self::$SELECT_ALL_PARKING_SPOTS);

        $parking_spots = array();
        while ($row = $query->fetch()) {
            $spot = new ParkingSpot($row["number"], $row["first"]." ".$row["last"], $row["time_in"],
            $row["time_out"], $row["free"]);

            array_push($parking_spots, $spot);
        }

        return $parking_spots;
    }

    public function getNumber() {
        return $this->number;
    }

    public function getOwner() {
        return $this->owner;
    }

    public function getTimeIn() {
        return $this->time_in;
    }

    public function getTimeOut() {
        return $this->time_out;
    }

    public function isFree() {
        return $this->free;
    }
}
