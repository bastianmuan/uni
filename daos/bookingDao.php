<?php

class BookingDao extends Dao{

  public function getActiveBookingMachines($machineId){
    /***
     * Consultem si hi ha reserves actives amb per aquesta màquina. Aquest mètode s'executa des del borrat d'una màquina.
     * No es permet eliminar màquines amb reserves actives. Primer s'haurà d'anular les reserves actives i posteriorment eliminar la màquina.
    ***/

    $conn = $this->getConnection();
    $stmt = $conn->prepare("select id from bookings where machine_id = ? and end_date IS NULL");
    $stmt->bind_param("i", $machineId);
    $stmt->execute();
    $totalRows = $stmt->get_result()->num_rows;
    $stmt->close();
    $conn->close();
    return $totalRows > 0;
  }

  public function getActiveBookingLaboratories($laboratoryId){
    /***
     * Consultem si hi ha reserves actives amb per aquest laboratori. Aquest mètode s'executa des del borrat d'un laboratory.
     * No es permet eliminar màquines amb reserves actives. Primer s'haurà d'anular les reserves actives i posteriorment eliminar la màquina.
    ***/
    $conn = $this->getConnection();
    $stmt = $conn->prepare("select id from bookings where laboratory_id = ? and end_date IS NULL");
    $stmt->bind_param("i", $laboratoryId);
    $stmt->execute();
    $totalRows = $stmt->get_result()->num_rows;
    $stmt->close();
    $conn->close();

    return $totalRows > 0;
  }

  public function removeActiveBookings($userId){
    /***
     * TODO: Eliminem totes les reserves actives per al usuari introduit. Aquest mètode s'executa des del borrat d'usuari.
     * Es manté tot l'historic de reserves, però les reserves actives encara no realitzarà s'eliminen, ja que aquest usuari no les realitzarà, i així deixa la màquina
     * lliure per poder ser reservada per un altre usuari.
    ***/

    $sql = "select bookings.id from bookings inner join bookings_user on bookings_user.booking_id = bookings.id where user_id = ? and start_date IS NULL";
    $conn = $this->getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $bdBookingIds = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    $conn->close();
    $response = [];
    foreach($bdBookingIds as $bdBooking){
      $this->deleteBooking($bdBooking["id"]);
    }
  }

  public function getActiveBookings($machineId = 0, $startDate = null, $endDate = null){
    /*** Reserves actives segons filtre ****/

    $prepareSQL = $this->prepareSQLBookings($machineId, $startDate, $endDate, 1);
    return $this->getBookings($prepareSQL);
  }

  public function getHistoryBookings($machineId = 0, $startDate = null, $endDate = null){
    /*** Reserves realitzades (historic) segons filtre ****/

    $prepareSQL = $this->prepareSQLBookings($machineId, $startDate, $endDate, 2);
    return $this->getBookings($prepareSQL);
  }

  private function prepareSQLBookings($machineId = 0, $startDate = null, $endDate = null, $type = 1){
    $sql = "select bookings.*, bookings_user.user_id, bookings_user.name, bookings_user.surname, bookings_user.email  from bookings
    inner join bookings_user on bookings_user.booking_id = bookings.id where 1 = 1";
    $keys = "";
    $params = [];

    if($machineId > 0){
      $sql .= " and machine_id = ?";
      array_push($params,$machineId);
      $keys .= "i";
    }

    
    if($startDate != null && $endDate != null){
      $sql .=" and booking_date between ? and ?";
      array_push($params,$startDate);
      array_push($params,$endDate);
      $keys .= "ss";
    }
    
    if(!Utils::isAdmin()){
      $user = Utils::getSessionUser();
      $sql .=" and bookings_user.user_id = ?";
      array_push($params,$user->getId());
      $keys .= "i";
    }
    
    if($type == 1){ //Active
      $sql .=" and end_date IS NULL";
    }else{ //Historic
      $sql .=" and end_date IS NOT NULL";
    }

   

    $sql .= " order by booking_date DESC";
    
    $response = [];
    $response["sql"] = $sql;
    $response["keys"] = $keys;
    $response["params"] = $params;
    return $response;
  }

