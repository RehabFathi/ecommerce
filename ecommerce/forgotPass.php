<?php
$title = "Verified Email";
include_once "layouts/header.php";
include_once "layouts/nav.php";
include_once "app/requests/RegisterRequest.php";
include_once "app/database/models/User.php";
include_once "app/mail/SendMail.php";
if($_POST){
    // validation of email
    $validation = new RegisterRequest;
    $validation->setEmail($_POST["email"]);
    $emailValidationResult = $validation->emailValidation();
    if(empty($emailValidationResult)){
       $emailExistsValidationResult=  $validation->emailExistsValidation();
       if(!empty($emailExistsValidationResult)){
           $code=rand(10000,99999);
           $user = new User;
           $user->setCode($code);
           $user->setEmail($_POST["email"]);
           $updatCodeResult = $user->updateCode();
           if($updatCodeResult){
            $subject = "Forgot Code";
            $body ="<div class='alert alert-success  m-2'>  <br> Your Verification Code is <b>".$code."<b><br> Thank You.<div>";
               $sendMail = new SendMail($_POST["email"],$subject,$body);
               $sendMailResult = $sendMail->send();
               if(empty( $sendMailResult )){
                $_SESSION['email'] = $_POST['email'];
                header("location:checkCode.php?page=forgotPass");
               }
           }
           
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
                                        <input type="email" name="email" placeholder="Email" value="<?php if (isset($_POST['email'])) { echo $_POST['email']; } ?>">
                                        <?php
                                        if (!empty($emailValidationResult)) {
                                            foreach ($emailValidationResult as $key => $value) {
                                                echo $value;
                                            }
                                        }
                                        if(isset($emailExistsValidationResult) && empty($emailExistsValidationResult)){
                                            echo  " <div class='alert alert-danger'>This Email Is Not Exists In Our Records</div> ";
                                        }
                                        if(isset($updatCodeResult) &&!$updatCodeResult){
                                            echo  " <div class='alert alert-danger'>Some Wrong Tray again</div> ";
                                        }
                                        if( !empty( $sendMailResult )){
                                            echo  $sendMailResult;
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
