<?php

class UserDao extends Dao{

  public function emailExists($email){
    /*** Control d'email repetit ***/
    
    $conn = $this->getConnection();
    $stmt = $conn->prepare("select * from users where email = ? "); 
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $user = $result->fetch_assoc();
    $conn->close();
    return $user != null;
  }

  public function getUsers(){
    /*** Obtenció dels usuaris */

    $conn = $this->getConnection();
    $stmt = $conn->prepare("select * from users order by role"); 
    $stmt->execute();
    $bdUsers = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $conn->close();
    $response = [];
    foreach($bdUsers as $bdUser){
      array_push($response, new User($bdUser));
    }
    return $response;
  }

  public function getUserById($id){
    /*** Obtenció d'usuari per id */
    
    $conn = $this->getConnection();
    $stmt = $conn->prepare("select * from users where id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $bdUsers = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $conn->close();
    foreach($bdUsers as $bdUser){
      return new User($bdUser);
    }
    return null;
  }

  public function getUser($email, $password){
    /*** Obtenció d'usuari mitjançant login ***/

    $conn = $this->getConnection();
    $stmt = $conn->prepare("select * from users where active = 1 AND email = ? "); 
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $user = $result->fetch_assoc();
    $conn->close();
    if($user == null || hash('sha256', $password) != $user["password"]){
      return null;
    }

    return new User($user);
  }

  public function createUser($postUser){
    /*** Creació d'usuari ***/

    $conn = $this->getConnection();
    $conn->begin_transaction();

    $name = $postUser["name"];
    $surname = $postUser["surname"];
    $email = $postUser["email"];
    $password = hash('sha256', $postUser["password"]);
    $role = $postUser["role"];
    $rfid = $postUser["rfid"];
    
    $stmt = $conn->prepare("insert into users (name, surname, email, password, role, rfid) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssis", $name, $surname, $email, $password, $role, $rfid);
    $stmt->execute();
    $stmt->close();

    $lastId  = $conn->insert_id;
    $conn->commit();
    $conn->close();
    return $lastId;
  }

  public function updateUser($putUser){
    /*** Edició d'usuari ***/

    $conn = $this->getConnection();
    $conn->begin_transaction();

    $id = $putUser["id"];
    $name = $putUser["name"];
    $surname = $putUser["surname"];
    $role = $putUser["role"];
    $rfid = $putUser["rfid"];

    $sql = "update users SET name = ?, surname = ?, role = ?, rfid = ?";
    if(isset($putUser["active"])){
      $sql .= ", active = ?";
    }
    $sql .= " WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if(isset($putUser["active"])){
      $stmt->bind_param("ssisii", $name, $surname, $role, $rfid, $putUser["active"], $id);
    }else{
      $stmt->bind_param("ssisi", $name, $surname, $role, $rfid, $id);
    }
    
    $stmt->execute();
    $stmt->close();
    $conn->commit();
    $conn->close();
  }

  function deleteUser($id){
    /*** Borrat d'usuari ***/

    /* Borrat de reserves active per aquest usuari */
    $bookingDao = new BookingDao();
    $bookingDao->removeActiveBookings($id);

    $conn = $this->getConnection();        
    $conn->begin_transaction();

    $stmt = $conn->prepare("delete from users where id = ?");
    $stmt->bind_param("i",$id);        
    $stmt->execute();
    $stmt->close();
    $conn->commit();
    $conn->close();
  }

}

?>