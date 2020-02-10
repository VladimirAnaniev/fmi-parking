<?php

class ParkingSpot
{
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
