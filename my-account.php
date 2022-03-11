<?php
$title = "My Account";
include_once "layouts/header.php";
include_once "app/middleware/guest.php";
include_once "layouts/nav.php";
include_once "layouts/breadcrumb.php";
include_once "app/requests/RegisterRequest.php";
include_once "app/database/models/User.php";
include_once "app/service/uploadImages.php";
include_once "app/mail/SendMail.php";
include_once "app/database/models/Address.php";
include_once "app/database/models/City.php";
include_once "app/database/models/Region.php";
include_once "app/requests/MyAccountRequest.php";

$userdata = new User;
$userdata->setEmail($_SESSION["user"]->email);

$validation = new RegisterRequest;

if (isset($_POST["updateProfile"])) {
    //   validation of frist name
    $validation->setName($_POST["frist_name"]);
    $FristNameValidationResult = $validation->NameValidation("Frist Name");

    //   validation of last name
    $validation->setName($_POST["last_name"]);
    $lastNameValidationResult = $validation->NameValidation("Last Name");

    //   validation of phone
    $validation->setPhone($_POST["phone"]);
    $phoneValidationResult = $validation->PhoneValidation();
    $phoneExistsValidationResult = $validation->phoneExistsValidation();

    //   validation of gender
    $validation->setSelect($_POST["gender"]);
    $avaible = ['m', 'f'];
    $genderValidationResult = $validation->SelectValidation('Gender', $avaible);

    if (
        empty($FristNameValidationResult) && empty($lastNameValidationResult)
        && empty($phoneValidationResult) && empty($genderValidationResult)
    ) {
        $userdata->setFrist_name($_POST["frist_name"]);
        $userdata->setLast_name($_POST["last_name"]);
        $userdata->setPhone($_POST["phone"]);
        $userdata->setGender($_POST["gender"]);

        if ($_FILES['image']['error'] == 0) {
            $uploadImage = new UploadImages($_FILES['image']);
            $uploadImage->extensionValidation()->sizeValidation();
            $uploadImageRsult = $uploadImage->uploadImg('assets/img/users/');
            if (empty($uploadImageRsult)) {

                $userdata->setImage($uploadImage->getPhotoName());
            }
        }
        $updated = $userdata->update();
        if ($updated) {
            $message['updateProfile']['success'] = "<div class='alert alert-success text-center'> data updated </div>";
        } else {
            $message['updateProfile']['error'] = "<div class='alert alert-danger text-center'> something went wrong </div>";
        }
    }
}
if (isset($_POST["updatePassword"])) {
    $OldPasswordValidation = $validation->setPassword($_POST['oldPassword'])->passwordValidation($required = "Old Password Is Required");
    if (empty($OldPasswordValidation)) {
        if (sha1($_POST['oldPassword']) == $_SESSION['user']->password) {
            $passwordValidation = $validation->setPassword($_POST['password'])->passwordValidation();
            $confirmValidation = $validation->setConfirm_password($_POST['confirmPassword'])->confirmValidation();
            if (empty($passwordValidation) && empty($confirmValidation)) {
                if ($_POST['password'] != $_POST['oldPassword']) {
                    $userdata->setPassword($_POST['password']);
                    $uploadPasswordRsult = $userdata->updatePassword();
                    if ($uploadPasswordRsult) {
                        $message['updatePassword']['success'] = "<div class='alert alert-success text-center'> Password updated </div>";
                    } else {
                        $message['updatePassword']['error'] = "<div class='alert alert-danger text-center'> something went wrong </div>";
                    }
                } else {
                    $errors["NewPassword "] = "<div class='alert alert-danger'>change the new password </div>";
                }
            }
        } else {
            $errors["old"] = "<div class='alert alert-danger'>Old Password Is Not Correct</div>";
        }
    }
}

