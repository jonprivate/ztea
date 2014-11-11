<?php
    require_once 'global.php';

    // empty value and expiration one hour before
    $res = setcookie('user_id', '', time() - 3600, "/");
    $res = setcookie('user_name', '', time() - 3600, "/");
    $res = setcookie('user_level', '', time() - 3600, "/");

    /* Redirect browser */
    // for mamp
    header("Location: http://localhost:8888/ztea/");
    /*// for bluehost
    header("Location: http://jiong-liu.rochestercs.org/ztea");
     */
 
    /* Make sure that code below does not get executed when we redirect. */
    exit;
?>