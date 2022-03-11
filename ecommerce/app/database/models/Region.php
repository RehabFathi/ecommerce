<?php
include_once "app/database/config/database.php";
include_once "app/database/config/crud.php";

class Region extends database implements crud {
    private $id;
    private $name_en;
    private $name_ar;
    private $status;
    private $lat;
    private $long;
    private $distance;
    private $city_id;
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
     * Get the value of name_en
     */ 
    public function getName_en()
    {
        return $this->name_en;
    }

    /**
     * Set the value of name_en
     *
     * @return  self
     */ 
    public function setName_en($name_en)
    {
        $this->name_en = $name_en;

        return $this;
    }

    /**
     * Get the value of name_ar
     */ 
    public function getName_ar()
    {
        return $this->name_ar;
    }

    /**
     * Set the value of name_ar
     *
     * @return  self
     */ 
    public function setName_ar($name_ar)
    {
        $this->name_ar = $name_ar;

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
     * Get the value of lat
     */ 
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Set the value of lat
     *
     * @return  self
     */ 
    public function setLat($lat)
    {
        $this->lat = $lat;

        return $this;
    }

    /**
     * Get the value of long
     */ 
    public function getLong()
    {
        return $this->long;
    }

    /**
     * Set the value of long
     *
     * @return  self
     */ 
    public function setLong($long)
    {
        $this->long = $long;

        return $this;
    }

    /**
     * Get the value of distance
     */ 
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * Set the value of distance
     *
     * @return  self
     */ 
    public function setDistance($distance)
    {
        $this->distance = $distance;

        return $this;
    }

    /**
     * Get the value of city_id
     */ 
    public function getCity_id()
    {
        return $this->city_id;
    }

    /**
     * Set the value of city_id
     *
     * @return  self
     */ 
    public function setCity_id($city_id)
    {
        $this->city_id = $city_id;

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

    function creat(){}
    function read(){
        $query ="SELECT * FROM `regions` WHERE `status`='$this->status'";
        return $this->runDQL($query);
    }
    function update(){}
    function delete(){}
    public function FunctionName()
    {
        $query ="SELECT * FROM `regions` WHERE `status`='$this->status'AND `city_id`='$this->city_id'";
        return $this->runDQL($query);
    }
}