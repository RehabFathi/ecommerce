<?php
include_once "app/database/models/User.php";
class CodeRequest{
    private $code;
    private $email;

    /**
     * Get the value of code
     */ 
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set the value of code
     *
     * @return  self
     */ 
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

  

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }


    public function codeValidation()
    {
        $error=[];
        if(!$this->code){
            $error['required']=" <div class='alert alert-danger'>Code Is Required </div> ";
        }else{
            if(!is_numeric($this->code)){
                $error['numaric']=" <div class='alert alert-danger'>Code Must Be Number </div> ";
            }else{
                if(strlen($this->code)!= 5){
                    $error['digit']=" <div class='alert alert-danger'>Code Must Be 5 Digit </div> ";
                }
            }
        }
        return $error;
    }

}