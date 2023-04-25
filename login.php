<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Page</title>
    <link href="css/stylesheet.css" rel="stylesheet">
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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
</head>
<body>
<!-- Start the session if it's not started -->
<?
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.html');
    exit;
}
if (session_id() == '' || !isset($_SESSION)) {
    session_start();
}
?>
<div id="mySidenav" class="sidenav">
    <!-- javascript:void(0) return "undefined" -->
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&#x2715;</a>
    <?php
    if (isset($_SESSION['username'])) {
        echo '<a href="account.php">My Account</a>';
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
<div class="container-row">
    <div class="layer2">
        <span>YILISA</span>
    </div>
    <div class="layer1">
        <span style="cursor:pointer; font-size: 30px;background-color: black; color: white" onclick="openNav()">&#9776; Menu</span>
    </div>
</div>
<div class="login">
    <h1>Login</h1>
    <form action="authenticate.php" method="post">
        <label for="username">
            <i class="fas fa-user"></i>
        </label>
        <input type="text" name="username" placeholder="Username" id="username" required>
        <label for="password">
            <i class="fas fa-lock"></i>
        </label>
        <input type="password" name="password" placeholder="Password" id="password" required>
        <input type="submit" value="Login">
        <input type="checkbox" onclick="toggleVisibility()">
        <!-- Doesn't work?? -->
        <div class="tooltip">Hover over me
            <span class="tooltiptext">Tooltip text</span>
        </div>
    </form>
</div>
<!-- Footer start -->
<footer>
    <div class="container">
        <div class="col-md-9 row">
            <a href="index.php"><img src="images/logo.jpg" alt="logo"
                                      class="logo-footer img-fluid center-horizontal"></a>
            <div class="footer-about">
                <p>This site is made possible by our dear investors and our friends who supported us in the most
                    desperate times.</p>
            </div>
            <br>
            <div class="footer-quicklinks">
                <ul>
                    <li><a href="index.php"><i class="bi bi-arrow-return-right"></i>Home</a></li>
                    <li><a href="about.php"><i class="bi bi-arrow-return-right"></i>About us</a></li>
                    <li><a href="contact.php"><i class="bi bi-arrow-return-right"></i>Contact</a></li>
                </ul>
            </div>
        </div>
        <div class="address">
            <h2><i class="bi bi-map-fill"> </i>Address</h2>
            <div class="address-street">
                Pestalozzistraße 62<br>
                72762<br>
                Reutlingen<br>
            </div>
            <h2><i class="bi bi-telephone-fill"> </i>Telephone</h2>
            <div class="address-telephone">
                +0 111 1111 1111
            </div>
            <h2><i class="bi bi-mailbox2"> </i>E-Mail</h2>
            <div class="address-email">
                <a href="mailto: info.studium@reutlingen-university.de">info.studium@reutlingen-university.de</a>
            </div>
        </div>
    </div>
</footer>
<!-- Footer end-->
<!-- Copyright start -->
<section id="copyright">
    <div class="copyright">
        <p>&copy; 2022 Sato powered by <a href="https://blog.getbootstrap.com/" target="_blank"
                                          rel="nopener norefferer">Bootstrap</a></p>
        <!-- rel="noopener" is a security measure https://mathiasbynens.github.io/rel-noopener
         and target="_blank" opens the link in a new tab -->
    </div>
</section>
<!-- Copyright end -->
</body>
</html>