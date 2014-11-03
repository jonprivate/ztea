<?php
    require 'global.php';
    require 'cgi-bin/check_status.php';
?>

<!DOCTYPE html>
<html lang="en">
    <!--
    Head part
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
                $form_reg = <<<EOD
                <div class="body-title-font">
                <h3 class="body-title-font">Register</h3>
                <form method="post" action="cgi-bin/reg.php">
                <input class="type-in" name="username" type=text size="50" placeholder="Username"/><br/>
                <input class="type-in" name="email" type=text size="50" placeholder="Email"/><br/>
                <input class="type-in" name="password" type="password" size="50" placeholder="Password"/><br/>
                <input id="submit-form" type="submit" value="Sign up"/>
                </form>
                </div>
EOD;
                if(!$uid_isset) {
                    echo $form_reg;
                } else {
                    if($uid_isvalid) {
                        echo "welcome";
                    } else {
                        echo $form_reg;
                    }
                }
            ?>

        </section>

        <?php
            require 'parts/footer.php';
        ?>
    </body>
</html>
