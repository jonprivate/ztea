<?php
    require_once __DIR__ . '/../global.php';
    require_once 'cgi-bin/check_status.php';
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
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    
                    // check if the user already registered
                    $item_name = 'username';
                    if(checkTable($conn, $table_name, $item_name, $username))
                    {
                        echo "Sorry, but you already exist<br/>";
                        $link = <<<EOD
                        <a href="/login.php">You can login here</a>
EOD;
                        echo $link;
                    } else
                    {
                        // insert the new user
                        insertIntoTable($conn, $table_name, $username, $email, $password);
                        echo "Welcome, $username!";
                        $cookie_name = "uid";
                        $cookie_value = $username; 
                        setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
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


