<?php
    require_once 'global.php';
    require 'db_query.php';
    $cookie_name = "user_id";
    $uid_isset = false;
    $uid_isvalid = false;
    if(!isset($_COOKIE[$cookie_name])) {
        $uid_isset = false;
    } else {
        $uid_isset = true;
        connectToDB();
        $table_name = 'users';
        $user_id = $_COOKIE[$cookie_name];
        $user_name = $_COOKIE["user_name"];
        $user_level = $_COOKIE["user_level"];
        $uid_isvalid = checkUsersWithID($user_id);
        closeDB();
    }
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>Mella-tea, enjoy a cup of life</title>
        <link rel="stylesheet" href="/ztea/CSS/main.css">
        <link href='http://fonts.googleapis.com/css?family=Sigmar+One|Monoton|Pinyon+Script|Rock+Salt|Kaushan+Script|Julius+Sans+One|Kranky|Coming+Soon' rel='stylesheet' type='text/css'>
    </head>

    <body>
        <header id="index-header">
            <?php
                if($uid_isset && $uid_isvalid) {
                    echo '<div id="reg-log">
                    <p id="greeting">Hi, ' . $user_name . '!</p> <a href="/ztea/changeset.php">settings</a> <a href="/ztea/logout.php">logout</a>
                    </div>';
                } else {
                    echo '<div id="reg-log">
                    <a href="/ztea/register.php">register</a>
                    <a href="/ztea/login.php">login</a>
                    </div>';
                }
            ?>

            <ul>
                <li><a href="/ztea/index.php">Home</a></li>
                <li><a href="/ztea/personal.php">Personal</a></li>
                <li><a id="toplogo" href="/index.php">
                    <img src="/ztea/images/coffee.gif" alt="coffee logo" height="150">
                        </a></li>
                <li><a href="/ztea/forum.php">Forum</a></li>
                <li><a href="/ztea/contact.php">Contact</a></li>
            </ul>
        </header>
        <br/><br/>
        <section>