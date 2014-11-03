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
            <p>Welcome!</p>
            <?php
                require 'cgi-bin/db_query.php';
            ?>
        </section>
        
        <?php
            require 'parts/footer.php';
        ?>
    </body>
</html>
