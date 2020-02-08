<?php


class ParkingSpot
{
    private  static $SELECT_ALL_PARKING_SPOTS = "SELECT * FROM parking_spots";

    private $number;
    private $car;
    private $owner;
    private $time_in;
    private $duration;
    private $time_out;
    private $free;

    public function __construct($number, $car, $owner, $time_in, $duration, $time_out, $free)
    {
        $this->number = $number;
        $this->car = $car;
        $this->owner = $owner;
        $this->time_in = $time_in;
        $this->duration = $duration;
        $this->time_out = $time_out;
        $this->free = $free;
    }

    public static function get_all($connection) {
        $query = $connection->query(self::$SELECT_ALL_PARKING_SPOTS);

        $parking_spots = array();
        while ($row = $query->fetch()) {
            $spot = new ParkingSpot($row["number"], $row["car"], $row["owner"], $row["time_in"],
            $row["duration"], $row["time_out"], $row["free"]);

            array_push($parking_spots, $spot);
        }

        return $parking_spots;
    }

    public function getNumber() {
        return $this->number;
    }

    public function getCar() {
        return $this->car;
    }

    public function getOwner() {
        return $this->owner;
    }

    public function getTimeIn() {
        return $this->time_in;
    }

    public function getDuration() {
        return $this->duration;
    }

    public function getTimeOut() {
        return $this->time_out;
    }

    public function isFree() {
        return $this->free;
    }
}

?>
