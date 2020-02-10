<?php

require_once 'ParkingSpot.php';
require_once 'ParkingDB.php';

class ParkingSpotService
{
    private static $SELECT_ALL_PARKING_SPOTS = "SELECT ps.number, ps.time_in, ps.time_out, ps.free, u.u_first as first, u.u_last as last FROM parking_spots ps LEFT JOIN users u ON u.u_id = ps.owner";

    public static function getAllParkingSpots()
    {
        $connection = ParkingDB::getInstance()->getConnection();
        $query = $connection->query(self::$SELECT_ALL_PARKING_SPOTS);

        $parking_spots = array();
        while ($row = $query->fetch()) {
            $spot = new ParkingSpot(
                $row["number"], 
                $row["first"]." ".$row["last"], 
                $row["time_in"],
                $row["time_out"], 
                $row["free"]);

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
