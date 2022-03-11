<?php
include_once "app/database/config/database.php";
include_once "app/database/config/crud.php";

class Review extends database implements crud{
    private $product_id;
    private $user_id;
    private $value;
    private $comment;
    private $created_at;
    private $updated_at;

    

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
     * Get the value of value
     */ 
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the value of value
     *
     * @return  self
     */ 
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get the value of comment
     */ 
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set the value of comment
     *
     * @return  self
     */ 
    public function setComment($comment)
    {
        $this->comment = $comment;

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
        $query= "INSERT INTO `reviews` (`product_id`,`user_id`,`comment`,`value`) value($this->product_id,$this->user_id,'$this->comment',$this->value)";
        return $this->runDML($query);
    }
    function read(){
        $query ="SELECT `reviews`.*,CONCAT(`users`.`frist_name`,' ',`users`.`last_name`) AS `user_name`
         FROM `reviews`
        JOIN `users`
        ON `users`.`id` =`reviews`.`user_id`
         WHERE `product_id`=$this->product_id ORDER BY `created_at`DESC,`value`DESC";
        return $this->runDQL($query);
    }
    function update(){}
    function delete(){}

    public function checkIfUserReview()
    {
        $query ="SELECT * FROM `reviews` WHERE `product_id`=$this->product_id AND `user_id`=$this->user_id";
        return $this->runDQL($query);
    }
    

}