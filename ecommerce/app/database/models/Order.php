<?php
include_once "app/database/config/database.php";
include_once "app/database/config/crud.php";

class Order extends database implements crud{
    private $product_id;
    private $user_id;
    private $price_after_order;

  
     

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
     * Get the value of price_after_order
     */ 
    public function getPrice_after_order()
    {
        return $this->price_after_order;
    }

    /**
     * Set the value of price_after_order
     *
     * @return  self
     */ 
    public function setPrice_after_order($price_after_order)
    {
        $this->price_after_order = $price_after_order;

        return $this;
    }

    function creat(){}
    function read(){}
    function update(){}
    function delete(){}
    public function checkIfUserOrderProduct()
    {
        $query ="SELECT `order`.*,
        `products_orders`.*,
        `addersses`.`user_id`
        FROM `products_orders`
        JOIN `order`
        ON `order`.`id`=`products_orders`.`order_id`
        JOIN `addersses`
        ON `order`.`address_id` =`addersses`.`id`
        WHERE `product_id`=$this->product_id AND `user_id`=$this->user_id";
        return $this->runDQL($query);
    }
}