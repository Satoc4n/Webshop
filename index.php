<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Said">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>YILISA Perfumeries</title>
    <link href="css/stylesheet.css" rel="stylesheet">
    <link href="css/footernew.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;1,300&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <script src="js/jquery.js" rel="script"></script>
    <script src="js/shop-javascript.js" rel="script"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
            crossorigin="anonymous"></script>
</head>
<body>
<!-- Start the session if it's not started -->
<?php
session_start();
if (session_id() == '' || !isset($_SESSION)) {
    session_start();
}
// Connect to local host server for items
$DATABASE_HOST  = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'phplogin';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
$result = mysqli_query($con, "SELECT price FROM items");
?>

<!-- Top navigation bar. top-bar or side-bar-->
<!--
<nav class="top-bar">
    <a href="index.html" class="active">Home</a>
    <a href="women.html">Women</a>
    <a href="men.html">Men</a>
    <a href="couple.html">Couple</a>
</nav>
-->
<div id="mySidenav" class="sidenav">
    <!-- javascript:void(0) return "undefined" -->
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&#x2715;</a>
    <?php
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
        echo '<a href="accountoverview.php">My Account</a>';
        echo '<a href="logout.php">Logout</a>';
    } else {
        echo '<a href="login.php">Login</a>';
        echo '<a href="register/registerpage.html">Register</a>';
    }
    ?>
    <a href="index.php" class="active">Home</a>
    <a href="women.php">Women</a>
    <a href="men.php">Men</a>
    <a href="couple.php">Couple</a>
</div>
<!-- Title -->
<!--
<header class="h1">YILISA</header>
-->
<!-- Clickable hamburger menu !!Whole part is clickable!! -->
<div class="container-row">
    <div class="layer2">
        <span>YILISA</span>
    </div>
    <div class="layer1">
        <span style="cursor:pointer; font-size: 30px;background-color: black; color: white" onclick="openNav()">&#9776; Menu</span>
    </div>
</div>
<!-- Search bar end -->
<!-- Search bar start, doesn't work -->

