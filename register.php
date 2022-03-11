<?php
      $title = "register";
    include_once "layouts/header.php";
    include_once "app/middleware/auth.php";
    include_once "layouts/nav.php";
    include_once "layouts/breadcrumb.php";
    include_once "app/requests/RegisterRequest.php";
    include_once "app/database/models/User.php";
    include_once "app/mail/SendMail.php";
    if($_POST){
        // validation
        $validation =new RegisterRequest;

        // validation of frist name
        $validation -> setName($_POST["frist-name"]);
        $FristNameValidationResult = $validation -> NameValidation("Frist Name"); 

       // validation of last name
        $validation->setName($_POST["last-name"]);
        $lastNameValidationResult = $validation -> NameValidation("Last Name");

        // validation of phone
        $validation->setPhone($_POST["phone"]);
        $phoneValidationResult = $validation-> PhoneValidation();
        $phoneExistsValidationResult = $validation->phoneExistsValidation();
       
        // validation of email
        $validation->setEmail($_POST["email"]);
        $emailValidationResult = $validation->emailValidation();
        $emailExistsValidationResult= $validation->emailExistsValidation();
    
        // validation of gender
        $validation->setSelect((isset($_POST["gender"]) ? $_POST["gender"] : ""));
        $avaible=["m","f"];
        $genderValidationResult= $validation->selectValidation("Gender", $avaible);

        // validation of password 
        $validation->setPassword($_POST['password']);
        $passwordValidationResult = $validation->passwordValidation();

         // validation of  confirmed
        $validation->setConfirm_password($_POST["confirm-password"]);
        $confirmValidationResult = $validation->confirmValidation();
  
////////////////////////////////////////////////////

      if(empty($FristNameValidationResult) && empty($lastNameValidationResult) && empty($phoneValidationResult)
          && empty($emailValidationResult) && empty($genderValidationResult) && empty( $passwordValidationResult)
          && empty($phoneExistsValidationResult) && empty($emailExistsValidationResult)) {
           // generate code 
        $code = rand(10000,99999);
        // insert data to database
        $userData= new User;
        $userData->setFrist_name($_POST['frist-name']);
        $userData->setLast_name($_POST['last-name']);
        $userData->setPhone($_POST['phone']);
        $userData->setEmail($_POST['email']);
        $userData->setGender($_POST['gender']);
        $userData->setPassword($_POST['password']);
        $userData->setCode($code);
        $result= $userData->creat();

        if($result){
            //send email with code for verified
            $subject = "Validation Code";
            $body ="<div class='alert alert-success  m-1'> Hi dear <b>".$_POST["frist-name"]."</b>; <br> You Verification Code is <b>".$code."<b><br> Thank You.<div>";
            $sendMail = new SendMail($_POST["email"] , $subject , $body );
            $sendMailResult = $sendMail->send();
            if(empty($sendMailResult)){
                $message['successRegister']=" <div class='alert alert-success'>Good Regiser; Check Your Mail To Find Code   </div> ";
                $_SESSION["email"]=$_POST["email"];
                header("location: checkCode.php?page=register");
            }
        }else{
            $error["insertData"]="<div class='alert alert-danger'>please tay again</div> ";
        }
      }   
    }
   
    ?>

    <div class="login-register-area ptb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                    <div class="login-register-wrapper">
                        <div class="login-register-tab-list nav">
                            <a class="active" data-toggle="tab" href="#lg2">
                                <h4> register </h4>
                            </a>
                        </div>
                        <div class="tab-content">
                            <div id="lg2" >
                                <div class="login-form-container">
                                    <div class="login-register-form">
                                        <?php
                                        if(!empty($sendMailResult)){
                                            echo $sendMailResult;
                                        }else{
                                            if(isset($message['successRegister'])){
                                                echo$message['successRegister'];
                                            }
                                        }
                                        ?>
                                        <form  method="post">
                                            <input type="text" name="frist-name" placeholder="Frist Name" value="<?= isset($_POST['frist-name'])? $_POST['frist-name']:"" ?>" >
                                            <?php
                                            if(!empty($FristNameValidationResult)){
                                               foreach ($FristNameValidationResult as $key => $value) {
                                                   echo $value;
                                               }
                                            } 
                                            ?>
                                            <input type="text" name="last-name" placeholder="Last Name"value="<?= isset($_POST['last-name'])? $_POST['last-name']:"" ?>" >
                                            <?php
                                            if(!empty($lastNameValidationResult)){
                                               foreach ($lastNameValidationResult as $key => $value) {
                                                   echo $value;
                                               }
                                            } 
                                            ?>
                                            <input name="phone" placeholder="Phone Namber" type="phone" value="<?= isset($_POST['phone'])? $_POST['phone']:"" ?>">
                                            <?php
                                            if(!empty($phoneValidationResult)){
                                               foreach ($phoneValidationResult as $key => $value) {
                                                   echo $value;
                                               }
                                            } 
                                            if(!empty($phoneExistsValidationResult)){
                                                echo $phoneExistsValidationResult;
                                            }
                                            ?>
                                            <input name="email" placeholder="Email" type="email" value="<?= isset($_POST['email'])? $_POST['email']:"" ?>">
                                            <?php
                                            if(!empty($emailValidationResult)){
                                               foreach ($emailValidationResult as $key => $value) {
                                                   echo $value;
                                               }
                                            }
                                            if(!empty($emailExistsValidationResult)){
                                                echo $emailExistsValidationResult;
                                            } 
                                            ?>
                                            <input type="password" name="password" placeholder="Password" >
                                            <?php
                                            if(!empty($passwordValidationResult)){
                                               foreach ($passwordValidationResult as $key => $value) {
                                                   echo $value;
                                               }
                                            } 
                                            ?>
                                            <input type="password" name="confirm-password" placeholder="Confirm Password">
                                            <?php
                                            if(!empty($confirmValidationResult)){
                                               foreach ($confirmValidationResult as $key => $value) {
                                                   echo $value;
                                               }
                                            } 
                                            ?>
                                            <select name="gender" class="form-control mb-4">
                                                <option selected disabled> Select Your Gender</option>
                                                <option value="m" <?= isset($_POST["gender"]) && $_POST["gender"]=="m" ? "selected":""  ?> >Male</option>
                                                <option value="f" <?= isset($_POST["gender"]) && $_POST["gender"]=="f" ? "selected":""  ?> >Female</option>
                                            </select>
                                            <?php
                                            if(!empty($genderValidationResult)){
                                                foreach ($genderValidationResult as $key => $value) {
                                                    echo $value;
                                                } 
                                            } 
                                            ?>
                                            <div class="button-box">
                                                <button type="submit"><span><?= $title ?></span></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer style Start -->
    <?php
    include_once "layouts/footer.php"
    ?>
   