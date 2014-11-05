<?php
    require __DIR__ . '/../global.php';
    require 'cgi-bin/check_status.php';
?>

<!DOCTYPE html>
<html lang="en">
    <!--
    Header part
    -->
    <?php
        require 'parts/head.php';
    ?>

    <!--
    Body part
    -->
    <body>
        <?php
            require 'parts/header.php';
        ?>
        <section>
        <?php
        if(!$uid_isset || !$uid_isvalid) {
            require_once 'cgi-bin/db_query.php';
            $db_name = 'jiongliu_users';
            $table_name = 'users';
            // access database and posted data
            $conn = connectToDB($db_name);
            $username = $_POST['username'];
            $password = $_POST['password'];
            
            // check if the user already registered
            $item_name = 'username';
            if(checkTable($conn, $table_name, $item_name, $username))
            {
                echo "Hello $username, welcome back!";
                $cookie_name = "uid";
                $cookie_value = $username; 
                setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day

            } else
            {
                echo "Sorry, but your username or password is wrong.";
                echo "<br/>";
                $link = <<<EOD
                <a href="/register.php">You can register here :)</a>
EOD;
                echo $link;
            }
            closeDB($conn);
            echo "<br/>";
            /* Redirect browser */
            header("Location: http://jiong-liu.rochestercs.org/");
     
            /* Make sure that code below does not get executed when we redirect. */
            exit;
        }	
        ?>
        </section>

        <?php
            require 'parts/footer.php';
        ?>

    </body>
</html>


