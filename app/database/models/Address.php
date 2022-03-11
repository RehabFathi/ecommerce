<?php
include_once "app/database/config/database.php";
include_once "app/database/config/crud.php";

class Address extends database implements crud{
    private $id;
    private $street;
    private $building;
    private $floor;
    private $flat_number;
    private $notes;
    private $status;
    private $region_id;
    private $user_id;
    private $created_at;
    private $updated_at;

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of street
     */ 
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set the value of street
     *
     * @return  self
     */ 
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get the value of building
     */ 
    public function getBuilding()
    {
        return $this->building;
    }

    /**
     * Set the value of building
     *
     * @return  self
     */ 
    public function setBuilding($building)
    {
        $this->building = $building;

        return $this;
    }

    /**
     * Get the value of floor
     */ 
    public function getFloor()
    {
        return $this->floor;
    }

    /**
     * Set the value of floor
     *
     * @return  self
     */ 
    public function setFloor($floor)
    {
        $this->floor = $floor;

        return $this;
    }

  /**
     * Get the value of flat_number
     */ 
    public function getFlat_number()
    {
        return $this->flat_number;
    }

    /**
     * Set the value of flat_number
     *
     * @return  self
     */ 
    public function setFlat_number($flat_number)
    {
        $this->flat_number = $flat_number;

        return $this;
    }

    /**
     * Get the value of notes
     */ 
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set the value of notes
     *
     * @return  self
     */ 
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * Get the value of status
     */ 
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */ 
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of region_id
     */ 
    public function getRegion_id()
    {
        return $this->region_id;
    }

    /**
     * Set the value of region_id
     *
     * @return  self
     */ 
    public function setRegion_id($region_id)
    {
        $this->region_id = $region_id;

        return $this;
    }

    /**
     * Get the value of user_id
     */ 
    public function getUser_id()
    {
        return $this->user_id;
    }

    /**
     * Set the value of user_id
     *
     * @return  self
     */ 
    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * Get the value of created_at
     */ 
    public function getCreated_at()
    {
        return $this->created_at;
    }

    /**
     * Set the value of created_at
     *
     * @return  self
     */ 
    public function setCreated_at($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * Get the value of updated_at
     */ 
    public function getUpdated_at()
    {
        return $this->updated_at;
    }

    /**
     * Set the value of updated_at
     *
     * @return  self
     */ 
    public function setUpdated_at($updated_at)
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    function creat(){
        $query = "INSERT INTO `addersses`( `street`,`building`,`floor`, `flat_number`,`notes`,`region_id`,`user_id`)
        VALUES('$this->street', $this->building, $this->floor,$this->flat_number , '$this->notes', $this->region_id,$this->user_id)";
        return $this->runDML($query);

    }
    function read(){
        $query ="SELECT * FROM `addressdtails` WHERE `status`=$this->status AND `user_id`=$this->user_id ORDER bY `updated_at` DESC "  ;
        return $this->runDQL($query);
    }
    function update(){
        $query ="UPDATE `addersses` set `street`='$this->street',`building`='$this->building',`floor`='$this->floor' ,
        `flat_number`='$this->flat_number',`notes`='$this->notes',`region_id`='$this->region_id' WHERE `id`=$this->id AND `user_id`=$this->user_id ";
        return $this->runDML($query); 
    }
    function delete(){
        $query="DELETE FROM`addersses`WHERE `id`=$this->id";
        return$this->runDML($query);
    }

  
}