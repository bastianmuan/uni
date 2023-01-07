<?php

class MachineDao extends Dao{
  
  public function getMachines($active = -1, $laboratoryId = 0){
    /*** Obtenció de les màquines segons filtre */

    $conn = $this->getConnection();
        
    $sql = "SELECT * FROM machines WHERE 1 = 1";
     if($active >= 0){
      $sql .= " AND active = ?";
    }
    if($laboratoryId > 0){
      $sql .= " AND laboratory_id = ?";
    }
    $stmt = $conn->prepare($sql); 
    if($active >= 0 && $laboratoryId > 0){
      $stmt->bind_param("ii", $active, $laboratoryId);
    }else if($active >= 0){
      $stmt->bind_param("i", $active);
    }else if($laboratoryId > 0){
      $stmt->bind_param("i", $laboratoryId);
    }
    $stmt->execute();
    $bdMachines = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $conn->close();
    $response = [];
    foreach($bdMachines as $bdMachine){
      array_push($response, new Machine($bdMachine));
    }
    return $response;
  }

  public function getMachine($id){
    /*** Obtenció de màquina per id */
    $conn = $this->getConnection();
    $stmt = $conn->prepare("select * from machines where id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $bdMachines = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $conn->close();
    foreach($bdMachines as $bdMachine){
      return new Machine($bdMachine);
    }
    return null;
  }

  public function createMachine($postMachine){
    /*** Creació d'una nova màquina ***/

    $conn = $this->getConnection();
    $conn->begin_transaction();

    $name = $postMachine["name"];
    $description = $postMachine["description"];
    $laboratoryId = isset($postMachine["laboratoryId"]) ? $postMachine["laboratoryId"] : NULL;
    $active = $postMachine["active"];
    
    $stmt = $conn->prepare("insert into machines (name, description, laboratory_id, active) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssii", $name, $description, $laboratoryId, $active);
    $stmt->execute();
    $stmt->close();

    $lastId  = $conn->insert_id;
    $conn->commit();
    $conn->close();
    return $lastId;
  }

  public function updateMachine($putMachine){
    /*** Edició d'una màquina ***/

    $conn = $this->getConnection();
    $conn->begin_transaction();

    $id = $putMachine["id"];
    $name = $putMachine["name"];
    $description = $putMachine["description"];
    $laboratoryId = $putMachine["laboratoryId"];
    $active = $putMachine["active"];

    if(!is_numeric($laboratoryId)){
      $sql = "update machines SET name = ?, description = ?, laboratory_id = NULL, active = ? where id = ?";
      
    }else{
      $sql = "update machines SET name = ?, description = ?, laboratory_id = ?, active = ? where id = ?";
    }
    $stmt = $conn->prepare($sql);
    if(!is_numeric($laboratoryId)){
      $stmt->bind_param("ssii", $name, $description, $active, $id);
    }else{
      $stmt->bind_param("ssiii", $name, $description, $laboratoryId, $active, $id);
    }
    $stmt->execute();
    $stmt->close();
    $conn->commit();
    $conn->close();
  }

  public function deleteMachine($id){
    /*** Borrat d'una màquina. ***/

    $bookingDao = new BookingDao();
    /* Control de reserves actives d'una màquina. No es permet borrar la màquina */
    $hasBookingMachines = $bookingDao->getActiveBookingMachines($id); 
    if($hasBookingMachines){
      return 0;
    }

    $conn = $this->getConnection();  
    $conn->begin_transaction();
    $stmt = $conn->prepare("delete from machines where id = ?");
    $stmt->bind_param("i",$id);        
    $stmt->execute();
    $stmt->close();
    $conn->commit();
    $conn->close();
    return 1;
  }
}

?>