if (isset($_POST["updateEmail"])) {
    $validation->setEmail($_POST['email']);
    $emailValidation = $validation->emailValidation();
    if (empty($emailValidation)) {
        if ($_POST['email'] != $_SESSION["user"]->email) {
            $checkEmailExists = $validation->setEmail($_POST['email'])->emailExistsValidation();
            if ($checkEmailExists) {
                $errors['updateEmail']["exists "] = "<div class='alert alert-danger'>This EmailIs already Exists in this website </div>";
            }
        } else {
            $errors['updateEmail']["Newemail "] = "<div class='alert alert-danger'>You Should change the new email</div>";
        }
    }
    if (empty($errors['updateEmail']) && empty($emailValidation)) {
        $code = rand(10000, 99999);
        $userdata->setEmail($_POST['email'])->setId($_SESSION['user']->id)->setCode($code)
            ->setStatus(0)->setEmail_verified_at('NULL');
        $updateEmail = $userdata->updateEmail();

        if ($updateEmail) {
            $subject = "Change email Code";
            $body = "<div class='alert alert-success  m-1'> Hi dear <b>" . $_SESSION['user']->frist_name . "</b>; <br> You Verification Code is <b>" . $code . "<b><br> Thank You.<div>";
            $sendMail = new SendMail($_POST["email"], $subject, $body);
            $errors['updateEmail']["sendMail "] = $sendMail->send();

            if (empty($errors['updateEmail']["sendMail "])) {
                unset($_SESSION['user']);
                $_SESSION['email'] = $_POST['email'];
                $message['updateEmail']['success'] = "<div class='alert alert-success'>Your Check Code Sent to your New Email</div>";
                header("Refresh:2, URL= checkCode.php?page=my-account ");
            }
        } else {
            $errors['updateEmail']["notUpdated "] = "<div class='alert alert-danger'>something went wrong</div>";
        }
    }
}
$user = $userdata->read()->fetch_object();


$cityObject = new City;
$cityData = $cityObject->setStatus(1)->read();
if ($cityData) {
    $cities = $cityData->fetch_all(MYSQLI_ASSOC);
}
$regionObject = new Region;
$regionData = $regionObject->setStatus(1)->read();
if ($regionData) {
    $regions = $regionData->fetch_all(MYSQLI_ASSOC);
}
$addressObject = new Address;
$validationAccount = new MyacouuntRequest;