  private function getBookings($prepareSQL){
    $conn = $this->getConnection();
    $sql = $prepareSQL["sql"];
    $keys = $prepareSQL["keys"];
    $params = $prepareSQL["params"];
  
    $stmt = $conn->prepare($sql); 
    if(count($params) > 0){
      $stmt->bind_param($keys, ...$params);
    }
    $stmt->execute();
    $bdBookings = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $conn->close();
    $response = [];
    foreach($bdBookings as $bdBooking){
      array_push($response, new Booking($bdBooking));
    }
    return $response;
  }

  public function createBooking($postBooking){
    /*** Creació d'una nova reserva ***/
    
    //Control de paràmetres!
    if(!isset($postBooking["machineId"]) || !isset($postBooking["bookingDate"]) || !isset($postBooking["bookingHour"])){
      return 3;
    }
    
    //Control del bookingDate de tipus data i resetejar minuts i segons per les correctes consultes SQL, per si ens intenten colar per darrere un datetime no permés per interficie!
    try{
      $bookingDate =new DateTime($postBooking["bookingDate"]);

      $hour = max(0, min(23,$postBooking["bookingHour"]));
      $bookingDate->setTime($hour,0,0,0);
      $bookingDateStr = $bookingDate->format('Y-m-d H:i:s');
      $startDateStr = $bookingDate->format('Y-m-d')." 00:00:00";
      $endDateStr = $bookingDate->format('Y-m-d')." 23:59:59";
    }catch (Exception $e) {
      return 3;
    }
    
    //Controlem que hi hagi usuari a la sessió
    $userId = Utils::getSessionUser()->getId();
    if($userId == null){
      return 3;
    }
    
    //Control de dates!! S'ha de comprovar que per la data seleccionada, la màquina no estigui ocupada.
    if(!$this->isExecutableBooking($postBooking["machineId"], $userId, $bookingDateStr, $startDateStr, $endDateStr)){
      return 2;
    }
        
    //Control de machineId. S'ha de comprovar que la machineId existeix, està activa i està associada a un laboratori.
    //Obtenim les dades de la maquina!
    $machineDao = new MachineDao();
    $machine = $machineDao->getMachine($postBooking["machineId"]);
    if($machine == null || !$machine->getActive() || $machine->getLaboratoryId() == null){
      return 3;
    }
    
    //Control de laboratori. S'ha de comprovar que el laboratory associat a la màquina existeixi i estigui actiu.
    $laboratoryDao = new LaboratoryDao();
    //Obtenim les dades del laboratori!
    $laboratory = $laboratoryDao->getLaboratory($machine->getLaboratoryId());
    if($laboratory == null || !$laboratory->getActive()){
      return 3;
    }
    
    //Obtenim dades de l'usuari
    $userDao = new UserDao();
    $user = $userDao->getUserById($userId);
    if($user == null){
      return 3;
    }
    
    $machineId = $machine->getId();
    $machineName = $machine->getName();
    $laboratoryId = $laboratory->getId();
    $laboratoryName = $laboratory->getName();
    $userId = $user->getId();
    $username = $user->getName();
    $userSurname = $user->getSurname();
    $userEmail = $user->getEmail();
    
    $conn = $this->getConnection();
    $conn->begin_transaction();
    $stmt = $conn->prepare("insert into bookings (machine_id, machine_name, laboratory_id, laboratory_name, booking_date) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isiss", $machineId, $machineName, $laboratoryId, $laboratoryName, $bookingDateStr);
    $stmt->execute();
    $stmt->close();
    $lastId  = $conn->insert_id;

    $stmt = $conn->prepare("insert into bookings_user (booking_id, user_id, name, surname, email) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iisss", $lastId, $userId, $username, $userSurname, $userEmail);
    $stmt->execute();
    $stmt->close();

    $conn->commit();
    $conn->close();
    return 1;
  }

  public function startBooking($param){
    // 0 1 # 1 2 3 4 5 6 7 8  ---> Trama complerta
    
    $date = new DateTime();
    $dateStr = $date->format('Y-m-d H').":00:00";
    
    $endDateStr = $date->format('Y-m-d H').":59:59";
    $endDate = new DateTime($endDateStr);

    $rfid = substr($param, 3, 8);  
    $machineId = substr($param, 0, 2);

    $sql = "select bookings.id from bookings 
    inner join bookings_user on bookings_user.booking_id = bookings.id
    inner join users on users.id = bookings_user.user_id
    where machine_id = ? and booking_date = ? and users.rfid = ? and start_date is null";

    $conn = $this->getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $machineId,$dateStr, $rfid);
    $stmt->execute();
    $result = $stmt->get_result(); 
    $found = $result->num_rows;

