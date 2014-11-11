<?php
    $folder = 'images/products/';
    $filetype = '*.*';
    $files = glob($folder.$filetype);
    $count = count($files);
    
    for ($i = 0; $i < $count; $i++) {
        echo '<div class="img">';
        echo '<a target="_blank" href="' . $files[$i] . '">';
        echo '<img src="' . $files[$i] . '" alt="' . substr($files[$i],strlen($folder),strpos($files[$i], '.')-strlen($folder)) . '">';
        echo '</a>';
        echo '<div class="body-title-font">' . substr($files[$i],strlen($folder),strpos($files[$i], '.')-strlen($folder)) . '</div>';
        echo '</div>';
    }
?>