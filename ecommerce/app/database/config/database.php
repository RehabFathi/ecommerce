<?php
class database{
    private $hostName = 'localhost';
    private $database = 'ecommerce';
    private  $userName = "root";
    private $password = "";
    private  $con;

    // connection with database
    public function __construct() {
           $this->con = new mysqli($this->hostName,$this->userName,$this->password,$this->database);
          
        // check connection
        // if ($con->connect_error) {
        //     die("Connection failed: " . $con->connect_error);
        // } else {
        //     echo "ok";
        // }
    }

    // to deal with database
  public function runDML($query)
  {
      $result = $this->con->query($query);
      if($result){
        return true;
      }else{
        return false;
      }
  }
  
  public function runDQL($query)
  {
   $result =$this->con->query($query);
   if($result->num_rows >0 ){
       return $result;
   }else{
       return [];
   }
  }
}

