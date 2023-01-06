<?php
class Booking
{
    private $id;

    private $machineId;

    private $machineName;

    private $laboratoryId;

    private $laboratoryName;

    private $bookingDate;

    private $startDate;

    private $endDate;

    private $consumption;

    private $bookingUser;
        
    public function __construct($bbddBooking) {
        $this->id = $bbddBooking["id"];
        $this->machineId = $bbddBooking["machine_id"];
        $this->machineName = $bbddBooking["machine_name"];
        $this->laboratoryId = $bbddBooking["laboratory_id"];
        $this->laboratoryName = $bbddBooking["laboratory_name"];
        $this->bookingDate = $bbddBooking["booking_date"];
        $this->startDate = $bbddBooking["start_date"];
        $this->endDate = $bbddBooking["end_date"];
        $this->consumption = $bbddBooking["consumption"];
        $this->bookingUser = new BookingUser($bbddBooking);
    }

    public function getId(){
        return $this->id;
    }

    public function getMachineId(){
        return $this->machineId;
    }

    public function getMachineName(){
        return $this->machineName;
    }

    public function getLaboratoryId(){
        return $this->laboratoryId;
    }

    public function getLaboratoryName(){
        return $this->laboratoryName;
    }

    public function getBookingDate(){
        return $this->bookingDate;
    }

    public function getStartDate(){
        return $this->startDate;
    }

    public function getEndDate(){
        return $this->endDate;
    }

    public function getConsumption(){
        return $this->consumption;
    }

    public function getBookingUser(){
        return $this->bookingUser;
    }
}
?>