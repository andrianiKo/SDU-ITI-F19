<?php echo '<link href="css/NavigationBar.css" rel="stylesheet" type="text/css" >'; ?>

<div class="navigation_bar__wrapper">
    <div class="navigation_bar__button" onclick="location.href='/feed'"> Feed</div>
    <div class="navigation_bar__button" onclick="location.href='/images'"> My Images</div>
    <div class="navigation_bar__button" onclick="location.href='/me'"> My page</div>
    <div class="navigation_bar__button" onclick="location.href='/users'"> Users</div>
    <div class="navigation_bar__button" onclick="location.href='/ajax'"> Ajax!</div>
    <?php
    if( isset($_SESSION['user_id']) ){
       echo " <div class=\"navigation_bar__button\" onclick=\"location.href='/logout'\">Logout</div>";
    } else {
        echo "<div class=\"navigation_bar__button\" onclick=\"location.href='/login'\"> Login</div>";
    }
    ?>
</div>