if (isset($_POST["address"])) {
    // validation of city
    $validation->setSelect((isset($_POST["city"]) ? $_POST["city"] : ""));
    $avaibleCities = [];
    foreach ($cities as $key => $value) {
        array_push($avaibleCities, $value['id']);
    }
    $cityValidationResult = $validation->selectValidation("City", $avaibleCities);
    // validation of region
    $validation->setSelect((isset($_POST["region"]) ? $_POST["region"] : ""));
    $avaibleRegion = [];
    foreach ($regions as $key => $valueRegion) {
        array_push($avaibleRegion, $valueRegion['id']);
    }
    $regionValidationResult = $validation->selectValidation("Region", $avaibleRegion);

    // validation of street
    $validation->setName($_POST["street"]);
    $streetValidationResult = $validation->NameValidation("Street");

    // validation of building
    $validationAccount->setNumber($_POST["building"]);
    $buildingValidationResult = $validationAccount->NumberValidation("Bulding Number");

    // validation of floor
    $validationAccount->setNumber($_POST["floor"]);
    $floorValidationResult = $validationAccount->NumberValidation("Floor Number");

    // validation of flat
    $validationAccount->setNumber($_POST["flat"]);
    $flatValidationResult = $validationAccount->NumberValidation("Flat Number");
    // print_r($_POST);die;
    if (
        empty($cityValidationResult) && empty($regionValidationResult) && empty($streetValidationResult) &&
        empty($buildingValidationResult) && empty($floorValidationResult) && empty($flatValidationResult)
    ) {
        $addressObject->setStreet($_POST['street'])->setNotes($_POST['note'])
            ->setRegion_id($_POST['region'])->setFlat_number($_POST['flat'])
            ->setFloor($_POST['floor'])->setBuilding($_POST['building'])
            ->setUser_id($user->id);

        $addressData = $addressObject->setStatus(1)->setUser_id($user->id)->read();
        if ($addressData) {
            $addresses = $addressData->fetch_all(MYSQLI_ASSOC);
        }


        if (isset($_POST['address']['add'])) {
            if ((isset($addresses) && count($addresses) < 5 )|| !isset($addresses) ) {
                $added = $addressObject->creat();
                if ($added) {
                    $message['addAddress']['success'] = "<div class='alert alert-success text-center'> Add New Address </div>";
                } else {
                    $message['addAddress']['error'] = "<div class='alert alert-danger text-center'> something went wrong </div>";
                }
            } elseif (isset($addresses) && count($addresses) >= 5) {
                $message['addAddress']['num'] = "<div class='alert alert-danger text-center'> The Maximum Number Of Your Address Is 5 </div>";
            }
        }
        if (isset($_POST['address']['update'])) {
            $addressObject->setId($_POST['address']['update']);
            $updated = $addressObject->update();
            if ($updated) {
                $message['updateAddress']['success'] = "<div class='alert alert-success text-center'> data updated </div>";
            } else {
                $message['updateAddress']['error'] = "<div class='alert alert-danger text-center'> something went wrong </div>";
            }
        }
        if (isset($_POST['address']['delete'])) {
            $addressObject->setId($_POST['address']['delete']);
            // print_r($_POST);die;
            $delete = $addressObject->delete();
            if ($delete) {
                $message['deleteAddress']['success'] = "<div class='alert alert-success text-center'> This Address deleted </div>";
            } else {
                $message['deleteAddress']['error'] = "<div class='alert alert-danger text-center'> something went wrong </div>";
            }
        }
    }
}

$addressData = $addressObject->setStatus(1)->setUser_id($user->id)->read();
if ($addressData) {
    $addresses = $addressData->fetch_all(MYSQLI_ASSOC);
}




