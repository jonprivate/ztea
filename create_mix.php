<?php
    include 'header.php';
    require_once 'db_query.php';
    connectToDB();

    echo '<h2 class="body-title-font">Create your mix</h2>';
    if(!$uid_isset || !$uid_isvalid)
    {
        //the user is not signed in
        echo 'Sorry, you have to be <a href="/ztea/login.php">signed in</a> to create a mix.';
    }
    else
    {
        if($_SERVER['REQUEST_METHOD'] != 'POST')
        {
            //the form hasn't been posted yet, display it
            include 'ingredients.php';
            echo '<div id="showmix">';
            echo '<div id="container_for_miximg"></div>';
            echo '<div id="fortest"></div>';
            echo '<div id="adjust-amount">';
            foreach($ingredients as $item => $amount) {
                echo '<div class="item" id="' . $item . '"><button class="add">add</button> <button class="reduce">reduce</button> ' . $item . ' - amount: <span class="amount">' . $amount . '</span></div>';
            }
            echo '</div>';
            echo '<form name="create_mix" action="" method="POST">';
            // ingredients
            echo '<input id="water-input" type="hidden" name="water" value="">';
            echo '<input id="milk-input" type="hidden" name="milk" value="">';
            echo '<input id="sugar-input" type="hidden" name="sugar" value="">';
            echo '<input id="bubble-input" type="hidden" name="bubble" value="">';
            // user id
            echo '<input type="hidden" name="mix_by" value="' . $user_id . '">';
            // mix name
            echo 'Name your mix: <input type="text" name="mix_name" placeholder="untitled"><br/>';
            // mix description
            echo 'Describe your mix: <br/><textarea name="mix_description" placeholder="undescribed"/></textarea><br/>';
            echo '<input type="submit" value="Mix is done!" />';
            echo '</form>';
            echo '</div>';
        }
        else
        {
            //$ingredients = json_decode($_POST['ingredients'], true);
            $mix_by = $_POST['mix_by'];
            if(!isset($_POST['mix_name']) || empty($_POST['mix_name']))
                $mix_name = "untitled";
            else {
                $mix_name = $_POST['mix_name'];
            }
            if(!isset($_POST['mix_description']) || empty($_POST['mix_description']))
                $mix_description = "undescribed";
            else
                $mix_description = $_POST['mix_description'];
            if(!isset($_POST['water']) || empty($_POST['water']))
                $water = "0";
            else
                $water = $_POST['water'];
            if(!isset($_POST['milk']) || empty($_POST['milk']))
                $milk = "0";
            else
                $milk = $_POST['milk'];
            if(!isset($_POST['sugar']) || empty($_POST['sugar']))
                $sugar = "0";
            else
                $sugar = $_POST['sugar'];
            if(!isset($_POST['bubble']) || empty($_POST['bubble']))
                $bubble = "0";
            else
                $bubble = $_POST['bubble'];
            
            $sql = "INSERT INTO mixes(mix_name, mix_description, mix_by, mix_date, water, sugar, milk, bubble) VALUES ('" . mysql_real_escape_string($mix_name) . "', '" . mysql_real_escape_string($mix_description) . "'," . $mix_by . ", NOW()," . $water . "," . $milk . "," . $sugar . "," . $bubble . ")";
            
            $result = mysql_query($sql);
            
            if(!$result)
            {
                //something went wrong, display the error
                echo 'An error occured while inserting your post. Please try again later.' . mysql_error();
            }
            else
            {
                //after a lot of work, the query succeeded!
                echo 'You have successfully created a mix';
            }
        }
    }
    
    include 'footer.php';
    closeDB();
?>

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<script src="raphael.js"></script>
<script>
function limitAmount(item, change) {
    var liquid_amount = 0;
    var solid_amount = 0;
    var maximum_liquid_amount = 4;
    var maximum_solid_amount = 3;
    var operate;
    if(change == 'add') operate = 1;
    else operate = -1;
    
    var solid_amount = 0; var liquid_amount = 0;
    var maximum_amount, new_amount;
    var current_item, current_amount;
    for(current_item in ingred) {
        current_amount = ingred[current_item];
        if(current_item == "bubble")
            solid_amount += current_amount;
        else
            liquid_amount += current_amount;
    }
    if(item == "bubble") {
        maximum_amount = maximum_solid_amount;
        new_amount = solid_amount + operate;
    }
    else {
        maximum_amount = maximum_liquid_amount;
        new_amount = liquid_amount + operate;
    }
    if(new_amount >= 0 && new_amount <= maximum_amount && ingred[item] + operate >= 0) ingred[item] += operate;
}

