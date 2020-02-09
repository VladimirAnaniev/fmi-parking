<?php

require_once 'ParkingDB.php';

class ParkingSpot
{
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
