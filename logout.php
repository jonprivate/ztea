<?php
    require_once 'global.php';
    $cookie_name = "uid";
    unset($_COOKIE[$cookie_name]);
    // empty value and expiration one hour before
    $res = setcookie($cookie_name, '', time() - 3600, "/");

    /* Redirect browser */
    header("Location: http://jiong-liu.rochestercs.org/");
 
    /* Make sure that code below does not get executed when we redirect. */
    exit;
?>

