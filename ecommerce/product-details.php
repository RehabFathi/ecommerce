<?php

include_once "app/database/models/Product.php";
include_once "app/database/models/Review.php";
include_once "app/database/models/Spec.php";
include_once "app/database/models/Order.php";
include_once "app/database/models/Cart.php";
include_once "app/requests/MyAccountRequest.php";

if ($_GET) {
    if (isset($_GET['product'])) {
        if (is_numeric($_GET['product'])) {
            $productObject = new Product;
            $productData =  $productObject->setStatus(1)->setId($_GET['product'])->getProductById();
            if ($productData) {
                $product = $productData->fetch_object();
            } else {
                header("location:errors/404.php");
                die;
            }
        } else {
            header("location:errors/404.php");
            die;
        }
    } else {
        header("location:errors/404.php");
        die;
    }
} else {
    header("location:errors/404.php");
    die;
}
$title = $product->name_en;
include_once "layouts/header.php";
include_once "layouts/nav.php";
include_once "layouts/breadcrumb.php";

$reviewObject = new Review;
$specObject = new Spec;
$specdata = $specObject->setProduct_id($product->id)->read();
if ($specdata) {
    $specs = $specdata->fetch_all(MYSQLI_ASSOC);
}

$orderObject = new Order;
if (isset($_SESSION['user'])) {
    $ProductIsOrder = $orderObject->setProduct_id($product->id)
        ->setUser_id($_SESSION['user']->id)->checkIfUserOrderProduct();
}
if ($_POST) {
    if (isset($_POST["submit"])) {
        if ($ProductIsOrder) {
            $ReviewExist = $reviewObject->setProduct_id($product->id)->setUser_id($_SESSION['user']->id)->checkIfUserReview();
            if (!$ReviewExist) {
                if (!empty($_POST['value']) || !empty($_POST['Comment'])) {
                    if (is_numeric($_POST['value']) && in_array($_POST['value'], [1, 2, 3, 4, 5])) {
                        $reviewObject->setValue($_POST['value'])->setComment($_POST['Comment'])->creat();
                    } else {
                        $message['ErrorValue'] = "<div class='alert alert-warning col-12 text-center mt-4'> You Enter invalid value </div>";
                    }
                }
            } else {
                $message['ReviewExist'] = "<div class='alert alert-warning col-12 text-center mt-4'> You Already Reviewed This Product </div>";
            }
        } else {
            $message["NoReview"] = "<div class='alert alert-secondary col-12 text-center mt-4'>
        <h3 class='text-primary text-capitalize'>You Must Purchase The Product Before Evaluating It</h3>  
        <div class='pro-dec-social '>
            <ul>
                <li><a class='tweet '  href='#'><i class=''></i> Put Product In Cart</a></li>
            </ul>
        </div>
        </div>";
        }
    }
    $Validation = new MyacouuntRequest;
    $cartObject = new Cart;
    if (isset($_POST['AddCart']) || isset($_POST['cart'])) {
        $quantityErroes = $Validation->setNumber(isset($_POST['qtybutton']) ?  $_POST['qtybutton'] : 1)->NumberValidation("Quantity");
        if (empty($quantityErroes)) {
            if (isset($_SESSION['user'])) {
                $alreadyExists = $cartObject->setUser_id($_SESSION['user']->id)
                    ->setProduct_id((isset($_POST['product']) && is_numeric($_POST['product'])) ?  $_POST['product'] : "")->alreadyExists();
                if (!$alreadyExists) {
                    $cartResult = $cartObject->setQuantity(isset($_POST['qtybutton']) ?  $_POST['qtybutton'] : 1)->creat();
                    if ($cartResult) {
                        $successCart = "<div class='alert alert-success text-center'> This Product added To Your Cart</div>";
                        array_push($quantityErroes, $successCart);
                    } else {
                        $errorCart = "<div class='alert alert-danger text-center'> Some Wrong Tray Again</div>";
                        array_push($quantityErroes, $errorCart);
                    }
                } else {
                    $cart = $alreadyExists->fetch_object();
                    $CartExists = " <div class='alert alert-danger text-center'>You Can Not Add This Product again To The Cart<br>
               You Can Change Qunatity <br>
               <div class='pro-dec-social '>
                        <form method='post'>
                            <div class='product-quantity'>
                            <input hidden name='product' value=' $product->id'>
                                <input  name='qtybutton' value='$cart->quantity'>
                                <button type='submit' name='updateCart' class=' mt-2 '> Update Cart </button>
                        </form>
                    </div>
               </div>";
                    array_push($quantityErroes, $CartExists);
                }
            } else {
                $errorNotUser = "<div class='alert alert-danger text-center'> You Must Be User To Add To Cart, please 
          <div class='button-box'> <button type='submit'><a href ='login.php'>Login </a></button></div> </div>";
                array_push($quantityErroes, $errorNotUser);
            }
        }
    }

    if (isset($_POST["updateCart"])) {
        $quantityErroes = $Validation->setNumber($_POST['qtybutton'])->NumberValidation("Quantity");
        if (empty($quantityErroes)) {
            $cartUpdated =  $cartObject->setUser_id($_SESSION['user']->id)
                ->setProduct_id((isset($_POST['product']) && is_numeric($_POST['product'])) ?  $_POST['product'] : "")
                ->setQuantity($_POST['qtybutton'])->update();
            if ($cartUpdated) {
                $successCartUpdated = "<div class='alert alert-success text-center'> Quantity Updated </div>";
                array_push($quantityErroes, $successCartUpdated);
            } else {
                $errorCartUpdated = "<div class='alert alert-danger text-center'> Some Wrong Tray Again</div>";
                array_push($quantityErroes, $errorCartUpdated);
            }
        }
    }
}

