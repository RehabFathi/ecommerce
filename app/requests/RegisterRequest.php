<?php
include_once __DIR__.'/../database/models/User.php';

class RegisterRequest {
    private $name;
    private $phone;
    private $email;
    private $password;
    private $confirm_password;
    private $select;



    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

  

    /**
     * Get the value of phone
     */ 
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set the value of phone
     *
     * @return  self
     */ 
    public function setPhone($phone)
    {
        $this->phone = $phone;

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

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of confirm_password
     */ 
    public function getConfirm_password()
    {
        return $this->confirm_password;
    }

    /**
     * Set the value of confirm_password
     *
     * @return  self
     */ 
    public function setConfirm_password($confirm_password)
    {
        $this->confirm_password = $confirm_password;

        return $this;
    }

    /**
     * Get the value of select
     */ 
    public function getSelect()
    {
        return $this->select;
    }

    /**
     * Set the value of select
     *
     * @return  self
     */ 
    public function setSelect($select)
    {
        $this->select = $select;

        return $this;
    }
   

    // validation of frist name
    public function NameValidation($name)
    {
      $error=[];
      if(empty($this->name)){
          $error["required"]="<div class='alert alert-danger'>$name is required</div> ";
      }elseif ( strlen($this->name) < 3){
            $error["strlen"]="<div class='alert alert-danger'> The Minimum Number Of Latter Is 3</div>";
         }else{
             if(is_numeric($this->name)){
                $error["notNumber"]="<div class='alert alert-danger'> $name Must Be Not Number </div>"; 
             }
         } 
      return $error; 
    }
   
    // validation of phone
    public function PhoneValidation()
    {
        $error=[];
        if(empty($this->phone)){
            $error["required"]="<div class='alert alert-danger'>Phone Number is required</div> ";
        }elseif(!is_numeric($this->phone)){
            $error["numeric"]="<div class='alert alert-danger'>Phone Number Must Be Number </div> ";
        }else{
            if(strlen($this->phone) != 11 ){
                $error["number"]="<div class='alert alert-danger'>Phone Number Must Be 11 Number </div> ";
            }
        }
        return $error;
    }
    // validation of email
    public function emailValidation()
    {
        $error=[];
        $pattern = "/^([\w\-\.]+)@((\[([0-9]{1,3}\.){3}[0-9]{1,3}\])|(([\w\-]+\.)+)([a-zA-Z]{2,4}))$/";
        if(empty($this->email)){
            $error["required"]=" <div class='alert alert-danger'>Email is required</div> ";
        }else{
            if(!preg_match($pattern,$this->email) ){
                $error["regular"]=" <div class='alert alert-danger'>Email is Not Valid</div> ";  
            }
        }
        return $error;

    }

    public function passwordValidation($required="Password Is Required", $passwordMessage ="Minimum eight and maximum 20 characters, at least one uppercase letter, one lowercase letter, one number and one special character:" )
    {
        $error =[];
        $pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,20}$/";
        
        if(empty($this->password )){
            $error["Required"]= " <div class='alert alert-danger'>$required</div> ";  
        }else{
            if(!preg_match($pattern,$this->password)){
                $error["regex"] = "<div class='alert alert-danger'>".$passwordMessage." </div>";
            }
        }
        return $error;
    }
    public function confirmValidation()
    {
        $error =[];
        if(empty($this->confirm_password)){
            $error["Required"]=" <div class='alert alert-danger'>Confirm Password Is Required</div> ";    
        }else{
            if($this->password != $this->confirm_password){
                $error["confirmed"]=" <div class='alert alert-danger'>Confirm Password Must be the Same As Password</div> ";    
            }  
        }
        return $error;
    }
    // validation of select
    public function selectValidation($name , array $avaible)
    {
        $error=[];
        if(empty($this->select)){
            $error["required"]=" <div class='alert alert-danger'>$name Is Required</div> ";
        }else{
            if(!in_array($this->select,$avaible)){
                $error["avaible"]=" <div class='alert alert-danger'>$name Is Not Correct</div> ";
            }
        }
        return $error;
    }

    // validation of email exists
    public function emailExistsValidation()
    {
       $error=[];
       $user = new User;
       $user->setEmail($this->email);
       $result= $user->checkEmailExists();
       if($result){
        $error=" <div class='alert alert-danger'>This Email Is exists</div> ";
       }
       return $error;
    }
    // validation of phone exists
    public function phoneExistsValidation()
    {
      $error=[];
      $user = new User;
      $user->setPhone($this->phone);
      $result =$user->checkPhoneExists();
        if($result){
            $error=" <div class='alert alert-danger'>This Phone Is exists</div> ";
        }
        return $error;  
    } 
    }

