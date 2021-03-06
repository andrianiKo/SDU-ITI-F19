<?php

session_start();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Coiny|Indie+Flower" rel="stylesheet">

    <script src="../JS/Users.js"></script>
    <script src="../JS/navbar.js"></script>
    <link rel="stylesheet" type="text/css" href="../CSS/Users.css">
    <link rel="stylesheet" type="text/css" href="../CSS/Navbar.css">
    <link rel="stylesheet" type="text/css" href="../CSS/General.css">

    <meta charset="UTF-8">
    <title>Image Feed</title>
</head>

<body>


<?php

require 'UserLoader.php';


if (isset($_SESSION["username"])) {
    echo "<navbar id=\"navbar\"><a class=\"navbar-link\" href=\"LoginPage.php\">Profile</a></navbar>";
} else {
    echo "<navbar id=\"navbar\"><a class=\"navbar-link\" href=\"LoginPage.php\">Register</a></navbar>";
}


if(isset($_SESSION['username'])) {
    $userElements = loadUserElements();

    echo "

<div class=\"page-container\">
    
    <div class=\"main-content\" id=\"main-content-users\">
        <h1 class='users-header'>Users</h1>
            <input  id='inputSearchUsers'  type='text' placeholder='Search for users...' name='searchParam'>
            <input type='submit' value='Search' id='btnSearchUsers'>
        <div class='users-container' id='users-container'></div>
       </div>
</div>
";
} else {
    echo " <div class=\"loginform\">
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