$reviewData = $reviewObject->setProduct_id($product->id)->read();
if ($reviewData) {
    $reviews = $reviewData->fetch_all(MYSQLI_ASSOC);
};

$ProductRelatedData = $productObject->setStatus(1)->setBrand_id($product->brand_id)
    ->setSubcategory_id($product->subcategory_id)->RelatedProducts();
if ($ProductRelatedData) {
    $ProductsRelated = $ProductRelatedData->fetch_all(MYSQLI_ASSOC);
}



?>
<link rel="stylesheet" href="assets/css/star.css">;
<!-- Product Deatils Area Start -->
<div class="product-details pt-100 pb-95">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <div class="product-details-img">
                    <img class="zoompro" src="assets/img/product/<?= $product->image ?>" data-zoom-image="assets/img/product-details/product-detalis-bl1.jpg" alt="zoom" />
                    <!-- <span>-29%</span> -->
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="product-details-content">
                    <h4><?= $product->name_en ?></h4>
                    <div class="rating-review">
                        <div class="pro-dec-rating">
                            <?php
                            for ($i = 1; $i <= $product->avg_review; $i++) {
                            ?>
                                <i class="ion-android-star-outline theme-star"></i>
                            <?php
                            }
                            for ($i = 1; $i <= 5 - $product->avg_review; $i++) {
                            ?>
                                <i class="ion-android-star-outline"></i>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="pro-dec-review">
                            <ul>
                                <li><?= $product->count_review ?> Reviews </li>
                                <li> Add Your Reviews</li>
                            </ul>
                        </div>
                    </div>
                    <span><?= $product->price ?></span>
                    <div class="in-stock">
                        <?php
                        if ($product->quantity == 0) {
                            $Available = "Out stock";
                            $color = "danger";
                        } elseif ($product->quantity > 0 && $product->quantity <= 5) {
                            $Available = "In stock ( " . $product->quantity . " )";
                            $color = "warning";
                        } else {
                            $Available = "In stock";
                            $color = "success";
                        }
                        ?>
                        <p>Available: <span class="text-<?= $color ?>"><?= $Available ?></span></p>
                    </div>
                    <p><?= $product->desc_en ?> </p>
                    <div class="pro-dec-feature">
                        <ul>
                            <?php
                            if (isset($specs)) {
                                foreach ($specs as $index => $spec) {
                            ?>
                                    <li><?= $spec['spec_en'] ?>: <span> <?= $spec['spec_value'] ?></span></li>
                                <?php
                                }
                            } else {
                                ?>
                                <div class="pro-dec-feature">
                                    <ul>
                                        <li> <span> No Variable Spec</span></li>
                                    </ul>
                                </div>
                            <?php
                            }
                            ?>
                        </ul>
                    </div>
                    <!-- <div class="quality-add-to-cart">
                        <div class="quality">
                            <label>Qty:</label>
                            <input class="cart-plus-minus-box" type="text" name="qtybutton" value="02">
                        </div>
                        <div class="shop-list-cart-wishlist">
                            <a title="Add To Cart" href="#">
                                <i class="icon-handbag"></i>
                            </a>
                            <a title="Wishlist" href="#">
                                <i class="icon-heart"></i>
                            </a>
                        </div>
                    </div> -->
                    <div class="pro-dec-categories">
                        <ul>
                            <li class="categories-title text-success">Categories:</li>
                            <li><a href="shop.php?"><?= $product->category_name_en ?> <span class="text-success font-weight-bold"> | </span></a></li>
                            <li class="  "><a href="shop.php?sub=<?= $product->subcategory_id ?>"> <?= $product->subcategory_name_en ?> <span class="text-success font-weight-bold"> | </span> </a></li>
                            <li><a href="shop.php?brand=<?= $product->brand_id ?>"><?= $product->brand_name_en ?></a></li>
                        </ul>
                    </div>
                    <div class="pro-dec-social ">
                        <form method="post">
                            <div class="product-quantity">
                                <input hidden name="product" value="<?= $product->id ?>">
                                <button type="submit" name="cart" class=" mb-2 "> Put Product In Cart </button>
                        </form>
                    </div>
                    <?php
                    if ((isset($_POST['cart']) || isset($_POST['updateCart'])) && !empty($quantityErroes)) {
                        foreach ($quantityErroes as $key => $error) {
                            echo $error;
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Product Deatils Area End -->
<div class="description-review-area pb-70">
    <div class="container">
        <div class="description-review-wrapper">
            <?php
            if (isset($message)) {
                foreach ($message as $key => $value) {
                    echo $value;
                }
            }
            ?>
            <div class="description-review-topbar nav text-center">
                <a class="active" data-toggle="tab" href="#des-details1">Description</a>
                <a data-toggle="tab" href="#des-details3">Review</a>
            </div>
            <div class="tab-content description-review-bottom">
                <div id="des-details1" class="tab-pane active">
                    <div class="product-description-wrapper">
                        <p><?= $product->desc_en ?> </p>

                    </div>
                </div>
                <div id="des-details3" class="tab-pane">
                    <div class="rattings-wrapper">
                        <?php
                        if (isset($reviews)) {
                            foreach ($reviews as $index => $review) {
                        ?>
                                <div class="sin-rattings">
                                    <div class="star-author-all">
                                        <div class="ratting-star f-left">
                                            <?php
                                            for ($i = 0; $i < 5; $i++) {
                                                if ($i < $review['value']) {
                                            ?>
                                                    <i class="ion-star theme-color"></i>
                                                <?php
                                                } else {
                                                ?>
                                                    <i class="ion-android-star-outline"></i>
                                            <?php
                                                }
                                            }
                                            ?>
                                            <span>(<?= $review['value'] ?>)</span>
                                        </div>
                                        <div class="ratting-author f-right">
                                            <h3><?= $review['user_name'] ?></h3>
                                            <span><?php
                                                    $date = date_create($review['updated_at']);
                                                    echo date_format($date, "H:i") ?></span>
                                            <span><?= date_format($date, "d/M/Y") ?></span>
                                        </div>
                                    </div>
                                    <p><?= $review['comment'] ?></p>
                                </div>
                        <?php
                            }
                        } else {
                            echo "<div class='alert alert-warning text-center col-10 offset-1 '> No Review On This Products Yet </div>";
                        }
                        ?>
                    </div>

                    <?php
                    if (isset($_SESSION['user'])) {
                    ?>
                        <div class="ratting-form-wrapper">
                            <h3>Add your Comments :</h3>
                            <div class="ratting-form">
                                <form action="" method="post">
                                    <div class="star-box">
                                        <h2>Rating:</h2>
                                        <div>
                                            <input class="star" type="checkbox" name="value" value="5" id="st1">
                                            <label for="st1"></label>
                                            <input class="star" type="checkbox" name="value" value="4" id="st2">
                                            <label for="st2"></label>
                                            <input class="star" type="checkbox" name="value" value="3" id="st3">
                                            <label for="st3"></label>
                                            <input class="star" type="checkbox" name="value" value="2" id="st4">
                                            <label for="st4"></label>
                                            <input class="star" type="checkbox" name="value" value="1" id="st5">
                                            <label for="st5"></label>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="rating-form-style form-submit">
                                                <textarea name="Comment" placeholder="Comment"></textarea>
                                                <input type="submit" name="submit" value="add review">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            </form>
                        </div>
                </div>
            <?php
                    } else {
            ?>
                <div class="pro-dec-social ">
                    <ul>
                        <li><a class="tweet " href="login.php"><i class=""></i> Login To Add Review</a></li>
                    </ul>
                </div>
            <?php
                    }
            ?>
            </div>
        </div>
    </div>
</div>

<!-- Related Products -->
<div class="product-area pb-100">
    <div class="container">
        <div class="product-top-bar section-border mb-35">
            <div class="section-title-wrap">
                <h3 class="section-title section-bg-white">Related Products</h3>
            </div>
        </div>
        <div class="featured-product-active hot-flower owl-carousel product-nav">
            <?php
            if (isset($ProductsRelated)) {
                foreach ($ProductsRelated as $index => $ProductRelated) {
            ?>
                    <div class="product-wrapper">
                        <div class="product-img">
                            <a href="product-details.php?product=<?= $ProductRelated['id'] ?>">
                                <img alt="" src="assets/img/product/<?= $ProductRelated['image'] ?>">
                            </a>
                            <!-- <span>-30%</span> -->
                            <!-- Need Ajax -->
                            <div class="product-action">
                                <a class="action-wishlist" href="#" title="Wishlist">
                                    <i class="ion-android-favorite-outline"></i>
                                </a>
                                <a class="action-cart" href="#" title="Add To Cart">
                                    <i class="ion-ios-shuffle-strong"></i>
                                </a>
                                <a class="action-compare" href="#" data-target="#exampleModal<?= $ProductRelated['id'] ?>" data-toggle="modal" title="Quick View">
                                    <i class="ion-ios-search-strong"></i>
                                </a>
                            </div>
                            <!-- ------- -->
                        </div>
                        <div class="product-content text-left">
                            <div class="product-hover-style">
                                <div class="product-title">
                                    <h4>
                                        <a href="product-details.php?product=<?= $ProductRelated['id'] ?>"><?= $ProductRelated['name_en'] ?></a>
                                    </h4>
                                </div>
                                <!-- Need Ajax -->
                                <div class="cart-hover">
                                    <h4><a href="#">+ Add to cart</a></h4>
                                </div>
                                <!-- ---------- -->
                            </div>
                            <div class="product-price-wrapper">
                                <span><?= $ProductRelated['price'] ?></span>
                                <!-- <span class="product-price-old">$120.00 </span> -->
                            </div>
                        </div>
                    </div>
            <?php
                }
            }
            ?>

        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade " id="exampleModal<?= $ProductRelated['id'] ?>" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5 col-sm-5 col-xs-12">
                        <!-- Thumbnail Large Image start -->
                        <div class="tab-content">
                            <div id="pro-1" class="tab-pane fade show active">
                                <img src="assets/img/product/<?= $ProductRelated['image'] ?>" alt="">
                            </div>
                        </div>
                        <!-- Thumbnail Large Image End -->
                    </div>
                    <div class="col-md-7 col-sm-7 col-xs-12">
                        <div class="modal-pro-content">
                            <h3><?= $ProductRelated['name_en'] ?> </h3>
                            <div class="product-price-wrapper">
                                <!-- <span class="product-price-old">£162.00 </span> -->
                                <span><?= $ProductRelated['price'] ?> EGP</span>
                            </div>
                            <p><?= $ProductRelated['desc_en'] ?></p>
                            <div class="product-quantity">
                                <form action="" method="post">
                                    <div class="cart-plus-minus mb-2 ">
                                        <input class="cart-plus-minus-box" type="text" name="qtybutton" value="<?= isset($_POST['qtybutton']) ? $_POST['qtybutton'] : "2" ?>">
                                    </div>
                                    <input hidden name="product" value="<?= $ProductRelated['id'] ?>">
                                    <button type="submit" name="AddCart" class="m-0 mb-2 ">Add to cart</button>
                                    <?php
                                    if ((isset($_POST['cart']) || isset($_POST['updateCart'])) && !empty($quantityErroes)) {
                                        foreach ($quantityErroes as $key => $error) {
                                            echo $error;
                                        }
                                    }
                                    ?>
                                </form>
                            </div>
                            <?php
                            if ($ProductRelated['quantity'] == 0) {
                                $Available = "Out stock";
                                $note = "<br>( Wait For The New Quantity Soon)";
                                $color = "danger";
                            } elseif ($ProductRelated['quantity'] > 0 && $ProductRelated['quantity'] <= 5) {
                                $Available = "In stock ";
                                $note = " (Only  " . $ProductRelated['quantity'] . " )";
                                $color = "warning";
                            } else {
                                $Available = "   In stock";
                                $note = "";
                                $color = "success";
                                $check = "fa-check";
                            }
                            ?>
                            <span><i class="fa <?= $check ?>"></i><span class=" text-<?= $color ?>"><?= $Available ?></span><?= $note ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal end -->

<?php
include_once "layouts/footer.php"
?>