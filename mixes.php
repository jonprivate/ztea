<?php
    include 'header.php';
    require_once 'db_query.php';
    connectToDB();
    //first select the category based on $_GET['cat_id']
    $sql = "SELECT mix_name, mix_description FROM mixes WHERE mix_id = '" . mysql_real_escape_string($_GET['id']) . "'";
    
    $result = mysql_query($sql);
    
    if(!$result)
    {
        echo 'The mix could not be displayed, please try again later 1.' . mysql_error();
    }
    else
    {
        if(mysql_num_rows($result) == 0)
        {
            echo 'This mix does not exist.';
        }
        else
        {
            //display category data
            $row = mysql_fetch_assoc($result);
            echo '<h2>' . $row['topic_subject'] . '</h2>';
            
            //do a query for the topics
            $sql = "SELECT
            mixes.mix_name,
            mixes.mix_description,
            mixes.mix_date,
            mixes.water,
            mixes.milk,
            mixes.sugar,
            mixes.bubble,
            users.user_id,
            users.user_name
            FROM
            mixes
            LEFT JOIN
            users
            ON
            mixes.mix_by = users.user_id
            WHERE
            mixes.mix_id = " . mysql_real_escape_string($_GET['id']);
            
            $result = mysql_query($sql);
            
            if(!$result)
            {
                //echo 'The mix could not be displayed, please try again later 2.';
                echo $sql;
            }
            else
            {
                if(mysql_num_rows($result) == 0)
                {
                    echo 'The mix seems to be empty actually.';
                }
                else
                {
                    //prepare the table
                    echo '<table border="1">
                    <tr>
                    <th>Mix</th>
                    <th>Created at</th>
                    </tr>';
                    
                    while($row = mysql_fetch_assoc($result))
                    {
                        echo '<tr>';
                        echo '<td class="leftpart">';
                        //echo '<h3><a href="topic.php?id=' . $row['topic_id'] . '">' . $row['topic_subject'] . '</a><h3>';
                        echo '<h3>' . $row['mix_description'] . '</h3>';
                        echo '</td>';
                        echo '<td class="rightpart">';
                        echo date('d-m-Y', strtotime($row['mix_date']));
                        echo '</td>';
                        echo '</tr>';
                        $ingredients = array("water"=>$row['water'],"milk"=>$row['milk'],"suggar"=>$row['suggar'],"bubble"=>$row['bubble']);
                    }
                    echo '</table>';
                    echo '<div id="canvas_container"></div>';
                    echo '<div id="test"></div>';
                }
            }
        }
    }
    
    include 'footer.php';
    closeDB();
?>

<script src="raphael.js"></script>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script>
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
            var radius = cellheight / 2;
            var solid_center_left = solid_left_pos + radius;
            var solid_center_top = solid_top_pos - radius;
            var num_per_line = brect[2] / (2 * radius);
            var num_lines = ingred[item];
            for(var y = 0; y < num_lines; y++) {
                solid_center_left = solid_left_pos + radius;
                for(var x = 0; x < num_per_line; x++) {
                    paper.circle(solid_center_left, solid_center_top, radius);
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

window.onload = function() {
    var paper = new Raphael(document.getElementById('canvas_container'), 500, 500);
    //var rect = paper.rect(10, 10, 80, 150);
    //rect.attr({fill: '#9cf', stroke: 'none', 'stroke-width': 5});
    var ingred = <?php echo json_encode($ingredients); ?>;

    var bottle_left = 10, bottle_top = 10, bottle_width = 150, bottle_height = 350;
    var brect = [bottle_left, bottle_top, bottle_width, bottle_height];
    var cellheight = 50, cellwidth = bottle_width;
    drawMyBottle(ingred, paper, brect, cellheight, cellwidth);
}
</script>