<?php
$title = "Ckeck Code";
include_once "layouts/header.php";
include_once "app/middleware/auth.php";
include_once "layouts/nav.php";
include_once "app/requests/CodeRequest.php";
include_once "app/database/models/User.php";
if($_GET){
    $pages=["register","login","forgotPass", "my-account"];
    if(!isset($_GET["page"])){
        header("location:errors/404.php");
    }else{
        if(!in_array($_GET["page"],$pages)){
            header("location: errors/404.php"); 
        }
    }
}else{
    header("location:errors/404.php");
}
if ($_POST) {
    //validation
    $validation = new CodeRequest;
    $validation->setCode($_POST["code"]);
    $codeValidationResult = $validation->codeValidation();
///////////////////////////////////////////////

    if(empty($codeValidationResult)){
        $userObject = new User;
        $userObject->setCode($_POST["code"]);
        $userObject->setEmail($_SESSION['email']);
        $result =$userObject->checkCodeExists();
        if($result){
            $user = $result->fetch_object();
            $userObject->setStatus(1);
            date_default_timezone_set('Africa/Cairo');
            $userObject->setEmail_verified_at(date("Y-m-d H:i:s"));
            $verificationResult= $userObject->emailVerified();
            $message=[];
            if($verificationResult){
                if($_GET["page"]=="register"){
                    $message['success']=" <div class='alert alert-success'> Code is correct</div> ";
                    unset($_SESSION["email"]);
                    header("refresh:1 ; url=login.php");

                }elseif($_GET["page"]=="forgotPass"){
                    $message['success']=" <div class='alert alert-success'> Code is correct</div> ";
                    header("refresh:1 ; url=verifyPass.php");

                }elseif($_GET["page"]=="login"){
                    $message['success']=" <div class='alert alert-success'> Code is correct</div> ";
                    unset($_SESSION["email"]);
                    $_SESSION["user"]=$user;
                    header("refresh:1 ; url=index.php");

                }elseif($_GET["page"]=="my-account"){
                    $message['success']=" <div class='alert alert-success'> Code is correct</div> ";
                    unset($_SESSION["email"]);
                    $_SESSION["user"]=$user;
                    header("refresh:1 ; url= my-account.php");
                }
            }else{
                $message['error']=" <div class='alert alert-danger'> Some wrong Please Tray In Anather Time</div> ";
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
                            <h4><?= $title  ?> </h4>
                        </a>
                    </div>
                    <div class="tab-content">
                        <div id="lg1" class="tab-pane active">
                            <div class="login-form-container">
                                <div class="login-register-form">
                                    <?php
                                     if (isset($message["success"])) {
                                        echo  $message["success"];
                                    } 
                                    ?>
                                    <form method="post">
                                        <input type="number" name="code" placeholder="Code">
                                        <?php
                                        if(!empty($codeValidationResult)){
                                            foreach ($codeValidationResult as $key => $value) {
                                                echo $value;
                                            }
                                        }
                                        if (empty($result) && isset($result)) {
                                            echo  " <div class='alert alert-danger'>Code Is Not correct </div> ";
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