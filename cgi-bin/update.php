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
                $cookie_name = "uid";
                $username = $_COOKIE[$cookie_name];
                $old_password = $_POST['old_password'];
                $new_password = $_POST['new_password'];
                // check if the user already registered
                require_once 'cgi-bin/db_query.php';
                $db_name = 'jiongliu_users';
                $table_name = 'users';
                $conn = connectToDB($db_name);
                $item_name1 = 'username';
                $item_name2 = 'password';
                if(checkTable2($conn, $table_name, $item_name1, $username, $item_name2, $old_password)) {
                    updateTable($conn, $table_name, $item_name2, $new_password, $item_name1, $username);
                    echo "Your new password has been set";
                } else {
                    echo "Sorry, the old password is not correct, please try again <a href='/changeset.php'>here</a>";
                }
                $db->close();
            ?>
        </section>

        <?php
            require 'parts/footer.php';
        ?>

    </body>
</html>