function drawMyBottle(ingred, paper, brect, cellheight, cellwidth) {
    var rect = paper.rect(brect[0], brect[1], brect[2], brect[3]).attr({fill: '#9cf', stroke: 'none', 'stroke-width': 5});
    var color;
    var left_pos = brect[0], top_pos = brect[1] + brect[3];
    var solid_left_pos = brect[0], solid_top_pos = brect[1] + brect[3];
    for(item in ingred) {
        switch (item) {
            case 'water':
                color = "blue";
                break;
            case 'milk':
                color = "white";
                break;
            case 'sugar':
                color = "red";
                break;
            case 'bubble':
                color = "black";
                break;
        }
        if(ingred[item] == null)
            ingred[item] = '0';
        if(item == 'bubble') {
            var radius = Math.floor((cellheight - 2) / 2);
            var solid_center_left = solid_left_pos + radius + 1;
            var solid_center_top = solid_top_pos - radius - 1;
            var num_per_line = Math.floor((brect[2] - 2) / (2 * radius));
            var num_lines = ingred[item];
            for(var y = 0; y < num_lines; y++) {
                solid_center_left = solid_left_pos + radius + 1;
                for(var x = 0; x < num_per_line; x++) {
                    paper.circle(solid_center_left, solid_center_top, radius).attr({fill: color, stroke: 'none'});
                    solid_center_left += 2 * radius;
                }
                solid_center_top -= 2 * radius;
            }
        } else {
            width = cellwidth; height = cellheight * ingred[item];
            top_pos = top_pos - height;
            paper.rect(left_pos, top_pos, width, height).attr({fill: color, stroke: 'none'});
        }
    }
}

var paper = new Raphael(document.getElementById('container_for_miximg'), 500, 500);
var bottle_left = 10, bottle_top = 10, bottle_width = 150, bottle_height = 350;
var brect = [bottle_left, bottle_top, bottle_width, bottle_height];
var cellheight = 50, cellwidth = bottle_width;

window.onload = function() {
    //var rect = paper.rect(10, 10, 80, 150);
    //rect.attr({fill: '#9cf', stroke: 'none', 'stroke-width': 5});
    var ingreds = {'water': 0, 'milk': 0, 'sugar': 0, 'bubble': 0};
    drawMyBottle(ingreds, paper, brect, cellheight, cellwidth);
}

var ingred = <?php echo json_encode($ingredients); ?>;
function changeIngredAmount(ingred) {
    //ingred = JSON.parse(json.ingredients);
    var item;
    for(item in ingred)
        $("#" + item + "-input").attr('value', ingred[item]);
    //var item = "water";
    //$("#" + item + "-input").attr('value', ingred[item]);
}


$(document).ready(
                  function() {
                  $('.add').click(function(){
                                  var item = $(this).parent().attr('id');
                                  var cur_div = $(this);
                                  limitAmount(item, 'add');
                                  cur_div.parent().find('span').html(ingred[item]);
                                  changeIngredAmount(ingred);
                                  drawMyBottle(ingred, paper, brect, cellheight, cellwidth);
                                  }
                                  );
                  $('.reduce').click(function(){
                                  var item = $(this).parent().attr('id');
                                  var cur_div = $(this);
                                  limitAmount(item, 'reduce');
                                  cur_div.parent().find('span').html(ingred[item]);
                                  changeIngredAmount(ingred);
                                  drawMyBottle(ingred, paper, brect, cellheight, cellwidth);
                                  }
                                  );
                  $(".ingredient").draggable({helper:'clone'});
                  $("#container_for_miximg").droppable({
                                         accept: ".ingredient",
                                         drop: function(event,ui) {
                                         var dragid = ui.draggable.attr("id");
                                         var item  = dragid.substr(0, dragid.length - 3);
                                         limitAmount(item, 'add');
                                         $("#" + item).find('span').html(ingred[item]);
                                         changeIngredAmount(ingred);
                                         drawMyBottle(ingred, paper, brect, cellheight, cellwidth);
                                         }
                  });
                  }
                  );

</script>
