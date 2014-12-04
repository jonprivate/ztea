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
                    }
                    echo '</table>';
                }
            }
        }
    }
    
    include 'footer.php';
    closeDB();
?>
