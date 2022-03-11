<?php
include_once "app/database/config/database.php";
include_once "app/database/config/crud.php";

class Spec extends database implements crud{
private $product_id;
private $spec_id;
private $spec_value; 

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
 * Get the value of spec_id
 */ 
public function getSpec_id()
{
return $this->spec_id;
}

/**
 * Set the value of spec_id
 *
 * @return  self
 */ 
public function setSpec_id($spec_id)
{
$this->spec_id = $spec_id;

return $this;
}

/**
 * Get the value of spec_value
 */ 
public function getSpec_value()
{
return $this->spec_value;
}

/**
 * Set the value of spec_value
 *
 * @return  self
 */ 
public function setSpec_value($spec_value)
{
$this->spec_value = $spec_value;

return $this;
}

function creat(){}
function read(){
    $query ="SELECT `product_spec` .*,
    `products`.`name_en`,
    `spec`.`spec_en`
    FROM `product_spec`
    JOIN`products`
    ON `products`.`id`=`product_spec`.`product_id`
    JOIN `spec`
    ON `spec`.`id`=`product_spec`.`spec_id`
    WHERE `product_id`=$this->product_id";
    return $this->runDQL($query);
}
function update(){}
function delete(){}
}
