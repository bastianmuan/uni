<?php

class LaboratoryDao extends Dao{
  
  public function getLaboratories($active = -1){
    /*** Obtenció dels laboratoris segons filtre */

    $conn = $this->getConnection();
        
    $sql = "SELECT * FROM laboratories WHERE 1 = 1";
     if($active >= 0){
      $sql .= " AND active = ?";
    }
    
    $stmt = $conn->prepare($sql); 
    if($active >= 0){
      $stmt->bind_param("i", $active);
    }
    
    $stmt->execute();
    $bdLaboratories = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $conn->close();
    $response = [];
    foreach($bdLaboratories as $bdLaboratory){
      array_push($response, new Laboratory($bdLaboratory));
    }
    return $response;
  }

  public function getLaboratory($id){
    /*** Obtenció de laboratory per id */
    $conn = $this->getConnection();
    $stmt = $conn->prepare("select * from laboratories where id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $bdLaboratories = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $conn->close();
    foreach($bdLaboratories as $bdLaboratory){
      return new Laboratory($bdLaboratory);
    }
    return null;
  }

  public function createLaboratory($postLaboratory){
    /*** Creació d'un nou laboratori ***/

    $conn = $this->getConnection();
    $conn->begin_transaction();

    $name = $postLaboratory["name"];
    $description = $postLaboratory["description"];
    $active = $postLaboratory["active"];
    
    $stmt = $conn->prepare("insert into laboratories (name, description, active) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $name, $description, $active);
    $stmt->execute();
    $stmt->close();

    $lastId  = $conn->insert_id;
    $conn->commit();
    $conn->close();
    return $lastId;
  }

  public function updateLaboratory($putLaboratory){
    /*** Edició d'un laboratori ***/

    $conn = $this->getConnection();
    $conn->begin_transaction();

    $id = $putLaboratory["id"];
    $name = $putLaboratory["name"];
    $description = $putLaboratory["description"];
    $active = $putLaboratory["active"];

    $sql = "update laboratories SET name = ?, description = ?, active = ? where id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssii", $name, $description, $active, $id);
    $stmt->execute();
    $stmt->close();
    $conn->commit();
    $conn->close();
  }

  public function deleteLaboratory($id){
    /*** Borrat d'un laboratory. ***/

    $bookingDao = new BookingDao();
    /* Control de reserves actives d'un laboratory. No es permet borrar el laboratory */
    $hasBookingLaboratories = $bookingDao->getActiveBookingLaboratories($id); 
    if($hasBookingLaboratories){
      return 0;
    }

    $conn = $this->getConnection();  
    $conn->begin_transaction();
    $stmt = $conn->prepare("delete from laboratories where id = ?");
    $stmt->bind_param("i",$id);        
    $stmt->execute();
    $stmt->close();
    $conn->commit();
    $conn->close();
    return 1;
  }
}

?>