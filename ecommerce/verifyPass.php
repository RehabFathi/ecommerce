<?php
$title = "Verified Password";
include_once "layouts/header.php";
include_once "app/middleware/auth.php";
include_once "layouts/nav.php";
include_once "layouts/breadcrumb.php";
include_once "app/requests/RegisterRequest.php";
include_once "app/database/models/User.php";

if($_POST){
    // validation
    $validation=new RegisterRequest;
     // validation of Password
    $validation->setPassword($_POST["password"]);
    $passwordValidationResult = $validation->passwordValidation();

    // validation of confirm Password
    $validation->setConfirm_password($_POST["confirm-password"]);
    $confirmValidationResult = $validation->confirmValidation();

    if(empty($passwordValidationResult)&&empty($confirmValidationResult)){
       $userObject = new User;
       $userObject->setEmail($_SESSION["email"])->setPassword($_POST["password"]);
       $updatePasswordResult = $userObject->updatePassword();
       if($updatePasswordResult){
           unset($_SESSION["email"]);
           header("location:login.php");
       }else{
        $message = "<div class='alert alert-danger'> Something Went Wrong </div>";
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
                        <a class="active" data-toggle="tab" href="#lg1">
                            <h4><?= $title ?> </h4>
                        </a>
                    </div>
                    <div class="tab-content">
                        <div id="lg1" class="tab-pane active">
                            <div class="login-form-container">
                                <div class="login-register-form">
                                    <form method="post">
                                       <?php 
                                        if(isset($message)){
                                            echo $message;
                                        }
                                        ?>
                                        <input type="password" name="password" placeholder="Password">
                                        <?php
                                        if (!empty($passwordValidationResult)) {
                                            foreach ($passwordValidationResult as $key => $value) {
                                                echo $value;
                                            }
                                        }
                                        ?>
                                        <input type="password" name="confirm-password" placeholder="Confirm Password">
                                        <?php
                                        if (!empty($confirmValidationResult)) {
                                            foreach ($confirmValidationResult as $key => $value) {
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
include_once "layouts/footer.php";
