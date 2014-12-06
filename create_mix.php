<?php
    include 'header.php';
    require_once 'db_query.php';
    connectToDB();

    echo '<h2>Create your mix!</h2>';
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
            echo '<img id="miximg" src="' . $image_name . '" alt="">';
            echo '<div id="adjust-amount">';
            foreach($ingredients as $iterm => $amount) {
                echo '<div class="iterm" id="' . $iterm . '"><button class="add">add</button> <button class="reduce">reduce</button> ' . $iterm . ' - amount: <span class="amount">' . $amount . '</span></div>';
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
<script>
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
                                  var iterm = $(this).parent().attr('id');
                                  var cur_div = $(this);
                                  //console.dir(iterm);
                                  //console.dir(ingred);
                                  $.ajax({
                                         url: "draw_mix.php",
                                         type: "GET",
                                         data: {ingredients: JSON.stringify(ingred), iterm_name: iterm, change: 'add', image_name: <?php echo "'" . $image_name . "'"; ?>},
                                         dataType: "json",
                                         error: function() {
                                                    console.dir('error occurs');
                                         },
                                         success: function(json) {
                                                    $('#miximg').attr('src', json.image_name + '?' + Math.random());
                                                    //console.dir(json.image_name);
                                                    ingred = JSON.parse(json.ingredients);
                                                    //console.dir(ingred);
                                                    cur_div.parent().find('span').html(ingred[iterm]);
                                         changeIngredAmount(ingred)
                                         },
                                  });
                                  }
                                  );
                  $('.reduce').click(function(){
                                  var iterm = $(this).parent().attr('id');
                                  var cur_div = $(this);
                                  //console.dir(iterm);
                                  //console.dir(ingred);
                                  $.ajax({
                                         url: "draw_mix.php",
                                         type: "GET",
                                         data: {ingredients: JSON.stringify(ingred), iterm_name: iterm, change: 'reduce', image_name: <?php echo "'" . $image_name . "'"; ?>},
                                         dataType: "json",
                                         error: function() {
                                         console.dir('error occurs');
                                         },
                                         success: function(json) {
                                         $('#miximg').attr('src', json.image_name + '?' + Math.random());
                                         //console.dir(json.image_name);
                                         ingred = JSON.parse(json.ingredients);
                                         //console.dir(ingred);
                                         cur_div.parent().find('span').html(ingred[iterm]);
                                         changeIngredAmount(ingred);
                                         },
                                         });
                                  }
                                  );
                  $(".ingredient").draggable({helper:'clone'});
                  $("#miximg").droppable({
                                         accept: ".ingredient",
                                         drop: function(event,ui) {
                                         var dragid = ui.draggable.attr("id");
                                         var iterm  = dragid.substr(0, dragid.length - 3);
                                         $.ajax({
                                                url: "draw_mix.php",
                                                type: "GET",
                                                data: {ingredients: JSON.stringify(ingred), iterm_name: iterm, change: 'add', image_name: <?php echo "'" . $image_name . "'"; ?>},
                                                dataType: "json",
                                                error: function() {
                                                console.dir('error occurs');
                                                },
                                                success: function(json) {
                                                $('#miximg').attr('src', json.image_name + '?' + Math.random());
                                                //console.dir(json.image_name);
                                                ingred = JSON.parse(json.ingredients);
                                                //console.dir(ingred);
                                                $("#" + iterm).find('span').html(ingred[iterm]);
                                                changeIngredAmount(ingred);
                                                },
                                                });
                                         }
                  });
                  }
                  );

</script>
