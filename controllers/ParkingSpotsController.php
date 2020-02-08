<?php
require 'models/ParkingSpot.php';

class ParkingSpotsController
{
    public static function count_free_parking_spots($parking_spots)
    {
        return count(array_filter($parking_spots, function ($spot) {
            return $spot->isFree();
        }));
    }
}
