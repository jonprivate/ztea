<?php
    require_once 'global.php';
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
                $form_reg = <<<EOD
                <div class="body-title-font">
                <h3 class="body-title-font">Update your password</h3>
                <form method="post" action="/cgi-bin/update.php">
                <input class="type-in" name="old_password" type="password" size="50" placeholder="Old password"/><br/>
                <input class="type-in" name="new_password" type="password" size="50" placeholder="New password"/><br/>
                <input id="submit-form" type="submit" value="Update"/>
                </form>
                </div>
EOD;
                if(!$uid_isset || !$uid_isvalid) {
                    // access database and posted data
                    $link = <<<EOD
                    <a href="login.php">Please first log in :)</a>
EOD;
                    echo $link;
                } else {
                    echo $form_reg;
                }
            ?>
        </section>

	<?php
            require 'parts/footer.php';
        ?>
    </body>
</html>



