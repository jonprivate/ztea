<?php
    include 'header.php';
    include 'forum_nav.php';
    require_once 'db_query.php';
    connectToDB();
    $sql = "SELECT
    cat_id,
    cat_name,
    cat_description
    FROM
    categories";
    
    $result = mysql_query($sql);
    closeDB();
    
    if(!$result)
    {
        echo 'The categories could not be displayed, please try again later.';
    }
    else
    {
        if(mysql_num_rows($result) == 0)
        {
            echo 'No categories defined yet.';
        }
        else
        {
            //prepare the table
            echo '<table border="1">
            <tr>
            <th>Category</th>
            <th>Last topic</th>
            </tr>';
            
            $rows = array();
            while($row = mysql_fetch_assoc($result))
            {
                echo '<tr>';
                echo '<td class="leftpart">';
                echo '<h3><a href="category.php?id=' . $row['cat_id'] . '">' . $row['cat_name'] . '</a></h3>' . $row['cat_description'];
                echo '</td>';
                echo '<td class="rightpart">';
                echo '<a href="topic.php?id=">Topic subject</a> at 10-10';
                echo '</td>';
                echo '</tr>';
                $rows[] = $row['cat_id'];
            }
            echo '</table>';
        }
    }
    
    include 'footer.php';
    
?>
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
                  setInterval(function(){
                              <?php for($i = 0, $size = count($rows); $i < $size; $i++) { ?>
                              ajax_query(<?php echo $i ?>, <?php echo $rows[$i] ?>);
                              <?php } ?>
                              }, 1000);
                  }
                  );

                  function ajax_query(i, cat_id) {
                  $.ajax({
                         url: "handle_query.php",
                         data: {query_type: 'topic', query_id: cat_id},
                         type: "GET",
                         dataType: "json",
                         success: function(json){
                         if(json.subject == "null" && json.id == "null" && json.date == "null")
                             $('td.rightpart').eq(i).html('No topic has been created for this category');
                         else
                             $('td.rightpart').eq(i).html(
                                                          '<a href="topic.php?id=' + json.id + '">' + json.subject + '</a> at ' + json.date
                                                          );
                         }
                         });
                  }
</script>