<?php
    require 'global.php';
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
                $form_login = <<<EOD
                    <div class="body-title-font">
                    <h3 class="body-title-font">Log in</h3>
                    <form method="post" action="cgi-bin/login.php">
                        <input class="type-in" name="username" type="text" size=50 placeholder="Username"/><br/>
                        <input class="type-in" name="password" type="password" size=50 placeholder="Password"/><br/>
                        <input id="submit-form" type="submit" value="Sign in"/>
                    </form>
                    </div>
EOD;
                if(!$uid_isset) {
                    echo $form_login;
                } else {
                    if($uid_isvalid) {
                        echo "welcome";
                    } else {
                        echo $form_login;
                    }
                }
            ?>
        </section>

        <?php
            require 'parts/footer.php';
        ?>
    </body>
</html>
