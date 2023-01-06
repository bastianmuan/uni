<?php
class Machine
{
    private $id;

    private $name;

    private $description;

    private $laboratoryId;

    private $active;
        
    public function __construct($bbddMachine) {
        $this->id = $bbddMachine["id"];
        $this->name = $bbddMachine["name"];
        $this->description = $bbddMachine["description"];
        $this->active = $bbddMachine["active"];
        $this->laboratoryId = $bbddMachine["laboratory_id"];
    }

    public function getId(){
        return $this->id;
    }

    public function getName(){
        return $this->name;
    }

    public function getDescription(){
        return $this->description;
    }

    public function getActive(){
        return $this->active;
    }

    public function getLaboratoryId(){
        return $this->laboratoryId;
    }
}
?>