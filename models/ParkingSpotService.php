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

    public static function hasFreeParkingSpots()
    {
        $sql = "SELECT * FROM parking_spots WHERE free=1";
        $connection = ParkingDB::getInstance()->getConnection();
        $query = $connection->prepare($sql);
        $query->execute();
        return $query->rowCount() > 0;
    }

    public static function updateParkingSpot($id, $duration)
    {
        $sql = "UPDATE parking_spots
                SET free=0, owner=:id, time_in=NOW(), duration=:duration
                WHERE number =
                (SELECT number FROM parking_spots
                WHERE free = 1 LIMIT 1)";

        $connection = ParkingDB::getInstance()->getConnection();
        $query = $connection->prepare($sql);
        $result = $query->execute(['id' => $id, "duration" => $duration]);

        if (!$result) {
            header("Location:".INDEX_URL."?failedToUpdateParking=true");
            exit();
        }
    }

    public static function freeParkingSpot($id)
    {
        $sql = "UPDATE parking_spots
                SET free=1, owner=NULL, time_in=NULL, duration=NULL
                WHERE owner =
                (SELECT owner FROM parking_spots
                WHERE free=0 AND owner=:id LIMIT 1)";

        $connection = ParkingDB::getInstance()->getConnection();
        $query = $connection->prepare($sql);
        $result = $query->execute(['id' => $id]);

        if (!$result) {
            header("Location:".INDEX_URL."?failToFree=true".$id);
            exit();
        }
    }
}
