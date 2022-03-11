<?php
include_once "app/database/models/Category.php";
include_once "app/database/models/SupCategory.php";
include_once "app/database/models/Cart.php";
?>

<header class="header-area gray-bg clearfix">
    <div class="header-bottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-6">
                    <div class="logo">
                        <a href="index.php">
                            <img alt="" src="assets/img/logo/logo.png">
                        </a>
                    </div>
                </div>
                <div class="col-lg-9 col-md-8 col-6">
                    <div class="header-bottom-right">
                        <div class="main-menu">
                            <nav>
                                <ul>
                                    <li class="top-hover"><a href="index.php">home</a></li>
                                    <li><a href="shop.php">Shop</a></li>
                                    <li class="mega-menu-position top-hover"><a href="shop.php">categories</a>
                                        <ul class="mega-menu">
                                            <?php
                                            $categoryObject = new Category;
                                            $categoryData = $categoryObject->setStatus(1)->read();

                                            if ($categoryData) {
                                                $categories = $categoryData->fetch_all(MYSQLI_ASSOC);
                                                foreach ($categories as $index => $category) {
                                            ?>
                                                    <li>
                                                        <ul>
                                                            <li class="mega-menu-title"><a href="shop.php?cat=<?= $category["id"] ?>" class="fm-l bold"><?= $category["name_en"] ?></a></li>

                                                            <?php
                                                            $subCategoryObject = new SupCategory;
                                                            $subCategoryData = $subCategoryObject->setStatus(1)->setCategory_id($category["id"])->read();
                                                            if ($subCategoryData) {
                                                                $subCategories = $subCategoryData->fetch_all(MYSQLI_ASSOC);
                                                                foreach ($subCategories as $index =>  $subCategory) {
                                                            ?>
                                                                    <li><a href="shop.php?sub=<?= $subCategory['id'] ?>"><?= $subCategory["name_en"] ?></a></li>
                                                            <?php
                                                                }
                                                            } else {
                                                                echo  "<div class='alert alert-warning'>No Any SubCategories </div>";
                                                            }
                                                            ?>
                                                        </ul>
                                                    </li>
                                            <?php
                                                }
                                            } else {
                                                echo "<div class='alert alert-warning'>No Any Categories </div>";
                                            }

                                            ?>
                                        </ul>
                                    </li>
                                    <li><a href="contact.php">contact</a></li>
                                    <li><a href="about-us.php">about</a></li>
                                </ul>
                            </nav>
                        </div>
                        <div class="header-currency">
                            <?php
                            if (isset($_SESSION["user"])) {
                            ?>
                                <span class="digit"><?= $_SESSION["user"]->frist_name . ' ' . $_SESSION["user"]->last_name ?> <i class="ti-angle-down"></i></span>
                                <div class="dollar-submenu">
                                    <ul>
                                        <li><a href="my-account.php">My account</a></li>
                                        <li><a href="logout.php">Logout</a></li>
                                    </ul>
                                </div>
                            <?php
                            } else {
                            ?>
                                <a href="login.php"><span class="digit">Login <i class="ti-angle-down"></i></span></a>
                                <div class="dollar-submenu">
                                    <ul>
                                        <li><a href="register.php">Register</a></li>
                                    </ul>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="header-cart">
                            <a href="#">
                                <div class="cart-icon">
                                    <i class="ti-shopping-cart"></i>
                                </div>
                            </a>
                            <div class="shopping-cart-content">
                                <ul>
                                    <?php
                                    $cartObject = new Cart;
                                    $cartData = $cartObject->setUser_id($_SESSION['user']->id)->read();
                                    if ($cartData) {
                                        $tptalPrice=50;
                                        $carts = $cartData->fetch_all(MYSQLI_ASSOC);
                                        foreach ($carts as $index => $cart) {
                                            $tptalPrice +=($cart['product_price']*$cart['quantity']);
                                    ?>
                                            <li class="single-shopping-cart">
                                                <div class="shopping-cart-img">
                                                    <a href="#"><img alt="" style="height: 5em;" src="assets/img/product/<?= $cart['product_image']?>"></a>
                                                </div>
                                                <div class="shopping-cart-title">
                                                    <h4><a href="#"><?= $cart['product_name_en']?></a></h4>
                                                    <h6>Qty: <?= $cart['quantity']?></h6>
                                                    <span><?= $cart['product_price']?></span>
                                                </div>
                                                <div class="shopping-cart-delete">
                                                    <a href="#"><i class="ion ion-close"></i></a>
                                                </div>
                                            </li>
                                    <?php
                                        }
                                    }
                                    ?>
                                </ul>
                                <div class="shopping-cart-total">
                                    <h4>Shipping : <span>50.00 EGP</span></h4>
                                    <h4>Total : <span class="shop-total"><?=$tptalPrice?></span></h4>
                                </div>
                                <div class="shopping-cart-btn">
                                    <a href="cart-page.php">view cart</a>
                                    <a href="checkout.php">checkout</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mobile-menu-area">
                <div class="mobile-menu">
                    <nav id="mobile-menu-active">
                        <ul class="menu-overflow">
                            <li><a href="#">HOME</a></li>
                            <li><a href="shop.php"> Shop </a>
                                <ul>
                                    <li>Categories 01</li>
                                    <ul>
                                        <li><a href="shop.php">Aconite</a></li>
                                        <li><a href="shop.php">Ageratum</a></li>
                                        <li><a href="shop.php">Allium</a></li>
                                        <li><a href="shop.php">Anemone</a></li>
                                        <li><a href="shop.php">Angelica</a></li>
                                        <li><a href="shop.php">Angelonia</a></li>
                                    </ul>
                            </li>
                            <li><a href="#">Categories 02</a>
                                <ul>
                                    <li><a href="shop.php">Balsam</a></li>
                                    <li><a href="shop.php">Baneberry</a></li>
                                    <li><a href="shop.php">Bee Balm</a></li>
                                    <li><a href="shop.php">Begonia</a></li>
                                    <li><a href="shop.php">Bellflower</a></li>
                                    <li><a href="shop.php">Bergenia</a></li>
                                </ul>
                            </li>
                            <li><a href="#">Categories 03</a>
                                <ul>
                                    <li><a href="shop.php">Caladium</a></li>
                                    <li><a href="shop.php">Calendula</a></li>
                                    <li><a href="shop.php">Carnation</a></li>
                                    <li><a href="shop.php">Catmint</a></li>
                                    <li><a href="shop.php">Celosia</a></li>
                                    <li><a href="shop.php">Chives</a></li>
                                </ul>
                            </li>
                            <li><a href="#">Categories 04</a>
                                <ul>
                                    <li><a href="shop.php">Daffodil</a></li>
                                    <li><a href="shop.php">Dahlia</a></li>
                                    <li><a href="shop.php">Daisy</a></li>
                                    <li><a href="shop.php">Diascia</a></li>
                                    <li><a href="shop.php">Dusty Miller</a></li>
                                    <li><a href="shop.php">Dame’s Rocket</a></li>
                                </ul>
                            </li>
                        </ul>
                        </li>
                        <li><a href="contact.php"> Contact us </a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>