?>
<!-- my account start -->
<div class="checkout-area pb-80 pt-100">
    <div class="container">
        <div class="row">
            <div class="ml-auto mr-auto col-lg-9">
                <div class="checkout-wrapper">
                    <div id="faq" class="panel-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><span>1</span> <a data-toggle="collapse" data-parent="#faq" href="#my-account-1">Edit your account information </a></h5>
                            </div>
                            <div id="my-account-1" class="panel-collapse collapse <?php if (isset($_POST['updateProfile'])) echo 'show'; ?> ">
                                <div class="panel-body">
                                    <div class="billing-information-wrapper">
                                        <div class="account-info-wrapper">
                                            <h4>My Account Information</h4>
                                            <h5>Your Personal Details</h5>
                                        </div>
                                        <form method="post" enctype="multipart/form-data">
                                            <?php
                                            if (!empty($message['updateProfile'])) {
                                                foreach ($message['updateProfile'] as $key => $value) {
                                                    echo $value;
                                                }
                                            }
                                            if (!empty($uploadImageRsult)) {
                                                foreach ($uploadImageRsult as $key => $value) {
                                                    echo $value;
                                                }
                                            }
                                            ?>
                                            <div class="col-4 offset-4 mb-1">
                                                <img src="assets/img/users/<?= $user->image;  ?>" alt="" class="rounded-circle w-100 ">
                                                <input type="file" name="image">
                                            </div>
                                            <div class="row mt-4">
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="billing-info">
                                                        <label>First Name</label>
                                                        <input type="text" name="frist_name" value="<?= $user->frist_name;  ?>">
                                                    </div>
                                                    <?php
                                                    if (!empty($FristNameValidationResult)) {
                                                        foreach ($FristNameValidationResult as $key => $value) {
                                                            echo $value;
                                                        }
                                                    }

                                                    ?>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="billing-info">
                                                        <label>Last Name</label>
                                                        <input type="text" name="last_name" value="<?= $user->last_name;  ?>">
                                                    </div>
                                                    <?php
                                                    if (!empty($lastNameValidationResult)) {
                                                        foreach ($lastNameValidationResult as $key => $value) {
                                                            echo $value;
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="billing-info">
                                                        <label>Phone</label>
                                                        <input type="phone" name="phone" value="<?= $user->phone;  ?>">
                                                    </div>
                                                    <?php
                                                    if (!empty($phoneValidationResult)) {
                                                        foreach ($phoneValidationResult as $key => $value) {
                                                            echo $value;
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                                <div class="col-lg-6 col-md-6 ">
                                                    <div class="billing-info ">
                                                        <label>Gender</label>
                                                        <select name="gender" class="form-control">
                                                            <option value="m" <?= $user->gender == "M" ? "selected" : "";  ?>>Male</option>
                                                            <option value="f" <?= $user->gender == "F" ? "selected" : "";  ?>>Female</option>
                                                        </select>
                                                        <?php
                                                        if (isset($genderValidationResult["required"])) {
                                                            echo $genderValidationResult["required"];
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="billing-back-btn">
                                                <div class="billing-btn">
                                                    <button type="submit" name="updateProfile">Update Profile</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title "><span>2</span> <a data-toggle="collapse" data-parent="#faq" href="#my-account-2">Edit your addresses information </a></h5>
                            </div>
                            <div id="my-account-2" class="panel-collapse collapse <?php if (isset($_POST['address'])) echo 'show'; ?>">
                                <div class="panel-body">
                                    <div class="billing-information-wrapper">
                                        <div class="account-info-wrapper">
                                            <h4> My Addresses Information</h4>
                                            <h5>Your Addresses Details</h5>
                                        </div>
                                        <?php
                                        if (!empty($message['deleteAddress'])) {
                                            foreach ($message['deleteAddress'] as $key => $value) {
                                                echo $value;
                                            }
                                        }
                                        if (isset($addresses)) {
                                            foreach ($addresses as $index1 => $address) {
                                        ?>
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <h5 class="panel-title bg-white"><span><?= $index1 + 1 ?></span> <a data-toggle="collapse" data-parent="#faq\" href="#my-account-<?= $index1 . 'add' ?>"><?= $address["city name_en"] . ' / ' . $address["region name_en"] . ' / ' . $address["street"] ?> </a></h5>
                                                    </div>
                                                    <div id="my-account-<?= $index1 . 'add' ?>" class='panel-collapse collapse <?= (isset($_POST["address"]["update"]) && $_POST["address"]["update"] == $address['id']) ? "show" : "" ?> '>
                                                        <div class="panel-body">
                                                            <div class="billing-information-wrapper">
                                                                <div class="account-info-wrapper">
                                                                    <h4> My Address Information</h4>
                                                                    <h5>Your Addres Details</h5>
                                                                </div>
                                                                <form action="" method="post">
                                                                    <?php
                                                                    if (!empty($message['updateAddress']) && (isset($_POST["address"]["update"]) && $_POST["address"]["update"] == $address['id'])) {
                                                                        foreach ($message['updateAddress'] as $key => $value) {
                                                                            echo $value;
                                                                        }
                                                                    }
                                                                    ?>
                                                                    <div class="row">
                                                                        <div class="col-lg-12 col-md-12">
                                                                            <div class="billing-info">
                                                                                <label>City</label>
                                                                                <select name="city" id="" class="form-control">
                                                                                    <?php
                                                                                    if (isset($cities)) {
                                                                                        foreach ($cities as $index => $city) {
                                                                                    ?>
                                                                                            <option value="<?= $city['id'] ?>" <?= isset($_POST['region']) && $_POST['region'] == $city['id'] ? "selected" : "" ?>><?= $city['name_en'] ?></option>
                                                                                    <?php
                                                                                        }
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                                <?php
                                                                                if (isset($_POST["address"]["update"]) && $_POST["address"]["update"] == $address['id']  && !empty($cityValidationResult)) {
                                                                                    foreach ($cityValidationResult as $key => $value) {
                                                                                        echo $value;
                                                                                    }
                                                                                }
                                                                                ?>
                                                                                <label class="mt-4">Region</label>
                                                                                <select name="region" id="" class="form-control">
                                                                                    <?php
                                                                                    if (isset($regions)) {
                                                                                        foreach ($regions as $index => $region) {
                                                                                    ?>
                                                                                            <option value="<?= $region['id'] ?>" <?= isset($_POST['region']) && $_POST['region'] == $region['id'] ? "selected" : "" ?>><?= $region['name_en'] ?></option>
                                                                                    <?php
                                                                                        }
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                                <?php
                                                                                if (isset($_POST["address"]["update"]) && $_POST["address"]["update"] == $address['id']  && !empty($regionValidationResult)) {
                                                                                    foreach ($regionValidationResult as $key => $value) {
                                                                                        echo $value;
                                                                                    }
                                                                                }
                                                                                ?>
                                                                                <label class="mt-4">Street</label>
                                                                                <input type="text" name="street" value="<?= $address["street"];  ?>">
                                                                                <?php
                                                                                if (isset($_POST["address"]["update"]) && $_POST["address"]["update"] == $address['id']  && !empty($streetValidationResult)) {
                                                                                    foreach ($streetValidationResult as $key => $value) {
                                                                                        echo $value;
                                                                                    }
                                                                                }
                                                                                ?>
                                                                                <label class="mt-4">Building Number</label>
                                                                                <input type="number" name="building" value="<?= $address["building"]  ?>">
                                                                                <?php
                                                                                if (isset($_POST["address"]["update"]) && $_POST["address"]["update"] == $address['id']  && !empty($buildingValidationResult)) {
                                                                                    foreach ($buildingValidationResult as $key => $value) {
                                                                                        echo $value;
                                                                                    }
                                                                                }
                                                                                ?>
                                                                                <label class="mt-4">Floor Number</label>
                                                                                <input type="number" name="floor" value="<?= $address["floor"]  ?>">
                                                                                <?php
                                                                                if (isset($_POST["address"]["update"]) && $_POST["address"]["update"] == $address['id']  && !empty($floorValidationResult)) {
                                                                                    foreach ($floorValidationResult as $key => $value) {
                                                                                        echo $value;
                                                                                    }
                                                                                }
                                                                                ?>
                                                                                <label class="mt-4">Flat Number</label>
                                                                                <input type="number" name="flat" value="<?= $address["flat_number"]  ?>">
                                                                                <?php
                                                                                if (isset($_POST["address"]["update"]) && $_POST["address"]["update"] == $address['id']  && !empty($flatValidationResult)) {
                                                                                    foreach ($flatValidationResult as $key => $value) {
                                                                                        echo $value;
                                                                                    }
                                                                                }
                                                                                ?>
                                                                                <label class="mt-4">Note</label>
                                                                                <textarea type="text" name="note" class="bg-white"><?= $address["notes"] ?></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="billing-back-btn">
                                                                        <div class="billing-btn">
                                                                            <button type="submit" value="<?= $address['id'] ?>" name="address[update]">Update This Address</button>
                                                                            <button type="submit" value="<?= $address['id'] ?>" name="address[delete]">Delete This Address</button>

                                                                        </div>
                                                                        <div class="">
                                                                            <button type="submit" class=" btn btn-outline-danger border-secondary  " name="">Delete This Address</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        <?php
                                            }
                                        }
                                        ?>

                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h5 class="panel-title bg-secondary"><a data-toggle="collapse" data-parent="#faq\" href="#my-account-add"> Add New Address </a></h5>
                                            </div>
                                            <div id="my-account-add" class="panel-collapse collapse <?php if (isset($_POST['address']['add'])) echo 'show'; ?>">
                                                <div class="panel-body">
                                                    <div class="billing-information-wrapper">
                                                        <div class="account-info-wrapper">
                                                            <h4>Add New Address</h4>
                                                            <h5>Your Address</h5>
                                                        </div>
                                                        <form action="" method="post">
                                                            <?php
                                                            if (!empty($message['addAddress'])) {
                                                                foreach ($message['addAddress'] as $key => $value) {
                                                                    echo $value;
                                                                }
                                                            }
                                                            ?>
                                                            <div class="row">
                                                                <div class="col-lg-12 col-md-12">
                                                                    <div class="billing-info">
                                                                        <label>City</label>
                                                                        <select name="city" id="" class="form-control">
                                                                            <option selected disabled>Select Your City</option>
                                                                            <?php
                                                                            foreach ($cities as $index => $city) {
                                                                            ?>
                                                                                <option value="<?= $city['id'] ?>" <?= isset($_POST['city']) && $_POST['city'] == $city['id'] ? "selected" : "" ?>> <?= $city['name_en'] ?> </option>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                        <?php
                                                                        if (isset($_POST["address"]['add']) && !empty($cityValidationResult)) {
                                                                            foreach ($cityValidationResult as $key => $value) {
                                                                                echo $value;
                                                                            }
                                                                        }
                                                                        ?>
                                                                        <label class="mt-4">Region</label>
                                                                        <select name="region" id="" class="form-control">
                                                                            <option selected disabled>Select Your Region</option>
                                                                            <?php
                                                                            foreach ($regions as $index => $region) {
                                                                            ?>
                                                                                <option value="<?= $region['id'] ?>" <?= isset($_POST['region']) && $_POST['region'] == $region['id'] ? "selected" : "" ?>><?= $region['name_en'] ?></option>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                        <?php
                                                                        if (isset($_POST["address"]['add']) && !empty($regionValidationResult)) {
                                                                            foreach ($regionValidationResult as $key => $value) {
                                                                                echo $value;
                                                                            }
                                                                        }
                                                                        ?>
                                                                        <label class="mt-4">Street</label>
                                                                        <input type="text" name="street" value="<?= isset($_POST['street']) ? $_POST['street'] : "" ?> ">
                                                                        <?php
                                                                        if (isset($_POST["address"]['add']) && !empty($streetValidationResult)) {
                                                                            foreach ($streetValidationResult as $key => $value) {
                                                                                echo $value;
                                                                            }
                                                                        }
                                                                        ?>
                                                                        <label class="mt-4">Building Namber</label>
                                                                        <input type="number" name="building" value="<?= isset($_POST['building']) ? $_POST['building'] : "" ?>">
                                                                        <?php
                                                                        if (isset($_POST["address"]['add']) && !empty($buildingValidationResult)) {
                                                                            foreach ($buildingValidationResult as $key => $value) {
                                                                                echo $value;
                                                                            }
                                                                        }
                                                                        ?>
                                                                        <label class="mt-4">Floor Namber</label>
                                                                        <input type="number" name="floor" value="<?= isset($_POST['floor']) ? $_POST['floor'] : "" ?>">
                                                                        <?php
                                                                        if (isset($_POST["address"]['add']) && !empty($floorValidationResult)) {
                                                                            foreach ($floorValidationResult as $key => $value) {
                                                                                echo $value;
                                                                            }
                                                                        }
                                                                        ?>
                                                                        <label class="mt-4">Flat Number</label>
                                                                        <input type="number" name="flat" value="<?= isset($_POST['flat']) ? $_POST['flat'] : "" ?>">
                                                                        <?php
                                                                        if (isset($_POST["address"]['add']) && !empty($flatValidationResult)) {
                                                                            foreach ($flatValidationResult as $key => $value) {
                                                                                echo $value;
                                                                            }
                                                                        }
                                                                        ?>
                                                                        <label class="mt-4">Note</label>
                                                                        <textarea type="text" name="note" class="bg-white" value="<?= isset($_POST['note']) ? $_POST['note'] : "" ?>"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="billing-back-btn">
                                                                <div class="billing-btn">
                                                                    <button type="submit" name="address[add]">Add New Address</button>
                                                                </div>
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
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><span>3</span> <a data-toggle="collapse" data-parent="#faq" href="#my-account-3">Change your password </a></h5>
                            </div>
                            <div id="my-account-3" class="panel-collapse collapse  <?php if (isset($_POST['oldPassword'])) echo 'show'; ?>">
                                <div class="panel-body">
                                    <div class="billing-information-wrapper">
                                        <div class="account-info-wrapper">
                                            <h4>Change Password</h4>
                                            <h5>Your Password</h5>
                                        </div>
                                        <form action="" method="post">
                                            <?php
                                            if (!empty($message['updatePassword'])) {
                                                foreach ($message['updatePassword'] as $key => $value) {
                                                    echo $value;
                                                }
                                            }
                                            ?>
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="billing-info">
                                                        <label>Old Password</label>
                                                        <input type="password" name="oldPassword">
                                                    </div>
                                                    <?php
                                                    if (!empty($OldPasswordValidation)) {
                                                        foreach ($OldPasswordValidation as $key => $value) {
                                                            echo $value;
                                                        }
                                                    }
                                                    if (isset($errors["old"])) {
                                                        echo $errors["old"];
                                                    }
                                                    ?>
                                                </div>
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="billing-info">
                                                        <label>Password</label>
                                                        <input type="password" name="password">
                                                    </div>
                                                    <?php
                                                    if (!empty($passwordValidation)) {
                                                        foreach ($passwordValidation as $key => $value) {
                                                            echo $value;
                                                        }
                                                    }
                                                    if (isset($errors["NewPassword "])) {
                                                        echo $errors["NewPassword "];
                                                    }
                                                    ?>
                                                </div>
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="billing-info">
                                                        <label>Password Confirm</label>
                                                        <input type="password" name="confirmPassword">
                                                    </div>
                                                    <?php
                                                    if (!empty($confirmValidation)) {
                                                        foreach ($confirmValidation as $key => $value) {
                                                            echo $value;
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="billing-back-btn">
                                                <div class="billing-btn">
                                                    <button type="submit" name="updatePassword">Change your password</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><span>4</span> <a data-toggle="collapse" data-parent="#faq" href="#my-account-4">Change your Email </a></h5>
                            </div>
                            <div id="my-account-4" class="panel-collapse collapse <?php if (isset($_POST['updateEmail'])) echo 'show'; ?>">
                                <div class="panel-body">
                                    <div class="billing-information-wrapper">
                                        <div class="account-info-wrapper">
                                            <h4>Change your Email</h4>
                                            <h5>Your Email</h5>
                                        </div>
                                        <form action="" method="post">
                                            <?php

                                            if (!empty($message['updateEmail'])) {
                                                foreach ($message['updateEmail'] as $key => $value) {
                                                    echo $value;
                                                }
                                            }
                                            ?>
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="billing-info">
                                                        <label>Email</label>
                                                        <input type="email" name="email" value="<?= $user->email;  ?>">
                                                    </div>
                                                    <?php
                                                    if (!empty($emailValidation)) {
                                                        foreach ($emailValidation as $key => $value) {
                                                            echo $value;
                                                        }
                                                    }
                                                    if (!empty($errors['updateEmail'])) {
                                                        foreach ($errors['updateEmail'] as $key => $value) {
                                                            echo $value;
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="billing-back-btn">
                                                <div class="billing-btn">
                                                    <button type="submit" name="updateEmail">Change your Email</button>
                                                </div>
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
</div>
<!-- my account end -->
<?php
include_once "layouts/footer.php";
?>