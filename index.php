<?php
    require_once 'global.php';
    require_once 'cgi-bin/check_status.php';
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
	        require 'showProducts.php';
	    ?>
        </section>
        
        <?php
            require 'parts/footer.php';
        ?>
    </body>
</html>