<!-- Search bar end -->
<!-- Start of the main division -->
<div id="main">
    <div class="indexStripe">
        <header style="color: white; background-color: black; font-size: 24pt; position: center; text-align: center; font-family: 'Bauhaus 93'">Welcome to yilisa! </header>
        <article></article>
        <!-- Show how many users online with AJAX -->
        <div>
            <!-- Can be deleted since we can now count online users with $_SESSION -->
            <!--
            <p id="counter">Users Online: <iframe src="tempFiles/counter.php"></iframe> </span></p>
            -->
            <?php
                // Connect to database as usual
                $DATABASE_HOST = 'localhost';
                $DATABASE_USER = 'root';
                $DATABASE_PASS = '';
                $DATABASE_NAME = 'phplogin';
                // Prepare the sql query for execution
                $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
                if ( mysqli_connect_errno() ) {
                    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
                }
                // Execute he query and fetch the results in an array, preparing it for array_sum() function. !! Array Sum counts everything double. Maybe for each??
                $onlineUserCount = mysqli_query($con, "SELECT COUNT(isOnline) FROM accounts WHERE isOnline = '1'");
                $infoOnlineUserCount = mysqli_fetch_array($onlineUserCount);

                // Prepare table for later use
                $table_name = 'items';
            ?>
            <!-- Print the user counter to HTML -->
            <p name="howManyUsersOnline">Online User Counter: <?php echo array_sum($infoOnlineUserCount); ?></p>
        </div>
    </div>
    <div class="row height d-flex justify-content-center align-items-center">
        <div class="col-md-8">
            <div class="search">
                <i class="fa fa-search"></i>
                <input type="text" class="form-control" placeholder="Search">
                <button class="bi bi-search"> Search</button>
            </div>
        </div>
    </div>
    <!-- Start of items division -->
    <div style="display: flex">
    <!-- Start of product division. -->
    <div class="itemCard">
        <!-- Image / Thumbnail of the product. -->
        <img src="images/perfumethumbnails/tom_ford-black-orchid375x500.jpg" alt="black_orchid">
        <h1>Tom Ford Black Orchid</h1>
        <?php
            $itemId = '1';
            $stmt = "SELECT name FROM $DATABASE_NAME.$table_name WHERE itemID = itemId";
            $result = mysqli_query($con, $stmt);
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                echo $row["name"];
            }
        ?>
        <p class="itemPrice"><?php
            // Prepare itemID every time.
            // Have to find a workaround.
            $stmt = "SELECT price FROM $DATABASE_NAME.$table_name WHERE itemID = itemId";
            $result = mysqli_query($con, $stmt);
            // Check if there are any matches.
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                echo $row["price"];
            }
            ?> $</p>
        <p>Even though it smells like a perfume for women, we assure you it also is perfect for men</p>
        <p><button>Add to cart</button></p>
    </div>
    <!-- End of product division. -->
    <!-- Start of product division -->
    <div class="itemCard">
        <!-- Image / Thumbnail of the product. -->
        <img src="images/perfumethumbnails/guy_laroche_horizon.jpg" alt="horizon">
        <!-- Name of the product. -->
        <h1>Guy Laroche Horizon</h1>
        <!-- Get the item price from the database. -->
        <p class="itemPrice"><?php
            // Prepare itemID every time.
            // Have to find a workaround.
            $stmt = "SELECT price FROM $DATABASE_NAME.$table_name WHERE itemID = '2'";
            $result = mysqli_query($con, $stmt);
            // Check if there are any matches.
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                echo $row["price"];
            }
            ?> $</p>
        <p>Some description about the perfume</p>
        <p><button>Add to cart</button></p>
    </div>
    <!-- End of product division. -->
    <!-- Start of experimentel product division. -->
    <div class="itemCard">
        <div class="img-thumbnail-stack-exchange">
            <img src="images/perfumethumbnails/gucci_alchemist_garden_green.jpg" alt="alchemist_garden_green" ">
        </div>
        <h1>Gucci</h1>
        <?php
        $itemID = '3';
        echo '<script type="text/javascript">','getItemDetails();', '</script>';
        ?>
    </div>
    </div>
    <!-- End of items division -->
    <!-- Footer start -->
    <footer>
        <div class="footer-gray">
            <div class="footer-custom">
                <div class="footer-lists">
                    <div class="footer-list-wrap">
                        <h6 class="ftr-hdr">Direct Contact</h6>
                        <ul class="ftr-links-sub">
                            <li>+49 012485344957</li>
                            <li>**additional charges may apply</li>
                        </ul>
                        <h6 class="ftr-hdr">International</h6>
                        <ul class="ftr-links-sub">
                            <li><a href="http://www.art.de" rel="nofollow">Germany</a></li>
                            <li><a href="https://www.art.com" rel="nofollow">United States and Canada</a></li>
                        </ul>
                    </div>
                    <!--/.footer-list-wrap-->
                    <div class="footer-list-wrap">
                        <h6 class="ftr-hdr">Customer Service</h6>
                        <ul class="ftr-links-sub">
                            <li><a href="/help/contact_us.php" rel="nofollow">Contact Us</a></li>
                            <li><a href="/help/problems_with_orders.php" rel="nofollow">Problems with orders</a></li>
                            <li><a href="/help/shipping_delivery.php" rel="nofollow">Shipping &amp; Delivery</a></li>
                            <li><a href="/help/returns.php" rel="nofollow">RetSurns</a></li>
                            <li><a href="/help/international_orders.php" rel="nofollow">International Orders</a></li>
                            <li><a href="/help/faq.php" rel="nofollow">FAQ</a></li>
                        </ul>
                    </div>
                    <div class="footer-list-wrap">
                        <h6 class="ftr-hdr">About Yilisa.com</h6>
                        <ul class="ftr-links-sub">
                            <li><a href="index.php" rel="nofollow"><strong>Homepage</strong></a></li>
                            <li><a href="/asp/about_us.php" rel="nofollow">Our Company</a></li>
                            <li><a href="/asp/job_opportunities.php" rel="nofollow">Job opportunities</a></li>
                            <li><a href="/asp/catalog.php" rel="nofollow"><strong>Shop Our Catalog</strong></a></li>
                            <li><a href="http://blog.yilisa.com" rel="nofollow">Our BLOG</a></li>
                        </ul>
                    </div>
                    <!--/.footer-list-wrap-->
                    <!--
                    <div class="footer-list-wrap">
                        <h6 class="ftr-hdr">My Account</h6>
                        <ul class="ftr-links-sub">
                            <art:content rule="!loggedin">
                                <li class="ftr-Login"><span class="link login-trigger">Access My Account</span></li>
                                <li><span class="link" onclick="link('/asp/secure/your_account/track_orders-asp/_/posters.htm')">Track My Order</span></li>
                            </art:content>
                            <art:content rule="loggedin">
                                <li class="ftr-Login"><span class="link ftr-access-my-account">Access My Account</span></li>
                                <li><span class="link" onclick="window.location.href = getProfileKey() + '?pagetype=oh';">Track My Order</span></li>
                            </art:content>
                        </ul>
                    </div>
                    -->
                    <!--/.footer-list-wrap-->
                </div>
                <!--/.footer-lists-->
                <div class="footer-email">
                    <h6 class="ftr-hdr">Sign up for our newsletter!</h6>
                    <div id="ftr-email" class="ftr-email-form">
                        <form id="ftrEmailForm" method="post" action="http://em.yilisa.com/pub/rf">
                            <div class="error">Please enter a valid email address</div>
                            <input type="text" name="email_address_" id="ftrEmailInput" class="input" placeholder="Enter email address" />
                            <!-- Have to change according to our needs -->
                            <input type="submit" class="button" value="SUBMIT" />
                            <input type="hidden" name="country_iso2" value="">
                            <input type="hidden" name="language_iso2" value="en">
                            <input type="hidden" name="site_domain" value="yilisa.com">
                            <input type="hidden" name="email_acq_source" value="01-000001">
                            <input type="hidden" name="email_acq_date" value="" id="ftr-email-date">
                            <input type="hidden" name="brand_id" value="YILISA">
                            <input type="hidden" name="_ri_" value="X0Gzc2X%3DWQpglLjHJlYQGnp51yrMf2qXdC9tjU8pzgMtwfYzaVwjpnpgHlpgneHmgJoXX0Gzc2X%3DWQpglLjHJlYQGnyLSq2fzdkuzdzglHMsUhgeNzaSgkk">
                        </form>
                    </div>
                    <!--/.ftr-email-form-->
                    <div class="ftr-email-privacy-policy"></div>
                </div>
                <!--/.footer-email-->
                <div class="footer-social">
                    <h6 class="ftr-hdr">Follow Us</h6>
                    <ul>
                        <li>
                            <a href="https://www.facebook.com/yilisa.com" title="Facebook" onclick="_gaq.push(['_trackSocial', 'Facebook', 'Follow', 'Footer', 'undefined', 'True']);">
                                <img width="24" height="24" alt="Like us on Facebook" src="http://cache1.artprintimages.com/images/jump_pages/rebrand/footer/fb.png">
                            </a>
                        </li>
                        <li>
                            <a href="https://plus.google.com/ourGooglePlusPage" title="Google+" onclick="_gaq.push(['_trackSocial', 'GooglePlus', 'Follow', 'Footer', 'undefined', 'True']);">
                                <img width="24" height="24" alt="Follow us on Google+" src="http://cache1.artprintimages.com/images/jump_pages/rebrand/footer/gplus.png">
                            </a>
                        </li>
                        <li>
                            <a href="https://pinterest.com/yilisaperfumes/" target="_blank">
                                <img width="24" height="24" alt="Follow us on Pinterest" src="http://cache1.artprintimages.com/images/jump_pages/rebrand/footer/pin-badge.png">
                            </a>
                        </li>
                        <li>
                            <a target="_blank" href="http://instagram.com/yilisaperfumes/">
                                <img width="24" height="24" alt="Follow us on Instagram" src="http://cache1.artprintimages.com/images/jump_pages/rebrand/footer/instagram-badge.png">
                            </a>
                        </li>
                        <li>
                            <a href="https://www.twitter.com/yilisaperfumes" title="Twitter" onclick="_gaq.push(['_trackSocial', 'Twitter', 'Follow', 'Footer', 'undefined', 'True']);">
                                <img width="67" alt="Follow us on Twitter" src="http://cache1.artprintimages.com/images/jump_pages/rebrand/footer/twitter.png">
                            </a>
                        </li>
                    </ul>
                </div>
                <!--/.footer-social-->
                <div class="footer-legal">
                    <p>&copy; Yilisa.com All Rights Reserved. | <a href="/help/privacy_policy.php" rel="nofollow">Privacy Policy</a> | <a href="/help/terms_of_use.php" rel="nofollow">Terms of Use</a> | <a href="/help/terms_of_sale.php" rel="nofollow">Terms of Sale</a></p>
                    <p>Made possible with the help we got from friends and various websites that shared their knowledge with us.</p>
                </div>
                <!--/.footer-legal-->
                <div class="footer-payment">
                    <ul>
                        <li class="ftr-paypal">
                            <a href="https://www.paypal.com/en/home" target="_blank">
                                <span title="Paypal" onclick="openLink('https://www.paypal.com/')"></span>
                            </a>
                        </li>
                        <li>
                            <span onclick="clickTrack(); return false;" onmouseover="this.style.cursor='pointer'"><img border="0" alt="HACKER SAFE certified sites prevent over 99.9% of hacker crime." src="https://images.scanalert.com/meter/www.art.com/31.gif"></span>
                        </li>
                        <li class="ftr-visa">
                            <a href="visa.com" target="_blank">
                                <span title="Visa" onclick="openLink('visa.com')"></span>
                            </a>
                        </li>
                    </ul>
                </div>
                <!--/.footer-payment-->
            </div>
            <!--/.footer-custom-->
        </div>
        <!--/.footer-gray-->
    </footer>
    <!-- Footer end-->
    <!-- Copyright start -->
    <!--
    <section id="copyright">
        <div class="copyright">
            <p>&copy; 2022 Sato powered by <a href="https://blog.getbootstrap.com/" target="_blank" rel="nopener norefferer">Bootstrap</a></p>
             and target="_blank" opens the link in a new tab -->
        </div>
    </section>
    <!-- Copyright end -->
</div>
</body>
</html>

<footer>


</footer>