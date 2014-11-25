<h3>Following are the ingredients you can choose from to create your unique bubble tea, enjoy mixing!</h3>

<div class="ingredient"  id="waterimg">
<img src="images/ingredients/water1.png" alt="water">
<div class="body-title-font">Water</div>
</div>

<div class="ingredient" id="milkimg">
<img src="images/ingredients/milk1.png" alt="milk">
<div class="body-title-font">Milk</div>
</div>

<div class="ingredient" id="bubbleimg">
<img src="images/ingredients/bubbles.png" alt="bubbles">
<div class="body-title-font">Bubbles</div>
</div>

<div class="ingredient" id="sugarimg">
<img src="images/ingredients/sugar2.png" alt="sugar">
<div class="body-title-font">Sugar</div>
</div>

<br/>

<?php
    function drawMyBottle($ingredients, $canvas, $inrange, $cellheight, $cellwidth) {
        // ingredients: arrays of ingredients with item/amount pair
        // canvas: the original image
        // inrange: the inner range of the bottle
        // cellheight: the minimum height of change
        
        // clean the initial image
        /*code for clean $canvas...*/
        // get the bottom
        $currentbottom = $inrange['by'];
        foreach($ingredients as $item => $amount) {
            // set drawing color according to the specific ingredient
            switch($item) {
                case "water":
                    $color = imagecolorallocate($canvas, 0, 0, 255); break;
                case "milk":
                    $color = imagecolorallocate($canvas, 255, 255, 255); break;
                case "sugar":
                    $color = imagecolorallocate($canvas, 255, 0, 0); break;
                case "bubble":
                    $color = imagecolorallocate($canvas, 50, 50, 50); break;
                default:
                    $color = imagecolorallocate($canvas, 0, 255, 0);
            }
            // the height to be filled
            if($amount == 0)
                continue;
            $height = $cellheight * $amount;
            if($item == "bubble") {
                $width = $inrange['rx'] - $inrange['lx'] + 1;
                for($i = 0; ($i + 1) * $cellwidth <= $height; $i++) {
                    for($j = 0; ($j + 1) * $cellwidth <= $width; $j++) {
                        // compute cx, cy
                        $cx = $j * $cellwidth + $cellwidth / 2 + $inrange['lx'];
                        $cy = $inrange['by'] - ($i * $cellwidth + $cellwidth / 2);
                        imagefilledellipse($canvas, $cx, $cy, $cellwidth, $cellwidth, $color);
                    }
                }
                continue;
            }
            // draw the filled rectangular
            imagefilledrectangle($canvas, $inrange['lx'], $currentbottom, $inrange['rx'], $currentbottom - $height, $color);
            // raise the position of the bottom
            $currentbottom = $currentbottom - $height - 1;
        }
    }
    
    $ingredients = array("water" => 0, "milk" => 0, "sugar" => 0, "bubble" => 0);
    $liquid_amount = 0;
    $solid_amount = 0;
    $maximum_liquid_amount = 4;
    $maximum_solid_amount = 3;
    
    // size of container
    $canvas = imagecreatetruecolor(100, 250);
    $inner_width = 80;
    $inner_height = 200;
    $lx = 10; $ty = 25;
    $rx = $lx + $inner_width + 1; $by = $ty + $inner_height + 1;
    $inrange = array("lx" => $lx + 1, "ty" => $ty + 1, "rx" => $rx - 1, "by" => $by - 1);
    $cellheight = 49;
    $cellwidth = 19;
    
    // draw the initial bottle
    $color = imagecolorallocate($canvas, 255, 255, 255);
    imagerectangle($canvas, $lx, $ty, $rx, $by, $color);
    drawMyBottle($ingredients, $canvas, $inrange, $cellheight);
    $image_name = "images/current_mix_by_" . $user_id . ".jpg";
    imagejpeg($canvas, $image_name);
?>