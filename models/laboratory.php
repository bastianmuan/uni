<?php
class Laboratory
{
    private $id;

    private $name;

    private $description;

    private $active;
        
    public function __construct($bbddLaboratory) {
        $this->id = $bbddLaboratory["id"];
        $this->name = $bbddLaboratory["name"];
        $this->description = $bbddLaboratory["description"];
        $this->active = $bbddLaboratory["active"];
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

}
?>