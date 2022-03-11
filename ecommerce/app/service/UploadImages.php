<?php
class UploadImages {
    private $image;
    private $errors=[];
    private $photoExtension;
    private $photoName;
    public function __construct($image) {
        $this->image = $image;
    }
     /**
     * Get the value of photoName
     */ 
    public function getPhotoName()
    {
        return $this->photoName;
    }

    /**
     * Set the value of photoName
     *
     * @return  self
     */ 
    public function setPhotoName($photoName)
    {
        $this->photoName = $photoName;

        return $this;
    }

   
    public function extensionValidation(array $allowedExtensions = ['png','jpg','jpeg'])
    {
        $this->photoExtension = pathinfo($this->image['name'],PATHINFO_EXTENSION);
        if(!in_array($this->photoExtension,$allowedExtensions)){
            $this->errors['ext'] = "<div class='alert alert-danger'> Allowed Extensions are ".implode(",",$allowedExtensions)." </div>";
        } 
        return $this;
    }

    public function sizeValidation( int $maxUploadSize = 10**6)
    {
        if(empty($this->errors)){
            $maxUploadSizeMega = $maxUploadSize/1000000; // 1 mega
            if($this->image['size'] > $maxUploadSize){
                $this->errors['size'] = "<div class='alert alert-danger'> Size Must Be Less Than $maxUploadSizeMega Mega </div>";
            } 
        }
         return  $this->errors;
    }

    public function uploadImg(string $dir)
    {
        if(empty($this->errors)){
            $this->photoName = time(). '.' . $this->photoExtension; 
            $photoPath = $dir . $this->photoName; 
            move_uploaded_file($this->image['tmp_name'],$photoPath);
        }
        return $this->errors;
    }
 
        
        // update
        // condition
        // if(empty($errors['image'])){
        //     $_SESSION['user']['name'] = $_POST['name'];
        //     $_SESSION['user']['email'] = $_POST['email'];
        //     $_SESSION['user']['gender'] = $_POST['gender'];
        //     $success = "<div class='alert alert-success'> Data Updated Sucessfully </div>";
        // }
        

 

   
    }
