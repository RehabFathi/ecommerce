<?php
include_once "app/database/config/database.php";
include_once "app/database/config/crud.php";

class Cart extends database implements crud{
    private $user_id;
    private $product_id;
    private $quantity;
    

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
     * Get the value of product_id
     */ 
    public function getProduct_id()
    {
        return $this->product_id;
    }

    /**
     * Set the value of product_id
     *
     * @return  self
     */ 
    public function setProduct_id($product_id)
    {
        $this->product_id = $product_id;

        return $this;
    }

    /**
     * Get the value of quantity
     */ 
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set the value of quantity
     *
     * @return  self
     */ 
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    function creat(){
        $query ="INSERT INTO `carts`(`user_id`,`product_id`,`quantity`)
        VALUES($this->user_id,$this->product_id,$this->quantity)";
        return $this->runDML($query);
    }
    function read(){
        $query ="SELECT `carts`.*,`products`.`name_en`AS`product_name_en`,`products`.`image`AS`product_image`,
        `products`.`price` AS`product_price` FROM `carts`
        JOIN `products` ON `carts`.`product_id`=`products`.`id`  WHERE `user_id`=$this->user_id ";
        return $this->runDQL($query);
    }
    function update(){
        $query ="UPDATE `carts`SET`quantity`=$this->quantity WHERE `user_id`=$this->user_id AND`product_id`=$this->product_id";
        return $this->runDML($query);
    }
    function delete(){}
    public function alreadyExists()
    {
        $query ="SELECT * FROM `carts` WHERE `user_id`=$this->user_id AND `product_id`=$this->product_id";
        return $this->runDQL($query);
    }
}