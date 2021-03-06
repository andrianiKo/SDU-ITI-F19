<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Coiny|Indie+Flower" rel="stylesheet">
    <meta charset="UTF-8">
    <script src="../JS/Feed.js"></script>
    <script src="../JS/navbar.js"></script>
    <link rel="stylesheet" type="text/css" href="../CSS/Navbar.css">
    <link rel="stylesheet" type="text/css" href="../CSS/Feed.css">
    <link rel="stylesheet" type="text/css" href="../CSS/General.css">

    <meta charset="UTF-8">
    <title>Image Feed</title>
</head>

<body>

<?php
include 'imageLoader.php';

if (isset($_SESSION["username"])) {
    echo "<navbar id=\"navbar\"><a class=\"navbar-link\" href=\"LoginPage.php\">Profile</a></navbar>";
} else {
    echo "<navbar id=\"navbar\"><a class=\"navbar-link\" href=\"LoginPage.php\">Register</a></navbar>";
}


if (isset($_SESSION["username"])) {

    $imageElements = loadAllImages();


    echo "<div class=\"page-container\">
    <div class=\"main-content\" id=\"main-content-feed\">
        <h1 class=\"feed-title\">Æκóνæς</h1>
        <div class=\"image-feed-container\" id=\"image-feed-container\">
        {$imageElements}  
        </div>
    </div>
</div>


";
} else {

    echo " 
            <div class=\"loginform\">
                <h2>Login to your account</h2>
                <form action=\"LogIn.php\" method='post'>
                    <input type=\"text\" name=\"username\" placeholder=\"username\"/>
                    <input type=\"password\" name=\"password\" placeholder=\"password\"/>
                    <button type=\"submit\" class=\"btn\" id=\"btnLogin\">Login</button>
                    <a class=\"btnCreateNewUser\"
                       id=\"btnSubmit\"
                       href=\"LoginPage.php\">Create new user</a>
                </form>
            </div>";
}
?>


</body>

</html>
