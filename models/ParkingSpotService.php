<?php

require_once 'ParkingSpot.php';
require_once 'ParkingDB.php';

class ParkingSpotService
{
    private static $SELECT_ALL_PARKING_SPOTS = "SELECT * FROM parking_spots";

    public static function getAllParkingSpots()
    {
        $connection = ParkingDB::getInstance()->getConnection();
        $query = $connection->query(self::$SELECT_ALL_PARKING_SPOTS);

        $parking_spots = array();
        while ($row = $query->fetch()) {
            $spot = new ParkingSpot(
                $row["number"],
                $row["car"],
                $row["owner"],
                $row["time_in"],
                $row["duration"],
                $row["time_out"],
                $row["free"]
            );

            array_push($parking_spots, $spot);
        }

        return $parking_spots;
    }

    public static function countFreeParkingSpots()
    {
        $parking_spots = self::getAllParkingSpots();
        return count(array_filter($parking_spots, function ($spot) {
            return $spot->isFree();
        }));
    }
}