    $stmt->close();
    $conn->close();
    
    if($found == 0){
      return "#00000"; //Registre incorrecte
    }
  
    $bookingId = intval($result->fetch_all(MYSQLI_ASSOC)[0]["id"]);

    //Registre correcte!

    /**************************************** */
    /* Consulta a la API Externa IES Castellet
    /* IF TRUE si portem les ullleres --> Retornem Temps obtingut
     * IF FALSE si no portem ulleres -->  Retornem "#00000";
     */
    /**************************************** */
    $validacio_api_ies_castellet = true;
    if(!$validacio_api_ies_castellet){
      return "#00000";
    }

    //Registrem a bbdd l'inici de l'activitat updatant el camp start_date;
    $conn = $this->getConnection();
    $conn->begin_transaction();
    $stmt = $conn->prepare("update bookings set start_date = ? WHERE id = ?");
    $currentDateStr = $date->format('Y-m-d H:i:s');
    
    $stmt->bind_param("si", $currentDateStr, $bookingId);
    $stmt->execute();
    $stmt->close();
    $conn->commit();
    $conn->close();

    $remainingSeconds = $endDate->getTimestamp() - $date->getTimestamp();
    return "#".str_pad($remainingSeconds, 5,'0', STR_PAD_LEFT);
  }

  public function endBooking($param){
    $date = new DateTime();
    $dateStr = $date->format('Y-m-d H:i:s');
    $machineId = substr($param, 0, 2);
    $consumption = intval(substr($param, 3, 8));

    $conn = $this->getConnection();
    $conn->begin_transaction();
    $stmt = $conn->prepare("update bookings set end_date = ?, consumption = ? WHERE machine_id = ? and start_date is not null and end_date is null");
    $stmt->bind_param("sii", $dateStr, $consumption, $machineId);
    $stmt->execute();
    $stmt->close();
    $conn->commit();
    $conn->close();
    
    return "#00001";
  }

  public function deleteBooking($id){
    /*** Borrat/anulació d'una reserva activa */

    $conn = $this->getConnection();  
    $conn->begin_transaction();
    $stmt = $conn->prepare("delete from bookings where id = ? and start_date IS NULL"); //Només permetem borrar reserves actives no realitzades
    $stmt->bind_param("i",$id);        
    $stmt->execute();
    $stmt->close();
    $conn->commit();
    $conn->close();
    return 1;
  }

  private function isExecutableBooking($machineId, $userId, $date, $startDate, $endDate){
    $conn = $this->getConnection();

    //Controlem que no hi hagi una reserva a l'hora indicada per la màquina facilitada.
    $stmt = $conn->prepare("select id from bookings where machine_id = ? and booking_date = ?"); 
    $stmt->bind_param("is", $machineId, $date);
    $stmt->execute();
    $totalRows = $stmt->get_result()->num_rows;
    $stmt->close();
    
    if($totalRows > 0){
      $conn->close();
      return false;
    }

    //Controlem que l'usuari no hagi fet 3 reserves en aquell dia!
    $sql = "select bookings.id from bookings inner join bookings_user on bookings_user.booking_id = bookings.id where user_id = ? and booking_date between ? and ?";
    $stmt = $conn->prepare($sql); 
    $stmt->bind_param("iss", $userId, $startDate, $endDate);
    $stmt->execute();
    $totalRows = $stmt->get_result()->num_rows;
    $stmt->close();
    $conn->close();
    return $totalRows < 3;
  }

  public function getAvailableHours($date, $machineId){
    try{ 
      $conn = $this->getConnection();
      $sql = "select hour(booking_date) as hour FROM bookings where year(booking_date) = ? and month(booking_date) = ? and day(booking_date) = ? and machine_id = ?";
      $stmt = $conn->prepare($sql); 
      $arrDate = explode("-",$date);
      $year = $arrDate[0];
      $month = $arrDate[1];
      $day = $arrDate[2];
      $stmt->bind_param("iiii", $year, $month, $day, $machineId);
      $stmt->execute();
      $results = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
          
      $a1 = [];
      $a2 = [];
      foreach($results as $result){
        array_push($a2, $result["hour"]);
      }
      for($i=0; $i < 24; $i++){
        array_push($a1, $i);
      }

      return $response = array_diff($a1, $a2); 
    }catch(Exception $e){
      return [];
    }

  }
  
}

?>