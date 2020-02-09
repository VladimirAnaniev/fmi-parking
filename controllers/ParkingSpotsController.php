<?php
require_once 'models/ParkingSpot.php';
require_once 'models/ParkingSpotService.php';

class ParkingSpotsController
{
    public static function getAllParkingSpots()
    {
        return ParkingSpotService::getAllParkingSpots();
    }

    public static function countFreeParkingSpots($parking_spots)
    {
        return ParkingSpotService::countFreeParkingSpots();
    }
}
