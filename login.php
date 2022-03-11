<?php
$title = "Login";
include_once "layouts/header.php";
include_once "app/middleware/auth.php";
include_once "layouts/nav.php";
include_once "layouts/breadcrumb.php";
include_once "app/requests/RegisterRequest.php";

if ($_POST) {
// validation
    $validation = new RegisterRequest;

    // validation of email 
    $validation->setEmail($_POST["email"]);
    $emailValidationResult = $validation->emailValidation();

    // validation of password
    $validation->setPassword($_POST["password"]);
    $passwordvalidationResult = $validation->passwordValidation($required="Password Is Required",$passwordMessage =" Wrong Email Or Password ");

    ///////////////////////////////////////////////////
    if (empty($passwordvalidationResult) && empty($emailValidationResult)) {
        $userData = new User;
        $userData->setEmail($_POST["email"]);
        $userData->setPassword($_POST["password"]);
        $result = $userData->login();

        if (!empty($result)) {      
            // user is exists in database
            $user = $result->fetch_object();
            if ($user->email_verified_at) {
                //   user is validate
                if ($user->status == 1) {
                    // user is active
                    if($_POST["rememberMe"]){
                        setcookie("rememberMe" , $_POST["email"], time() + 8600*30 );
                    }
                    $_SESSION["user"] = $user;
                    header("location:index.php");

                    // user is not active
                } elseif ($user->status == 0) {
                    $error = " <div class='alert alert-danger'>You are not active please concat  with admin</div> ";
                } 
            } else {
                //   user not validate
                $_SESSION['email'] = $_POST['email'];
                header("location:checkCode.php?page=login"); die;
            }
        } else {
            // user is not exists in database
            $error = " <div class='alert alert-danger'>Wrong Email Or Password</div> ";
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
                                        <input type="email" name="email" placeholder="Email" value="<?php if (isset($_POST['email'])) {
                                                                                                        echo $_POST['email'];
                                                                                                    } ?>">
                                        <?php
                                        if (!empty($emailValidationResult)) {
                                            foreach ($emailValidationResult as $key => $value) {
                                                echo $value;
                                            }
                                        }
                                        ?>
                                        <input type="password" name="password" placeholder="Password">
                                        <?php
                                        if (!empty($passwordvalidationResult)) {
                                            foreach ($passwordvalidationResult as $key => $value) {
                                                echo $value;
                                            }
                                        }

                                        if (isset($error)) {
                                            echo $error;
                                        }
                                        ?>
                                        <div class="button-box">
                                            <div class="login-toggle-btn">
                                                <input type="checkbox" name="rememberMe">
                                                <label>Remember me</label>
                                                <a href="forgotPass.php">Forgot Password?</a>
                                            </div>
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
