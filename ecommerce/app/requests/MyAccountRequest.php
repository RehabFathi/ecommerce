<?php
class MyacouuntRequest
{
    private $number;

   

    /**
     * Get the value of number
     */ 
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set the value of number
     *
     * @return  self
     */ 
      
        
    
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    public function NumberValidation($name)
    {
      $error=[];
      if(empty($this->number)){
          $error["required"]="<div class='alert alert-danger'>$name is required</div> ";
      }else{
             if(!is_numeric($this->number)){
                $error["number"]="<div class='alert alert-danger'> $name Must Be Number </div>"; 
             }
         } 
      return $error; 
    }

  
}
