<?php

class ConsumptionDao extends Dao{

  public function getWeeklyConsumption($machineId){
    
    $conn = $this->getConnection();
    $stmt = $conn->prepare("select SUM(consumption) as total, DAYNAME(booking_date) as name from bookings 
    where machine_id = ? and DATE_ADD(booking_date, INTERVAL 7 DAY) >= NOW()
    GROUP BY DAY(booking_date), DAYNAME(booking_date), YEAR(booking_date),MONTH(booking_date) 
    ORDER BY YEAR(booking_date),MONTH(booking_date), DAY(booking_date);");
    $stmt->bind_param("i", $machineId);
    $stmt->execute();
    $consumptions = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    $conn->close();
    return $consumptions;

  }
}

?>